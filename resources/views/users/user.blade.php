@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>
        {{ $edit ? $edit->name : 'New Account' }}
      </h3>
    </div>
  </div>
  <hr>
  <div class="row content">
    <div class="col">
      <div class="card">
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif

          @if (session('success'))
            <div class="alert alert-success">
                <ul class="mb-0">
                    <li>User updated successfully!</li>
                </ul>
            </div>
          @endif

          @if ($edit)
            <form method="POST" action="/users/{{ $edit->id }}">
          @else
            <form method="POST" action="/users/new">
          @endif
            <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label">Full Name</label>
              <div class="col-sm-10">
                <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" value="{{ $edit ? $edit->name : null }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="{{ $edit ? $edit->email : null }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="col-sm-2 col-form-label">New Password</label>
              <div class="col-sm-10">
                <input name="password" type="password" class="form-control" id="password" placeholder="New Password" {{ $edit ? '' : 'required' }}>
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="col-sm-2 col-form-label">Role</label>
              <div class="col-sm-10">
                <select name="role" class="form-control" required>
                  <option value="1" {{ $edit && $edit->role === 1 ? 'selected' : null }}>Admin</option>
                  <option value="2" {{ $edit && $edit->role === 2 ? 'selected' : null }}>HR</option>
                  <option value="3" {{ $edit && $edit->role === 3 ? 'selected' : null }}>Guest</option>
                </select>
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">{{ $edit ? 'Update' : 'New' }} Account</button>
              </div>
            </div>
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
