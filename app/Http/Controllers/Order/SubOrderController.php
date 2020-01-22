<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Category;
use App\SubOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Order $order)
    {
        $sub_orders = SubOrder::where(function($q) use ($request) {

            return $q->when($request->search, function($query) use($request) {

                return $query->where("created_at", "like", "%{$request->search}%")
                ->orWhere("updated_at", "like", "%{$request->search}%");
            });
        })->latest()->paginate(6);

        return view('dashboard.orders.sub_orders.index', compact('sub_orders', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Order $order)
    {
        $categories = Category::all();
        return view('dashboard.orders.sub_orders.create', compact('order', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $order)
    {
        $data = $request->validate([

            'category_id' => 'required | numeric',
            'amount' => 'required | numeric',
            'unit_price' => 'required | numeric',
            'paid' => 'required | numeric',
        ]);

        $cat = Category::where('id', $request->category_id)->first();

        if($cat->stock < $request->amount){

            session()->flash('warning', 'لا يمكن انشاء هذه الطلبيه حيث ان الكميه الموجوده فى المخزن أقل من الكميه المطلوبه');

            return redirect()->route('orders.sub_orders.index', $order);

        }

        $total_stock = $cat->stock - $request->amount;

        // update stock

        Category::where('id', $request->category_id)->update(['stock' => $total_stock]);

        $remain = ($request->amount * $request->unit_price) - $request->paid;

        SubOrder::create($data + ['order_id' => $order, 'remain' => $remain]);

        session()->flash('success', 'تم إضافة البيانات بنجاح');

        return redirect()->route('orders.sub_orders.index', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubOrder  $subOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order, SubOrder $subOrder)
    {
        $categories = Category::all();
        return view('dashboard.orders.sub_orders.edit', compact('order', 'subOrder', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubOrder  $subOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $order, SubOrder $subOrder)
    {
        $data = $request->validate([

            'category_id' => 'required | numeric',
            'amount' => 'required | numeric',
            'unit_price' => 'required | numeric',
            'paid' => 'required | numeric',
        ]);

        $cat = Category::where('id', $request->category_id)->first();

        if($cat->stock + $subOrder->amount < $request->amount){

            session()->flash('warning', 'لا يمكن انشاء هذه الطلبيه حيث ان الكميه الموجوده فى المخزن أقل من الكميه المطلوبه');

            return redirect()->route('orders.sub_orders.index', $order);

        }

        $total_stock = ($cat->stock + $subOrder->amount)  - $request->amount;

        // update stock

        Category::where('id', $request->category_id)->update(['stock' => $total_stock]);

        $remain = ($request->amount * $request->unit_price) - $request->paid;

        $subOrder->update($data + ['remain' => $remain]);

        session()->flash('success', 'تم تعديل البيانات بنجاح');

        return redirect()->route('orders.sub_orders.index', $order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubOrder  $subOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy($order, SubOrder $subOrder)
    {

        $cat = Category::where('id', $subOrder->category_id)->first();

        $total_stock = $cat->stock + $subOrder->amount;

        // update stock

        Category::where('id', $subOrder->category_id)->update(['stock' => $total_stock]);

        $subOrder->delete();

        session()->flash('success', 'تم حذف البيانات بنجاح');

        return redirect()->route('orders.sub_orders.index', $order);
    }
}
