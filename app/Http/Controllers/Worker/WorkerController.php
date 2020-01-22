<?php

namespace App\Http\Controllers\Worker;

use App\Worker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $workers = Worker::where(function($q) use($request) {

            return $q->when($request->search, function($query) use($request) {

                return $query->where("name", "like", "%{$request->search}%")
                ->orWhere("job", "like", "%{$request->search}%");
            });
        })->latest()->paginate(5);

        return view('dashboard.workers.index', compact('workers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.workers.create');
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
            'name' => 'required | string | max:255',
            'job' => 'required | string | max:255',
        ]);

        Worker::create($data);

        session()->flash('success', 'تم إضافة البيانات بنجاح');

        return redirect()->route('workers.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function edit(Worker $worker)
    {
        return view('dashboard.workers.edit', compact('worker'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Worker $worker)
    {
        $data = $request->validate([
            'name' => 'required | string | max:255',
            'job' => 'required | string | max:255',
        ]);

        $worker->update($data);

        session()->flash('success', 'تم تعديل البيانات بنجاح');

        return redirect()->route('workers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Worker $worker)
    {
        $worker->delete();

        session()->flash('success', 'تم حذف البيانات بنجاح');

        return redirect()->route('workers.index');
    }
}
