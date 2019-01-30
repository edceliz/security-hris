@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>Users</h3>
    </div>
    <div class="col text-right">
      <a class="btn btn-secondary" href="/users/new" role="button">Add New</a>
    </div>
  </div>
  <hr>
  <div class="row content">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>E-mail</th>
                <th>Role</th>
                <th>Date Created</th>
                <th>Operation</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
                <tr>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @if ($user->role === 1)
                      Admin
                    @elseif ($user->role === 2)
                      HR
                    @else
                      Guest
                    @endif
                  </td>
                  <td>{{ $user->created_at }}</td>
                  <td>
                    <a class="btn btn-primary" href="/users/{{ $user->id }}" role="button">Edit</a>
                    @if ($user->id !== Auth::user()->id)
                      <a class="btn btn-danger" href="/users/delete/{{ $user->id }}" 
                        role="button"
                        onclick="event.preventDefault();
                        if (confirm('Are you sure you want to delete {{ $user->name }}?')) {
                          document.getElementById('delete-form-{{ $user->id }}').submit();
                        }">
                        Delete
                      </a>
                      <form id="delete-form-{{ $user->id }}" action="/users/delete/{{ $user->id }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
