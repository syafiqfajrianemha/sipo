<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;

class LplpoController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'petugas-puskesmas') {
            $orders = Order::where('status', 'done')->where('user_id', $user->id)->get();
        } else {
            $orders = Order::where('status', 'done')->get();
        }

        return view('lplpo.index', compact('orders'));
    }

    public function generatePdf($id)
    {
        // $data = [
        //     'puskesmas' => 'Puskesmas Purwosari',
        //     'kota' => 'Surakarta',
        //     'bulan' => 'September 2021',
        //     'dokumen' => '12785',
        //     'periode_pelaporan' => 'Agustus',
        //     'periode_permintaan' => 'September',
        //     'obat' => [
        //         [
        //             'nama' => 'Amoxicillin syrup',
        //             'satuan' => 'Botol',
        //             'stok_awal' => 8,
        //             'penerimaan' => 83,
        //             'persediaan' => 91,
        //             'pemakaian' => 85,
        //             'sisa_stok' => 6,
        //             'stok_optimum' => 111,
        //             'permintaan' => 104,
        //             'apbn' => 50,
        //             'askes' => 0,
        //             'apbd_i' => 0,
        //             'apbd_ii' => 50,
        //             'buffer' => 0,
        //             'lain' => 4,
        //             'jumlah' => 104
        //         ],
        //         [
        //             'nama' => 'Betametason',
        //             'satuan' => 'Tube',
        //             'stok_awal' => 19,
        //             'penerimaan' => 186,
        //             'persediaan' => 205,
        //             'pemakaian' => 200,
        //             'sisa_stok' => 5,
        //             'stok_optimum' => 260,
        //             'permintaan' => 255,
        //             'apbn' => 100,
        //             'askes' => 50,
        //             'apbd_i' => 0,
        //             'apbd_ii' => 50,
        //             'buffer' => 0,
        //             'lain' => 55,
        //             'jumlah' => 255
        //         ]
        //     ]
        // ];
        $user = auth()->user();
        // Ambil data order berdasarkan ID
        if ($user->role === 'petugas-puskesmas') {
            $order = Order::where('user_id', $user->id)->with(['orderItems.drug', 'orderItems.drugDistributions.budget'])->findOrFail($id);
        } else {
            $order = Order::with(['orderItems.drug', 'orderItems.drugDistributions.budget'])->findOrFail($id);
        }

        // Mapping data untuk laporan
        $data = [
            'puskesmas' => $order->unit_name,
            'kota' => 'Purbalingga', // Jika ada field kota di database bisa disesuaikan
            'bulan' => $order->report_month,
            'dokumen' => $order->document_number,
            'periode_pelaporan' => $order->report_month,
            'periode_permintaan' => $order->request_month,
            'obat' => []
        ];

        foreach ($order->orderItems as $item) {
            $distributions = $item->drugDistributions->groupBy('budget.name')->map(function ($dist) {
                return $dist->sum('quantity');
            });

            $data['obat'][] = [
                'nama' => $item->drug->name,
                'satuan' => $item->unit,
                'stok_awal' => $item->initial_stock,
                'penerimaan' => $item->acceptance,
                'persediaan' => $item->inventory,
                'pemakaian' => $item->usage,
                'sisa_stok' => $item->remaining_stock,
                'stok_optimum' => $item->optimum_stock,
                'permintaan' => $item->request_quantity,
                'apbn' => $distributions->get('APBN', 0),
                'askes' => $distributions->get('ASKES', 0),
                'apbd_i' => $distributions->get('APBD I', 0),
                'apbd_ii' => $distributions->get('APBD II', 0),
                'buffer' => $distributions->get('Buffer', 0),
                'lain' => $distributions->get('LAIN-LAIN', 0),
                'jumlah' => $distributions->sum()
            ];
        }

        $pdf = Pdf::loadView('lplpo.pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan_Pemakaian_Obat.pdf');
    }
}
