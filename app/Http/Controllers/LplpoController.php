<?php

namespace App\Http\Controllers;

use App\Models\Order;

class LplpoController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', 'done')->latest()->get();

        return view('lplpo.index', compact('orders'));
    }
}
