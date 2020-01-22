<?php

namespace App\Http\Controllers;

use App\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sales = Sale::where(function($q) use($request) {

            return $q->when($request->search, function($query) use($request) {

                return $query->where("buyer", "like", "%{$request->search}%")
                ->orWhere("material", "like", "%{$request->search}%")
                ->orWhere("created_at", "like", "%{$request->search}%");
            });

        })->latest()->paginate(5);

        return view('dashboard.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.sales.create');
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
            'buyer' => 'required | string | max:255',
            'material' => 'required | string | max:255',
            'amount' => 'required | numeric',
            'unit_price' => 'required | numeric',
            'paid' => 'required | numeric',
        ]);

        $remain = ($request->unit_price * $request->amount) - $request->paid;

        Sale::create($data + ['remain' => $remain]);

        session()->flash('success', 'تم إضافة البيانات بنجاح');

        return redirect()->route('sales.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        return view('dashboard.sales.edit', compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $data = $request->validate([
            'buyer' => 'required | string | max:255',
            'material' => 'required | string | max:255',
            'amount' => 'required | numeric',
            'unit_price' => 'required | numeric',
            'paid' => 'required | numeric',
        ]);

        $remain = ($request->unit_price * $request->amount) - $request->paid;

        $sale->update($data + ['remain' => $remain]);

        session()->flash('success', 'تم تعديل البيانات بنجاح');

        return redirect()->route('sales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        session()->flash('success', 'تم حذف البيانات بنجاح');

        return redirect()->route('sales.index');
    }
}
