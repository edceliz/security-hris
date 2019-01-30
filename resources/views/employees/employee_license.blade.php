@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>
        <a href="/employees/{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->surname }}</a>
      </h3>
    </div>
    <div class="col text-right">
      <a class="btn btn-secondary" href="/employees/edit/{{ $employee->id }}" role="button">Edit Information</a>
      <a class="btn btn-primary disabled" href="/employees/license/{{ $employee->id }}" role="button" aria-disabled="true">Edit License</a>
      <a class="btn btn-secondary" href="/employees/job/{{ $employee->id }}" role="button">Edit Status/Detachment</a>
    </div>
  </div>
  <hr>
  @if ($license)
    <div class="row content">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h4 class="mb-0">Current Security License</h4>
          </div>
          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success">
                  <ul class="mb-0">
                      <li>Employee license updated successfully!</li>
                  </ul>
              </div>
            @endif
            <form>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="license">Security License Number</label>
                  <input value="{{ $license->number }}" type="text" class="form-control" id="license" placeholder="Security License Number" disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="issued-date">Issued Date</label>
                  <input value="{{ date('Y-m-d', strtotime($license->date_issued)) }}" type="date" class="form-control" id="issued-date" disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="expiration-date">Expiration Date</label>
                  <input value="{{ date('Y-m-d', strtotime($license->date_expired)) }}" type="date" class="form-control" id="expiration-date" disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="remarks">Remarks</label>
                  <input value="{{ $license->remarks }}" type="text" class="form-control" id="remarks" placeholder="Remarks" disabled>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endif
  <div class="row content mt-3">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0">New Security License</h4>
        </div>
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

          <form method="post" action="/employees/license/{{ $employee->id }}">
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="license">Security License Number *</label>
                <input value="{{ $license ? $license->number : null }}" name="number" type="text" class="form-control" id="license" placeholder="Security License Number" required>
              </div>
              <div class="form-group col-md-3">
                <label for="issued-date">Issued Date *</label>
                <input name="date_issued" min="1918-01-01" type="date" class="form-control" id="issued-date" required>
              </div>
              <div class="form-group col-md-3">
                <label for="expiration-date">Expiration Date *</label>
                <input name="date_expired" min="1918-01-01" type="date" class="form-control" id="expiration-date" required>
              </div>
              <div class="form-group col-md-3">
                <label for="remarks">Remarks</label>
                <input name="remarks" type="text" class="form-control" id="remarks" placeholder="Remarks">
              </div>
            </div>
            <p class="font-weight-bold"><i>* Fields with required valid values</i></p>
            <button type="submit" class="btn btn-primary">Save Security License</button>
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
