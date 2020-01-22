<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $materials = Material::where(function($q) use($request) {

            return $q->when($request->search, function($query) use($request) {

                return $query->where("material_name", "like", "%{$request->search}%")
                ->orWhere("supplier", "like", "%{$request->search}%")
                ->orWhere("unit_price", "like", "%{$request->search}%")
                ->orWhere("created_at", "like", "%{$request->search}%");
            });

        })->latest()->paginate(5);

        return view('dashboard.materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.materials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'material_name' => 'required | string | max:255',
            'supplier' => 'required | string | max:255',
            'amount' => 'required',
            'unit_price' => 'required | numeric',
            'paid' => 'required | numeric',
        ]);

        $remain = ($request->unit_price * $request->amount) - $request->paid;

        Material::create($data + ['remain' => $remain]);

        session()->flash('success', 'تم إضافة البيانات بنجاح');

        return redirect()->route('materials.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        return view('dashboard.materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $data = $request->validate([
            'material_name' => 'required | string | max:255',
            'supplier' => 'required | string | max:255',
            'amount' => 'required',
            'unit_price' => 'required | numeric',
            'paid' => 'required | numeric',
        ]);

        $remain = ($request->unit_price * $request->amount) - $request->paid;

        $material->update($data + ['remain' => $remain]);

        session()->flash('success', 'تم تعديل البيانات بنجاح');

        return redirect()->route('materials.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        $material->delete();

        session()->flash('success', 'تم حذف البيانات بنجاح');

        return redirect()->route('materials.index');
    }
}
