<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionReport;
use Illuminate\Http\Request;

class TransactionReportController extends Controller
{
    public function show(Transaction $transaction)
    {
        return view('transaction.report', compact('transaction'));
    }

    public function store(Request $request, Transaction $transaction)
    {
        $this->validate($request, [
            'report_text' => 'required|min:5|max:100'
        ]);

        $report = new TransactionReport();
        $report->user_id = auth()->user()->id;
        $report->transaction_id = $transaction->id;
        $report->reason = $request->report_text;
        $report->save();

        return redirect('/');
    }
}
