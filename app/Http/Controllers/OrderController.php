<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Drug;
use App\Models\DrugBudget;
use App\Models\DrugDistribution;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'petugas-puskesmas') {
            $orders = Order::whereIn('status', ['unverified', 'verified'])->where('user_id', $user->id)->get();
        } else {
            $orders = Order::whereIn('status', ['unverified', 'verified'])->get();
        }

        return view('order.index', compact('orders'));
    }

    public function create()
    {
        $user = auth()->user();
        $unitName = $user->unit ? $user->unit->name : 'Unit tidak ditemukan';

        $currentDate = now()->format('Y-m-d');

        $latestCreatedAt = Drug::max('created_at');
        $drugs = Drug::where('created_at', $latestCreatedAt)->get();

        if ($user->role === 'petugas-puskesmas') {
            $latestCompletedOrder = Order::max('created_at');
            $completedOrders = Order::where('status', 'done')->where('user_id', $user->id)->where('created_at', $latestCompletedOrder)->with('orderItems')->get();

            $orderItemQuantities = [];
            foreach ($completedOrders as $order) {
                foreach ($order->orderItems as $orderItem) {
                    $totalQuantity = DrugDistribution::where('order_item_id', $orderItem->id)->sum('quantity');
                    $orderItemQuantities[$orderItem->id] = $totalQuantity;
                }
            }
        } else {
            $completedOrders = Order::where('status', 'done')->with('orderItems')->get();
        }

        return view('order.create', compact('unitName', 'currentDate', 'drugs', 'completedOrders', 'orderItemQuantities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_number' => 'required|string|max:255',
            'unit_name' => 'required|string|max:255',
            'report_month' => 'required|string|max:255',
            'request_month' => 'required|string|max:255',
            'input_date' => 'required|date',
            // 'items' => 'required|array',
            // 'items.*.drug_id' => 'required',
            // 'items.*.unit' => 'required|string|max:255',
            // 'items.*.initial_stock' => 'required|integer|min:0',
            // 'items.*.acceptance' => 'required|integer|min:0',
            // 'items.*.inventory' => 'required|integer|min:0',
            // 'items.*.usage' => 'required|integer|min:0',
            // 'items.*.remaining_stock' => 'required|integer|min:0',
            // 'items.*.optimum_stock' => 'required|integer|min:0',
            // 'items.*.request_quantity' => 'required|integer|min:0',
        ]);

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

    public function show($id)
    {
        $user = auth()->user();
        if ($user->role === 'petugas-puskesmas') {
            $order = Order::where('user_id', $user->id)->with('orderItems.drug')->findOrFail($id);
        } else {
            $order = Order::with('orderItems.drug')->findOrFail($id);
        }

        foreach ($order->orderItems as $orderItem) {
            $drugDistributionExists = DrugDistribution::where('order_item_id', $orderItem->id)->exists();
            $orderItem->drug_distribution_exists = $drugDistributionExists;
        }

        $attachment = Attachment::where('order_id', $id)->first();

        return view('order.show', compact('order', 'attachment'));
    }

    public function giveDrug($itemId)
    {
        $orderItem = OrderItem::findOrFail($itemId);

        $budgets = DrugBudget::with('budget')->where('drug_id', $orderItem->drug_id)->get();

        return view('give.index', compact('orderItem', 'budgets'));
    }

    public function storeDrugGiving(Request $request, $itemId)
    {
        $orderItem = OrderItem::findOrFail($itemId);

        $order = $orderItem->order;
        $order->status = 'verified';
        $order->save();

        foreach ($request->input('budgets') as $budgetId => $quantity) {
            if ($quantity > 0) {
                $drugBudget = DrugBudget::find($budgetId);
                $drugBudget->stock -= $quantity;
                $drugBudget->save();

                DrugDistribution::create([
                    'order_item_id' => $orderItem->id,
                    'budget_id' => $budgetId,
                    'quantity' => $quantity,
                ]);
            }
        }

        return redirect()->route('order.show', $order->id)->with('message', 'Pemberian obat berhasil!');
    }

    public function giveList($orderId)
    {
        $user = auth()->user();
        if ($user->role === 'petugas-puskesmas') {
            $order = Order::where('user_id', $user->id)->with(['drugDistributions.orderItem.drug', 'drugDistributions.budget'])->findOrFail($orderId);
        } else {
            $order = Order::with(['drugDistributions.orderItem.drug', 'drugDistributions.budget'])->findOrFail($orderId);
        }

        // Dapatkan semua nama budget yang unik
        $budgets = $order->drugDistributions->pluck('budget.name')->unique();

        // Kelompokkan data berdasarkan nama obat
        $groupedDistributions = $order->drugDistributions
            ->groupBy(function ($distribution) {
                return $distribution->orderItem->drug->name;
            })
            ->map(function ($group) use ($budgets) {
                $budgetQuantities = [];

                // Inisialisasi semua budget dengan 0
                foreach ($budgets as $budget) {
                    $budgetQuantities[$budget] = 0;
                }

                // Hitung quantity per budget
                foreach ($group as $distribution) {
                    $budgetName = $distribution->budget->name;
                    $budgetQuantities[$budgetName] += $distribution->quantity;
                }

                return [
                    'drug_name' => $group->first()->orderItem->drug->name,
                    'budgets' => $budgetQuantities,
                    'total_quantity' => array_sum($budgetQuantities),
                ];
            });

        return view('give.list', compact('order', 'groupedDistributions', 'budgets'));
    }

    public function uploadAttachment(Request $request, $orderId)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $order = Order::findOrFail($orderId);

        $filePath = $request->file('attachment')->store('attachments', 'public');

        $order->attachments()->create([
            'file_path' => $filePath
        ]);

        return redirect()->back()->with('success', 'Bukti berhasil di-upload.');
    }

    public function updateDone($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => 'done'
        ]);

        return redirect(route('lplpo.index', absolute: false))->with('message', 'Pesanan Telah Selesai');
    }

    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect(route('order.index', absolute: false))->with('message', 'Pesanan Berhasil di Hapus');
    }
}
