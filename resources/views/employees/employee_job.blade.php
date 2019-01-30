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
      <a class="btn btn-secondary" href="/employees/license/{{ $employee->id }}" role="button">Edit License</a>
      <a class="btn btn-primary disabled" href="/employees/job/{{ $employee->id }}" role="button" aria-disabled="true">Edit Status/Detachment</a>
    </div>
  </div>
  <hr>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

  <div id="accordion">
    <div class="card">
      <div class="card-header" id="headingOne">
        <h5 class="mb-0">
          <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <h5 class="mb-0">Change Status</h5>
          </button>
        </h5>
      </div>
      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body">
          <form method="POST" action="/employees/job/status/{{ $employee->id }}">
            <div class="form-group">
              <label for="status">Status</label>
              <select name="status" id="status" class="form-control" name="status" required>
                <option selected disabled>Choose Status</option>
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
            <div class="form-group row mb-1">
              <div class="form-group col-6">
                <label for="job-remarks">Remarks</label>
                <input name="remarks" type="text" class="form-control" id="job-remarks" placeholder="Remarks">
              </div>
              <div class="form-group col-6">
                <label for="job-date">Date Performed</label>
                <input value="{{ date('Y-m-d') }}" name="date_changed" type="date" class="form-control" id="job-date" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
            @csrf
          </form>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header" id="headingTwo">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          <h5 class="mb-0">Change Detachment</h5>
          </button>
        </h5>
      </div>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
        <div class="card-body">
          <form method="POST" action="/employees/job/detachment/{{ $employee->id }}">
            @if (in_array($employee->currentStatus->status, ['AWOL', 'Resigned', 'Retired', 'Suspended', 'Terminated']) || !$employee->currentLicense)
              <div class="form-group">
                <label for="detachment">Detachment</label>
                <select name="detachment_id" id="detachment" class="form-control" name="detachment" disabled>
                  <option selected disabled>Choose Detachment</option>
                  @foreach ($detachments as $detachment)
                    <option value="{{ $detachment->id }}">{{ $detachment->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group row mb-1">
                <div class="form-group col-6">
                  <label for="detachment-remarks">Remarks</label>
                  <input name="remarks" type="text" class="form-control" id="detachment-remarks" placeholder="Remarks" disabled>
                </div>
                <div class="form-group col-6">
                  <label for="detachment-date">Date Performed</label>
                  <input value="{{ date('Y-m-d') }}" name="date_changed" type="date" class="form-control" id="detachment-date" required disabled>
                </div>
              </div>
              <button type="submit" class="btn btn-primary" disabled>Assign Detachment</button>
            @else
              <div class="form-group">
                <label for="detachment">Detachment</label>
                <select name="detachment_id" class="selectpicker form-control" data-live-search="true">
                  @foreach ($detachments as $detachment)
                    <option value="{{ $detachment->id }}">{{ $detachment->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group row mb-1">
                <div class="form-group col-6">
                  <label for="detachment-remarks">Remarks</label>
                  <input name="remarks" type="text" class="form-control" id="detachment-remarks" placeholder="Remarks">
                </div>
                <div class="form-group col-6">
                  <label for="detachment-date">Date Performed</label>
                  <input value="{{ date('Y-m-d') }}" name="date_changed" type="date" class="form-control" id="detachment-date" required>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Assign Detachment</button>
            @endif
            @csrf
          </form>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header" id="headingThree">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            <h5 class="mb-0">Change Job Position</h5>
          </button>
        </h5>
      </div>
      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
        <div class="card-body">
          <form method="POST" action="/employees/job/position/{{ $employee->id }}">
            <div class="form-group">
              <label for="position">Position</label>
              <select name="position" id="position" class="form-control" name="position" required>
                <option selected disabled>Choose Position</option>
                <option value="Detachment Commander">Detachment Commander</option>
                <option value="Assistant Detachment Commander">Assistant Detachment Commander</option>
                <option value="Shift in Charge">Shift in Charge</option>
                <option value="Watchment/Guard">Watchment/Guard</option>
                <option value="Post in Charge">Post in Charge</option>
              </select>
            </div>
            <div class="form-group row mb-1">
              <div class="form-group col-6">
                <label for="job-remarks">Remarks</label>
                <input name="remarks" type="text" class="form-control" id="job-remarks" placeholder="Remarks">
              </div>
              <div class="form-group col-6">
                <label for="job-date">Date Performed</label>
                <input value="{{ date('Y-m-d') }}" name="date_changed" type="date" class="form-control" id="job-date" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Position</button>
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>

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

<script>
  $(document).ready(function() {
    $('.selectpicker').selectpicker();
  });
</script>
@endsection
