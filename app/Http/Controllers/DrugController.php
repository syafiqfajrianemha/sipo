<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Drug;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    public function index()
    {
        $drugs = Drug::with('budgets')->get();

        foreach ($drugs as $drug) {
            $drug->total_stock = $drug->budgets->sum('pivot.stock');
        }

        return view('drug.index', compact('drugs'));
    }

    public function create()
    {
        $budgets = Budget::all();
        return view('drug.create', compact('budgets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stocks.*' => 'required|integer|min:0',
        ]);

        $drug = Drug::create([
            'name' => $request->name,
            'unit' => $request->unit,
            'description' => $request->description,
        ]);

        foreach ($request->stocks as $budgetId => $stock) {
            $drug->budgets()->attach($budgetId, ['stock' => $stock]);
        }

        return redirect(route('obat.index', absolute: false))->with('message', 'Obat Berhasil di Tambahkan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $drug = Drug::findOrFail($id);
        $budgets = Budget::all();
        return view('drug.edit', compact('drug', 'budgets'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stocks.*' => 'required|integer|min:0',
        ]);

        $drug = Drug::findOrFail($id);

        $drug->update([
            'name' => $request->name,
            'unit' => $request->unit,
            'description' => $request->description,
        ]);

        foreach ($request->stocks as $budgetId => $stock) {
            $drug->budgets()->updateExistingPivot($budgetId, ['stock' => $stock]);
        }

        return redirect(route('obat.index', absolute: false))->with('message', 'Obat Berhasil di Edit');
    }

    public function destroy($id)
    {
        $drug = Drug::findOrFail($id);
        $drug->delete();
        return redirect(route('obat.index', absolute: false))->with('message', 'Obat Berhasil di Hapus');
    }
}
