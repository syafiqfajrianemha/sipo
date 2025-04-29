<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class RekapObatExport implements FromCollection
{
    protected $request;
    private $fileName = 'rekap-permintaan-obat.xlsx';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('drugs', 'order_items.drug_id', '=', 'drugs.id')
            ->selectRaw('YEAR(orders.input_date) as year, MONTH(orders.input_date) as month, drugs.name as drug_name, SUM(order_items.request_quantity) as total')
            ->when($this->request->year, fn($q) => $q->whereYear('orders.input_date', $this->request->year))
            ->when($this->request->unit, fn($q) => $q->where('orders.unit_name', $this->request->unit))
            ->groupBy('year', 'month', 'drug_name')
            ->orderBy('year')->orderBy('month')
            ->get();
    }
}
