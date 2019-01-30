@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>
        Dashboard
      </h3>
    </div>
  </div>
  <hr>
  <div class="row content">
    <div class="col-md-3">
      <div class="card text-white bg-primary">
        <div class="card-header">Active Employees</div>
        <div class="card-body">
          <h1 class="display-5 text-center">{{ $employees }}</h1>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-success">
        <div class="card-header">Active Detachments</div>
        <div class="card-body">
          <h1 class="display-5 text-center">{{ count($branches) }}</h1>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-warning">
        <div class="card-header">Expiring Licenses</div>
        <div class="card-body">
          <h1 class="display-5 text-center">{{ $expiringLicenses->count() }}</h1>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-danger">
        <div class="card-header">Expired Licenses</div>
        <div class="card-body">
          <h1 class="display-5 text-center">{{ $expiredLicenses->count() }}</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="row content mt-3">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h4 class="mb-0">
                Expiring Licenses 
              </h4>
            </div>
            <div class="col text-right">
              @if (count($expiringLicenses) > 5)
                <a class="btn btn-success" href="/list/view/expiring" role="button">View Full List</a>
              @endif
              <a class="btn btn-secondary" href="/list/print/expiring" role="button">Print Full List</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Expiration Date</th>
                <th>Remarks</th>
              </tr>
            </thead>
            <tbody>
              @foreach (array_slice($expiringLicenses->toArray(), 0, 5) as $employee)
                <tr>
                  <td><a href="/employees/license/{{ $employee['id'] }}">{{ $employee['first_name'] }} {{ $employee['surname'] }}</a></td>
                  <td>{{ $employee['current_status']['status'] }}</td>
                  <td>{{ $employee['current_license']['date_expired'] }} </td>
                  <td>{{ $employee['current_license']['remarks'] }}</td>
                </tr>
              @endforeach
              @if (!count($expiringLicenses))
                <tr>
                  <td colspan="4" class="text-center">There are no expiring licenses.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row content mt-3">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h4 class="mb-0">
                Expired Licenses
              </h4>
            </div>
            <div class="col text-right">
              @if (count($expiredLicenses) > 5)
                <a class="btn btn-success" href="/list/view/expired" role="button">View Full List</a>
              @endif
              <a class="btn btn-secondary" href="/list/print/expired" role="button">Print Full List</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Expiration Date</th>
                <th>Remarks</th>
              </tr>
            </thead>
            <tbody>
              @foreach (array_slice($expiredLicenses->toArray(), 0, 5) as $employee)
                <tr>
                  <td><a href="/employees/license/{{ $employee['id'] }}">{{ $employee['first_name'] }} {{ $employee['surname'] }}</a></td>
                  <td>{{ $employee['current_status']['status'] }}</td>
                  <td>{{ $employee['current_license']['date_expired'] }} </td>
                  <td>{{ $employee['current_license']['remarks'] }}</td>
                </tr>
              @endforeach
              @if (!count($expiredLicenses))
                <tr>
                  <td colspan="4" class="text-center">There are no expired licenses.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row content mt-3">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h4 class="mb-0">
                Incomplete Information 
              </h4>
            </div>
            <div class="col text-right">
              @if (count($incompleteInformation) > 3)
                <a class="btn btn-success" href="/list/view/incomplete" role="button">View Full List</a>
              @endif
              <a class="btn btn-secondary" href="/list/print/incomplete" role="button">Print Full List</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Incomplete Information</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($incompleteInformation as $employee)
                <tr>
                  <td><a href="/employees/{{ $employee['id'] }}">{{ $employee['first_name'] }} {{ $employee['surname'] }}</a></td>
                  <td>{{ $employee->currentStatus['status'] }}</td>
                  <td>
                    @foreach ($employee->getAttributes() as $key => $value)
                      @if (empty($value) && ($key !== 'deleted_at' && $key !== 'deleted_by' ))
                        <p class="mb-0">{{ $key }}</p>
                      @endif
                    @endforeach
                  </td>
                </tr>
              @endforeach
              @if (!count($incompleteInformation))
                <tr>
                  <td colspan="4" class="text-center">There are no incomplete information.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0">
            Detachments
            @if (count($branches) > 10)
              <a class="btn btn-success" href="/list/view/detachments" role="button">View Full List</a>
            @endif
          </h4>
        </div>
        <div class="card-body">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Total Employees</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($branches->take(10) as $branch)
                <tr>
                  <td>{{ $branch->name }}</td>
                  <td>{{ $branch->employees_count }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row content mt-3">
    
  </div>
</div>
@endsection
