<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:user,comment',
            'target_id' => 'required|integer',
            'reason' => 'required|string|min:10|max:500',
        ]);

        $reporter = Auth::guard('user')->user();

        if (!$reporter) {
            return redirect()->route('user.login');
        }

        $reportable = $request->type === 'user'
            ? User::findOrFail($request->target_id)
            : Comment::withTrashed()->findOrFail($request->target_id);

        if ($request->type === 'user' && (int) $reportable->id === (int) $reporter->id) {
            return back()->withErrors(['report' => 'Anda tidak dapat melaporkan akun sendiri.']);
        }

        if ($request->type === 'comment' && (int) $reportable->user_id === (int) $reporter->id) {
            return back()->withErrors(['report' => 'Anda tidak dapat melaporkan komentar sendiri.']);
        }

        Report::create([
            'reporter_id' => $reporter->id,
            'reportable_id' => $reportable->id,
            'reportable_type' => get_class($reportable),
            'type' => $request->type,
            'reason' => $request->reason,
        ]);

        return back()->with('status', 'Laporan berhasil dikirim. Terima kasih atas partisipasi Anda.');
    }
}

