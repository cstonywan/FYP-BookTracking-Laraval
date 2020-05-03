@extends('layouts.app')

@section('content')
<div class="container text-center">
    @if (session('message'))
        <div class="alert alert-warning w-50 mx-auto" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <h1>Books list</h1>
    <div class="table-responsive">
      <table class="table table-light table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Cover</th>
            <th scope="col">Tag ID</th>
            <th scope="col">Title</th>
            <th scope="col">Author</th>
            <th scope="col">Type</th>
            <th scope="col">Publisher</th>
            <th scope="col">Publication Year</th>
            <th scope="col">Language</th>
            <th scope="col">ISBN</th>
            <th scope="col">Status</th>
            <th scope="col">Create At</th>
            <th class="text-center" width="125px">
              <a href="#" class="book-create-modal btn btn-success btn-lg">
                <i class="glyphicon glyphicon-plus"></i> Add Book
              </a>
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($books as $book)
          <tr>
              <td>{{ $book->id }}</td>
              <td width="10%">
                  @if($book->image)
                  <img src="/storage/{{ $book->image }}" weight="80" height="100" class="img-thumbnail">
                  @else
                  <img src="/storage/uploads/default.png" weight="80" height="100" class="img-thumbnail">
                  @endif
              </td>
              <td>{{ $book->tag_id }}</td>
              <td>{{ $book->title }}</td>
              <td>{{ $book->author }}</td>
              <td>{{ $book->type }}</td>
              <td>{{ $book->publisher }}</td>
              <td>{{ $book->publicationYear }}</td>
              <td>{{ $book->language }}</td>
              <td>{{ $book->ISBN }}</td>
              <td>{{ $book->status }}</td>
              <td>{{ $book->created_at }}</td>
              <td class="text-center">
                <a href="{{ url('/b/detail/' . $book->id) }}" class="book-show-modal btn btn-info btn-sm">
                  <i class="glyphicon glyphicon-eye-open"></i>
                </a>
                <a href="#" class="book-edit-modal btn btn-warning btn-sm" data-id="{{$book->id}}" data-tag_id="{{$book->tag_id}}" data-title="{{$book->title}}" data-author="{{$book->author}}" data-publisher="{{$book->publisher}}" data-publicationyear="{{$book->publicationYear}}" data-language="{{$book->language}}" data-isbn="{{$book->ISBN}}" data-description="{{$book->description}}" data-pagenumber="{{$book->pageNumber}}" data-status="{{$book->status}}" data-type="{{$book->type}}" data-image="{{$book->image}}">
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
                        <input id="tag_id" type="text" class="form-control add-input" name="tag_id" caption="tag_id" value="{{ old('tag_id') }}" required autocomplete="tag_id" autofocus>
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
                        <input id="book_edit_tag_id" type="text" class="form-control edit-input" name="tag_id" require>
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
