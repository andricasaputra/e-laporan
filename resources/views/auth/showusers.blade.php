@extends('layouts.app')

@section('title', 'Home Operasional - Show All Users')

@section('content')

<style type="text/css">
 table th, table tbody, table td{
    text-align: center !important;
  }
</style>

<main class="content-wrapper">
  <div class="container-fluid">
   <div class="row">
      <div class="col-md-10 offset-md-1 card">
          @include('inc.message')
          <div class="card-header">
            Data Users
          </div>
          <div class="card-body">
             <table class="table table-responsive table-bordered w-100 d-block d-md-table" id="users">
              <thead>
                 <th>Id</th>
                 <th>Name</th>
                 <th>Username</th>
                 <th>Bagian</th>
                 <th>Options</th>
              </thead>
              <tbody></tbody>        
           </table>
          </div>
      </div>
    </div>
  </div>
</main>

@endsection

@section('custom_scripts')

  <script>
    $(document).ready(function () {
        $('#users').DataTable({

            "processing": true,
            "serverSide": true,
            "ajax":{
               "url": "{{ route('api.user') }}",
               "dataType": "json"
            },
            "columns": [
              { "data": "id" },
              { "data": "name" },
              { "data": "username" },
              { "data": "bagian" },
              { "data": "action" }
            ]  

        });
    });
  </script>

@endsection