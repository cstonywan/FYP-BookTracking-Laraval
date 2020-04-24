@extends('layouts.app')

@section('content')

<div class="container">
    <div class="justify-content-center">
        <!-- <h1 align="center">{{ $book->title}}</h1> -->
        <div class="col-md-12 justify-content-center">

            @if(session()->has('update_message'))
            <div class="alert alert-success alert-dismissable" style="Font-size:25px;Font-weight:bold;min-width:1200px;">
                Success! You had lead the book.
            </div>
            @endif
            <!--For show image -->
            <!-- <?php /*$result = $_GET['image'];*/ ?> -->
            <!-- <img src="images/gallery/<?php /*echo $result; */?>.jpg">  -->
            <div class="row justify-content-center">
                @if($book->image)
                    <img src="/storage/{{ $book->image }}" weight="250" height="350" class="border">
                @else
                    <img src="/storage/uploads/default.png" class="border" weight="250" height="350">
                @endif
            </div>
        </div>

         <!--For show Book Details -->

        <div class="col-md-12">
            <h1>Details:</h1>
            <table class="table table-hover table-dark" style="min-width:200px">
                <tr>
                    <td scope="col" class="font-weight-bold">Book Name :</td>
                    <td scope="col">{{$book->title}}</td>
                </tr>
                <tr>
                    <td scope="col" class="font-weight-bold">Author :</td>
                    <td scope="col">{{$book->author}}</td>
                </tr>
                <tr>
                    <td scope="col" class="font-weight-bold">Publisher :</td>
                    <td scope="col">{{$book->publisher}}</td>
                </tr>
                <tr>
                    <td scope="col" class="font-weight-bold">Publication Year :</td>
                    <td scope="col">{{$book->publicationYear}}</td>
                </tr>
                <tr>
                    <td scope="col" class="font-weight-bold">Language :</td>
                    <td scope="col">{{$book->language}}</td>
                </tr>
                <tr>
                    <td scope="col" class="font-weight-bold">ISBN :</td>
                    <td scope="col">{{$book->ISBN}}</td>
                </tr>
                <tr>
                    <td scope="col" class="font-weight-bold">Page Number :</td>
                    <td scope="col">{{$book->pageNumber}}</td>
                </tr>
                <tr>
                    <td scope="col" class="font-weight-bold">Description :</td>
                    <td scope="col">{{$book->description}}</td>
                </tr>
                <tr>
                    <td scope="col" class="font-weight-bold">Status :</td>
                    <td scope="col">{{$book->status}}</td>
                </tr>
            </table>
            <br>
            @if (Auth::user()->role >= 1 && $book->status == "inLibrary")
            <div class="">
              <form action="{{ route('manageBorrow') }}" method="get">
                  @csrf
                  <input type="hidden" name="book_id" value="{{ $book->id }}">
                  <button type="submit" id="leadbook_btn" class="btn btn-primary btn-lg btn-block" >Lead Book</a>
              </form>
            </div>
            <br>
            @endif
            <div class="">
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="window.location='{{ url('/b/track/'.$book->id) }}'">Track Book</button>
            </div>
        </div>
    </div>
</div>
@endsection
