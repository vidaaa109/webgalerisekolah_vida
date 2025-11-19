<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->withCount([
            'reports as reports_received_count' => function ($q) {
                $q->where('type', 'user');
            },
        ]);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,blocked',
            'blocked_reason' => 'nullable|string|max:500',
        ]);

        $user->status = $request->status;
        $user->blocked_reason = $request->status === 'blocked' ? ($request->blocked_reason ?: 'Diblokir oleh admin.') : null;
        $user->blocked_at = $request->status === 'blocked' ? now() : null;
        $user->save();

        return back()->with('success', 'Status pengguna berhasil diperbarui.');
    }
}

