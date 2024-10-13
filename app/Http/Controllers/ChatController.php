<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index(User $user)
    {
        $chats = DB::table('chats')->where('sender_id', auth()->id())->orWhere('receiver_id', auth()->id())->get();

        $users = $chats->map(function ($chats) {
            if ($chats->sender_id === auth()->id()) {
                return $chats->receiver_id;
            }
            return $chats->sender_id;
        })->unique();

        if (!$user) {
            $user = $users->first();
        }

        $userLists = $users->map(function ($users) {
            $user = User::findOrFail($users);
            $user->message = DB::table('chats')->where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->latest("created_at")->first()->message;
            return $user;
        });

        return view('account.chat', compact('chats', 'user', 'userLists'));
    }

    public function send(Request $request, User $user)
    {
        $currChat = $request->validate([
            'chat-message' => 'required'
        ]);

        $chat = new Chat();
        $chat->sender_id = auth()->user()->id;
        $chat->receiver_id = $user->id;
        $chat->message = $currChat['chat-message'];
        $chat->save();

        return redirect()->back();
    }
}
