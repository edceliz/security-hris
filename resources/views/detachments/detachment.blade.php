@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>{{ $edit ? $edit->name : 'New Detachment' }}</h3>
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
                    <li>Detachment updated successfully!</li>
                </ul>
            </div>
          @endif

          @if ($edit)
            <form method="POST" action="/detachments/{{ $edit->id }}">
          @else
            <form method="POST" action="/detachments">
          @endif
            <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ $edit ? $edit->name : null }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="address" class="col-sm-2 col-form-label">Address</label>
              <div class="col-sm-10">
                <input name="address" type="text" class="form-control" id="address" placeholder="Address" value="{{ $edit ? $edit->address : null }}">
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">{{ $edit ? 'Save' : 'Create' }} Detachment</button>
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
