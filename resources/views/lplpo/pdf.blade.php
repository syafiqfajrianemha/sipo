<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemakaian dan Lembar Permintaan Obat (LPLPO)</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-left { text-align: left; }
        .signature { margin-top: 50px; }
    </style>
</head>
<body>

    <h2 style="text-align: center;">Laporan Pemakaian dan Lembar Permintaan Obat (LPLPO)</h2>

    <table>
        <tr>
            <td class="text-left">Puskesmas: {{ $data['puskesmas'] }}</td>
            <td class="text-left">Bulan: {{ $data['bulan'] }}</td>
        </tr>
        <tr>
            <td class="text-left">Daerah Kab/Kota: {{ $data['kota'] }}</td>
            <td class="text-left">Dokumen: {{ $data['dokumen'] }}</td>
        </tr>
    </table>

    <p>Pelaporan Bulan/Periode: {{ $data['periode_pelaporan'] }}</p>
    <p>Permintaan Bulan/Periode: {{ $data['periode_permintaan'] }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Satuan</th>
                <th>Stok Awal</th>
                <th>Penerimaan</th>
                <th>Persediaan</th>
                <th>Pemakaian</th>
                <th>Sisa Stok</th>
                <th>Stok Optimum</th>
                <th>Permintaan</th>
                <th>APBD I</th>
                <th>APBD II</th>
                <th>LAIN-LAIN</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['obat'] as $obat)
                <tr>
                    <td class="text-left">{{ $obat['nama'] }}</td>
                    <td>{{ $obat['satuan'] }}</td>
                    <td>{{ $obat['stok_awal'] }}</td>
                    <td>{{ $obat['penerimaan'] }}</td>
                    <td>{{ $obat['persediaan'] }}</td>
                    <td>{{ $obat['pemakaian'] }}</td>
                    <td>{{ $obat['sisa_stok'] }}</td>
                    <td>{{ $obat['stok_optimum'] }}</td>
                    <td>{{ $obat['permintaan'] }}</td>
                    <td>{{ $obat['apbd_i'] }}</td>
                    <td>{{ $obat['apbd_ii'] }}</td>
                    <td>{{ $obat['lain'] }}</td>
                    <td>{{ $obat['jumlah'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <table>
            <tr>
                <td>Menyetujui:<br>Kepala Dinkes Kab/Kota,<br><br><br>(Hanif Fauzi H)</td>
                <td>Yang Menyerahkan:<br>Kepala Instalasi Farmasi,<br><br><br>(Nuriyasinta)</td>
                <td>Yang Meminta:<br>Kepala Puskesmas,<br><br><br>(Kayla Shareta A)</td>
                <td>Yang Menerima:<br>Petugas Puskesmas,<br><br><br>(Kartika Dewi Larasati)</td>
            </tr>
        </table>
    </div>

</body>
</html>
