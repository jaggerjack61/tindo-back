<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function showMessages()
    {
        $results = Message::orderBy('created_at', 'desc')->paginate(30);
        return view('pages.messages',compact('results'));
    }

    public function readMessage($id) {
        $message = Message::find($id);
        $message->status = 'read';
        $message->save();
        return back()->with('success','Message has been marked as read.');
    }

    public function unreadMessage($id) {
        $message = Message::find($id);
        $message->status = 'unread';
        $message->save();
        return back()->with('success','Message has been marked as unread.');
    }

}
