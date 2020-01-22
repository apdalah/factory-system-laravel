<?php

namespace App\Http\Controllers\Car;

use App\DaysCar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DaysCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $days = DaysCar::where(function($q) use($request) {

            return $q->when($request->search, function($query) use($request) {

                return $query->where("driver", "like", "%{$request->search}%")
                ->orWhere("description", "like", "%{$request->search}%")
                ->orWhere("day", "like", "%{$request->search}%")
                ->orWhere("created_at", "like", "%{$request->search}%");
            });
        })->latest()->paginate(5);

        return view('dashboard.days_car.index', compact('days'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.days_car.create');
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
            'driver' => 'required | string | max:255',
            'day' => 'required | string | max:255',
            'description' => 'required',
            'price' => 'required | numeric',
            'paid' => 'required | numeric',
        ]);

        $remain = $request->price - $request->paid;

        DaysCar::create($data + ['remain' => $remain]);

        session()->flash('success', 'تم إضافة البيانات بنجاح');

        return redirect()->route('days_car.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DaysCar  $daysCar
     * @return \Illuminate\Http\Response
     */
    public function edit(DaysCar $daysCar)
    {
        return view('dashboard.days_car.edit', compact('daysCar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DaysCar  $daysCar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DaysCar $daysCar)
    {
        $data = $request->validate([
            'driver' => 'required | string | max:255',
            'day' => 'required | string | max:255',
            'description' => 'required',
            'price' => 'required | numeric',
            'paid' => 'required | numeric',
        ]);

        $remain = $request->price - $request->paid;

        $daysCar->update($data + ['remain' => $remain]);

        session()->flash('success', 'تم تعديل البيانات بنجاح');

        return redirect()->route('days_car.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DaysCar  $daysCar
     * @return \Illuminate\Http\Response
     */
    public function destroy(DaysCar $daysCar)
    {
        $daysCar->delete();

        session()->flash('success', 'تم حذف البيانات بنجاح');

        return redirect()->route('days_car.index');
    }
}
