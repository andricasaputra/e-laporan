@extends('intern.layouts.app')

@section('title', 'Data Penugasan KT')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Data Penugasan Karantina Tumbuhan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kt') }}">Menu Utama</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('showmenu.data.operasional.kt') }}">Menu Penugasan Karantina Tumbuhan</a></li>
            <li class="breadcrumb-item" aria-current="page">Data Penugasan</li>
        </ol>
    </nav>
</div>

@endsection

@section('content') 

<style>
   table tr th, table tr td:not(:nth-of-type(1)){
    text-align: center;
  }

  table tr td{
    font-size: 11pt;
    font-weight: bold;
  }

  table tr.active{
    background-color:#eee;
  }
</style>

@if($datas['month'] !== null)

  <h4>
    Data Penugasan Karantina Tumbuhan 
    {{ $datas['month'] == 'all' 
        ? '' 
        : 'Bulan ' . bulan($datas['month']) }} 
    Tahun {{ $datas['year'] }}
    {{ $datas['wilker'] === null ? 'Semua Wilker' : $datas['wilker']->getOriginal('nama_wilker') }}
  </h4>

@else

  <h4>Data Penugasan Karantina Tumbuhan Tahun {{ $datas['year'] }}</h4>
  
@endif

<form id="change_data_penugasan">
  <div class="row mb-3">
    <div class="col-md-4 col-sm-12">
      <label for="year">Pilih Tahun</label>
      <select class="form-control" name="year" id="year">
        @for($i = date('Y') - 5; $i < date('Y') + 2 ; $i++)
    
          @if($i == $datas['year'])

            <option value="{{ $i }}" selected>{{ $i }}</option>

          @else

            <option value="{{ date('Y') }}">{{ date('Y') }}</option>

          @endif

        @endfor
      </select>
    </div>

    <div class="col-md-4 col-sm-12">
      <label for="month">Pilih Bulan</label>
      <select class="form-control" name="month" id="month">
        <option value="all">Semua Bulan</option>

        <option value="{{ date('m') - 1 }}" selected>Bulan Lalu</option>
        
        @for($i = 1; $i < 13 ; $i++)
    
          @if($i == $datas['month'])

            <option value="{{ $i }}" selected>{{ bulan($i) }}</option>

          @else

            <option value="{{ $i }}">{{ bulan($i) }}</option>

          @endif

        @endfor
        
      </select>
    </div>

    <div class="col-md-4 col-sm-12">
      <label for="wilker">Pilih Wilker</label>
      <select class="form-control" name="wilker" id="wilker">

        @if(admin())
          <option value="" selected>Semua</option>
        @endif

        @foreach($userWilker as $wilker)

         <option value="{{ $wilker->id }}">{{ $wilker->getOriginal('nama_wilker') }}</option>
          
        @endforeach

      </select>
    </div>

    <div class="col-md-4 col-sm-12 mt-3">
     <button type="submit" class="btn btn-danger">Pilih</button>
    </div>

  </div>
</form>

@include('intern.penugasan.kt.data.dokel')

<div class="row">
  <div class="col">
    <div class="text-center">
      <a href="{{ route('showmenu.data.operasional.kt') }}" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Kembali</a>
    </div>
  </div>
</div>

@endsection

@section('script')

 <script>

  let year = $('#year').val();

    let month = $('#month').val();

    let wilker = $('#wilker').val();

    $('#change_data_penugasan').on('submit', function(e){

      e.preventDefault();

      year = $('#year').val();

      month = $('#month').val();

      wilker = $('#wilker').val();

      window.location = '{{ route('kt.view.penugasan.home') }}/' + year + '/' + month + '/' + wilker;

    });
   
    setDataTable(
      'PenugasanDokelKt', '{{ route('api.kt.dokel.penugasan') }}/' + year + '/' + month + '/' + wilker, year, month, wilker
    );

    function setDataTable(container, url, year, month, wilker){

      let tableId = $('#' + container);

      let table = $('#PenugasanDokelKt').DataTable({

        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax":{
           "url": url
        },
        "columns": [
          { "data" : "bulan" }, 
          { "data" : "no_permohonan" }, 
          { "data" : "no_aju" },
          { "data" : "tanggal_permohonan" }, 
          { "data" : "jenis_permohonan" }, 
          { "data" : "nama_wilker" }, 
          { "data" : "nama_pengirim" }, 
          { "data" : "alamat_pengirim" }, 
          { "data" : "nama_penerima" }, 
          { "data" : "alamat_penerima" }, 
          { "data" : "nama_tercetak" }, 
          { "data" : "nama_latin_tercetak" },
          { "data" : "bentuk_tercetak" }, 
          { "data" : "jumlah_kemasan" }, 
          { "data" : "kota_asal" }, 
          { "data" : "asal" }, 
          { "data" : "kota_tuju" }, 
          { "data" : "tujuan" }, 
          { "data" : "port_asal" }, 
          { "data" : "port_tuju" }, 
          { "data" : "moda_alat_angkut_terakhir" }, 
          { "data" : "tipe_alat_angkut_terakhir" }, 
          { "data" : "nama_alat_angkut_terakhir" }, 
          { "data" : "dok_pelepasan" },
          { "data" : "nomor_dok_pelepasan" }, 
          { "data" : "tanggal_pelepasan" }, 
          { "data" : "no_surat_tugas" }, 
          { "data" : "tgl_surat_tugas" }, 
          { "data" : "deskripsi" },
          { "data" : "petugas" }, 
          { "data" : "dokumen_pendukung" },
          { "data" : "kontainer" }, 
          { "data" : "created_at" }, 
        ],
        "columnDefs": [{
          "defaultContent": "-",
          "targets": "_all"
        }]

      });
    }/*end function*/
 </script>

@endsection