@extends('layouts.app')

@section('content')
<div class="container text-center">
    @if (session('message'))
        <div class="alert alert-warning w-50 mx-auto" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <h1>Books list</h1> 
   
    <div class="table-responsive border">
      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th scope="col" style="color:#3A74A1" width="5%">ID
              <a href="?sort=id">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1" width="10%">Cover</th>
            <th scope="col" style="color:#3A74A1" width="20%">Title
              <a href="?sort=title">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1" width="15%">Tag ID
              <a href="?sort=title">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1" width="15%">Author
              <a href="?sort=author">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1" width="15%">Publisher
              <a href="?sort=publisher">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1" width="10%">Status
              <a href="?sort=status">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th  style="color:#3A74A1"class="text-center" width="125px">
              <a href="#" class="book-create-modal btn btn-success btn-lg">
                <i class="glyphicon glyphicon-plus"></i> Add Book
              </a>
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($books as $indexKey => $book)
          <tr>
              <td style="font-size: 15px;">{{ $book->id }}</td>
              <td>
                  @if($book->image)
                  <img src="/storage/{{ $book->image }}" class="img-thumbnail" style="width:80px;height:100px">
                  @else
                  <img src="/storage/uploads/default.png" class="img-thumbnail" style="width:80px;height:100px">
                  @endif
              </td>
              <td style="font-size: 15px;">{{ $book->title }}</td>
              <td style="font-size: 15px;">{{ $book->tag_id }}</td>
              <td style="font-size: 15px;">{{ $book->author }}</td>
              <td style="font-size: 15px;">{{ $book->publisher }}</td>
              <td style="font-size: 15px;">{{ $book->status }}</td>
              <td class="text-center">
                <a href="{{ url('/b/detail/' . $book->id) }}" class="book-show-modal btn btn-info btn-sm">
                  <i class="glyphicon glyphicon-eye-open"></i>
                </a>
                <a href="#" class="book-edit-modal btn btn-warning btn-sm" data-tagid="{{$book->tag_id}}" data-id="{{$book->id}}" data-title="{{$book->title}}" data-author="{{$book->author}}" data-publisher="{{$book->publisher}}" data-publicationyear="{{$book->publicationYear}}" data-language="{{$book->language}}" data-isbn="{{$book->ISBN}}" data-description="{{$book->description}}" data-pagenumber="{{$book->pageNumber}}" data-status="{{$book->status}}" data-type="{{$book->type}}" data-image="{{$book->image}}">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a>
                <a href="#" class="book-delete-modal btn btn-danger btn-sm" data-id="{{$book->id}}" data-title="{{$book->title}}">
                  <i class="glyphicon glyphicon-trash"></i>
                </a>
              </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <br>
    <div class="d-flex justify-content-between">
      <p>{{ $show }}</p>
      {{ $books->appends(['sort' => $sort])->links() }}
    </div>

    <h1 id="misstitle" style="display:none">Missing Book</h1><br><br>
    <button id="startcheck" class="btn btn-primary btn-lg" style="border-radius:1.5rem;"><strong>Show Missing Book</strong></button>
    <h3 id="nomiss" style="display:none">No missing book was found.</h3>
    <br> 
        <table id="misstable" class="table table-sm table-striped" style="display:none;" onload="realTime()">
            <thead>
              <tr>
                <th scope="col" style="color:#3A74A1" width="5%">Book ID</th>
                <th scope="col" style="color:#3A74A1" width="5%">Title</th>
                <th scope="col" style="color:#3A74A1" width="5%">Tag ID</th>
              </tr>
            </thead>
            <tbody id="misstablebody">
            
            </tbody>
        </table>
    
</div>


