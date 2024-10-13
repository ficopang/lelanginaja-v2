<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit()
    {
        $user = User::findOrFail(auth()->user()->id);

        return view('account.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'phone' => 'required|numeric|min:10',
            'address' => 'required',
        ]);

        $user = User::findOrFail(auth()->id());
        $user->firstname = $request->first_name;
        $user->lastname = $request->last_name;
        $user->phone_number = $request->phone;
        $user->address = $request->address;
        $user->save();

        return back()->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|alpha_num|min:8',
            'new_password' => 'required|alpha_num|min:8|required_with:confirm_new_password|same:confirm_new_password',
            'confirm_new_password' => 'required'
        ]);

        $user = User::findOrFail(auth()->id());
        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return back()->with('success', 'Password updated successfully');
        } else {
            return back()->withErrors('Wrong password');
        }
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        if (Hash::check($request->password, $user->password)) {
            $user = User::findOrFail(auth()->id());

            $user->reports()->delete();
            $user->watchlist()->delete();
            $user->sentChats()->delete();
            $user->receivedChats()->delete();

            foreach ($user->sellerTransactions() as $tr) {

                $shipment = Shipment::where('transaction_id', $tr->id)->firstOrFail();
                $shipment->remove();
            }

            foreach ($user->buyerTransactions() as $tr) {

                $shipment = Shipment::where('transaction_id', $tr->id)->firstOrFail();
                $shipment->remove();
            }
            $user->bids()->delete();
            $user->products()->delete();
            $user->withdraws()->delete();
            $user->delete();

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withSuccess('User deleted successfully.');
        } else {
            return back()->withErrors('Wrong password');
        }
    }
}
