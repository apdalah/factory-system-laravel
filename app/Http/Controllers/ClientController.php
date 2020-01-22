<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $clients = Client::where(function($q) use($request) {

            return $q->when($request->search, function($query) use($request) {

                return $query->where("name", "like", "%{$request->search}%")
                ->orWhere("phone", "like", "%{$request->search}%")
                ->orWhere("address", "like", "%{$request->search}%");
            });
        })->latest()->paginate(5);

        return view('dashboard.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required | string | max:255',
            'phone.0' => 'required | max:15',
            'address' => 'required | string | max:255',
        ]);

        Client::create($request->all());

        session()->flash('success', 'تم إضافة البيانات بنجاح');

        return redirect()->route('clients.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => 'required | string | max:255',
            'phone' => 'required  | max:15',
            'address' => 'required | string | max:255',
        ]);

        $client->update($data);

        session()->flash('success', 'تم تعديل البيانات بنجاح');

        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        session()->flash('success', 'تم حذف البيانات بنجاح');

        return redirect()->route('clients.index');
    }
}
