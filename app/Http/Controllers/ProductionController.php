<?php

namespace App\Http\Controllers;

use App\Production;
use App\Category;
use DB;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productions = Production::where(function($query) use($request) {

            $query->when($request->search, function($query) use($request) {

                $query->where('day', "like", "%{$request->search}%")
                ->orWhere('created_at', "like", "%{$request->search}%");
            });
        })->latest()->paginate(5);

        return view('dashboard.productions.index', compact('productions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.productions.create', compact('categories'));
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
            'category_id' => 'required',
            'day' => 'required',
            'amount' => 'required'
        ]);

        Production::create($data);

        $cat = Category::where('id', $request->category_id)->first();

        $total_stock = $cat->stock + $request->amount;

        Category::where('id', $request->category_id)->update(['stock' => $total_stock]);

        session()->flash('success', 'تم إضافة البيانات بنجاح');

        return redirect()->route('productions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function edit(Production $production)
    {
        $categories = Category::all();
        return view('dashboard.productions.edit', compact('production', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Production $production)
    {
        $data = $request->validate([
            'category_id' => 'required',
            'day' => 'required',
            'amount' => 'required'
        ]);

        $old_amount = $production->amount;

        $new_amount = $request->amount;

        $total_amount = $new_amount - $old_amount;

        $production->update($data);

        $cat = Category::where('id', $request->category_id)->first();

        $total_stock = $cat->stock + $total_amount;
        // 

        Category::where('id', $request->category_id)->update(['stock' => $total_stock]);

        session()->flash('success', 'تم تعديل البيانات بنجاح');

        return redirect()->route('productions.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Production $production)
    {
        $deleted_stock = $production->amount;

        $cat = Category::where('id', $production->category_id)->first();

        $total_stock = $cat->stock - $deleted_stock;

        Category::where('id', $production->category_id)->update(['stock' => $total_stock]);

        $production->delete();

        session()->flash('success', 'تم حذف البيانات بنجاح');

        return redirect()->route('productions.index');
    }
}
