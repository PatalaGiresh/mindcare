<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all conversation partners
        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function ($msg) use ($user) {
                return $msg->sender_id === $user->id ? $msg->receiver_id : $msg->sender_id;
            });

        // Mark received as read
        Message::where('receiver_id', $user->id)->whereNull('read_at')->update(['read_at' => now()]);

        $partnerId = request('with');
        $partner = $partnerId ? User::find($partnerId) : null;
        $messages = [];

        if ($partner) {
            $messages = Message::where(function ($q) use ($user, $partner) {
                $q->where('sender_id', $user->id)->where('receiver_id', $partner->id);
            })->orWhere(function ($q) use ($user, $partner) {
                $q->where('sender_id', $partner->id)->where('receiver_id', $user->id);
            })->orderBy('created_at')->get();
        }

        return view('messages.index', compact('conversations', 'partner', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'body'        => ['required', 'string', 'max:1000'],
        ]);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'body'        => $request->body,
        ]);

        return redirect()->route('messages.index', ['with' => $request->receiver_id])
            ->with('success', 'Message sent.');
    }
}
