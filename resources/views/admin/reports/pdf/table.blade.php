<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan {{ $typeLabel }}</title>
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
        .statistics {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .statistics h3 {
            margin-top: 0;
            color: #333;
            font-size: 16px;
        }
        .stat-item {
            margin: 10px 0;
            padding: 8px;
            background-color: white;
            border-left: 4px solid #007bff;
        }
        .stat-item strong {
            color: #007bff;
        }
        .top-galleries {
            margin: 15px 0;
        }
        .top-galleries h4 {
            margin: 10px 0 5px 0;
            color: #555;
            font-size: 14px;
        }
        .top-galleries table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .top-galleries table th,
        .top-galleries table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .top-galleries table th {
            background-color: #007bff;
            color: white;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .data-table th {
            background-color: #333;
            color: white;
        }
        .data-table tr:nth-child(even) {
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
        .date-range {
            margin: 10px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan {{ $typeLabel }}</h1>
        <p>Sistem Manajemen Galeri</p>
        <div class="date-range">
            @if($from || $to)
                Periode: 
                @if($from && $to)
                    {{ \Carbon\Carbon::parse($from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
                @elseif($from)
                    Dari: {{ \Carbon\Carbon::parse($from)->format('d M Y') }}
                @elseif($to)
                    Sampai: {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
                @endif
            @else
                Semua Data
            @endif
        </div>
    </div>

    <div class="statistics">
        <h3>Statistik</h3>
        <div class="stat-item">
            <strong>Total Data:</strong> {{ number_format($statistics['total'], 0, ',', '.') }}
        </div>

        @if($type === 'galery' && isset($statistics['top_by_likes']))
            <div class="top-galleries">
                <h4>Top 5 Galeri dengan Like Terbanyak</h4>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Galeri</th>
                            <th>Post</th>
                            <th>Total Like</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statistics['top_by_likes'] as $index => $galery)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $galery->judul }}</td>
                            <td>{{ $galery->post->judul ?? '-' }}</td>
                            <td>{{ number_format($galery->total_likes ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="top-galleries">
                <h4>Top 5 Galeri dengan Komentar Terbanyak</h4>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Galeri</th>
                            <th>Post</th>
                            <th>Total Komentar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statistics['top_by_comments'] as $index => $galery)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $galery->judul }}</td>
                            <td>{{ $galery->post->judul ?? '-' }}</td>
                            <td>{{ number_format($galery->total_comments ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="top-galleries">
                <h4>Top 5 Galeri dengan Simpan Terbanyak</h4>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Galeri</th>
                            <th>Post</th>
                            <th>Total Simpan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statistics['top_by_bookmarks'] as $index => $galery)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $galery->judul }}</td>
                            <td>{{ $galery->post->judul ?? '-' }}</td>
                            <td>{{ number_format($galery->total_bookmarks ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="top-galleries">
                <h4>Top 5 Galeri dengan Download Terbanyak</h4>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Galeri</th>
                            <th>Post</th>
                            <th>Total Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statistics['top_by_downloads'] as $index => $galery)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $galery->judul }}</td>
                            <td>{{ $galery->post->judul ?? '-' }}</td>
                            <td>{{ number_format($galery->total_downloads ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <h3>Detail Data</h3>
    <table class="data-table">
        <thead>
            <tr>
                @foreach($headers as $header)
                <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
            <tr>
                @foreach($row as $cell)
                <td>{{ $cell }}</td>
                @endforeach
            </tr>
            @empty
            <tr>
                <td colspan="{{ count($headers) }}" style="text-align: center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ $generatedAt->format('d M Y H:i:s') }}</p>
    </div>
</body>
</html>

