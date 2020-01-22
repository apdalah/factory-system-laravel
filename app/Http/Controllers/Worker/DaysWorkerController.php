<?php

namespace App\Http\Controllers\Worker;

use App\DaysWorker;
use App\Worker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DaysWorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Worker $worker)
    {
        $days = DaysWorker::where('worker_id', $worker->id)->where(function($q) use($request) {

            return $q->when($request->search, function($query) use($request) {

                return $query->where("day", "like", "%{$request->search}%")
                ->orWhere("description", "like", "%{$request->search}%")
                ->orWhere("created_at", "like", "%{$request->search}%")
                ->orWhere("updated_at", "like", "%{$request->search}%");
            });
        })->latest()->paginate(5);

        return view('dashboard.workers.days.index', compact('days', 'worker'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Worker $worker)
    {
        return view('dashboard.workers.days.create', compact('worker'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Worker $worker)
    {
        $data = $request->validate([
            'day' => 'required | string',
            'description' => 'required',
            'price' => 'required | numeric',
            'paid' => 'required | numeric',
        ]);

        $remain = $request->price - $request->paid;

        DaysWorker::create($data + ['worker_id' => $worker->id, 'remain' => $remain]);

        session()->flash('success', 'تم إضافة البيانات بنجاح');

        return redirect()->route('workers.days_worker.index', $worker->id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DaysWorker  $daysWorker
     * @return \Illuminate\Http\Response
     */
    public function edit(Worker $worker, DaysWorker $daysWorker)
    {
        return view('dashboard.workers.days.edit', compact('daysWorker', 'worker'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DaysWorker  $daysWorker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $worker, DaysWorker $daysWorker)
    {
        $data = $request->validate([

                'day' => 'required | string',
                'description' => 'required',
                'price' => 'required | numeric',
                'paid' => 'required | numeric',
            ]);

        $remain = $request->price - $request->paid;

        $daysWorker->update($data + ['remain' => $remain]);

        session()->flash('success', 'تم تعديل البيانات بنجاح');

        return redirect()->route('workers.days_worker.index', $worker);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DaysWorker  $daysWorker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Worker $worker, DaysWorker $daysWorker)
    {
        $daysWorker->delete();

        session()->flash('success', 'تم حذف البيانات بنجاح');

        return redirect()->route('workers.days_worker.index', $worker->id);
    }
}
