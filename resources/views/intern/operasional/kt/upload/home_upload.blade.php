@extends('intern.layouts.app')

@section('title', 'Upload Laporan KT')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Upload Laporan Operasional Karantina Tumbuhan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kt') }}">Menu</a></li>
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

  .fa-bus, .fa-exchange{
    background-color: #f73b5e;
    color: #fff
  }

  .fa-truck, .fa-money{
    background-color: #2962FF;
    color: #fff;
  }

  .fa-ship, .fa-file-excel-o{
    background-color: #FF8F29;
    color: #fff;
  }

  .fa-plane, .card-body > .fa-repeat{
    background-color: #12AFAF;
    color: #fff;
  }

  .badge{
    padding: 4px 13px !important;
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
        <a href="{{ route('kt.upload.page.domas') }}" class="btn btn-default">Masuk</a>
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
        <a href="{{ route('kt.upload.page.dokel') }}" class="btn btn-default">Masuk</a>
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
        <a href="{{ route('kt.upload.page.ekspor') }}" class="btn btn-default">Masuk</a>
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
        <a href="{{ route('kt.upload.page.impor') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div>
</div>

<div class="row" id="advancedMenu">
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Serah Terima
      </div>
      <div class="card-body">
        <i class="fa fa-exchange fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Serah Terima
        </h4>
        <a href="{{ route('kt.upload.page.serah_terima') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div>  
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Re Ekspor
      </div>
      <div class="card-body">
        <i class="fa fa-repeat fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Re Ekspor
        </h4>
        <a href="{{ route('kt.upload.page.reekspor') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div> 
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Pembatalan Dokumen
      </div>
      <div class="card-body">
        <i class="fa fa-file-excel-o fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Pembatalan Dokumen
        </h4>
        <a href="{{ route('kt.upload.page.pembatalan_dokumen') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div> 
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Penyetoran PNBP
      </div>
      <div class="card-body">
        <i class="fa fa-money fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Penyetoran PNBP
        </h4>
        <a href="{{ route('kt.upload.page.report_billing') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div>
</div>

<a href="#" id="showMoreMenu" class="badge badge-pill badge-danger">
 menu lanjutan <i class="fa fa-angle-double-down"></i>
</a>

<hr>

<div class="row mt-4 mb-2">
  <div class="col mb-3">
    <div class="text-center">
      <a href="{{ route('showmenu.operasional.kt') }}" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> Kembali</a>
    </div>
  </div>
</div>

@include('intern.inc.message')

<h4 class="mt-3">Log Pengiriman Laporan Bulanan</h4>

<hr>

<form id="logProperty">
  <div class="row mt-4">
    <div class="col-md-3 mb-2">
      <select name="wilker_id" id="wilker" class="form-control">

        @if(count($wilkers) > 0)

            @if(admin())

            <option value="1">Semua Wilker</option>

            @endif

            @foreach($wilkers as $wilker)

              <option value="{{ $wilker['id'] }}">{{ $wilker['nama_wilker'] }}</option>

            @endforeach
          
        @endif
        
      </select>
    </div>
    <div class="col-md-2 mb-2">
      <select class="form-control" name="year" id="year">
        @for($i = date('Y') - 3; $i < date('Y') + 2 ; $i++)

          @if($i == date('Y'))

          <option value="{{ $i }}" selected>{{ $i }}</option>

          @else

          <option value="{{ $i }}">{{ $i }}</option>

          @endif

        @endfor
      </select>
    </div>
    <div class="col-md-2 mb-2">
      <select class="form-control" name="month" id="month">

        <option value="all">Semua bulan</option>
        
        @for($i = 1; $i < 13 ; $i++)
    
          <option value="{{ $i }}">{{ bulan($i) }}</option>

        @endfor
        
      </select>
    </div>
    <div class="col-md-3 mb-2">
      <select class="form-control" name="type" id="type">
        <option value="all">Semua permohonan</option>
        <option value="domas_kt">Domestik Masuk</option>
        <option value="dokel_kt">Domestik Keluar</option> 
        <option value="ekspor_kt">Ekspor</option> 
        <option value="impor_kt">Impor</option>
        <option value="reekspor_kt">Re Ekspor</option>
        <option value="serah_terima_kt">Serah Terima</option>
        <option value="pembatalan_dok_kt">Pembatalan Dokumen</option> 
        <option value="report_billing_kt">Setor Billing</option>    
      </select>
    </div>
    <div class="col-md-2 text-center">
      <button type="submit" class="btn btn-danger">
        <i class="fa fa-sort"></i> Sortir
      </button>
    </div>
  </div>
</form>

<div class="row mt-2">
  <div class="col-md-12">
    <div class="card" style="border: 1px solid #eee">
      <div class="card-header">
        <b>Log Pengiriman Laporan</b> <span class="info-log"></span>
      </div>
      <div class="card-body">
        <table id="logOperasional" class="table table-responsive table-striped table-bordered text-center w-100 d-block d-md-table">
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

    let wilker  = '{{ admin() ? 1 : $wilker->id }}';

    let year    = '{{ $year }}';

    let month   = $('#month').val();

    let type    = $('#type').val();

    let data = [

      { "data" : "DT_Row_Index", orderable: false, searchable: false},
      { "data" : "type" },
      { "data" : "bulan" },
      { "data" : "wilker.nama_wilker" },
      { "data" : "rolledbackAtStatus"},
      { "data" : "created_at" },
      { "data" : "action" , orderable: false, searchable: false}

    ]

    changeLog(wilker, year, month, type);

    $('#logProperty').on('submit', function(e){

      e.preventDefault();

      year    = $('#year').val();

      month   = $('#month').val();

      wilker  = $('#wilker').val();

      type    = $('#type').val();

      changeLog(wilker, year, month, type);

    });

    function changeLog(wilker, year, month, type){

      let url = `{{ route('api.kt.log_operasional') }}/
                ${year}/${month}/${wilker}/${type}
                `;

      $('#logOperasional').DataTable().destroy();

      $('.info-log').html(`
 
        <b>Tahun : ${year}, 
        Bulan : ${month == 'all' ? 'Semua Bulan' : '0' + month},
        Permohonan : ${type == 'all' ? 'Semua Permohonan' : type}</b>

      `);

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

    } 

    $(document).on('click', '#rollbackOperasionalBtn', function(e){

      e.preventDefault();

      let id = $( this ).data( 'id' );

      $('#modalRollbackOperasional').modal('show');

      $("#modalRollbackOperasional #typeId").val(id);

    });  

    $('#advancedMenu .col-md-3').hide();

    $('#showMoreMenu').click(function(e){

      e.preventDefault();

      $('#advancedMenu .col-md-3').slideToggle();

    });

  }); /*End Ready*/

</script>

@endsection