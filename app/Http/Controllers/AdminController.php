<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReport;
use App\Models\Transaction;
use App\Models\TransactionReport;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $userCount = User::all()->count();
        $productCount = Product::all()->count();
        $transactionCount = Transaction::all()->count();
        $bidCount = Bid::all()->count();

        $transactions = Transaction::orderBy('created_at', 'desc')->take(6)->get();
        $topProductByTotalBidAmount = Product::with(['bids' => function ($query) {
            $query->select('product_id', DB::raw('COALESCE(SUM(bid_amount), 0) as total_bid_amount'))
                ->groupBy('product_id');
        }])
            ->get()
            ->sortByDesc(function ($product) {
                return $product->bids->sum('total_bid_amount') + $product->starting_price;
            })
            ->take(6);
        $topProductByBidCount = Product::withCount('bids')
            ->orderBy('bids_count', 'desc')
            ->take(6)
            ->get();
        return view('admin.dashboard', compact('userCount', 'productCount', 'transactionCount', 'bidCount', 'transactions', 'topProductByTotalBidAmount', 'topProductByBidCount'));
    }

    public function users()
    {
        return view('admin.users');
    }

    public function products()
    {
        $categories = Category::all();
        return view('admin.products', compact('categories'));
    }

    public function reports()
    {
        return view('admin.reports');
    }

    public function getUserList(Request $request): JsonResponse
    {
        // Get DataTable parameters
        $start = $request->input('start'); // Offset
        $length = $request->input('length'); // Limit
        $order = $request->input('order')[0]['column']; // Ordering column
        $dir = $request->input('order')[0]['dir']; // Ascending or Descending
        $search = $request->input('search')['value']; // Search value
        $ban = $request->input('ban'); // Filter by ban status

        // Query the users, including the product count
        $query = User::withCount('products');

        // Filter by search value if provided
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->where('first_name', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by ban status if provided
        if ($ban !== null) {
            $query->where('ban', $ban);
        }

        // Ordering
        $columns = ['id', 'first_name', 'phone_number', 'products_count', 'created_at', 'ban'];
        $query->orderBy($columns[$order], $dir);

        // Get the filtered count
        $filteredCount = $query->count();

        // Apply pagination
        $users = $query->offset($start)->limit($length)->get();

        // Total count before filtering
        $totalCount = User::count();

        // Prepare the response in DataTables format
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $filteredCount,
            'data' => $users,
        ]);
    }

    public function toggleBan(User $user)
    {
        try {
            $user->ban = $user->ban == 0 ? 1 : 0;
            $user->save();

            return response()->json(['message' => 'User status updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating user.'], 500);
        }
    }

    public function getProductList(Request $request): JsonResponse
    {
        // Get DataTable parameters
        $start = $request->input('start'); // Offset
        $length = $request->input('length'); // Limit
        $order = $request->input('order')[0]['column']; // Ordering column
        $dir = $request->input('order')[0]['dir']; // Ascending or Descending
        $search = $request->input('search')['value']; // Search value
        $status = $request->input('status'); // Filter
        $category = $request->input('category'); // Filter
        $type = $request->input('type'); // Filter

        // Query the users, including the product count
        $query = Product::with(['Category', 'Images'])->select('products.*')
            ->addSelect([
                // Subquery to calculate the total bid amount
                DB::raw('(SELECT COALESCE(SUM(bid_amount), 0) + products.starting_price FROM bids WHERE bids.product_id = products.id) as total_bid_amount')
            ]);;

        // Filter by search value if provided
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Filter by ban status if provided
        if ($status !== null) {
            $query->where('end_time', $status, NOW());
        }
        if ($category !== null) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('id', $category);  // or any other field you want to filter by
            })->get();
        }
        if ($type !== null) {
            $query->where('auction_type', $type);
        }

        // Ordering
        $columns = [null, 'id', 'name', 'categories.name', 'auction_type', 'total_bid_amount', 'end_time'];
        // Apply ordering
        if (isset($columns[$order])) {
            // Check if ordering by a related model's column
            if ($columns[$order] === 'categories.name') {
                $query->join('categories', 'products.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', $dir);
            } else {
                $query->orderBy($columns[$order], $dir);
            }
        }

        // Get the filtered count
        $filteredCount = $query->count();

        // Apply pagination
        $products = $query->offset($start)->limit($length)->get();

        // Total count before filtering
        $totalCount = Product::count();

        // Prepare the response in DataTables format
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $filteredCount,
            'data' => $products,
        ]);
    }

    public function deleteProducts(Request $request): JsonResponse
    {
        $ids = $request->input('ids');
        // Product::whereIn('id', $ids)->delete();
        foreach ($ids as $id) {
            $product = Product::findOrFail($id);
            if ($product->logs()) $product->logs()->delete();
            if ($product->transaction()) {
                if (isset($product->transaction->report)) $product->transaction->report->delete();
                $product->transaction()->delete();
            }
            if ($product->bids()) $product->bids()->delete();
            if ($product->images()) $product->images()->delete();
            if ($product->watchlists()) $product->watchlists()->delete();
            if ($product->reports()) $product->reports()->delete();
            $product->delete();
        }

        return response()->json(['success' => true]);
    }

    public function getReportList(Request $request): JsonResponse
    {
        // Get DataTable parameters
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $order = $request->input('order')[0]['column'] ?? 0;
        $dir = $request->input('order')[0]['dir'] ?? 'desc';
        $search = $request->input('search')['value'] ?? '';

        // Combine ProductReports and TransactionReports
        $query = DB::query()
            ->from(function ($query) {
                $query->from('product_reports')
                    ->select(
                        'product_reports.id',
                        'product_reports.user_id',
                        DB::raw('product_reports.product_id as related_id'),
                        'product_reports.reason',
                        'product_reports.deleted_at',
                        'product_reports.created_at',
                        'product_reports.updated_at',
                        DB::raw("'product' as report_type")
                    )
                    ->whereNull('product_reports.deleted_at')
                    ->unionAll(
                        DB::table('transaction_reports')
                            ->select(
                                'transaction_reports.id',
                                'transaction_reports.user_id',
                                DB::raw('transaction_reports.transaction_id as related_id'),
                                'transaction_reports.reason',
                                'transaction_reports.deleted_at',
                                'transaction_reports.created_at',
                                'transaction_reports.updated_at',
                                DB::raw("'transaction' as report_type")
                            )
                            ->whereNull('transaction_reports.deleted_at')
                    );
            }, 'combined_reports');

        // Apply search if provided
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('reason', 'like', "%{$search}%");
            });
        }

        // Ordering
        $columns = ['created_at'];
        $query->orderBy($columns[$order], $dir);

        // Get the filtered count
        $filteredCount = $query->count();

        // Apply pagination
        $reports = $query->offset($start)->limit($length)->get();

        // Eager load relationships
        $productReportIds = $reports->where('report_type', 'product')->pluck('id');
        $transactionReportIds = $reports->where('report_type', 'transaction')->pluck('id');

        $productReports = ProductReport::with(['user', 'product.user', 'product.category', 'product.images'])
            ->whereIn('id', $productReportIds)
            ->whereNull('deleted_at')
            ->get()
            ->keyBy('id');

        $transactionReports = TransactionReport::with(['user', 'transaction.product.user', 'transaction.product.category', 'transaction.product.images'])
            ->whereIn('id', $transactionReportIds)
            ->whereNull('deleted_at')
            ->get()
            ->keyBy('id');

        // Combine the data
        $combinedData = $reports->map(function ($report) use ($productReports, $transactionReports) {
            if ($report->report_type === 'product') {
                $fullReport = $productReports[$report->id];
                $fullReport->product_id = $fullReport->related_id;
                $fullReport->transaction = null;
            } else {
                $fullReport = $transactionReports[$report->id];
                $fullReport->transaction_id = $fullReport->related_id;
                $fullReport->product = null;
            }
            unset($fullReport->related_id);
            return $fullReport;
        });

        // Total count
        $totalCount = ProductReport::count() + TransactionReport::count();

        // Prepare the response in DataTables format
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $filteredCount,
            'data' => $combinedData,
        ]);
    }
}
