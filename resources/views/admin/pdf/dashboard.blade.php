<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Dashboard Admin</title>
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
        .statistics-section {
            margin-bottom: 30px;
        }
        .statistics-section h3 {
            color: #333;
            font-size: 16px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .statistics-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-card {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .stat-card h4 {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }
        .stat-card .value {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .summary-table th,
        .summary-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .summary-table th {
            background-color: #333;
            color: white;
        }
        .summary-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Dashboard Admin</h1>
        <p>Sistem Manajemen Galeri - SMKN 4 BOGOR</p>
    </div>

    <div class="statistics-section">
        <h3>Ringkasan Statistik Sistem</h3>
        <div class="statistics-grid">
            <div class="stat-card">
                <h4>Total Posts</h4>
                <div class="value">{{ number_format($statistics['posts'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <h4>Total Galeri</h4>
                <div class="value">{{ number_format($statistics['galeries'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <h4>Total Foto</h4>
                <div class="value">{{ number_format($statistics['fotos'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <h4>Total Petugas</h4>
                <div class="value">{{ number_format($statistics['petugas'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <h4>Total Kategori</h4>
                <div class="value">{{ number_format($statistics['kategori'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <h4>Total Pengguna</h4>
                <div class="value">{{ number_format($statistics['users'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <h4>Total Like</h4>
                <div class="value">{{ number_format($statistics['likes'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <h4>Total Komentar</h4>
                <div class="value">{{ number_format($statistics['comments'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <h4>Total Simpan</h4>
                <div class="value">{{ number_format($statistics['bookmarks'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <h4>Total Laporan</h4>
                <div class="value">{{ number_format($statistics['reports'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <h4>Total Download</h4>
                <div class="value">{{ number_format($statistics['downloads'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="statistics-section">
        <h3>Detail Statistik</h3>
        <table class="summary-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori Data</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Posts</td>
                    <td>{{ number_format($statistics['posts'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Galeri</td>
                    <td>{{ number_format($statistics['galeries'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Foto</td>
                    <td>{{ number_format($statistics['fotos'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Petugas</td>
                    <td>{{ number_format($statistics['petugas'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Kategori</td>
                    <td>{{ number_format($statistics['kategori'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Pengguna</td>
                    <td>{{ number_format($statistics['users'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Like</td>
                    <td>{{ number_format($statistics['likes'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Komentar</td>
                    <td>{{ number_format($statistics['comments'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Simpan (Bookmark)</td>
                    <td>{{ number_format($statistics['bookmarks'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Laporan</td>
                    <td>{{ number_format($statistics['reports'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>Download</td>
                    <td>{{ number_format($statistics['downloads'], 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ $generatedAt->format('d M Y H:i:s') }}</p>
    </div>
</body>
</html>

