@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>Employees {{ !empty($search) ? 'Search' : null}}</h3>
    </div>
    @can ('manage-employees')
    <div class="col text-right">
      <a class="btn btn-secondary" href="/employees/new" role="button">Add New</a>
    </div>
    @endcan
  </div>
  <hr>
  <div class="row mb-3">
    <div class="col">
      <form method="GET" action="/employees/search" class="form-inline align-items-center">
        <div class="form-row ml-auto">
          <input type="hidden" name="status" value="{{ !empty(Request::get('status')) ? Request::get('status') : 'all' }}">
          <label for="filter">Search Using</label>
          <select name="filter" id="filter" class="form-control ml-2 mr-2">
            <option {{ !empty($search) && $search['filter'] === 'surname' ? 'selected' : null }} value="surname">Last Name</option>
            <option {{ !empty($search) && $search['filter'] === 'first_name' ? 'selected' : null }} value="first_name">First Name</option>
            <option {{ !empty($search) && $search['filter'] === 'current_address' ? 'selected' : null }} value="current_address">Current Address</option>
            <option {{ !empty($search) && $search['filter'] === 'permanent_address' ? 'selected' : null }} value="permanent_address">Permanent Address</option>
            <option {{ !empty($search) && $search['filter'] === 'detachment' ? 'selected' : null }} value="detachment">Detachment</option>
            <option {{ !empty($search) && $search['filter'] === 'status' ? 'selected' : null }} value="status">Status</option>
          </select>
          <input value="{{ !empty($search) ? $search['value'] : null }}" name="value" type="text" class="form-control mr-2" placeholder="Search...">
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
      </form>
    </div>
  </div>
  <div class="row content">
    <div class="col">
    <ul class="nav nav-tabs">
      <li class="nav-item mr-1">
        <a class="nav-link {{ Request::get('status') === 'all' || !Request::get('status') ? 'active bg-white' : 'bg-primary text-white' }}" href="/employees/search?status=all&filter={{ Request::get('filter') ?: 'all' }}&value={{ Request::get('value') ?: null }}">All</a>
      </li>
      <li class="nav-item mr-1">
        <a class="nav-link {{ Request::get('status') === 'active' ? 'active bg-white' : 'bg-primary text-white' }}" href="/employees/search?status=active&filter={{ Request::get('filter') ?: 'all' }}&value={{ Request::get('value') ?: null }}">Active</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::get('status') === 'inactive' ? 'active bg-white' : 'bg-primary text-white' }}" href="/employees/search?status=inactive&filter={{ Request::get('filter') ?: 'all' }}&value={{ Request::get('value') ?: null }}">Inactive</a>
      </li>
    </ul>
      <div class="card" style="border-top: none; border-top-left-radius: 0; border-top-right-radius: 0">
        <div class="card-body">
          <p class="text-right">Total Employees: {{ $employees->total() }}</p>
          <table class="table m-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Detachment</th>
                <th>Job Position</th>
                <th>License Expiration Date</th>
                <!-- <th>Last Updated</th> -->
                @can ('manage-employees')
                <th>Operation</th>
                @endcan
              </tr>
            </thead>
            <tbody>
              @foreach ($employees as $employee)
                @php ($white = false)
                @if ($employee->currentLicense && \Carbon\Carbon::createFromFormat('Y-m-d', $employee->currentLicense->date_expired) < \Carbon\Carbon::now())
                  <tr class="license_expired">
                @elseif ($employee->currentLicense && \Carbon\Carbon::createFromFormat('Y-m-d', $employee->currentLicense->date_expired) < \Carbon\Carbon::now()->addDays(60))
                  <tr class="license_expiring">
                @else
                  <tr>
                @endif
                  <td><a href="/employees/{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->surname }}</a></td>
                  <td>{{ $employee->currentStatus->status or null }}</td>
                  <td>{{ $employee->currentDetachment->name or null }}</td>
                  <td>{{ $employee->currentPosition->position or null }}</td>
                  <td>{{ $employee->currentLicense ? \Carbon\Carbon::parse($employee->currentLicense->date_expired)->toFormattedDateString() : null }}</td>
                  <!-- <td>{{ \Carbon\Carbon::parse($employee->updated)->toFormattedDateString() }}</td> -->
                  @can ('manage-employees')
                    <td>
                      <a title="Edit Status/Detachment" class="btn btn-primary" href="/employees/job/{{ $employee->id }}" role="button"><i class="fas fa-building"></i></a>
                      <a title="Edit License" class="btn btn-primary" href="/employees/license/{{ $employee->id }}" role="button"><i class="fas fa-id-card"></i></a>
                      @can ('manage-users')
                        <a class="btn btn-danger" href="/employees/delete/{{ $employee->id }}" 
                          role="button"
                          title="Delete Record"
                          onclick="event.preventDefault();
                          if (confirm('Are you sure you want to delete {{ $employee->first_name }} {{ $employee->surname }}?')) {
                            document.getElementById('delete-form-{{ $employee->id }}').submit();
                          }">
                          <i class="fas fa-trash-alt"></i>
                        </a>
                        <form id="delete-form-{{ $employee->id }}" action="/employees/delete/{{ $employee->id }}" method="POST" style="display: none;">
                          @csrf
                        </form>
                      @endcan
                    </td>
                  @endcan
                </tr>
              @endforeach
              @if (!count($employees))
                <tr>
                  <td colspan="7" class="text-center">No matching results.</td>
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
