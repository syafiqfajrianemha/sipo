<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $unitName = $user->unit ? $user->unit->name : 'Unit tidak ditemukan';

        $currentDate = now()->format('Y-m-d');

        $drugs = Drug::all();

        return view('order.create', compact('unitName', 'currentDate', 'drugs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'document_number' => 'required|string|max:255',
        //     'unit_name' => 'required|string|max:255',
        //     'report_month' => 'required|string|max:255',
        //     'request_month' => 'required|string|max:255',
        //     'input_date' => 'required|date',
        //     'items' => 'required|array',
        //     'items.*.drug_id' => 'required',
        //     'items.*.unit' => 'required|string|max:255',
        //     'items.*.initial_stock' => 'required|integer|min:0',
        //     'items.*.acceptance' => 'required|integer|min:0',
        //     'items.*.inventory' => 'required|integer|min:0',
        //     'items.*.usage' => 'required|integer|min:0',
        //     'items.*.remaining_stock' => 'required|integer|min:0',
        //     'items.*.optimum_stock' => 'required|integer|min:0',
        //     'items.*.request_quantity' => 'required|integer|min:0',
        // ]);

        $order = Order::create([
            'document_number' => $request->document_number,
            'unit_name' => $request->unit_name,
            'report_month' => $request->report_month,
            'request_month' => $request->request_month,
            'input_date' => $request->input_date,
            'user_id' => Auth::id(),
        ]);

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'drug_id' => $item['drug_id'],
                'unit' => $item['unit'],
                'initial_stock' => $item['initial_stock'],
                'acceptance' => $item['acceptance'],
                'inventory' => $item['inventory'],
                'usage' => $item['usage'],
                'remaining_stock' => $item['remaining_stock'],
                'optimum_stock' => $item['optimum_stock'],
                'request_quantity' => $item['request_quantity'],
            ]);
        }

        return redirect(route('order.index', absolute: false))->with('message', 'Pesanan Berhasil di Tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
