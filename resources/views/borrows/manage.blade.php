@extends('layouts.app')

@section('content')

<script type="application/javascript">
  var json_books = @json($books);
</script>

<div class="container text-center pagination-centered" id="manage_borrow">
  <div class="justify-content-center">
    @if (session('message'))
        <div class="alert alert-warning w-50 mx-auto" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <h1 align="center">Lending Record</h1>
    <form action="" method="get">
        @csrf

        <div class="form-group justify-content-center row pt-3">
            <div class="pt-1 col-md-1 d-none d-md-block">
                <img src="/icon/search.svg" height="30px" align="right">
            </div>
            <div class="col-md-3 col-sm-12">
                <select id="search_field" class="form-control custom-select custom-select-lg mb-3" name="search_field">
                  
                    <option value="id">ID</option>
                    <option value="book_id">Book ID</option>
                    <option value="user_id">User ID</option>
                    <option value="staff_id">Staff ID</option>
                    <option value="book_title">Book Title</option>                   
                    <option value="user_name">User Name</option>
                    <option value="renewal_num">Renewal No.</option>
                </select>
            </div>
            <div class="col-md-6 col-sm-12">
                <input id="search_content" type="text" class="form-control" name="search_content" value="{{ old('search_content') }}" placeholder="Search" autocomplete="search_content" autofocus>
            </div>
            <div class="col-md-2 col-sm-12 mt-3 mt-md-0">
                <button type="submit" class="btn btn-success btn-lg">
                    <strong>Search</strong>
                </button>
            </div>
        </div>
    </form>
    @if ($book_id)
    <div class="d-none" id="add_specific_book">{{$book_id}}</div>
    @endif
    <div class="table-responsive border">
      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th scope="col" style="color:#3A74A1">#
              @if (Request::get('search_content'))
              <a href="{{ url(Request::path() . '?_token=' . Request::get('_token') . '&search_field=' . Request::get('search_field') . '&search_content=' . Request::get('search_content') .'&sort=id')}}">
              @else
              <a href="?sort=id">
              @endif
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Book ID
              @if (Request::get('search_content'))
              <a href="{{ url(Request::path() . '?_token=' . Request::get('_token') . '&search_field=' . Request::get('search_field') . '&search_content=' . Request::get('search_content') .'&sort=book_id')}}">
              @else
              <a href="?sort=book_id">
              @endif
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">User ID
              @if (Request::get('search_content'))
              <a href="{{ url(Request::path() . '?_token=' . Request::get('_token') . '&search_field=' . Request::get('search_field') . '&search_content=' . Request::get('search_content') .'&sort=user_id')}}">
              @else
              <a href="?sort=user_id">
              @endif
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Staff ID
              @if (Request::get('search_content'))
              <a href="{{ url(Request::path() . '?_token=' . Request::get('_token') . '&search_field=' . Request::get('search_field') . '&search_content=' . Request::get('search_content') .'&sort=staff_id')}}">
              @else
              <a href="?sort=staff_id">
              @endif
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Borrowed At
              @if (Request::get('search_content'))
              <a href="{{ url(Request::path() . '?_token=' . Request::get('_token') . '&search_field=' . Request::get('search_field') . '&search_content=' . Request::get('search_content') .'&sort=borrow_at')}}">
              @else
              <a href="?sort=borrow_at">
              @endif
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Deadline At
              @if (Request::get('search_content'))
              <a href="{{ url(Request::path() . '?_token=' . Request::get('_token') . '&search_field=' . Request::get('search_field') . '&search_content=' . Request::get('search_content') .'&sort=deadline_at')}}">
              @else
              <a href="?sort=deadline_at">
              @endif
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Returned By
              @if (Request::get('search_content'))
              <a href="{{ url(Request::path() . '?_token=' . Request::get('_token') . '&search_field=' . Request::get('search_field') . '&search_content=' . Request::get('search_content') .'&sort=return_at')}}">
              @else
              <a href="?sort=return_at">
              @endif
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Renewal No.
              @if (Request::get('search_content'))
              <a href="{{ url(Request::path() . '?_token=' . Request::get('_token') . '&search_field=' . Request::get('search_field') . '&search_content=' . Request::get('search_content') .'&sort=renewal_num')}}">
              @else
              <a href="?sort=renewal_num">
              @endif
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th class="text-center" scope="col">
              <a href="#" class="record-create-modal btn btn-success btn-lg">
                <i class="glyphicon glyphicon-plus"></i> Add Record
              </a>
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($borrows as $borrow)
          <tr>
            <td class="text-center">{{ $borrow->id }}</td>
            <td class="text-center">
              <a href="{{ route('bookDetail', $borrow->book_id) }}">
                <u>{{ $borrow->book_id }}</u>
              </a>
            </td>
            <td class="text-center">
              <a href="{{ route('recordBorrow', $borrow->user_id) }}">
                <u>{{ $borrow->user_id }}</u>
              </a>
            </td>
            <td class="text-center">
              <a href="{{ route('recordBorrow', $borrow->staff_id) }}">
                <u>{{ $borrow->staff_id }}</u>
              </a>
            </td>
            <td class="text-center">{{ $borrow->borrow_at }}</td>
            <td class="text-center">{{ $borrow->deadline_at }}</td>
            <td class="text-center">
              @if($borrow->return_at)
                {{ $borrow->return_at }}
              @else
                <a href="#" class="return-btn-modal btn btn-outline-info btn-sm" data-id="{{$borrow->id}}" data-bookid="{{$borrow->book_id}}" data-booktitle="{{$borrow->book->title}}" data-userid="{{$borrow->user_id}}" data-username="{{$borrow->user->name}}" data-borrowat="{{$borrow->borrow_at}}" data-deadlineat="{{$borrow->deadline_at}}" data-renewalnum="{{$borrow->renewal_num}}">
                  <i class="glyphicon glyphicon-transfer"></i> Return
                </a>
              @endif
            </td>
            <td class="text-center">
              @if($borrow->return_at)
                {{ $borrow->renewal_num }}
              @else
                <span class="pr-2">{{ $borrow->renewal_num }}</span>
                <a href="#" class="renew-btn-modal btn btn-outline-info btn-sm" data-id="{{$borrow->id}}" data-booktitle="{{$borrow->book->title}}" data-username="{{$borrow->user->name}}" data-borrowat="{{$borrow->borrow_at}}" data-deadlineat="{{$borrow->deadline_at}}" data-renewalnum="{{$borrow->renewal_num}}">
                  <i class="glyphicon glyphicon-repeat"></i> Renewal
                </a>
              @endif
            </td>
            <td class="text-center">
              <a href="#" class="record-edit-modal btn btn-warning btn-sm" data-id="{{$borrow->id}}" data-bookid="{{$borrow->book_id}}" data-booktitle="{{$borrow->book->title}}" data-userid="{{$borrow->user_id}}" data-username="{{$borrow->user->name}}" data-staffid="{{$borrow->staff_id}}" data-borrowat="{{$borrow->borrow_at}}" data-deadlineat="{{$borrow->deadline_at}}" data-renewalnum="{{$borrow->renewal_num}}" data-returnat="{{$borrow->return_at}}">
                <i class="glyphicon glyphicon-pencil"></i>
              </a>
              <a href="#" class="record-delete-modal btn btn-danger btn-sm" data-id="{{$borrow->id}}" data-bookid="{{$borrow->book_id}}" data-booktitle="{{$borrow->book->title}}" data-userid="{{$borrow->user_id}}" data-username="{{$borrow->user->name}}" data-borrowat="{{$borrow->borrow_at}}" data-deadlineat="{{$borrow->deadline_at}}" data-renewalnum="{{$borrow->renewal_num}}">
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
      {{ $borrows->appends(['sort' => $sort])->links() }}
    </div>
  </div>
