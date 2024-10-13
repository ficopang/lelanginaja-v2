<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index()
    {
        $withdraws = Auth()->user()->withdraws;
        return view('account.withdraw', compact('withdraws'));
    }

    public function request(Request $request)
    {
        $amount = $request->amount;
        $user = User::find(auth()->id());
        if ($user->balance < $amount) {
            return back()->withErrors("Your Balance is not enough!");
        }
        $user->balance = $user->balance - $amount;
        $user->save();

        $withdraw = new Withdraw();
        $withdraw->user_id = $user->id;
        $withdraw->amount = $amount;
        $withdraw->status = "Pending";
        $withdraw->save();

        return redirect()->back()->withMessage("Withdrawal success!");
    }
}
