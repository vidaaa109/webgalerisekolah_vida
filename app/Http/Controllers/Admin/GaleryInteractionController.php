<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galery;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class GaleryInteractionController extends Controller
{
    public function show(Galery $galery)
    {
        $likes = $galery->likes()
            ->with(['user:id,name,email'])
            ->latest()
            ->get();

        $bookmarks = $galery->bookmarks()
            ->with(['user:id,name,email'])
            ->latest()
            ->get();

        $comments = $galery->comments()
            ->with(['user:id,name,email'])
            ->latest()
            ->get();

        $interactingUserIds = $likes->pluck('user.id')
            ->merge($bookmarks->pluck('user.id'))
            ->merge($comments->pluck('user.id'))
            ->filter()
            ->unique();

        $interactingUsers = $interactingUserIds->isEmpty()
            ? collect()
            : User::whereIn('id', $interactingUserIds)
                ->get(['id', 'name', 'email', 'created_at']);

        $summary = [
            'likes' => $likes->count(),
            'bookmarks' => $bookmarks->count(),
            'comments' => $comments->count(),
            'unique_users' => $interactingUsers->count(),
        ];

        $galery->load('post:id,judul');

        return view('admin.galery.interactions', compact(
            'galery',
            'summary',
            'likes',
            'bookmarks',
            'comments',
            'interactingUsers'
        ));
    }

    public function exportPdf(Galery $galery)
    {
        $likes = $galery->likes()
            ->with(['user:id,name,email'])
            ->latest()
            ->get();

        $bookmarks = $galery->bookmarks()
            ->with(['user:id,name,email'])
            ->latest()
            ->get();

        $comments = $galery->comments()
            ->with(['user:id,name,email'])
            ->latest()
            ->get();

        $interactingUserIds = $likes->pluck('user.id')
            ->merge($bookmarks->pluck('user.id'))
            ->merge($comments->pluck('user.id'))
            ->filter()
            ->unique();

        $interactingUsers = $interactingUserIds->isEmpty()
            ? collect()
            : User::whereIn('id', $interactingUserIds)
                ->get(['id', 'name', 'email', 'created_at']);

        $summary = [
            'likes' => $likes->count(),
            'bookmarks' => $bookmarks->count(),
            'comments' => $comments->count(),
            'unique_users' => $interactingUsers->count(),
            'downloads' => $galery->total_downloads ?? 0,
        ];

        $galery->load('post:id,judul');

        $pdf = Pdf::loadView('admin.galery.pdf.interactions', [
            'galery' => $galery,
            'summary' => $summary,
            'likes' => $likes,
            'bookmarks' => $bookmarks,
            'comments' => $comments,
            'interactingUsers' => $interactingUsers,
            'generatedAt' => now(),
        ]);

        $filename = 'laporan_interaksi_' . str_replace(' ', '_', $galery->judul ?? $galery->post->judul) . '_' . now()->format('Ymd_His') . '.pdf';
        
        return $pdf->download($filename);
    }
}

