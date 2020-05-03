@extends('layouts.app')

@section('content')
<head>

</head>
<div class="container">
    <div class="justify-content-center">
        <h1 align="center">Book Searching System</h1>
        <form action="" method="get">
            @csrf

            <div class="form-group row justify-content-center pt-3">
                <div class="pt-1 col-md-2 d-none d-md-block">
                    <img src="/icon/search.svg" height="30px" align="right">
                </div>
                <div class="col-md-2 ">
                    <select id="search_field"  class="form-control custom-select custom-select-lg mb-3" name="search_field">
                        <option value="all" selected>All Field</option>
                        <option value="id">ID</option>
                        <option value="title">Title</option>
                        <option value="type">Type</option>
                        <option value="author">Author</option>
                        <option value="publisher">Publisher</option>
                        <option value="publicationYear">Publication Year</option>
                        <option value="language">Language</option>
                        <option value="ISBN">ISBN</option>
                        <option value="description">Description</option>
                        <option value="pageNumber">Page Number</option>
                    </select>
                </div>
                <div class="col-md-5 col-sm-12">
                    <input  id="search_content" type="text" class="form-control" style="height:28px" name="search_content" value="{{ old('search_content') }}" placeholder="Search" autocomplete="search_content" autofocus>
                </div>
                <div class="col-md-2 col-sm-12 mt-3 mt-md-0 text-md-left text-right">
                    <button type="submit" class="btn btn-info btn-lg">
                    <span style="color:#FFFFFF" class="glyphicon glyphicon-search"></span><strong style="color:#FFFFFF"> Search</strong>
                    </button>
                </div>
            </div>
        </form>

        <table class="table table-hover table-light">

        <tbody>
          @foreach ($books as $book)
            <tr>
                <!-- <td width="1%" style="color:#9FA2A1">{{ $book->id }}</td> -->
                <td width="10%">
                    @if($book->image)
                    <img src="/storage/{{ $book->image }}" weight="100" height="150" class="rounded mx-auto d-block border">
                    @else
                    <img src="/storage/uploads/default.png" weight="100" height="150" class="rounded mx-auto d-block border">
                    @endif
                </td>
                <td>
                <div class ="row">
                    <div class="media-content-type align-self-start">
                       
                        <div class="col-md-12">
                            <span class="text-success" style="width:60%"><i>{{ $book->type }}</i></span>
                            <span style="color:#955915"><b><sup>{{ $book->status }}</sup></b></span>
                            <span>
                            <a href="{{ url('/b/detail/' . $book->id) }}" class="book-show-modal btn btn-link">
                                <h2 onclick="location.href='{{ url('/b/detail/' . $book->id) }}'"><Strong class="text-info">{{ $book->title }}</Strong></h2></a>
                            </span>
                        </div>

                        <div class="col-md-6"><strong style="color:#043364">Author: </strong>  <p style="color:#8a8a8a">@if($book->author) {{ $book->author }} @else N/A @endif</p></div>
                        <div class="col-md-6"><strong style="color:#043364">Language: </strong> <p style="color:#8a8a8a">@if($book->language) {{$book->language }} @else N/A @endif</p></div>
                        <div class="col-md-12" style="color:#9FA2A1">{{ $book->description }}</div>
                    </div>                   
                </div>
                </td>
                <td>
                    @if($book->status=="inLibrary")
                        <div class="col-md-3">                                   
                                <span>
                                    <button type="button" class="btn btn-info" title="Track Book" style="background: transparent;border: none;background-repeat:no-repeat;  outline:none;" onclick="window.location='{{ url('/b/track/'.$book->id) }}'">
                                    <img src="/icon/track.png" style ="border:0;"width="50px" height="50px">                                   
                                    </button>
                                </span>
                        </div>
                            @else
                        <div class="col-md-3">    
                            <span>
                                <button type="button" class="btn btn-info" title="Track Book" style="background: transparent;border: none;background-repeat:no-repeat;  outline:none;" onclick="window.location='{{ url('/b/track/'.$book->id) }}'" disabled>
                                <img src="/icon/track.png" style ="border:0;"width="50px" height="50px">                                   
                                </button>
                            </span>
                        </div>
                    @endif
                </td>
                <!-- <td class="text-center">
                    <a href="{{ url('/b/detail/' . $book->id) }}" class="book-show-modal btn btn-info btn-lg">
                    <i class="glyphicon glyphicon-eye-open"></i></a>
                </td> -->
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>
@endsection
