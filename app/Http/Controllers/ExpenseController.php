<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $expenses = Expense::where(function($q) use($request) {

            return $q->when($request->search, function($query) use($request) {

                return $query->where("description", "like", "%{$request->search}%")
                ->orWhere("supplier", "like", "%{$request->search}%")
                ->orWhere("price", "like", "%{$request->search}%")
                ->orWhere("created_at", "like", "%{$request->search}%");
            });

        })->latest()->paginate(5);

        return view('dashboard.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.expenses.create');
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
            'description' => 'required | string | max:255',
            'supplier' => 'required | string | max:255',
            'price' => 'required | numeric',
            'paid' => 'required | numeric',
        ]);

        $remain = $request->price - $request->paid;

        Expense::create($data + ['remain' => $remain]);

        session()->flash('success', 'تم إضافة البيانات بنجاح');

        return redirect()->route('expenses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        return view('dashboard.expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'description' => 'required | string | max:255',
            'supplier' => 'required | string | max:255',
            'price' => 'required | numeric',
            'paid' => 'required | numeric',
        ]);

        $remain = $request->price - $request->paid;

        $expense->update($data + ['remain' => $remain]);

        session()->flash('success', 'تم تعديل البيانات بنجاح');

        return redirect()->route('expenses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        session()->flash('success', 'تم حذف البيانات بنجاح');

        return redirect()->route('expenses.index');
    }
}
