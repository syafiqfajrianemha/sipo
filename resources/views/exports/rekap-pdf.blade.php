<!DOCTYPE html>
<html>
<head>
    <title>Rekap Permintaan Obat</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 6px; border: 1px solid #000; font-size: 12px; }
    </style>
</head>
<body>
    <h2>Rekap Permintaan Obat</h2>
    <table>
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Bulan</th>
                <th>Obat</th>
                <th>Total Permintaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekap as $row)
                <tr>
                    <td>{{ $row->year }}</td>
                    <td>{{ $row->month }}</td>
                    <td>{{ $row->drug_name }}</td>
                    <td>{{ $row->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
