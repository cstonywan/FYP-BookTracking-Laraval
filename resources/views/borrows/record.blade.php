@extends('layouts.app')

@section('content')

<div class="container text-center">
  <div class="justify-content-center">
    @if ($user->role == 0)
    <h1 align="left"><strong style="color:#BFBFBF">{{ $user->name }}</strong> - Borrow Record:</h1>
    @else
    <h1 align="left"><strong style="color:#BFBFBF">{{ $user->name }}</strong> - Handled Record:</h1>
    @endif
    @if (!$records->isEmpty())
    <div class="table-responsive">
      <table class="table table-dark table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Book Title</th>
            <th scope="col">Borrow at</th>
            <th scope="col">Deadline at</th>
            <th scope="col">Return at</th>
            <th scope="col">Renewal No.</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($records as $record)
          <tr>
            <td>{{ $record->id }}</td>
            <td align="left">{{ $record->book->title }}</td>
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