{{-- Form Add Book --}}
<div id="book_add_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-between">
        <h4 class="modal-title">Add Book</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form class="" action="/b/manage" enctype="multipart/form-data" method="post" id="add_book_form">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div id="add_book_error" class="error-box text-center text-danger"></div>
                    <!--Added by tony-->
                    <div class="form-group">
                        <label for="tag_id" class="pl-3 col-form-label">Tag ID</label>                        
                        <select id="tag_id" class="form-control custom-select custom-select-lg mb-3" name="tag_id">
                            <option value="">-- Please Select --</option>  
                            @foreach($tags as $tag)      
                            <option value="{{$tag}}">{{$tag}}</option>  
                            @endforeach
                        </select>
                    </div>
                    <!--Added by tony-->
                    <div class="form-group">
                        <label for="title" class="pl-3 col-form-label">Title</label>
                        <input id="title" type="text" class="form-control add-input" name="title" caption="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="author" class="pl-3 col-form-label">Author</label>
                        <input id="author" type="text" class="form-control add-input" name="author" caption="author" value="{{ old('author') }}" autocomplete="author" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="publisher" class="pl-3 col-form-label">Publisher</label>
                        <input id="publisher" type="text" class="form-control add-input" name="publisher" caption="publisher" value="{{ old('publisher') }}" autocomplete="publisher" autofocus>
                    </div>

                    <div class="row justify-content-between">
                        <div class="form-group col-md-6">
                            <label for="publicationYear" class="pl-3 col-form-label">Publication Year</label>
                            <input id="publicationYear" type="text" class="form-control add-input" name="publicationYear" caption="publicationYear" value="{{ old('publicationYear') }}" autocomplete="publicationYear" autofocus>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="language" class="pl-3 col-form-label">Language</label>
                            <input id="language" type="text" class="form-control add-input" name="language" caption="language" value="{{ old('language') }}" autocomplete="language" autofocus>
                        </div>
                    </div>

                    <div class="row justify-content-between">
                        <div class="form-group col-md-6">
                            <label for="ISBN" class="pl-3 col-form-label">ISBN</label>
                            <input id="ISBN" type="text" class="form-control add-input" name="ISBN" caption="ISBN" value="{{ old('ISBN') }}" autocomplete="ISBN" autofocus>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="pageNumber" class="pl-3 col-form-label">Page Number</label>
                            <input id="pageNumber" type="text" class="form-control add-input" name="pageNumber" caption="pageNumber" value="{{ old('pageNumber') }}" autocomplete="pageNumber" autofocus>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="form-group col-md-6">
                            <label for="type" class="pl-3 col-form-label">Type</label>
                            <select id="type" class="form-control custom-select custom-select-lg mb-3" name="type">
                                <option value="">-- Please Select --</option>
                                <option value="academic">Academic</option>
                                <option value="classics">Classics</option>
                                <option value="essay">Essay</option>
                                <option value="history">History</option>
                                <option value="horror">Horror</option>
                                <option value="romance">Romance</option>
                                <option value="textbook">Textbook</option>
                                <option value="others">Others</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="status" class="pl-3 col-form-label">Status</label>
                            <select id="status" class="form-control custom-select custom-select-lg mb-3" name="status">
                                <option selected value="inLibrary">In Library</option>
                                <option value="Lend">Lend</option>
                                <option value="Missing">Missing</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="pl-3 col-form-label">Description</label>
                        <!-- <input id="description" type="textarea" class="form-control @error('description') is-invalid @enderror" name="description" caption="description" value="{{ old('description') }}" autocomplete="description" autofocus> -->
                        <textarea id="description" class="form-control add-input" name="description" caption="description" value="{{ old('description') }}" autocomplete="description" autofocus rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <!-- <label for="image" class="pl-3 col-form-label">Image</label>
                        <div class="custom-file">
                            <input type="file" id="add_book_image" name="image" class="form-control custom-file-input @error('image') is-invalid @enderror">
                            <label id="add_book_image_label" class="custom-file-label" for="image">Choose file</label>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> -->
                        <label for="image" class="pl-3 col-form-label">Image</label>
                        <input type="file" id="image" name="image" class="form-control add-input">
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning" type="submit" id="add_book_btn" name="add_book_btn">
          <span class="glyphicon glyphicon-plus"></span> Save Book
        </button>
        <button class="btn btn-warning" type="button" data-dismiss="modal">
          <span class="glyphicon glyphicon-remobe"></span>Close
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Form Edit Book --}}
<div id="book_edit_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header align-items-between">
        <h4 class="modal-title">Edit Book</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="/b/manage" enctype="multipart/form-data" method="post" id="edit_book_form">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div id="edit_book_error" class="error-box text-center text-danger"></div>
                    
                    <div class="form-group">
                        <label for="id" class="pl-3 col-form-label">ID</label>
                        <input id="book_edit_id" type="text" class="form-control" name="id" disabled>
                    </div>
                     <!--Added by tony-->
                    <div class="form-group">
                        <label for="tag_id" class="pl-3 col-form-label">Tag ID</label>                        
                        <select id="book_edit_tag_id" class="form-control custom-select custom-select-lg mb-3" name="tag_id">                            
                              <option value="">-- Please Select --</option>                            
                            @foreach($tags as $tag)      
                            <option value="{{$tag}}">{{$tag}}</option>  
                            @endforeach                              
                        </select>
                    </div>
                     <!--Added by tony-->
                    <div class="form-group">
                        <label for="title" class="pl-3 col-form-label">Title</label>
                        <input id="book_edit_title" type="text" class="form-control edit-input" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="author" class="pl-3 col-form-label">Author</label>
                        <input id="book_edit_author" type="text" class="form-control edit-input" name="author">
                    </div>

                    <div class="form-group">
                        <label for="publisher" class="pl-3 col-form-label">Publisher</label>
                        <input id="book_edit_publisher" type="text" class="form-control edit-input" name="publisher">
                    </div>

                    <div class="row justify-content-between">
                        <div class="form-group col-md-6">
                            <label for="publicationYear" class="pl-3 col-form-label">Publication Year</label>
                            <input id="book_edit_publicationYear" type="text" class="form-control edit-input" name="publicationYear">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="language" class="pl-3 col-form-label">Language</label>
                            <input id="book_edit_language" type="text" class="form-control edit-input" name="language">
                        </div>
                    </div>

                    <div class="row justify-content-between">
                        <div class="form-group col-md-6">
                            <label for="ISBN" class="pl-3 col-form-label">ISBN</label>
                            <input id="book_edit_ISBN" type="text" class="form-control edit-input" name="ISBN">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="pageNumber" class="pl-3 col-form-label">Page Number</label>
                            <input id="book_edit_pageNumber" type="text" class="form-control edit-input" name="pageNumber">
                        </div>
                    </div>

                    <div class="row justify-content-between">
                        <div class="form-group col-md-6">
                            <label for="status" class="pl-3 col-form-label">Type</label>
                            <select id="book_edit_type" class="form-control custom-select custom-select-lg mb-3" name="type">
                                <option value="academic">Academic</option>
                                <option value="classics">Classics</option>
                                <option value="essay">Essay</option>
                                <option value="history">History</option>
                                <option value="horror">Horror</option>
                                <option value="romance">Romance</option>
                                <option value="textbook">Textbook</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="status" class="pl-3 col-form-label">Status</label>
                            <select id="book_edit_status" class="form-control custom-select custom-select-lg mb-3" name="status">
                                <option value="inLibrary">In Library</option>
                                <option value="Lend">Lend</option>
                                <option value="Missing">Missing</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-md-4 col-form-label">Description</label>
                        <textarea id="book_edit_description" class="form-control edit-input" rows="3" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image" class="pl-3 col-form-label">Re-upload Image</label>
                        <input type="file" id="book_edit_image" class="form-control edit-input" name="image">
                        <!-- <label for="image" class="pl-3 col-form-label">Image</label>
                        <div class="custom-file">
                            <input type="file" id="book_edit_image" name="image" class="form-control custom-file-input">
                            <label class="custom-file-label text-truncate" for="image" id="book_edit_image_label"></label>
                        </div> -->
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success edit" id="edit_book_btn">
          <span class="glyphicon glyphicon-check"></span> Edit
        </button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">
          <span class="glyphicon glyphicon-remobe"></span>close
        </button>
      </div>
    </div>
  </div>
</div>
{{-- Form Delete Book --}}
<div id="book_delete_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header align-items-between">
        <h4 class="modal-title">Delete Book</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="deleteContent">
          Are you sure to delete <span class="title"></span>?
          <span class="d-none id"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger delete" id="delete_book_btn" data-token="{{ csrf_token() }}" data-dismiss="modal">
          <span class="glyphicon glyphicon-trash"></span> Delele
        </button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">
          <span class="glyphicon glyphicon-remobe"></span>close
        </button>
      </div>
    </div>
  </div>
</div>

@endsection
