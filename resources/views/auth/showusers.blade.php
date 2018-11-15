@extends('intern.layouts.app')

@section('title', 'Home Operasional - Show All Users')

@section('barside')

  @include('intern.inc.barside_manajemen')

@endsection

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
          @include('intern.inc.message')
          <div class="card-header">
            Data Users
          </div>
          <div class="card-body">
             <table class="table table-responsive table-bordered w-100 d-block d-md-table" id="users">
              <thead>
                 <th>Id</th>
                 <th>Name</th>
                 <th>Username</th>
                 <th>Status</th>
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

@section('script')

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
              { "data": "pegawai.nama" },
              { "data": "username" },
              { "data": "pegawai.is_active" },
              { "data": "action" }
            ]  

        });
    });
  </script>

@endsection