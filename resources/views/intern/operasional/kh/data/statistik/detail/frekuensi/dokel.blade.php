@extends('intern.layouts.app')

@section('title','Operasional - Data Domestik Keluar')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('content')

@section('page-breadcrumb')

<h4 class="page-title">Detail Operasional Domestik Keluar Karantina Hewan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kh') }}">Menu Utama</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.data.operasional.kh') }}">Menu Data Operasional Karantina Hewan</a></li>
            <li class="breadcrumb-item" aria-current="page">Detail Operasional</li>
        </ol>
    </nav>
</div>

@endsection

<style type="text/css">
 table th, table tbody, table td{
    text-align: center !important;
  }
  table td:not(:first-of-type){
	min-width: 150px !important;
  }
</style>

@php 

use App\Http\Controllers\TanggalController as Tanggal; 

use App\Http\Controllers\RupiahController as Rupiah;

@endphp

<main class="content-wrapper">
  <div class="container-fluid">
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

                <option value="{{ $i }}" selected>{{ Tanggal::bulan($i) }}</option>

              @else

                <option value="{{ $i }}">{{  Tanggal::bulan($i) }}</option>

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

              <option value="{{ $wilker->id }}" selected>{{ $wilker->nama_wilker }}</option>

              @else

              <option value="{{ $wilker->id }}">{{ $wilker->nama_wilker }}</option>

              @endif
              
            @endforeach

          </select>
        </div>

        <div class="col-md-4 mt-3">
         <button type="submit" class="btn btn-danger">Pilih</button>
        </div>
      </div>
    </form>
    <div class="row">
      <div class="col-md-12 card">
        @include('intern.inc.message')
        <div class="card-header">
          Data Domestik Keluar Karantina Hewan Tahun <span id="yearSelect">{{ $tahun }}</span>
        </div>
        <div class="card-body">
           <table class="table table-responsive table-bordered w-100 d-block d-md-table" id="dokelkh">
            <thead>
              @foreach($titles as $title)
                <th>{{ ucwords(str_replace('_', ' ', $title)) }}</th>
              @endforeach
            </thead>
         </table>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <a href="{{ route('show.statistik.operasional.kh') }}" class="btn btn-primary"><i class="fa fa-angle-double-left"></i> kembali</a>
      </div>
    </div>
  </div>
</main>

@endsection

@section('script')

  <script>
    $(document).ready(function() {

      let container = $('#dokelkh');

      datatablesOperasional(
        container, 
        '{{ route('api.kh.detail.frekuensi.dokel', [$tahun, 'all', $userWilker === 1 ? null : $userWilker]) }}', 
        'kh'
      );

      $('#change_data').on('submit', function(e){

        e.preventDefault();

        let year = $('#year').val();

        let month = $('#month').val();

        let wilker = $('#wilker').val();

        container.DataTable().destroy();

        $('#yearSelect').html(`${year}`);

        if (year != '' && month == '' && wilker == '') {

          datatablesOperasional(container, 
            '{{ route('api.kh.detail.frekuensi.dokel') }}/' + year, 
          'kh');

        } else if(year != '' && month != '' && wilker == '') {

          datatablesOperasional(container, 
            '{{ route('api.kh.detail.frekuensi.dokel') }}/' + year + '/' + month, 
          'kh');

        } else {

          datatablesOperasional(container, 
            '{{ route('api.kh.detail.frekuensi.dokel') }}/' + year + '/' + month + '/' + wilker, 
          'kh');

        }

      });

    });
  </script>

@endsection