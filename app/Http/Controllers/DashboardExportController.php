<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapObatExport;
use PDF;
use Illuminate\Support\Facades\DB;

class DashboardExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        return Excel::download(new RekapObatExport($request), 'rekap-permintaan-obat.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $rekap = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('drugs', 'order_items.drug_id', '=', 'drugs.id')
            ->selectRaw('YEAR(orders.input_date) as year, MONTH(orders.input_date) as month, drugs.name as drug_name, SUM(order_items.request_quantity) as total')
            ->when($request->year, fn($q) => $q->whereYear('orders.input_date', $request->year))
            ->when($request->unit, fn($q) => $q->where('orders.unit_name', $request->unit))
            ->groupBy('year', 'month', 'drug_name')
            ->orderBy('year')->orderBy('month')
            ->get();

        $pdf = PDF::loadView('exports.rekap-pdf', compact('rekap'))->setPaper('a4', 'portrait');
        return $pdf->download('rekap-permintaan-obat.pdf');
    }
}

