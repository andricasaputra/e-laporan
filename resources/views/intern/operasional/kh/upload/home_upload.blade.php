@extends('intern.layouts.app')

@section('title', 'Menu Operasional KT')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Upload Laporan Operasional Karantina Hewan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kh') }}">Menu</a></li>
            <li class="breadcrumb-item" aria-current="page">Upload</li>
        </ol>
    </nav>
</div>

@endsection

@section('content')

<style type="text/css">

  i.fa-2x {
    display: inline-block;
    border-radius: 80px;
    box-shadow: 0px 0px 2px #888;
    padding: 0.5em 0.6em;
  }

  .fa-bus{
    background-color: #f73b5e;
    color: #fff
  }

  .fa-truck{
    background-color: #2962FF;
    color: #fff;
  }

  .fa-ship{
    background-color: #FF8F29;
    color: #fff;
  }

  .fa-plane{
    background-color: #12AFAF;
    color: #fff;
  }

</style>

<div class="row">
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Domas
      </div>
      <div class="card-body">
        <i class="fa fa-bus fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Domestik Masuk
        </h4>
        <a href="{{ route('kh.upload.page.domas') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div>  
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Dokel
      </div>
      <div class="card-body">
        <i class="fa fa-truck fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Domestik Keluar
        </h4>
        <a href="{{ route('kh.upload.page.dokel') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div> 
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Ekspor
      </div>
      <div class="card-body">
        <i class="fa fa-ship fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Ekspor
        </h4>
        <a href="{{ route('kh.upload.page.ekspor') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div> 
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Impor
      </div>
      <div class="card-body">
        <i class="fa fa-plane fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Impor
        </h4>
        <a href="{{ route('kh.upload.page.impor') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4 mb-2">
  <div class="col">
    <div class="text-center">
      <a href="{{ route('showmenu.operasional.kh') }}" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> Kembali</a>
    </div>
  </div>
</div>

@include('intern.inc.message')

<div class="row mt-4">
  <div class="col-md-2 mb-2">
    <select name="wilker_id" id="selectWilker" class="form-control">
               
      @if(count($all_wilker) > 0)

          <option disabled selected>Pilih Wilker</option>

          @foreach($all_wilker as $w)

            <option value="{{ $w->id }}">{{ $w->nama_wilker }}</option>

          @endforeach
        
      @endif
      
    </select>
  </div>
  <div class="col-md-12">
    <div class="card"  style="border: 1px solid #eee">
      <div class="card-header">
        <b>Log Pengiriman Laporan Bulanan </b>
      </div>
      <div class="card-body">
        <table id="logOperasional" class="table table-striped table-bordered text-center" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Tipe Laporan</th>
                <th>Bulan</th>
                <th>Wilker</th>
                <th>Status</th>
                <th>Waktu Upload</th>
                <th>Action</th>
              </tr>
            </thead>
        </table>
      </div>  
    </div>
  </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalRollbackOperasional" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h4>Apakah Anda Yakin Ingin Menarik Data Ini?</h4><br>
        <form action="{{ route('rollback.operasional.kt', 'delete') }}" method="post">

          @csrf
          @method('DELETE')

          <input type="hidden" name="id" id="typeId">
          
          <input type="submit" name="delete" value="Ya" class="btn btn-success">

          <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
      </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>


@endsection

@section('script')

<script>

  $(document).ready(function(){

    let year = {{ $year }};

    let wilker = {{ $wilker->id }};

    let url = '{{ route('api.kh.log_operasional') }}/' + year + '/' + wilker;

    let data = [

      { "data" : "DT_Row_Index", orderable: false, searchable: false},
      { "data" : "type" },
      { "data" : "bulan" },
      { "data" : "wilker.nama_wilker" },
      { "data" : null, 
        render: function (data, type, row) {
          let details = row.status + " " + row.rolledback_at;
          return details 
        }
      },
      { "data" : "created_at" },
      { "data" : "action" , orderable: false, searchable: false}

    ]

    $('#logOperasional').DataTable({

        "processing": true,
        "serverSide": true,
        "ajax":{
           "url": url,
           "method": "POST",
           "dataType": "JSON"
        },
        "columns": data,
        "columnDefs": [{
            "defaultContent": "-",
            "targets": "_all"
        }]

    });

    $('#selectWilker').on('change', function() {

      wilker = $(this).val();

      url = '{{ route('api.kh.log_operasional') }}/' + year + '/' + wilker;

      $('#logOperasional').DataTable().destroy();

      $('#logOperasional').DataTable({

          "processing": true,
          "serverSide": true,
          "ajax":{
             "url": url,
             "method": "POST",
             "dataType": "JSON"
          },
          "columns": data,
          "columnDefs": [{
              "defaultContent": "-",
              "targets": "_all"
          }]

      });

    });

    $(document).on('click', '#rollbackOperasionalBtn', function(e){

      e.preventDefault();
      let id = $( this ).data( 'id' );

      $('#modalRollbackOperasional').modal('show');

      let idInForm = $("#modalRollbackOperasional #typeId").val(id);

    });  


  });

</script>

@endsection