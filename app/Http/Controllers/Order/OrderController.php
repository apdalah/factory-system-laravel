<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::where(function($q) use($request) {

            return $q->when($request->search, function($query) use($request) {

                return $query->where("title", "like", "%{$request->search}%")
                ->orWhere("description", "like", "%{$request->search}%")
                ->orWhere("created_at", "like", "%{$request->search}%")
                ->orWhere("updated_at", "like", "%{$request->search}%");
            });
        })->latest()->paginate(5);

        return view('dashboard.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        return view('dashboard.orders.create', compact('clients'));
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

            'client_id' => 'required | numeric',
            'title' => 'required | string | max:255',
            'description' => 'required | string'
        ]);

        Order::create($data + ['status' => '0']);

        session()->flash('success', 'تم إضافة البيانات بنجاح');

        return redirect()->route('orders.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $clients = Client::all();
        return view('dashboard.orders.edit', compact('order', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([

            'client_id' => 'required | numeric',
            'title' => 'required | string | max:255',
            'description' => 'required | string'
        ]);

        $order->update($data);

        session()->flash('success', 'تم تعديل البيانات بنجاح');

        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        session()->flash('success', 'تم حذف البيانات بنجاح');

        return redirect()->route('orders.index');
    }


    public function update_status($order)
    {
        $order = Order::findOrFail($order);
        if($order->status == 0){

            $order->update(['status' => '1']);
        }else{

            $order->update(['status' => '0']);
        }

        return back();
    }
    
}
