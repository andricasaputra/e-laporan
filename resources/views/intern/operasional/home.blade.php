@extends('intern.layouts.app')

@section('title', 'E-Operasional - Ringkasan Data')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Dashboard</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ringkasan Data</li>
        </ol>
    </nav>
</div>

@endsection

@section('content')

<style type="text/css">

</style>

<style type="text/css">
  table td{
    font-size: 12pt;
    font-weight: 600;
  }

  table th, table td:not(:nth-of-type(1)){
    text-align: center;
  }

  i.fa-bar-chart, i.fa-line-chart, i.fa-money, i.fa-book {
    display: inline-block;
    border-radius: 80px;
    box-shadow: 0px 0px 2px #888;
    padding: 0.5em 0.6em;
  }

  .fa-bar-chart{
    background-color: #f73b5e;
    color: #fff
  }

  .fa-line-chart{
    background-color: #2962FF;
    color: #fff;
  }

  .fa-money{
    background-color: #FF8F29;
    color: #fff;
  }

  .fa-book{
    background-color: #12AFAF;
    color: #fff;
  }
</style>

@php 

use App\Http\Controllers\TanggalController as Tanggal; 

@endphp

    <h4 id="judul"></h4>

    <form id="change_data" class="form-loader">
      <div class="row mb-3">
        <div class="col-md-4 col-sm-12">
          <label for="year">Pilih Tahun</label>
          <select class="form-control" name="year" id="year">
            @for($i = date('Y') - 5; $i < date('Y') + 2 ; $i++)
      
              @if(date('Y') == $i)

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
            <option value="all">Semua Bulan</option>
            @for($i = 1; $i < 13 ; $i++)

              <option value="{{ $i }}">{{  Tanggal::bulan($i) }}</option>

            @endfor
            
          </select>
        </div>

        <div class="col-md-4 col-sm-12">
          <label for="wilker">Pilih Wilker</label>
          <select class="form-control" name="wilker" id="wilker">

            <option value="">Semua Wilker</option>

            @foreach($wilkers as $wilker)


            <option value="{{ $wilker->id }}">{{ $wilker->nama_wilker }}</option>

              
            @endforeach

          </select>
        </div>

      </div>

      <div class="row" style="text-align: left;">
        <div class="col-md-4 col-sm-12 mt-3">
         <button type="submit" class="btn btn-danger">Pilih</button>
        </div>
      </div>
    </form>

    <hr>

    <div class="row mt-3">
      <!-- column -->   
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table v-middle" id="table-dashboard">
                        <thead>
                            <tr class="bg-light">
                                <th class="border-top-0">Data</th>
                                <th class="border-top-0">Karantina Hewan</th>
                                <th class="border-top-0">Karantina Tumbuhan</th>
                                <th class="border-top-0">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <label for="frekKh">Pilih Jenis Permohonan</label>
        <select name="frekKh" id="selectCatKh" class="form-control">
          <option value="Domestik Keluar Karantina Hewan">Domestik Keluar</option>
          <option value="Domestik Masuk Karantina Hewan">Domestik Masuk</option>
          <option value="Ekspor Karantina Hewan">Ekspor</option>
          <option value="Impor Karantina Hewan">Impor</option>
        </select>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-8">
          <div class="card">
              <div class="card-body" id="chartFrekuensiKh"></div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="card">
              <div class="card-body">
                  <h4 class="card-title"><i class="fa fa-history" aria-hidden="true"></i> &nbsp;&nbsp;Top 5 Komoditi Karantina Hewan  </h4>
                  <h6>Berdasarkan Frekuensi</h6>
                  <div class="feed-widget">
                      <ul class="list-style-none feed-body m-0 p-b-20" id="topFiveKh"></ul>
                  </div>
              </div>
          </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <label for="frekKt">Pilih Jenis Permohonan</label>
        <select name="frekKt" id="selectCatKt" class="form-control">
          <option value="Domestik Keluar Karantina Tumbuhan">Domestik Keluar</option>
          <option value="Domestik Masuk Karantina Tumbuhan">Domestik Masuk</option>
          <option value="Ekspor Karantina Tumbuhan">Ekspor</option>
          <option value="Impor Karantina Tumbuhan">Impor</option>
        </select>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-8">
        <div class="card">
            <div class="card-body" id="chartFrekuensiKt"></div>
        </div>
      </div>
      <div class="col-md-4">
          <div class="card">
              <div class="card-body">
                  <h4 class="card-title"><i class="fa fa-history" aria-hidden="true"></i> &nbsp;&nbsp;Top 5 Komoditi Karantina Tumbuhan  </h4>
                  <h6>Berdasarkan Frekuensi</h6>
                  <div class="feed-widget">
                      <ul class="list-style-none feed-body m-0 p-b-20" id="topFiveKt"></ul>
                  </div>
              </div>
          </div>
      </div>
    </div>

@endsection

@section('script')

<script src="{{ asset('js/highcharts.js') }}"></script>

@include('intern.operasional.script_minify')

@endsection