<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Borrow;
use App\Book;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BorrowsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function manage(Request $request)
    {
        $content = $request->search_content;
        $field = $request->search_field;

        $book_id = $request->book_id;

        $users = User::all();
        $books = Book::all();

        if ($content == null or $content == '')
            $borrows = Borrow::whereNotNull('id');
        else if ($field == "book_title") {
            $matchbooks = Book::select('id')->where('title', 'like', '%'.$content.'%')->get();
            $borrows = Borrow::whereIn('book_id', $matchbooks);
        }
        else if ($field == "user_name") {
            $matchusers = User::select('id')->where('name', 'like', '%'.$content.'%')->get();
            $borrows = Borrow::whereIn('user_id', $matchusers);
        }
        else
            $borrows = Borrow::where($field, 'like', '%'.$content.'%');

        $sort = $request->sort;
        $paginate = 10;
        if ($sort == null) {
            $borrows = $borrows->paginate($paginate);
        } else {
            $borrows = $borrows->orderBy($sort)->paginate($paginate);
        }
        $entries = $borrows->total();
        $start = $borrows->currentPage() * $paginate - $paginate + 1;
        $end = $borrows->currentPage() * $paginate;
        if ($end > $entries) {
            $end = $entries;
        }
        $show = "Showing " . $start . " to " . $end . " of " . $entries . " entries";

        return view('borrows.manage', compact('borrows', 'users', 'books', 'book_id', 'show', 'sort'));
    }

    public function record($id)
    {
        $user = User::find($id);
        if ($user->role == 0)
            $records = Borrow::where('user_id', '=', $id);
        else {
            $records = Borrow::where('staff_id', '=', $id);
        }

        $sort = request('sort');
        $paginate = 10;
        if ($sort == null) {
            $records = $records->paginate($paginate);
        } else if ($sort == 'title') {
            $records = $records->join('books', 'books.id', 'borrows.book_id')->orderBy($sort)->select('borrows.*')->orderBy($sort)->paginate($paginate);
        } else {
            $records = $records->orderBy($sort)->paginate($paginate);
        }
        $entries = $records->total();
        $start = $records->currentPage() * $paginate - $paginate + 1;
        $end = $records->currentPage() * $paginate;
        if ($end > $entries) {
            $end = $entries;
        }
        $show = "Showing " . $start . " to " . $end . " of " . $entries . " entries";

        return view('borrows.record', compact('records', 'user', 'show', 'sort'));
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'book_id' => 'required|integer',
            'user_id' => 'required|integer',
            'borrow_at' => 'required|date',
            'deadline_at' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }

        $validator->after(function($validator) {
            if (!Book::find(request('book_id'))) {
                $validator->errors()->add('book_id', 'Cannot found the book.');
            }
            else if (Book::find(request('book_id'))->status != 'inLibrary') {
                $validator->errors()->add('book_id', 'The book is ' . Book::find(request('book_id'))->status . '.');
            }
            else;
            if (!User::find(request('user_id'))) {
                $validator->errors()->add('user_id', 'Cannot found the user.');
            }
            else if (User::find(request('user_id'))-> role != 0) {
                $validator->errors()->add('user_id', 'Staff cannot borrow book.');
            }
            else;
            if (request('borrow_at') > request('deadline_at')) {
                $validator->errors()->add('deadline_at', 'Deadline cannot earlier than borrow date.');
            }
        });

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }

        $data = array(
            'book_id' => (int)request('book_id'),
            'user_id' => (int)request('user_id'),
            'staff_id' => Auth::id(),
            'borrow_at' => request('borrow_at'),
            'deadline_at' => request('deadline_at'),
            'return_at' => null,
            'renewal_num' => 0,
        );
        $b = Borrow::create($data);
        $book = Book::find(request('book_id'));
        $book->status = "Lend";
        $book->save();
        Session::flash('message', 'The record has been created.');
    }

    public function remand($id)
    {
        $borrow = Borrow::find($id);
        $borrow->return_at = request('return_at');
        $borrow->save();
        $book = $borrow->book;
        $book->status = "inLibrary";
        $book->save();
        Session::flash('message', 'The book has been returned.');
    }

    public function renewal($id)
    {
        $borrow = Borrow::find($id);
        $borrow->deadline_at = request('deadline_at');
        $borrow->renewal_num = $borrow->renewal_num + 1;
        $borrow->save();
        Session::flash('message', 'Deadline has been postponed to ' . request('deadline_at') . '.');
    }

    public function edit($id)
    {
        $validator = Validator::make(request()->all(), [
            'book_id' => 'required|integer',
            'user_id' => 'required|integer',
            'staff_id' => 'required|integer',
            'renewal_num' => 'required|integer',
            'borrow_at' => 'required|date',
            'deadline_at' => 'required|date',
            'return_at' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }
        $validator->after(function($validator) {
            if (!Book::find(request('book_id'))) {
                $validator->errors()->add('book_id', 'Cannot found the book.');
            }
            else if (Book::find(request('book_id'))->status != 'inLibrary' && request('book_id') != Borrow::find(request('id'))->book_id) {
                $validator->errors()->add('book_id', 'The book is ' . Book::find(request('book_id'))->status . '.');
            }
            else;
            if (!User::find(request('user_id'))) {
                $validator->errors()->add('user_id', 'Cannot found the user.');
            }
            else if (User::find(request('user_id'))-> role != 0) {
                $validator->errors()->add('user_id', 'Staff cannot borrow book.');
            }
            else;
            if (!User::find(request('staff_id'))) {
                $validator->errors()->add('staff_id', 'Cannot found the staff.');
            }
            else if (User::find(request('staff_id'))->role < 1) {
                $validator->errors()->add('staff_id', 'The user is not a staff.');
            }
            else;
            if (request('borrow_at') > request('deadline_at')) {
                $validator->errors()->add('deadline_at', 'Deadline cannot earlier than borrow date.');
            }
        });
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }
        $borrow = Borrow::find($id);
        $borrow->book_id = (int)request('book_id');
        $borrow->user_id = (int)request('user_id');
        $borrow->staff_id = (int)request('staff_id');
        $borrow->renewal_num = (int)request('renewal_num');
        $borrow->borrow_at = request('borrow_at');
        $borrow->deadline_at = request('deadline_at');
        $borrow->return_at = request('return_at');
        $borrow->save();
        Session::flash('message', 'Borrow record has been edited.');
    }

    public function delete($id)
    {
        $borrow = Borrow::find($id);
        $borrow->delete();
        Session::flash('message', 'Borrow record has been deleted.');
    }

    // php artisan migrate:refresh --path=/database/migrations/2020_02_24_103035_create_borrows_table.php
}



