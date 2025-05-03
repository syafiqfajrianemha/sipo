<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Permintaan Obat</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 18px;
        }
        .info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #e5e7eb;
            font-weight: bold;
            text-align: center;
        }
        th, td {
            padding: 8px;
            border: 1px solid #000;
        }
        td {
            text-align: center;
        }
        .footer {
            font-size: 11px;
            text-align: right;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Rekap Permintaan Obat</h2>

    <div class="info">
        Mode: <strong>{{ request('mode') == 'year' ? 'Rekap Tahunan' : 'Rekap Bulanan' }}</strong><br>
        @if(request('unit'))
            Unit: <strong>{{ request('unit') }}</strong><br>
        @endif
        @if(request('year'))
            Tahun: <strong>{{ request('year') }}</strong><br>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Tahun</th>
                @if($rekap->first() && isset($rekap->first()->month))
                    <th>Bulan</th>
                @endif
                <th>Nama Obat</th>
                <th>Total Permintaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekap as $row)
                <tr>
                    <td>{{ $row->year }}</td>
                    @if(isset($row->month))
                        <td>{{ \Carbon\Carbon::create()->month($row->month)->locale('id')->translatedFormat('F') }}</td>
                    @endif
                    <td style="text-align: left;">{{ $row->drug_name }}</td>
                    <td>{{ number_format($row->total) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}
    </div>
</body>
</html>
