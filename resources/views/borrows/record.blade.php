@extends('layouts.app')

@section('content')

<div class="container text-center">
  <div class="justify-content-center">
    @if ($user->role == 0)
    <!-- <h1 align="center">Borrow Record of {{ $user->name }}</h1> -->
    <h1 align="center">Borrow Record</h1>
    @else
    <!-- <h1 align="center">Handled Record of {{ $user->name }}</h1> -->
    <h1 align="center">Handled Record</h1>
    @endif
    @if (!$records->isEmpty())
    <div class="table-responsive border">
      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th scope="col" style="color:#3A74A1">ID
              <a href="?sort=id">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Book Title
              <a href="?sort=title">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Borrowed At
              <a href="?sort=borrow_at">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Deadline At
              <a href="?sort=deadline_at">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Returned By
              <a href="?sort=return_at">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
            <th scope="col" style="color:#3A74A1">Renewal No.
              <a href="?sort=renewal_num">
                <i class="glyphicon glyphicon-sort"></i>
              </a>
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($records as $record)
          <tr>
              <td>{{ $record->id }}</td>
              <td>{{ $record->book->title }}</td>
              <td>{{ $record->borrow_at }}</td>
              <td>{{ $record->deadline_at }}</td>
              @if ($record->return_at)
                <td>{{ $record->return_at }}</td>
              @else
                <td>Not Yet Returned</td>
              @endif
              <td>{{ $record->renewal_num }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <br>
    <div class="d-flex justify-content-between">
      <p>{{ $show }}</p>
      {{ $records->appends(['sort' => $sort])->links() }}
    </div>
    @else
        @if ($user->role == 0)
        <p align="center">You do not have any borrow record.</p>
        @else
        <p align="center">You have not handled any borrow record yet.</p>
        @endif
    @endif
  </div>
</div>
@endsection


