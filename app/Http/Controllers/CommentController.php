<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Galery;
use Illuminate\Http\Request;
use App\Services\CommentFilterService;

class CommentController extends Controller
{
    protected CommentFilterService $filter;

    public function __construct(CommentFilterService $filter)
    {
        $this->filter = $filter;
    }

    protected function respondAfterAction(Request $request, Comment $comment, string $message, int $galeryId)
    {
        if ($request->expectsJson()) {
            $comment->loadMissing(['user', 'children.user']);

            $visibleCount = Comment::where('galery_id', $galeryId)
                ->whereNull('parent_id')
                ->where('status', 'visible')
                ->count();

            return response()->json([
                'message' => $message,
                'status' => $comment->status,
                'visible_count' => $visibleCount,
                'html' => $comment->status === 'visible'
                    ? view('guest.partials.comment_item', ['comment' => $comment])->render()
                    : null,
            ], $comment->status === 'visible' ? 201 : 202);
        }

        session()->flash('success', $message);
        return back();
    }

    public function store(Request $request, Galery $galery)
    {
        $userId = auth('user')->id() ?? auth()->id();
        if (!$userId) {
            return redirect()->route('user.login');
        }

        $data = $request->validate([
            'body' => ['required', 'string', 'min:1'],
        ]);

        $evaluation = $this->filter->evaluate($data['body']);

        $comment = Comment::create([
            'galery_id' => $galery->id,
            'user_id' => $userId,
            'body' => $evaluation['body'],
            'status' => $evaluation['status'],
            'moderation_note' => $evaluation['moderation_note'],
        ]);

        $message = $evaluation['status'] === 'visible'
            ? 'Komentar berhasil ditambahkan!'
            : 'Komentar mengandung kata yang dibatasi dan menunggu peninjauan admin.';

        return $this->respondAfterAction($request, $comment, $message, $galery->id);
    }

    public function reply(Request $request, Comment $comment)
    {
        $userId = auth('user')->id() ?? auth()->id();
        if (!$userId) {
            return redirect()->route('user.login');
        }

        $data = $request->validate([
            'body' => ['required', 'string', 'min:1'],
        ]);

        $evaluation = $this->filter->evaluate($data['body']);

        $reply = Comment::create([
            'galery_id' => $comment->galery_id,
            'user_id' => $userId,
            'parent_id' => $comment->id,
            'body' => $evaluation['body'],
            'status' => $evaluation['status'],
            'moderation_note' => $evaluation['moderation_note'],
        ]);

        $message = $evaluation['status'] === 'visible'
            ? 'Balasan berhasil ditambahkan!'
            : 'Balasan mengandung kata yang dibatasi dan menunggu peninjauan admin.';

        return $this->respondAfterAction($request, $reply, $message, $comment->galery_id);
    }

    public function destroy(Comment $comment)
    {
        $userId = auth('user')->id() ?? auth()->id();
        if (!$userId) {
            return redirect()->route('user.login');
        }

        if ($comment->user_id === (int) $userId) {
            $comment->delete();
            session()->flash('success', 'Komentar berhasil dihapus.');
        }

        return back();
    }
}
