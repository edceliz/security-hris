@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>Detachments {{ !empty($query) ? "like $query" : null }}</h3>
    </div>
    @can ('manage-detachments')
    <div class="col text-right">
      <a class="btn btn-secondary" href="/detachments/new" role="button">Add New</a>
    </div>
    @endcan
  </div>
  <hr>
  <div class="row mb-3">
    <div class="col">
      <form class="form-inline align-items-center" method="GET" action="/detachments/search">
        <div class="form-row ml-auto">
          <input name="q" type="text" class="form-control mr-2" placeholder="Search...">
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
        @csrf
      </form>
    </div>
  </div>
  <div class="row content">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Address</th>
                @can ('manage-detachments')
                  <th>Operation</th>
                @endcan
              </tr>
            </thead>
            <tbody>
              @foreach ($detachments as $detachment)
                <tr>
                  <td>{{ $detachment->name }}</td>
                  <td>{{ $detachment->address }}</td>
                  @can ('manage-detachments')
                    <td>
                      <a class="btn btn-primary" href="/detachments/{{ $detachment->id }}" role="button">Edit</a>
                      <a class="btn btn-danger" href="/detachments/delete/{{ $detachment->id }}" 
                        role="button"
                        onclick="event.preventDefault();
                        if (confirm('Are you sure you want to delete {{ $detachment->name }}?')) {
                          document.getElementById('delete-form-{{ $detachment->id }}').submit();
                        }">
                        Delete
                      </a>
                      <form id="delete-form-{{ $detachment->id }}" action="/detachments/delete/{{ $detachment->id }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                    </td>
                  @endcan
                </tr>
              @endforeach
              @if (!count($detachments))
                <tr>
                  <td colspan="4" class="text-center">No matching results.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
