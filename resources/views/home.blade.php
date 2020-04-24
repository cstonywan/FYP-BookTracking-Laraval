@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
	   <!-- <div class="alert alert-success" role="alert">
                    Welcome back! {{ Auth::user()->username }}!
            </div>-->

 	            @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

		<div class="card">

		<div class="card-header">Dashboard</div>

                <div class="card-body">



                    <div class="">
                        <a href="{{ route('manageBook') }}">Book Management</a>
                    </div>
                    <div class="">
                        <a href="{{ route('searchBook') }}">Search Book</a>
                    </div>
                    <div class="">
                        <a href="{{ route('manageUser') }}">User Management</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Important!!!</div>
                <div class="card-body">
                    <div class="">
                        <p>/app/Http/Controllers/BooksController.php</p>
                        <p>^^^^^^^^^</p>
                        <p>This part is different from the zip file</p>
                        <p>Since the upload image method is different</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Github</div>
                <div class="card-body">
                    <div class="">
                        <a href="https://github.com/jarvisTse/BookTracking">https://github.com/jarvisTse/BookTracking</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Update info</div>
                <div class="card-body">
                    <div class="">
                        <p>
                          <a class="btn btn-primary" data-toggle="collapse" href="#update8">19/3 22:00 Update List:</a>
                        </p>
                        <div class="collapse pb-2" id="update8">
                          <div class="card card-body">
                            <p>Update content:</p>
                            <p>Borrow System</p>
                            <p>I has almost updated all the file</p>
                          </div>
                        </div>
                        <p>
                          <a class="btn btn-primary" data-toggle="collapse" href="#update1">26/3 22:00 Update List:</a>
                        </p>
                        <div class="collapse pb-2" id="update1">
                          <div class="card card-body">
                            <p>Update content:</p>
                            <p>Validation, remove create borrow page</p>
                            <br>
                            <p>Update file:</p>
                            <p>Whole views folders</p>
                            <p>JS file: book_manage.js, borrow.js, user_manage.js</p>
                            <p>Controller: Books, Borrows, Users</p>
                            <p>Route: web.php</p>
                          </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
