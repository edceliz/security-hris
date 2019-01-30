@extends('layouts.app')

@section('head')
  <script>
    // alert('qwe');
  </script>
  <style>
    @media print {
      p {
        font-size: 1.5em;
      }

      nav, h3, a.btn, hr {
        display: none;
      }
      .card {
        width: 100%;
        border: none;
      }
    }
  </style>
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <h3>Request Memo</h3>
    </div>
    <div class="col text-right">
      <a class="btn btn-secondary" href="#" role="button">Print Full List</a>
    </div>
  </div>
  <hr>
  <div class="row content">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <p class="font-weight-bold">Dear Sample Name,</p>
          <p class="mb-4">06/06/2018</p>
          <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Et corrupti vero, voluptatum excepturi, pariatur explicabo molestias tempora modi sit repellat corporis sed perferendis officia, ipsam amet! Nulla a dicta id.</p>
          <p>Sincerely Yours,</p>
          <p>HR Manager</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
