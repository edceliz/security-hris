@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>Report Builder</h3>
    </div>
  </div>
  <hr>
  <div class="row content mb-4">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <p class="d-flex mb-0 align-items-center"><span>Click &nbsp;</span> <a class="btn btn-secondary" data-toggle="collapse" href="#form" role="button">Filter</a> <span>&nbsp; to show/hide the report builder form.</span></p>
          <form method="GET" action="/report/generate/view" class="collapse mt-4" id="form">
            <div class="form-group row">
              <label for="license-issued" class="col-sm-4 col-form-label text-right font-weight-bold">Security License Issued Date</label>
              <!-- <select name="date_issued_filter" class="form-control col-sm-2">
                <option value="between">BETWEEN</option>
              </select> -->
              <input value="between" type="hidden" name="date_issued_filter">
              <div class="col-sm-8">
                <div class="row">
                  <div class="col-6">
                    <input value="{{ !empty($data->date_issued_value_1) ? $data->date_issued_value_1 : null }}" name="date_issued_value_1" type="date" class="form-control" id="license-issued">
                  </div>
                  <div class="col-6">
                    <input value="{{ !empty($data->date_issued_value_2) ? $data->date_issued_value_2 : null }}" name="date_issued_value_2" type="date" class="form-control" id="license-issued">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="license-expired" class="col-sm-4 col-form-label text-right font-weight-bold">Security License Expiration Date</label>
              <!-- <select name="date_expired_filter" class="form-control col-sm-2">
                <option value="between">BETWEEN</option>
              </select> -->
              <input value="between" type="hidden" name="date_expired_filter">
              <div class="col-sm-8">
                <div class="row">
                  <div class="col-6">
                    <input value="{{ !empty($data->date_expired_value_1) ? $data->date_expired_value_1 : null }}" name="date_expired_value_1" type="date" class="form-control" id="license-issued">
                  </div>
                  <div class="col-6">
                    <input value="{{ !empty($data->date_expired_value_2) ? $data->date_expired_value_2 : null }}" name="date_expired_value_2" type="date" class="form-control" id="license-issued">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="date_hired" class="col-sm-4 col-form-label text-right font-weight-bold">Date Hired</label>
              <!-- <select name="date_hired_filter" class="form-control col-sm-2">
                <option value="between">BETWEEN</option>
              </select> -->
              <input value="between" type="hidden" name="date_hired_filter">
              <div class="col-sm-8">
                <div class="row">
                  <div class="col-6">
                    <input value="{{ !empty($data->date_hired_value_1) ? $data->date_hired_value_1 : null }}" name="date_hired_value_1" type="date" class="form-control" id="date_hired">
                  </div>
                  <div class="col-6">
                    <input value="{{ !empty($data->date_hired_value_2) ? $data->date_hired_value_2 : null }}" name="date_hired_value_2" type="date" class="form-control" id="date_hired">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="job-status" class="col-sm-4 col-form-label text-right font-weight-bold">Job Status</label>
              <!-- <select name="status_filter" class="form-control col-sm-2">
                <option value="=">EQUALS</option>
              </select> -->
              <input value="=" type="hidden" name="status_filter">
              <div class="col-sm-8">
                <select name="status_value" class="form-control" id="job-status">
                  <option value="" selected disabled>Select Status</option>
                  <option value="">All Status</option>
                  <option value="Active" {{ !empty($data->status_value) && $data->status_value === 'Active' ? 'selected' : null }}>Active</option>
                  <option value="Resigned" {{ !empty($data->status_value) && $data->status_value === 'Resigned' ? 'selected' : null }}>Resigned</option>
                  <option value="AWOL" {{ !empty($data->status_value) && $data->status_value === 'AWOL' ? 'selected' : null }}>AWOL</option>
                  <option value="Floating" {{ !empty($data->status_value) && $data->status_value === 'Floating' ? 'selected' : null }}>Floating</option>
                  <option value="Retired" {{ !empty($data->status_value) && $data->status_value === 'Retired' ? 'selected' : null }}>Retired</option>
                  <option value="On Leave" {{ !empty($data->status_value) && $data->status_value === 'On Leave' ? 'selected' : null }}>On Leave</option>
                  <option value="Suspended" {{ !empty($data->status_value) && $data->status_value === 'Suspended' ? 'selected' : null }}>Suspended</option>
                  <option value="Terminated" {{ !empty($data->status_value) && $data->status_value === 'Terminated' ? 'selected' : null }}>Terminated</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="job-position" class="col-sm-4 col-form-label text-right font-weight-bold">Job Position</label>
              <!-- <select name="position_filter" class="form-control col-sm-2">
                <option value="=">EQUALS</option>
              </select> -->
              <input value="=" type="hidden" name="position_filter">
              <div class="col-sm-8">
                <select name="position_value" class="form-control" id="job-position">
                  <option value="" selected disabled>Select Position</option>
                  <option value="">All Position</option>
                  <option value="Detachment Commander" {{ !empty($data->position_value) && $data->position_value === 'Detachment Commander' ? 'selected' : null }}>Detachment Commander</option>
                  <option value="Assistant Detachment Commander" {{ !empty($data->position_value) && $data->position_value === 'Assistant Detachment Commander' ? 'selected' : null }}>Assistant Detachment Commander</option>
                  <option value="Shift in Charge" {{ !empty($data->position_value) && $data->position_value === 'Shift in Charge' ? 'selected' : null }}>Shift in Charge</option>
                  <option value="Watchment/Guard" {{ !empty($data->position_value) && $data->position_value === 'Watchment/Guard' ? 'selected' : null }}>Watchment/Guard</option>
                  <option value="Post in Charge" {{ !empty($data->position_value) && $data->position_value === 'Post in Charge' ? 'selected' : null }}>Post in Charge</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="detachment" class="col-sm-4 col-form-label text-right font-weight-bold">Detachment</label>
              <!-- <select name="detachment_filter" class="form-control col-sm-2">
                <option value="=">EQUALS</option>
              </select> -->
              <input value="=" type="hidden" name="detachment_filter">
              <div class="col-sm-8">
                <select name="detachment_value" id="detachment" class="selectpicker form-control" data-live-search="true">
                  <option value="" selected disabled>Select Detachment</option>
                  <option value="">All Detachments</option>
                  @foreach ($detachments as $detachment)
                    <option value="{{ $detachment->name }}" {{ !empty($data->detachment_value) ? ($data->detachment_value === $detachment->name ? 'selected' : null) : null }}>{{ $detachment->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Generate Report</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <h3>Result ({{ $employees->total() }} Records)</h3>
    </div>
    <div class="col text-right">
      <a class="btn btn-secondary" href="/report/generate/print?{{ http_build_query($data) }}" role="button">Download Result</a>
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
                <th>Contact Number</th>
                <th>Status</th>
                <th>Detachment</th>
                <th>License Number</th>
                <th>License Expiration Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($employees as $employee)
                <tr>
                  <td><a href="/employees/{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->surname }}</a></td>
                  <td>{{ $employee->contact_number }}</td>
                  <td>{{ $employee->currentStatus ? $employee->currentStatus->status : null }}</td>
                  <td>{{ $employee->currentDetachment ? $employee->currentDetachment->name : null }}</td>
                  <td>{{ $employee->currentLicense->number or null }}</td>
                  <td>{{ $employee->currentLicense->date_expired or null }}</td>
                </tr>
              @endforeach

              @if (!$employees->total())
                <tr>
                  <td colspan="6" class="text-center">There are no employees matching your criteria.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
      <nav class="mt-3">
        {{ $employees->links() }}
      </nav>
    </div>
  </div>
</div>
@endsection
