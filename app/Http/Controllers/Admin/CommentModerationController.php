<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentModerationController extends Controller
{
    public function updateStatus(Request $request, Comment $comment)
    {
        $request->validate([
            'status' => 'required|in:visible,draft,hidden',
        ]);

        $comment->status = $request->status;
        $comment->save();

        return back()->with('success', 'Status komentar berhasil diperbarui.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}