</div>

{{-- Form Return Book --}}
<div id="return_book_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-between">
        <h4 class="modal-title">Return Book</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="justify-content-center table-responsive">
          <table class="table table-bordered">
            <tr>
              <td>Borrow ID</td>
              <td id="return_borrow_id"></td>
            </tr>
            <tr>
              <td>Book ID</td>
              <td id="return_book_id"></td>
            </tr>
            <tr>
              <td>Book Name</td>
              <td id="return_book_title"></td>
            </tr>
            <tr>
              <td>User ID</td>
              <td id="return_user_id"></td>
            </tr>
            <tr>
              <td>User Name</td>
              <td id="return_user_name"></td>
            </tr>
            <tr>
              <td>Borrow At</td>
              <td id="return_borrow_at"></td>
            </tr>
            <tr>
              <td>Deadline At</td>
              <td id="return_deadline_at"></td>
            </tr>
            <tr>
              <td>Return At</td>
              <td id="return_return_at"></td>
            </tr>
            <tr>
              <td>Renewal No.</td>
              <td id="return_renewal_num"></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="return_submit_btn" data-token="{{ csrf_token() }}" data-dismiss="modal">
          <span class="glyphicon glyphicon-ok"></span> Confirm
        </button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">
          <span class="glyphicon glyphicon-remobe"></span>Close
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Form Renew Book --}}
<div id="renew_book_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-between">
        <h4 class="modal-title">Renew Book</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="justify-content-center table-responsive">
          <table class="table table-bordered">
            <tr>
              <td>Record ID</td>
              <td id="renew_record_id"></td>
            </tr>
            <tr>
              <td>Book Name</td>
              <td id="renew_book_title"></td>
            </tr>
            <tr>
              <td>User Name</td>
              <td id="renew_user_name"></td>
            </tr>
            <tr>
              <td>Renewal No.</td>
              <td id="renew_renewal_num"></td>
            </tr>
            <tr>
              <td>Borrow At</td>
              <td id="renew_borrow_at"></td>
            </tr>
            <tr>
              <td>Original Deadline At</td>
              <td id="renew_o_deadline_at"></td>
            </tr>
            <tr>
              <td>New Deadline At</td>
              <td id="renew_n_deadline_at"></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="renew_submit_btn" data-token="{{ csrf_token() }}" data-dismiss="modal">
          <span class="glyphicon glyphicon-ok"></span> Confirm
        </button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">
          <span class="glyphicon glyphicon-remobe"></span>Close
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Form Create Borrow --}}
<div id="record-create-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-between">
        <h4 class="modal-title">Create Record</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="" enctype="multipart/form-data" method="post">
          @csrf
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div id="create_borrow_error" class="error-box text-center text-danger">
              </div>
              <div class="row justify-content-between">
                <div class="form-group col-md-4">
                  <label for="book_id" class="pl-3 col-form-label">Book ID</label>
                  <input id="borrow_create_book_id" onchange="autocomplete_create_book({{$books}})" type="text" class="form-control create-input" name="book_id">
                </div>
                <div class="form-group col-md-8">
                  <label for="book_title" class="pl-3 col-form-label">Book Title</label>
                  <input id="borrow_create_book_title" type="text" class="form-control" name="book_title" disabled>
                </div>
              </div>
              <div class="row justify-content-between">
                <div class="form-group col-md-4">
                  <label for="user_id" class="pl-3 col-form-label">User ID</label>
                  <input id="borrow_create_user_id" onchange="autocomplete_create_user({{$users}})" type="text" class="form-control create-input" name="user_id">
                </div>
                <div class="form-group col-md-8">
                  <label for="user_name" class="pl-3 col-form-label">User Name</label>
                  <input id="borrow_create_user_name" type="text" class="form-control" name="user_name" disabled>
                </div>
              </div>
              <div class="form-group" onchange="change_deadline()">
                <label for="borrow_at" class="pl-3 col-form-label">Borrow At</label>
                <div class="input-group-append">
                  <input id="borrow_at" type="text" class="form-control selectDate create-input" name="borrow_at">
                  <span class="input-group-text"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
              <div class="form-group">
                <label for="deadline_at" class="pl-3 col-form-label">Deadline At</label>
                <div class="input-group-append">
                  <input id="deadline_at" type="text" class="form-control selectDate create-input" name="deadline_at">
                  <span class="input-group-text"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="create_record_btn" data-token="{{ csrf_token() }}">
          <span class="glyphicon glyphicon-plus"></span> Submit
        </button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">
          <span class="glyphicon glyphicon-remobe"></span>Close
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Form Edit Borrow --}}
<div id="record-edit-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-between">
        <h4 class="modal-title">Edit Record</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="" enctype="multipart/form-data" method="post">
          @csrf
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div id="edit_borrow_error" class="error-box text-center text-danger">
              </div>
              <div class="form-group">
                <label for="id" class="pl-3 col-form-label">Record ID</label>
                <input id="borrow_edit_id" type="text" class="form-control" name="id" disabled>
              </div>
              <div class="row justify-content-between">
                <div class="form-group col-md-4">
                  <label for="book_id" class="pl-3 col-form-label">Book ID</label>
                  <input id="borrow_edit_book_id" onchange="autocomplete_edit_book({{$books}})" type="text" class="form-control edit-input" name="book_id">
                </div>
                <div class="form-group col-md-8">
                  <label for="book_title" class="pl-3 col-form-label">Book Title</label>
                  <input id="borrow_edit_book_title" type="text" class="form-control" name="book_title" disabled>
                </div>
              </div>
              <div class="row justify-content-between">
                <div class="form-group col-md-4">
                  <label for="user_id" class="pl-3 col-form-label">User ID</label>
                  <input id="borrow_edit_user_id" onchange="autocomplete_edit_user({{$users}})" type="text" class="form-control edit-input" name="user_id">
                </div>
                <div class="form-group col-md-8">
                  <label for="user_name" class="pl-3 col-form-label">User Name</label>
                  <input id="borrow_edit_user_name" type="text" class="form-control" name="user_name" disabled>
                </div>
              </div>
              <div class="row justify-content-between">
                <div class="form-group col-md-6">
                  <label for="staff_id" class="pl-3 col-form-label">Staff ID</label>
                  <input id="borrow_edit_staff_id" type="text" class="form-control edit-input" name="staff_id">
                </div>
                <div class="form-group col-md-6">
                  <label for="renewal_num" class="pl-3 col-form-label">Renewal No.</label>
                  <input id="borrow_edit_renewal_num" type="text" class="form-control edit-input" name="renewal_num">
                </div>
              </div>
              <div class="form-group">
                <label for="borrow_at" class="pl-3 col-form-label">Borrow At</label>
                <div class="input-group-append">
                  <input id="borrow_edit_borrow_at" type="text" class="form-control selectDate edit-input" name="borrow_at">
                  <span class="input-group-text"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
              <div class="form-group">
                <label for="deadline_at" class="pl-3 col-form-label">Deadline At</label>
                <div class="input-group-append">
                  <input id="borrow_edit_deadline_at" type="text" class="form-control selectDate edit-input" name="deadline_at">
                  <span class="input-group-text"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
              <div class="form-group">
                <label for="return_at" class="pl-3 col-form-label">Return At</label>
                <div class="input-group-append">
                  <input id="borrow_edit_return_at" type="text" class="form-control selectDate edit-input" name="return_at">
                  <span class="input-group-text"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="edit_record_btn" data-token="{{ csrf_token() }}">
          <span class="glyphicon glyphicon-pencil"></span> Submit
        </button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">
          <span class="glyphicon glyphicon-remobe"></span>Close
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Form Delete Borrow --}}
<div id="record-delete-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-between">
        <h4 class="modal-title">Delete Record</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="justify-content-center table-responsive">
          <h2 align="center"><strong>Confirm to Delete this record?</strong></h2>
          <table class="table table-bordered">
            <tr>
              <td>Borrow ID</td>
              <td id="del_record_borrow_id"></td>
            </tr>
            <tr>
              <td>Book ID</td>
              <td id="del_record_book_id"></td>
            </tr>
            <tr>
              <td>Book Name</td>
              <td id="del_record_book_title"></td>
            </tr>
            <tr>
              <td>User ID</td>
              <td id="del_record_user_id"></td>
            </tr>
            <tr>
              <td>User Name</td>
              <td id="del_record_user_name"></td>
            </tr>
            <tr>
              <td>Borrow At</td>
              <td id="del_record_borrow_at"></td>
            </tr>
            <tr>
              <td>Deadline At</td>
              <td id="del_record_deadline_at"></td>
            </tr>
            <tr>
              <td>Return At</td>
              <td id="del_record_return_at"></td>
            </tr>
            <tr>
              <td>Renewal No.</td>
              <td id="del_record_renewal_num"></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="delete_record_btn" data-token="{{ csrf_token() }}" data-dismiss="modal">
          <span class="glyphicon glyphicon-pencil"></span> Delete
        </button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">
          <span class="glyphicon glyphicon-remobe"></span>Close
        </button>
      </div>
    </div>
  </div>
</div>

@endsection



