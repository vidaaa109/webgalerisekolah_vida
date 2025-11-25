<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Interaksi Galeri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .gallery-info {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .gallery-info h3 {
            margin-top: 0;
            color: #333;
            font-size: 16px;
        }
        .statistics {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-card {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
            text-align: center;
        }
        .stat-card h4 {
            margin: 0 0 10px 0;
            font-size: 12px;
            color: #666;
        }
        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h3 {
            color: #333;
            font-size: 16px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #333;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .comment-body {
            max-width: 300px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Interaksi Galeri</h1>
        <p>Sistem Manajemen Galeri</p>
    </div>

    <div class="gallery-info">
        <h3>Informasi Galeri</h3>
        <p><strong>Judul:</strong> {{ $galery->judul ?? $galery->post->judul }}</p>
        <p><strong>Post:</strong> {{ $galery->post->judul ?? '-' }}</p>
        <p><strong>Posisi:</strong> {{ $galery->position ?? '-' }}</p>
        <p><strong>Status:</strong> {{ $galery->status ? 'Aktif' : 'Nonaktif' }}</p>
    </div>

    <div class="statistics">
        <div class="stat-card">
            <h4>Total Like</h4>
            <div class="value">{{ number_format($summary['likes'], 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <h4>Total Komentar</h4>
            <div class="value">{{ number_format($summary['comments'], 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <h4>Total Simpan</h4>
            <div class="value">{{ number_format($summary['bookmarks'], 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <h4>Total Download</h4>
            <div class="value">{{ number_format($summary['downloads'], 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="section">
        <h3>Pengguna yang Berinteraksi ({{ $interactingUsers->count() }} pengguna)</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Like</th>
                    <th>Komentar</th>
                    <th>Simpan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($interactingUsers as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $likes->where('user_id', $user->id)->count() }}</td>
                    <td>{{ $comments->where('user_id', $user->id)->count() }}</td>
                    <td>{{ $bookmarks->where('user_id', $user->id)->count() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Belum ada interaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Riwayat Like ({{ $likes->count() }} data)</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($likes as $index => $like)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $like->user->name ?? 'Pengguna' }}</td>
                    <td>{{ $like->user->email ?? '-' }}</td>
                    <td>{{ $like->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada like</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Riwayat Simpan ({{ $bookmarks->count() }} data)</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookmarks as $index => $bookmark)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $bookmark->user->name ?? 'Pengguna' }}</td>
                    <td>{{ $bookmark->user->email ?? '-' }}</td>
                    <td>{{ $bookmark->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada data simpan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Daftar Komentar ({{ $comments->count() }} komentar)</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>Komentar</th>
                    <th>Status</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $index => $comment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $comment->user->name ?? 'Pengguna' }}</td>
                    <td>{{ $comment->user->email ?? '-' }}</td>
                    <td class="comment-body">{{ \Illuminate\Support\Str::limit($comment->body, 100) }}</td>
                    <td>{{ ucfirst($comment->status) }}</td>
                    <td>{{ $comment->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Belum ada komentar</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ $generatedAt->format('d M Y H:i:s') }}</p>
    </div>
</body>
</html>

