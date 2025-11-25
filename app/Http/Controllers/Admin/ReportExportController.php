<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\Galery;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportExportController extends Controller
{
    protected array $types = ['galery', 'likes', 'comments', 'bookmarks', 'users'];

    public function index()
    {
        return view('admin.reports.export', [
            'types' => $this->types,
        ]);
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:' . implode(',', $this->types),
            'from' => 'nullable|date',
            'to' => 'nullable|date|after_or_equal:from',
        ]);

        [$headers, $rows] = $this->prepareData($validated['type'], $validated['from'] ?? null, $validated['to'] ?? null);

        $filename = $validated['type'] . '_report_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($headers, $rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    protected function prepareData(string $type, ?string $from, ?string $to): array
    {
        $queryDate = function ($query) use ($from, $to) {
            if ($from) {
                $query->whereDate('created_at', '>=', $from);
            }
            if ($to) {
                $query->whereDate('created_at', '<=', $to);
            }
        };

        switch ($type) {
            case 'galery':
                $query = Galery::with(['post:id,judul'])->orderByDesc('created_at');
                $queryDate($query);
                $headers = ['ID', 'Judul Galeri', 'Post', 'Posisi', 'Status', 'Total Like', 'Total Komentar', 'Total Simpan', 'Total Unduh', 'Dibuat'];
                $rows = $query->get()->map(function ($galery) {
                    return [
                        $galery->id,
                        $galery->judul,
                        $galery->post->judul ?? '-',
                        $galery->position,
                        $galery->status ? 'Aktif' : 'Nonaktif',
                        $galery->total_likes ?? 0,
                        $galery->total_comments ?? 0,
                        $galery->total_bookmarks ?? 0,
                        $galery->total_downloads ?? 0,
                        $galery->created_at,
                    ];
                })->toArray();
                break;

            case 'likes':
                $query = Like::with(['user:id,name,email', 'galery:id,judul'])->orderByDesc('created_at');
                $queryDate($query);
                $headers = ['ID', 'Pengguna', 'Email', 'Galeri', 'Waktu'];
                $rows = $query->get()->map(function ($like) {
                    return [
                        $like->id,
                        $like->user->name ?? '-',
                        $like->user->email ?? '-',
                        $like->galery->judul ?? '-',
                        $like->created_at,
                    ];
                })->toArray();
                break;

            case 'comments':
                $query = Comment::with(['user:id,name,email', 'galery:id,judul'])->orderByDesc('created_at');
                $queryDate($query);
                $headers = ['ID', 'Pengguna', 'Email', 'Galeri', 'Status', 'Komentar', 'Catatan Moderasi', 'Waktu'];
                $rows = $query->get()->map(function ($comment) {
                    return [
                        $comment->id,
                        $comment->user->name ?? '-',
                        $comment->user->email ?? '-',
                        $comment->galery->judul ?? '-',
                        $comment->status,
                        $comment->body,
                        $comment->moderation_note ?? '-',
                        $comment->created_at,
                    ];
                })->toArray();
                break;

            case 'bookmarks':
                $query = Bookmark::with(['user:id,name,email', 'galery:id,judul'])->orderByDesc('created_at');
                $queryDate($query);
                $headers = ['ID', 'Pengguna', 'Email', 'Galeri', 'Waktu'];
                $rows = $query->get()->map(function ($bookmark) {
                    return [
                        $bookmark->id,
                        $bookmark->user->name ?? '-',
                        $bookmark->user->email ?? '-',
                        $bookmark->galery->judul ?? '-',
                        $bookmark->created_at,
                    ];
                })->toArray();
                break;

            case 'users':
            default:
                $query = User::orderByDesc('created_at');
                $queryDate($query);
                $headers = ['ID', 'Nama', 'Username', 'Email', 'Status', 'Terverifikasi', 'Diblokir Pada', 'Alasan Blokir', 'Dibuat'];
                $rows = $query->get()->map(function ($user) {
                    return [
                        $user->id,
                        $user->name,
                        $user->username,
                        $user->email,
                        $user->status ?? 'active',
                        $user->is_verified ? 'Ya' : 'Tidak',
                        $user->blocked_at,
                        $user->blocked_reason,
                        $user->created_at,
                    ];
                })->toArray();
                break;
        }

        return [$headers, $rows];
    }

    public function exportPdf(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:' . implode(',', $this->types),
            'from' => 'nullable|date',
            'to' => 'nullable|date|after_or_equal:from',
        ]);

        $type = $validated['type'];
        $from = $validated['from'] ?? null;
        $to = $validated['to'] ?? null;

        // Get statistics
        $statistics = $this->getStatistics($type, $from, $to);
        
        // Get data
        [$headers, $rows] = $this->prepareData($type, $from, $to);

        $typeLabels = [
            'galery' => 'Galeri',
            'likes' => 'Like',
            'comments' => 'Komentar',
            'bookmarks' => 'Simpan',
            'users' => 'Pengguna',
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.table', [
            'type' => $type,
            'typeLabel' => $typeLabels[$type] ?? ucfirst($type),
            'statistics' => $statistics,
            'headers' => $headers,
            'rows' => $rows,
            'from' => $from,
            'to' => $to,
            'generatedAt' => now(),
        ]);

        $filename = $type . '_report_' . now()->format('Ymd_His') . '.pdf';
        
        return $pdf->download($filename);
    }

    protected function getStatistics(string $type, ?string $from, ?string $to): array
    {
        $queryDate = function ($query) use ($from, $to) {
            if ($from) {
                $query->whereDate('created_at', '>=', $from);
            }
            if ($to) {
                $query->whereDate('created_at', '<=', $to);
            }
        };

        switch ($type) {
            case 'galery':
                $query = Galery::with(['post:id,judul']);
                $queryDate($query);
                
                $total = $query->count();
                
                // Get top galleries by different metrics (all-time, not filtered by date)
                $topByLikes = Galery::orderByDesc('total_likes')
                    ->limit(5)
                    ->with(['post:id,judul'])
                    ->get(['id', 'judul', 'post_id', 'total_likes']);
                
                $topByComments = Galery::orderByDesc('total_comments')
                    ->limit(5)
                    ->with(['post:id,judul'])
                    ->get(['id', 'judul', 'post_id', 'total_comments']);
                
                $topByBookmarks = Galery::orderByDesc('total_bookmarks')
                    ->limit(5)
                    ->with(['post:id,judul'])
                    ->get(['id', 'judul', 'post_id', 'total_bookmarks']);
                
                $topByDownloads = Galery::orderByDesc('total_downloads')
                    ->limit(5)
                    ->with(['post:id,judul'])
                    ->get(['id', 'judul', 'post_id', 'total_downloads']);

                return [
                    'total' => $total,
                    'top_by_likes' => $topByLikes,
                    'top_by_comments' => $topByComments,
                    'top_by_bookmarks' => $topByBookmarks,
                    'top_by_downloads' => $topByDownloads,
                ];

            case 'likes':
                $query = Like::query();
                $queryDate($query);
                return ['total' => $query->count()];

            case 'comments':
                $query = Comment::query();
                $queryDate($query);
                return ['total' => $query->count()];

            case 'bookmarks':
                $query = Bookmark::query();
                $queryDate($query);
                return ['total' => $query->count()];

            case 'users':
            default:
                $query = User::query();
                $queryDate($query);
                return ['total' => $query->count()];
        }
    }
}

