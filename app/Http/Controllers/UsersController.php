<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function manage()
    {
        $sort = request('sort');
        $paginate = 10;
        if ($sort == null) {
            $users = User::paginate($paginate);
        } else {
            if ($sort == 'role') {
                $users = User::orderBy($sort, 'desc')->paginate($paginate);
            } else {
                $users = User::orderBy($sort)->paginate($paginate);
            }
        }
        $entries = $users->total();
        $start = $users->currentPage() * $paginate - $paginate + 1;
        $end = $users->currentPage() * $paginate;
        if ($end > $entries) {
            $end = $entries;
        }
        $show = "Showing " . $start . " to " . $end . " of " . $entries . " entries";
        return view('users.manage')->with('users', $users)->with('show', $show)->with('sort', $sort);
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
            'password-confirm' => 'required|same:password',
            'photo' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }

        $image = request('photo');

        if ($image == null) {
            $imagePath = "photo/defaultuser.png";
        } 
        else {
            $imagePath = $image->store('photo', 'public');
        }

        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'role' => request('role'),
            'photo' => $imagePath,
        ]);

        Session::flash('message', 'User has been created.');
    }

    public function edit(request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255|unique:users,name,' . $request->id,
            'email' => 'required|email|max:255|unique:users,email,' . $request->id,
            'photo' => 'nullable|image'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }

        $image = $request->photo;

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($image != null) {
            if ($user->photo && $user->photo != "photo/defaultuser.png") {
                $url = storage_path('app/public/'.$user->photo);
                if (file_exists($url)) {
                    unlink($url);
                }
            }
            $imagePath = $image->store('photo', 'public');
            $user->photo = $imagePath;
        }
        $user->save();

        Session::flash('message', 'User has been edited.');
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user->photo){
            $url = storage_path('app/public/'.$user->photo);
            if (file_exists($url)) {
                unlink($url);
            }
        }
        $user->delete();

        Session::flash('message', 'User has been deleted.');
    }

    public function getProfile() {
        return view('users.edit');
    }

    public function editProfile() {
        $validator = Validator::make(request()->all(), [
            'id' => 'required',
            'name' => 'required|max:255|unique:users,name,' . request('id'),
            'email' => 'required|email|max:255|unique:users,email,' . request('id'),
            'photo' => 'nullable|image'
        ]);

        if ($validator->fails()) {
            return Redirect::to('/profile')->withErrors($validator);
        }
        else {
            $image = request('photo');

            $user = User::find(request('id'));
            $user->name = request('name');
            $user->email = request('email');
            if ($image != null) {
                if ($user->photo && $user->photo != "photo/defaultuser.png") {
                    $url = storage_path('app/public/'.$user->photo);
                    if (file_exists($url)) {
                        unlink($url);
                    }
                }
                $imagePath = $image->store('photo', 'public');
                $user->photo = $imagePath;
            }
            $user->save();

            Session::flash('message', 'Profile has been edited.');

            return redirect()->back();
        }
    }

}
