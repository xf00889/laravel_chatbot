<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ], [
                'avatar.max' => 'The profile picture must not be larger than 2MB.',
                'avatar.mimes' => 'The profile picture must be a file of type: jpeg, png, jpg, gif.'
            ]);

            $user = auth()->user();

            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar) {
                    $oldAvatarPath = $_SERVER['DOCUMENT_ROOT'] . '/images/' . basename($user->avatar);
                    if (File::exists($oldAvatarPath)) {
                        File::delete($oldAvatarPath);
                    }
                }

                // Generate unique filename
                $filename = time() . '_' . $request->file('avatar')->getClientOriginalName();
                
                // Store new avatar directly in htdocs/images
                $request->file('avatar')->move($_SERVER['DOCUMENT_ROOT'] . '/images', $filename);
                
                // Update user with just the filename
                $user->update([
                    'name' => $request->name,
                    'avatar' => $filename
                ]);
            } else {
                $user->update([
                    'name' => $request->name
                ]);
            }

            return back()->with('success', 'Profile updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }
    }
} 