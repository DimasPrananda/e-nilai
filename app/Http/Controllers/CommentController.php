<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ],[
            'rating.required' => 'Rating harus dipilih.',
            'rating.integer' => 'Rating tidak valid.',
            'rating.min' => 'Rating tidak valid.',
            'rating.max' => 'Rating tidak valid.',
            'text.required' => 'Komentar harus diisi.',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'text' => $request->text,
            'rating' => $request->rating,
            'likes' => 0, // Default likes when a comment is created
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function like(Comment $comment)
    {
        $comment->increment('likes');
        return redirect()->back()->with('success', 'Comment liked successfully.');
    }

    public function index()
    {
        $comments = Comment::with('user')->latest()->get();
        return view('admin.dashboard', compact('comments'));
    }

    public function destroyAll()
    {
        Comment::truncate();
        return redirect()->back()->with('success', 'Semua komentar berhasil dihapus.');
    }
}
