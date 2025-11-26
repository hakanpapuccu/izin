<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'announcement_id' => 'required|exists:announcements,id',
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'announcement_id' => $request->announcement_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Yorum eklendi.');
    }
}
