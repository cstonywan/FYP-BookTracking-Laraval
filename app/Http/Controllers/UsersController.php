<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function manage()
    {
        $users = User::all();
        return view('users.manage')->with('users', $users);
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
            'password_confirm' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }

        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'role' => request('role'),
        ]);

        Session::flash('message', 'User has been created.');
    }

    public function edit(request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255|unique:users,name,' . $request->id,
            'email' => 'required|email|max:255|unique:users,email,' . $request->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        Session::flash('message', 'User has been edited.');
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        Session::flash('message', 'User has been deleted.');
    }
}
