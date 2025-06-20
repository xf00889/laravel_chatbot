<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ChatMessage::with('user')
                           ->orderBy('created_at', 'desc');

        // Filter by user if specified
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        $chatHistory = $query->paginate(15);
        $users = User::orderBy('name')->get();

        return view('admin.chat-history.index', compact('chatHistory', 'users'));
    }
} 