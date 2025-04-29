<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Drug;
use App\Models\Order;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalUnit = Unit::count();
        $totalLplpoSelesai = Order::where('status', 'done')->count();
        $totalObat = Drug::count();
        $totalAnggaran = Budget::count();
        $totalLplpoBelumSelesai = Order::whereIn('status', ['unverified', 'verified'])->count();
        $totalUser = User::count();

        // Rekap Permintaan Obat per Bulan dan Tahun
        $rekap = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('drugs', 'order_items.drug_id', '=', 'drugs.id')
            ->selectRaw('YEAR(orders.input_date) as year, MONTH(orders.input_date) as month, drugs.name as drug_name, SUM(order_items.request_quantity) as total')
            ->groupBy('year', 'month', 'drug_name')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Obat dengan stok kosong
        $obatKosong = DB::table('drug_budgets')
            ->join('drugs', 'drug_budgets.drug_id', '=', 'drugs.id')
            ->join('budgets', 'drug_budgets.budget_id', '=', 'budgets.id')
            ->where('stock', '<=', 0)
            ->select('drugs.name as drug_name', 'budgets.name as budget_name', 'drug_budgets.stock')
            ->get();

        if ($user->role === 'admin') {
            return view('dashboard', compact('totalUnit', 'totalLplpoSelesai', 'totalObat', 'totalAnggaran', 'totalLplpoBelumSelesai', 'totalUser', 'rekap', 'obatKosong'));
        }

        if ($user->role === 'petugas-farmasi') {
            return view('dashboard', compact('totalUnit', 'totalLplpoSelesai', 'totalObat', 'totalAnggaran', 'totalLplpoBelumSelesai'));
        }

        if ($user->role === 'petugas-puskesmas') {
            $totalLplpoByUser = Order::where('status', 'done')->where('user_id', $user->id)->count();
            return view('dashboard', compact('totalUnit', 'totalLplpoByUser'));
        }
    }
}
