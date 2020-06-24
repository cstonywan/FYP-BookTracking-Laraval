@extends('layouts.app')

@section('content')
<div class="container text-center">
    @if (session('message'))
        <div class="alert alert-warning w-50 mx-auto" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <h1 align="center">Users list</h1>
    <div class="table-responsive border">
      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th scope="col" style="color:#3A74A1">ID
              <a href="?sort=id">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Icon</th>
            <th scope="col" style="color:#3A74A1">Name
              <a href="?sort=name">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Email
              <a href="?sort=email">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Role
              <a href="?sort=role">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Created At
              <a href="?sort=created_at">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th class="text-center" width="150px">
              <a href="#" class="user-create-modal btn btn-success btn-lg">
                <i class="glyphicon glyphicon-plus"></i> Add User
              </a>
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
          <tr>
              <td>{{ $user->id }}</td>
              <td>
                @if($user->photo != null)
                  <img src="/storage/{{ $user->photo }}" style="width:40px;height:40px">
                @else
                  <img src="/icon/defaultuser.png" style="width:40px;height:40px">
                @endif
              </td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              @if ($user->role === 2)
                <td>Admin</td>
              @elseif ($user->role === 1)
                <td>Manager</td>
              @else
                <td>User</td>
              @endif
              <td>{{ $user->created_at }}</td>
              <td class="text-center">
                <a href="{{ route('recordBorrow', $user->id) }}" class="user-show-modal btn btn-info btn-sm">
                  <i class="glyphicon glyphicon-eye-open"></i>
                </a>
                <a href="#" class="user-edit-modal btn btn-warning btn-sm" data-id="{{$user->id}}" data-name="{{$user->name}}" data-email="{{$user->email}}" data-role="{{$user->role}}">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a>
                <a href="#" class="user-delete-modal btn btn-danger btn-sm" data-id="{{$user->id}}" data-name="{{$user->name}}">
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
      {{ $users->appends(['sort' => $sort])->links() }}
    </div>
</div>

{{-- Form Add User --}}
<div id="user_add_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-between">
        <h4 class="modal-title">Add User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form class="" enctype="multipart/form-data" method="post" id="add_user_form">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div id="add_user_error" class="error-box text-center text-danger"></div>
                    <div class="form-group">
                        <label for="name" class="pl-3 col-form-label">Name <strong class="text-danger">*</strong></label>
                        <input id="name" type="text" class="form-control add-input" name="name" caption="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="email" class="pl-3 col-form-label">Email <strong class="text-danger">*</strong></label>
                        <input id="email" type="text" class="form-control add-input" name="email" caption="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password" class="pl-3 col-form-label text-md-right">Password <strong class="text-danger">*</strong></label>
                        <input id="password" type="password" class="form-control add-input" name="password" required autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="pl-3 col-form-label text-md-right">Confirm Password <strong class="text-danger">*</strong></label>
                        <input id="password-confirm" type="password" class="form-control add-input" name="password-confirm" required autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="role" class="pl-3 col-form-label">Role <strong class="text-danger">*</strong></label>
                        <select id="role" class="form-control custom-select custom-select-lg mb-3" name="role">
                            <option value=0>User</option>
                            <option value=1>Manager</option>
                            <option value=2>Admin</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="photo" class="pl-3 col-form-label">Photo</label>
                        <input type="file" id="photo" name="photo" class="form-control add-input">
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning" type="submit" id="add_user_btn" name="add_user_btn">
          <span class="glyphicon glyphicon-plus"></span> Save User
        </button>
        <button class="btn btn-warning" type="button" data-dismiss="modal">
          <span class="glyphicon glyphicon-remobe"></span>Close
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Form Edit User --}}
<div id="user_edit_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header align-items-between">
        <h4 class="modal-title">Edit User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="edit_user_form">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div id="edit_user_error" class="error-box text-center text-danger"></div>
                    <div class="form-group">
                        <label for="id" class="pl-3 col-form-label">ID</label>
                        <input id="user_edit_id" type="text" class="form-control" name="id" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name" class="pl-3 col-form-label">Name <strong class="text-danger">*</strong></label>
                        <input id="user_edit_name" type="text" class="form-control edit-input" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="pl-3 col-form-label">Email <strong class="text-danger">*</strong></label>
                        <input id="user_edit_email" type="text" class="form-control edit-input" name="email">
                    </div>

                    <div class="form-group">
                        <label for="role" class="pl-3 col-form-label">Role <strong class="text-danger">*</strong></label>
                        <select id="user_edit_role" class="form-control custom-select custom-select-lg mb-3" name="role">
                            <option value=0>User</option>
                            <option value=1>Manager</option>
                            <option value=2>Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="photo" class="pl-3 col-form-label">Re-upload Photo</label>
                        <input type="file" id="book_edit_photo" class="form-control edit-input" name="photo">
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success edit" id="edit_user_btn">
          <span class="glyphicon glyphicon-check"></span> Edit
        </button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">
          <span class="glyphicon glyphicon-remobe"></span>close
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Form Delete User --}}
<div id="user_delete_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header align-items-between">
        <h4 class="modal-title">Delete User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="deleteContent">
          Are you sure to delete user: <span class="name"></span>?
          <span class="d-none id"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger delete" id="delete_user_btn" data-token="{{ csrf_token() }}" data-dismiss="modal">
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
