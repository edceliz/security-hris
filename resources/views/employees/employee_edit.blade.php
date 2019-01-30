@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>
        @if ($edit)
          <a href="/employees/{{ $edit->id }}">{{ $edit->first_name }} {{ $edit->surname }}</a>
        @else
          New Employee
        @endif
      </h3>
    </div>
    @if ($edit)
      <div class="col text-right">
        <a class="btn btn-primary disabled" href="/employees/edit/{{ $edit->id }}" role="button" aria-disabled="true">Edit Information</a>
        <a class="btn btn-secondary" href="/employees/license/{{ $edit->id }}" role="button">Edit License</a>
        <a class="btn btn-secondary" href="/employees/job/{{ $edit->id }}" role="button">Edit Status/Detachment</a>
      </div>
    @endif
  </div>
  <hr>
  <div class="row content">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0">Personal Information</h4>
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

          @if (session('success'))
            <div class="alert alert-success">
                <ul class="mb-0">
                    <li>User updated successfully!</li>
                </ul>
            </div>
          @endif

          @if ($edit)
            <form method="POST" action="/employees/edit/{{ $edit->id }}">
          @else
            <form method="POST" action="/employees">
          @endif
            <div class="form-row">
              <div class="form-group col-md-5">
                <label for="surname">Surname *</label>
                <input value="{{ $edit ? $edit->surname : old('surname') }}" name="surname" type="text" class="form-control" id="surname" placeholder="Surname" required>
              </div>
              <div class="form-group col-md-5">
                <label for="first-name">First Name *</label>
                <input value="{{ $edit ? $edit->first_name : old('first_name') }}" name="first_name" type="text" class="form-control" id="first-name" placeholder="First Name" required>
              </div>
              <div class="form-group col-md-2">
                <label for="middle-initial">Middle Initial *</label>
                <input value="{{ $edit ? $edit->middle_initial : old('middle_initial') }}" name="middle_initial" type="text" class="form-control" id="middle-initial" placeholder="Middle Initial" required>
              </div>
            </div>
            <div class="form-group">
              <label for="address">Current Address *</label>
              <input value="{{ $edit ? $edit->current_address : old('current_address') }}" name="current_address" type="text" class="form-control" id="address" placeholder="Current Address" required>
            </div>
            <div class="form-group">
              <label for="address">Permanent Address *</label>
              <input value="{{ $edit ? $edit->permanent_address : old('permanent_address') }}" name="permanent_address" type="text" class="form-control" id="address" placeholder="Permanent Address" required>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="contact-number">Contact Number *</label>
                <input value="{{ $edit ? $edit->contact_number : old('contact_number') }}" name="contact_number" type="tel" class="form-control" id="contact-number" placeholder="Contact Number" required>
              </div>
              <div class="form-group col-md-3">
                <label for="birthday">Birthday *</label>
                <input value="{{ $edit ? $edit->birthday : old('birthday') }}" name="birthday" type="date" class="form-control" id="birthday" required>
              </div>
              <div class="form-group col-md-3">
                <label for="blood-type">Blood Type</label>
                <input value="{{ $edit ? $edit->blood_type : old('blood_type') }}" name="blood_type" type="text" class="form-control" id="blood-type" placeholder="Blood Type">
              </div>
              <div class="form-group col-md-3">
                <label for="civil-status">Civil Status *</label>
                <select name="civil_status" class="form-control" required>
                  <option {{ $edit && $edit->civil_status === 'Single' ? 'selected' : (old('civil_status') === 'Single' ? 'selected' : null )   }} value="Single">Single</option>
                  <option {{ $edit && $edit->civil_status === 'Married' ? 'selected' : (old('civil_status') === 'Married' ? 'selected' : null )   }} value="Married">Married</option>
                  <option {{ $edit && $edit->civil_status === 'Widowed' ? 'selected' : (old('civil_status') === 'Widowed' ? 'selected' : null )   }} value="Widowed">Widowed</option>
                  <option {{ $edit && $edit->civil_status === 'Separated' ? 'selected' : (old('civil_status') === 'Separated' ? 'selected' : null )   }} value="Separated">Separated</option>
                  <option {{ $edit && $edit->civil_status === 'Divorced' ? 'selected' : (old('civil_status') === 'Divorced' ? 'selected' : null )   }} value="Divorced">Divorced</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="sss">SSS *</label>
                <input value="{{ $edit ? $edit->sss : old('sss') }}" name="sss" type="text" class="form-control" id="sss" placeholder="SSS Number" maxlength="12" required>
              </div>
              <div class="form-group col-md-3">
                <label for="tin">TIN *</label>
                <input value="{{ $edit ? $edit->tin : old('tin') }}" name="tin" type="text" class="form-control" id="tin" placeholder="TIN" maxlength="9" required>
              </div>
              <div class="form-group col-md-3">
                <label for="philhealth">Philhealth Number *</label>
                <input value="{{ $edit ? $edit->philhealth : old('philhealth') }}" name="philhealth" type="text" class="form-control" id="philhealth" maxlength="14" placeholder="Philhealth Number" required>
              </div>
              <div class="form-group col-md-3">
                <label for="pagibig">Pagibig Number *</label>
                <input value="{{ $edit ? $edit->pagibig : old('pagibig') }}" name="pagibig" type="text" class="form-control" id="pagibig" maxlength="12" placeholder="Pagibig Number" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="medical">Medical Insurance</label>
                <input value="{{ $edit ? $edit->health_insurance : old('health_insurance') }}" name="health_insurance" type="text" class="form-control" id="medical" placeholder="Medical Insurance">
              </div>
              <div class="form-group col-md-3">
                <label for="dependents">Number of Dependents *</label>
                <input value="{{ $edit ? $edit->dependents_no : old('dependents_no') }}" name="dependents_no" type="number" class="form-control" id="dependents" placeholder="Number of Dependents" min="0" max="100" required>
              </div>
              <div class="form-group col-md-3">
                <label for="emergency-person">Emergency Contact Person</label>
                <input value="{{ $edit ? $edit->emergency_contact : old('emergency_contact') }}" name="emergency_contact" type="text" class="form-control" id="emergency-person" placeholder="Emergency Contact Person">
              </div>
              <div class="form-group col-md-3">
                <label for="emergency-number">Emergency Contact Number</label>
                <input value="{{ $edit ? $edit->emergency_number : old('emergency_number') }}" name="emergency_number" type="tel" class="form-control" id="emergency-number" placeholder="Emergency Contact Number">
              </div>
            </div>
            @if (!$edit)
            <hr />
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="date-hired">Date Hired *</label>
                <input value="{{ old('date_hired') ?: date('Y-m-d') }}" name="date_hired" type="date" class="form-control" id="date-hired" required>
              </div>
            </div>
            @endif
            <p class="font-weight-bold"><i>* Fields with required valid values</i></p>
            <button type="submit" class="btn btn-primary">{{ $edit ? 'Save Employee' : 'Create Employee' }}</button>
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
