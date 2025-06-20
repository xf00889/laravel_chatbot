<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserCreditController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);
        return view('admin.credits.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'prompts' => 'required|integer|min:0'
        ]);

        try {
            $user->update([
                'prompts_remaining' => $request->prompts
            ]);

            return response()->json([
                'success' => true,
                'message' => "Credits updated successfully for {$user->name}",
                'new_value' => $request->prompts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update credits'
            ], 500);
        }
    }
} 