@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>Report Builder</h3>
    </div>
  </div>
  <hr>
  <div class="row content">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <form method="GET" action="/report/generate/view">
            <div class="form-group row">
              <label for="license-issued" class="col-sm-4 col-form-label text-right font-weight-bold">Security License Issued Date</label>
              <!-- <select name="date_issued_filter" class="form-control col-sm-2">
                <option value="between">BETWEEN</option>
              </select> -->
              <input value="between" type="hidden" name="date_issued_filter">
              <div class="col-sm-8">
                <div class="row">
                  <div class="col-6">
                    <input name="date_issued_value_1" type="date" class="form-control" id="license-issued">
                  </div>
                  <div class="col-6">
                    <input name="date_issued_value_2" type="date" class="form-control" id="license-issued">
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
                    <input name="date_expired_value_1" type="date" class="form-control" id="license-issued">
                  </div>
                  <div class="col-6">
                    <input name="date_expired_value_2" type="date" class="form-control" id="license-issued">
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
                    <input name="date_hired_value_1" type="date" class="form-control" id="date_hired">
                  </div>
                  <div class="col-6">
                    <input name="date_hired_value_2" type="date" class="form-control" id="date_hired">
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
                  <option value="Active">Active</option>
                  <option value="Resigned">Resigned</option>
                  <option value="AWOL">AWOL</option>
                  <option value="Floating">Floating</option>
                  <option value="Retired">Retired</option>
                  <option value="On Leave">On Leave</option>
                  <option value="Suspended">Suspended</option>
                  <option value="Terminated">Terminated</option>
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
                  <option value="Detachment Commander">Detachment Commander</option>
                  <option value="Assistant Detachment Commander">Assistant Detachment Commander</option>
                  <option value="Shift in Charge">Shift in Charge</option>
                  <option value="Watchment/Guard">Watchment/Guard</option>
                  <option value="Post in Charge">Post in Charge</option>
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
                  @foreach ($detachments as $detachment)
                    <option value="{{ $detachment->name }}">{{ $detachment->name }}</option>
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
</div>
@endsection
