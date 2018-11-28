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
                 <th>No</th>
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

<!-- Modal Delete -->
<div class="modal fade" id="modalDeleteUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h3>Apakah Anda Yakin Ingin Meghapus Data Ini?</h3><br>
        <form action="{{route('users.destroy', 'delete')}}" method="post">

        @csrf
          @method('DELETE')

          <input type="hidden" name="id" id="userId">
          
          <input type="submit" name="delete" value="Ya" class="btn btn-primary">
          <button type="button" class="btn btn-success" data-dismiss="modal">Tidak</button>
      </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

  <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

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
              { "data": "DT_Row_Index", orderable: false, searchable: false },
              { "data": "pegawai.nama" },
              { "data": "username" },
              { "data": "pegawai.is_active" },
              { "data": "action" }
            ]  

        });

        $(document).on('click', '#deleteUser', function(e){

          e.preventDefault();
          let id = $( this ).data( 'id' );

          $('#modalDeleteUser').modal('show');

          let idInForm = $("#modalDeleteUser #userId").val(id);

      });
    });
  </script>

@endsection