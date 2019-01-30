@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>
        {{ $employee->first_name }} {{ $employee->surname }}
      </h3>
    </div>
    @can ('manage-employees')
    <div class="col text-right">
      <a class="btn btn-secondary" href="/employees/edit/{{ $employee->id }}" role="button">Edit Information</a>
      <a class="btn btn-secondary" href="/employees/license/{{ $employee->id }}" role="button">Edit License</a>
      <a class="btn btn-secondary" href="/employees/job/{{ $employee->id }}" role="button">Edit Status/Detachment</a>
    </div>
    @endcan
  </div>
  <hr>
  <div class="row content">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0">Personal Information</h4>
        </div>
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Surname:</strong></div>
            <div class="col-sm-9">{{ $employee->surname }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>First Name:</strong></div>
            <div class="col-sm-9">{{ $employee->first_name }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Middle Initial:</strong></div>
            <div class="col-sm-9">{{ $employee->middle_initial }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Current Address:</strong></div>
            <div class="col-sm-9">{{ $employee->current_address }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Permanent Address:</strong></div>
            <div class="col-sm-9">{{ $employee->permanent_address }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Contact Number:</strong></div>
            <div class="col-sm-9">{{ $employee->contact_number }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Birthday:</strong></div>
            <div class="col-sm-9">{{ \Carbon\Carbon::parse($employee->birthday)->toFormattedDateString() }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Blood Type:</strong></div>
            <div class="col-sm-9">{{ $employee->blood_type }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Civil Status:</strong></div>
            <div class="col-sm-9">{{ $employee->civil_status }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>SSS:</strong></div>
            <div class="col-sm-9">{{ $employee->sss }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>TIN:</strong></div>
            <div class="col-sm-9">{{ $employee->tin }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Philhealth Number:</strong></div>
            <div class="col-sm-9">{{ $employee->philhealth }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Pagibig Number:</strong></div>
            <div class="col-sm-9">{{ $employee->pagibig }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Medical Insurance:</strong></div>
            <div class="col-sm-9">{{ $employee->health_insurance or '-' }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Number of Dependents:</strong></div>
            <div class="col-sm-9">{{ $employee->dependents_no or '0' }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Emergency Contact Person:</strong></div>
            <div class="col-sm-9">{{ $employee->emergency_contact or '-' }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Emergency Contact Number:</strong></div>
            <div class="col-sm-9">{{ $employee->emergency_number or '-' }}</div>
          </div>
          <hr />
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Date Hired:</strong></div>
            <div class="col-sm-9">{{ $employee->date_hired ? \Carbon\Carbon::parse($employee->date_hired)->toFormattedDateString() : null }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Current License:</strong></div>
            <div class="col-sm-9">{{ $employee->currentLicense ? "{$employee->currentLicense->number} expiring at" : null }} {{ $employee->currentLicense ? \Carbon\Carbon::parse($employee->currentLicense->date_expired)->toFormattedDateString() : null }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Status:</strong></div>
            <div class="col-sm-9">{{ $employee->currentStatus->status or null }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-3 text-right"><strong>Detachment:</strong></div>
            <div class="col-sm-9">{{ $employee->currentDetachment->name or null }}</div>
          </div>
          <div class="row">
            <div class="col-sm-3 text-right"><strong>Position:</strong></div>
            <div class="col-sm-9">{{ $employee->currentPosition->position or null }}</div>
          </div>
          <!-- <form>
            <div class="form-row">
              <div class="form-group col-md-5">
                <label for="surname">Surname</label>
                <input value="{{ $employee->surname }}" type="text" class="form-control" id="surname" placeholder="Surname" disabled>
              </div>
              <div class="form-group col-md-5">
                <label for="first-name">First Name</label>
                <input value="{{ $employee->first_name }}" type="text" class="form-control" id="first-name" placeholder="First Name" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="middle-initial">Middle Initial</label>
                <input value="{{ $employee->middle_initial }}" type="text" class="form-control" id="middle-initial" placeholder="Middle Initial" disabled>
              </div>
            </div>
            <div class="form-group">
              <label for="address">Current Address</label>
              <input value="{{ $employee->current_address }}" type="text" class="form-control" id="address" placeholder="Current Address" disabled>
            </div>
            <div class="form-group">
              <label for="paddress">Permanent Address</label>
              <input value="{{ $employee->permanent_address }}" type="text" class="form-control" id="paddress" placeholder="Permanent Address" disabled>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="contact-number">Contact Number</label>
                <input value="{{ $employee->contact_number }}" type="tel" class="form-control" id="contact-number" placeholder="Contact Number" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="birthday">Birthday</label>
                <input value="{{ $employee->birthday }}" type="date" class="form-control" id="birthday" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="blood-type">Blood Type</label>
                <input value="{{ $employee->blood_type }}" type="text" class="form-control" id="blood-type" placeholder="Blood Type" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="civil-status">Civil Status</label>
                <select class="form-control" disabled>
                  <option {{ $employee->civil_status === "Single" ? 'selected' : null }} value="Single">Single</option>
                  <option {{ $employee->civil_status === "Married" ? 'selected' : null }} value="Married">Married</option>
                  <option {{ $employee->civil_status === "Widowed" ? 'selected' : null }} value="Widowed">Widowed</option>
                  <option {{ $employee->civil_status === "Separated" ? 'selected' : null }} value="Separated">Separated</option>
                  <option {{ $employee->civil_status === "Divorced" ? 'selected' : null }} value="Divorced">Divorced</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="sss">SSS</label>
                <input value="{{ $employee->sss }}" type="text" class="form-control" id="sss" placeholder="SSS Number" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="tin">TIN</label>
                <input value="{{ $employee->tin }}" type="text" class="form-control" id="tin" placeholder="TIN" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="philhealth">Philhealth Number</label>
                <input value="{{ $employee->philhealth }}" type="text" class="form-control" id="philhealth" placeholder="Philhealth Number" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="pagibig">Pagibig Number</label>
                <input value="{{ $employee->pagibig }}" type="text" class="form-control" id="pagibig" placeholder="Pagibig Number" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="medical">Medical Insurance</label>
                <input value="{{ $employee->health_insurance }}" type="text" class="form-control" id="medical" placeholder="Medical Insurance" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="dependents">Number of Dependents</label>
                <input value="{{ $employee->dependents_no }}" type="number" class="form-control" id="dependents" placeholder="Number of Dependents" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="emergency-person">Emergency Contact Person</label>
                <input value="{{ $employee->emergency_contact }}" type="text" class="form-control" id="emergency-person" placeholder="Emergency Contact Person" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="emergency-number">Emergency Contact Number</label>
                <input value="{{ $employee->emergency_number }}" type="tel" class="form-control" id="emergency-number" placeholder="Emergency Contact Number" disabled>
              </div>
            </div>
          </form> -->
        </div>
      </div>
    </div>
  </div>
  @if ($license)
    <!-- <div class="row content mt-3">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h4 class="mb-0">Security License</h4>
          </div>
          <div class="card-body">
            <form>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="license">Security License Number</label>
                  <input value="{{ $license->number }}" type="text" class="form-control" id="license" placeholder="Security License Number" disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="issued-date">Issued Date</label>
                  <input value="{{ $license->date_issued }}" type="date" class="form-control" id="issued-date" disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="expiration-date">Expiration Date</label>
                  <input value="{{ $license->date_expired }}" type="date" class="form-control" id="expiration-date" disabled>
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
    </div> -->
  @endif
  <div class="row content mt-3">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0">History</h4>
        </div>
        <div class="card-body">
          <table class="table mb-0">
            <thead>
              <th>Status</th>
              <th>Status Date</th>
              <th>Updated On</th>
              <th>Updated By</th>
              <th>Remarks</th>
            </thead>
            <tbody>
              @foreach ($history as $entry)
                <tr>
                  <td>
                    @if (!empty($entry->number))
                      Updated license to {{ $entry->number }}
                    @elseif (!empty($entry->status))
                      Status changed to {{ $entry->status }}
                      @elseif (!empty($entry->position))
                      Position changed to {{ $entry->position }}
                    @else (!empty($entry->detachment_id))
                      Assigned to {{ $entry->detachment->name }}
                    @endif
                  </td>
                  <td>{{ $entry->number ? null : \Carbon\Carbon::parse($entry->date_changed)->toFormattedDateString() }}</td>
                  <td>{{ \Carbon\Carbon::parse($entry->created_at)->toFormattedDateString() }}</td>
                  <td>{{ $entry->creator->name }}</td>
                  <td>{{ $entry->remarks }}</td>
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
