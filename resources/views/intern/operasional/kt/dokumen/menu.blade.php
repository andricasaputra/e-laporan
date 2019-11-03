@extends('intern.layouts.app')

@section('title', 'Menu Operasional KT')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Dokumen Operasional Karantina Tumbuhan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kt') }}">Menu</a></li>
            <li class="breadcrumb-item" aria-current="page">Dokumen</li>
        </ol>
    </nav>
</div>

@endsection

@section('content')

<style type="text/css">

  table > thead > tr > th{
    vertical-align: middle !important;
  }

  i.fa-2x {
    display: inline-block;
    border-radius: 80px;
    box-shadow: 0px 0px 2px #888;
    padding: 0.5em 0.6em;
  }

  .fa-plus-circle{
    background-color: #008000;
    color: #fff;
  }


  .fa-file-excel-o{
    background-color: #F24656;
    color: #fff
  }

  .fa-file-archive-o{
    background-color: #16C2D0;
    color: #fff
  }

  .badge{
    padding: 4px 13px !important;
  }
</style>

<div class="row">
  <div class="col">
    @include('intern.inc.message')
  </div>
</div>

<div class="row">
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Data Dokumen
      </div>
      <div class="card-body">
        <i class="fa fa-plus-circle fa-2x mb-4"></i>
        <h4 class="card-text">
          Lihat Data Dokumen
        </h4>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('kt.dokumen.data') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Permintaan Dokumen
      </div>
      <div class="card-body">
        <i class="fa fa-file-archive-o fa-2x mb-4"></i>
        <h4 class="card-text">
          Penerimaan Dokumen
        </h4>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('kt.dokumen.penerimaan.create') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div> 
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Pembatalan Dokumen
      </div>
      <div class="card-body">
        <i class="fa fa-file-excel-o fa-2x mb-4"></i>
        <h4 class="card-text">
          Pembatalan Dokumen
        </h4>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('kt.upload.page.pembatalan_dokumen') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div> 
</div>

<div class="row">
  <div class="col text-center">
    <a href="{{ route('showmenu.operasional.kt') }}" class="btn btn-danger">
          <i class="fa fa-angle-double-left"></i> Kembali
        </a>
  </div>
</div>

<hr>

<div class="row mb-3">
  <div class="col">
    <form id="change_data">
        <div class="row mb-3">
          <div class="col-md-4 col-sm-12">
            <label for="year">Pilih Tahun</label>
            <select class="form-control" name="year" id="year">

              @for($i = date('Y') - 3; $i < date('Y') + 2 ; $i++)
          
                @if($i == $tahun)

                  <option value="{{ $i }}" selected>{{ $i }}</option>

                @else

                  <option value="{{ $i }}">{{ $i }}</option>

                @endif

              @endfor

            </select>
          </div>

          <div class="col-md-4 col-sm-12">
            <label for="month">Pilih Bulan</label>
            <select class="form-control" name="month" id="month">

              <option value="all">Semua</option>

              @for($i = 1; $i < 13 ; $i++)
          
                @if($i == $bulan)

                  <option value="{{ $i }}" selected>{{ bulan($i) }}</option>

                @else

                  <option value="{{ $i }}">{{  bulan($i) }}</option>

                @endif

              @endfor
              
            </select>
          </div>

          <div class="col-md-4 col-sm-12">
            <label for="wilker">Pilih Wilker</label>
            <select class="form-control" name="wilker" id="wilker">

              <option value="">Semua</option>

              @foreach($wilkers as $wilker)

                @if($userWilker != 1 && $wilker->id == $userWilker)

<<<<<<< HEAD
                <option value="{{ $wilker->id }}" selected>{{ $wilker->getOriginal('nama_wilker') }}</option>

                @else

                <option value="{{ $wilker->id }}">{{ $wilker->getOriginal('nama_wilker') }}</option>
=======
                <option value="{{ $wilker->id }}" selected>{{ $wilker->nama_wilker }}</option>

                @else

                <option value="{{ $wilker->id }}">{{ $wilker->nama_wilker }}</option>
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

                @endif
                
              @endforeach

            </select>

          </div>

          <div class="col-md-4 mt-3">
           <button type="submit" class="btn btn-danger">Pilih</button>
          </div>
        </div>
    </form>
  </div>
</div> 

<h4>Log Penerimaan Dokumen</h4>

<hr>
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header mt-3">
          <b>Penerimaan Dokumen Tahun : {{ $tahun }}</b>
        </div>
        <div class="card-body">
          <table class="table table-responsive table-striped table-bordered text-center w-100 d-block d-md-table" id="penerimaan">
            <thead>
              <tr>
                <th width="30">No</th>
                <th width="250">Wilker</th>
                <th width="50">Nama Dokumen</th>
                <th width="150">Deskripsi Dokumen</th>
                <th width="50">Jumlah Penerimaan (set)</th>
                <th width="100">No Seri</th>
                <th width="50">Tanggal Penerimaan</th>
                <th width="50">Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')

<script>

  $(document).ready(function(){

    let year = $('#year').val();

    let month = $('#month').val();

    let wilker = $('#wilker').val();

    /*set table data parameters (container, url)*/
    logPenerimaan(
      '#penerimaan', '{{ route('api.kt.dokumen.penerimaan') }}/' + year + '/' + month + '/' + wilker
    );

    $('#change_data').on('submit', function(e){

      e.preventDefault();

      year = $('#year').val();

      month = $('#month').val();

      wilker = $('#wilker').val();

      /*set table data parameters (container, url)*/
      logPenerimaan(
        '#penerimaan', '{{ route('api.kt.dokumen.penerimaan') }}/' + year + '/' + month + '/' + wilker
      );

    });

    function logPenerimaan(container, url){

      let tableId = $(container);

      $(tableId).DataTable().destroy();

      let table = $(tableId).DataTable({

        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax":{
          "url": url
        },
        "columns": [
          { "data" : "DT_Row_Index" },
<<<<<<< HEAD
          { "data" : "wilker.original_nama_wilker" },
=======
          { "data" : "wilker.nama_wilker" },
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
          { "data" : "dokumen.dokumen" },
          { "data" : "dokumen.deskripsi" },
          { "data" : "jumlah" },
          { "data" : "no_seri" },
          { "data" : "tanggal" },
          { "data" : "action", orderable: false, searchable: false},
        ]

      });
    }/*end function*/

  });/*End Ready*/

</script>

@endsection