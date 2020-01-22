<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::where(function($q) use($request) {

            return $q->when($request->search, function($query) use($request) {

                return $query->where("name", "like", "%{$request->search}%")
                ->orWhere("email", "like", "%{$request->search}%");
            });
        })->latest()->paginate(5);

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
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
            'email' => 'required | email | unique:users',
            'password' => 'required | min:8 | confirmed'
        ]);

        User::create($data);

        session()->flash('success', 'تم إضافة البيانات بنجاح');

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required | string | max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user)]
        ]);

        if($request->password)
        {
            $data += $request->validate(['password' => 'required | min:8 | confirmed']);
        }

        $user->update($data);

        session()->flash('success', 'تم تعديل البيانات بنجاح');

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        session()->flash('success', 'تم حذف البيانات بنجاح');

        return redirect()->route('users.index');
    }
}
