@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>{{ $title }}</h3>
    </div>
    <div class="col text-right">
      <a class="btn btn-secondary" href="/list/print/{{ $id }}" role="button">Print Full List</a>
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
                @switch ($id)
                  @case ('expiring')
                  @case ('expired')
                    <th>Name</th>
                    <th>Status</th>
                    <th>Expiration Date</th>
                    <th>Remarks</th>
                    @break
                  @case ('incomplete')
                    <th>Name</th>
                    <th>Status</th>
                    <th>Incomplete Information</th>
                    @break
                  @case ('detachments')
                    <th>Name</th>
                    <th>Address</th>
                    <th>Employee Count</th>
                    @break
                @endswitch
              </tr>
            </thead>
            <tbody>
              @switch ($id)
                @case ('expiring')
                @case ('expired')
                  @foreach ($list as $entry)
                    <tr>
                      <td><a href="/employees/{{ $entry->id }}">{{ $entry->first_name }} {{ $entry->surname }}</a></td>
                      <td>{{ $entry->currentStatus ? $entry->currentStatus->status : null }}</td>
                      <td>{{ $entry->currentLicense->date_expired }}</td>
                      <td>{{ $entry->currentLicense->remarks }}</td>
                    </tr>
                  @endforeach
                  @break
                @case ('incomplete')
                  @foreach ($list as $entry)
                    <tr>
                      <td><a href="/employees/{{ $entry->id }}">{{ $entry->first_name }} {{ $entry->surname }}</a></td>
                      <td>{{ $entry->currentStatus ? $entry->currentStatus->status : null }}</td>
                      <td>
                        @foreach ($entry->getAttributes() as $key => $value)
                          @if (empty($value) && ($key !== 'deleted_at' && $key !== 'deleted_by' ))
                            <p class="mb-0">{{ $key }}</p>
                          @endif
                        @endforeach
                      </td>
                    </tr>
                  @endforeach
                  @break
                @case ('detachments')
                  @foreach ($list as $entry)
                    <tr>
                      <td>{{ $entry->name }}</td>
                      <td>{{ $entry->address }}</td>
                      <td>{{ $entry->total }}</td>
                    </tr>
                  @endforeach
                  @break
              @endswitch
            </tbody>
          </table>
        </div>
      </div>
      <nav class="mt-3">
        {{ $list->links() }}
      </nav>
    </div>
  </div>
</div>
@endsection
