<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        return view('unit.index', compact('units'));
    }

    public function create()
    {
        return view('unit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric',
            'postal_code' => 'required|numeric'
        ]);

        Unit::create($request->all());

        return redirect(route('unit.index', absolute: false))->with('message', 'Unit Berhasil di Tambahkan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('unit.edit', compact('unit'));
    }

    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        $request->validate([
            'category' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric',
            'postal_code' => 'required|numeric'
        ]);

        $unit->update($request->all());

        return redirect(route('unit.index', absolute: false))->with('message', 'Unit Berhasil di Edit');
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();
        return redirect(route('unit.index', absolute: false))->with('message', 'Unit Berhasil di Hapus');
    }
}
