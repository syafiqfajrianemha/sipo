<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Drug;
use App\Models\Order;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

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

        if ($user->role === 'admin') {
            return view('dashboard', compact('totalUnit', 'totalLplpoSelesai', 'totalObat', 'totalAnggaran', 'totalLplpoBelumSelesai', 'totalUser'));
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
