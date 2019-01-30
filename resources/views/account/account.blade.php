@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>Account</h3>
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

          <form method="POST" action="/account/{{ $user->id }}">
            <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label">Full Name</label>
              <div class="col-sm-10">
                <input name="name" value="{{ $user->name }}" type="text" class="form-control" id="name" placeholder="Full Name" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input name="email" value="{{ $user->email }}" type="email" class="form-control" id="email" placeholder="Email" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="col-sm-2 col-form-label">New Password</label>
              <div class="col-sm-10">
                <input name="password" type="password" class="form-control" id="password" placeholder="New Password">
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Update Profile</button>
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
