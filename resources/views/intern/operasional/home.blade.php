@extends('intern.layouts.app')

@section('title', 'Home Operasional - Halaman Utama')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Ringkasan Data</h4>
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
  .card-title{
    color: #7460EE;
    font-weight: bold;
  }

  small{
    color: #F20A34;
  }

  .card-body{
    text-align: center;
  }
  .card {
    width: 100%;
    margin-bottom: 5%;
    border: 1px solid #eaeaea;
  }
</style>

@php 

use App\Http\Controllers\TanggalController as Tanggal; 

use App\Http\Controllers\RupiahController as Rupiah;

@endphp

    @if($dataKh['bulan'] !== null)
      <h3>
        Ringkasan Data Operasional 
        {{ Tanggal::bulan($dataKh['bulan']) }} Tahun {{ $dataKh['tahun'] }}
        {{ $dataKh['wilker'] }}
      </h3>
    @else
      <h3>Ringkasan Data Operasional Tahun {{ $dataKh['tahun'] }}</h3>
    @endif

    <form id="change_data">
      <div class="row mb-3">
        <div class="col-md-4 col-sm-12">
          <label for="year">Pilih Tahun</label>
          <select class="form-control" name="year" id="year">
            @for($i = date('Y') - 3; $i < date('Y') + 2 ; $i++)
        
              @if($i == $dataKh['tahun'])

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
            <option value="">Semua</option>
            @for($i = 1; $i < 13 ; $i++)
        
              @if($i == $dataKh['bulan'])

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

              @if(isset($dataKh['wilker']) && $dataKh['wilker'] == $wilker->nama_wilker)

              <option value="{{ $wilker->id }}" selected>{{ $wilker->nama_wilker }}</option>

              @else

              <option value="{{ $wilker->id }}">{{ $wilker->nama_wilker }}</option>

              @endif
              
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

    <h3 class="mt-5 text-center">Frekuensi <i class="fa fa-bar-chart" aria-hidden="true"></i></h3>

    <hr>

    <div class="row">
      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 card_body">
                  <h4 class="card-title">Operasional Karantina Hewan</h4>
                  <hr>
                  <small><i>Berdasarkan Sertifikasi</i></small>
                  <h1 class="mt-4">{{ collect($dataKh['dataKh']['frekuensiPerKegiatan'])->sum('frekuensi') }}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 card_body">
                  <h4 class="card-title">Operasional Karantina Tumbuhan</h4>
                  <hr>
                  <small><i>Berdasarkan Sertifikasi</i></small>
                  <h1 class="mt-4">{{ collect($dataKt['dataKt']['frekuensiPerKegiatan'])->sum('frekuensi') }}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 card_body">
                  <h4 class="card-title">Frekuensi Keseluruhan</h4>
                  <hr>
                  <small><i>Berdasarkan Sertifikasi</i></small>
                  <h1 class="mt-4">
                    {{ 
                      collect($dataKh['dataKh']['frekuensiPerKegiatan'])->sum('frekuensi')  +
                      collect($dataKt['dataKt']['frekuensiPerKegiatan'])->sum('frekuensi')
                    }}
                  </h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <h3 class="text-center">PNBP <i class="fa fa-money" aria-hidden="true"></i></h3>

    <hr>

    <div class="row">
      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 card_body">
                  <h4 class="card-title">PNBP Kegiatan Karantina Hewan</h4>
                  <hr>
                  <small><i>Berdasarkan Sertifikasi</i></small>
                  <h4 class="mt-4">{{ Rupiah::rp(collect($dataKh['dataKh']['totalPNBP'])->sum('pnbp')) }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 card_body">
                  <h4 class="card-title">PNBP Kegiatan Karantina Tumbuhan</h4>
                  <hr>
                  <small><i>Berdasarkan Sertifikasi</i></small>
                  <h4 class="mt-4">{{ Rupiah::rp(collect($dataKt['dataKt']['totalPNBP'])->sum('pnbp')) }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 card_body">
                  <h4 class="card-title">PNBP Keseluruhan</h4>
                  <hr>
                  <small><i>Berdasarkan Sertifikasi</i></small>
                  <h4 class="mt-4">
                    {{ 
                      Rupiah::rp(collect($dataKh['dataKh']['totalPNBP'])->sum('pnbp')  +
                      collect($dataKt['dataKt']['totalPNBP'])->sum('pnbp'))
                    }}
                  </h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <h3 class="text-center">Volume <i class="fa fa-area-chart" aria-hidden="true"></i></h3>

    <hr>

    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 card_body">
                  <h4 class="card-title">Operasional Karantina Hewan</h4>
                  <hr>
                  <small><i>Berdasarkan Sertifikasi</i></small>

                  @if(count(collect($dataKh['dataKh']['totalVolumeBySatuan'])->flatten(1)->collapse()) > 0)

                    @foreach(collect($dataKh['dataKh']['totalVolumeBySatuan'])->flatten(1)->collapse() as $key => $volume)

                    <h4 class="mt-4">{{ $volume->sum('volume') }} {{ ucfirst($key) }}</h4>

                    @endforeach

                  @else

                    <h4 class="mt-4">0</h4>

                  @endif


              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 card_body">
                  <h4 class="card-title">Operasional Karantina Tumbuhan</h4>
                  <hr>
                  <small><i>Berdasarkan Sertifikasi</i></small>

                  @if(count(collect($dataKt['dataKt']['totalVolumeBySatuan'])->flatten(1)->collapse()) > 0)

                    @foreach(collect($dataKt['dataKt']['totalVolumeBySatuan'])->flatten(1)->collapse() as $key => $volume)

                    <h4 class="mt-4">{{ number_format($volume->sum('volume'),0,",",".") }} {{ ucfirst($key) }}</h4>

                    @endforeach

                  @else

                    <h4 class="mt-4">0</h4>

                  @endif

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <h3 class="text-center">Pemakaian Dokumen <i class="fa fa-book" aria-hidden="true"></i></h3>

    <hr>

    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 card_body">
                  <h4 class="card-title">Pemakaian Dokumen Operasional Karantina Hewan</h4>
                  <hr>
                  <small><i>Berdasarkan Sertifikasi</i></small>
                  @if(count(collect($dataKh['dataKh']['Dokumen'])->flatten(1)->collapse()) > 0)

                    @foreach(collect($dataKh['dataKh']['Dokumen'])->flatten(1)->collapse() as $key => $dokumen)

                      <h4 class="mt-4">{{ $dokumen->dokumen }} : {{ $dokumen->total }}</h4>

                    @endforeach

                  @else

                    <h4 class="mt-4">0</h4>

                  @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 card_body">
                  <h4 class="card-title">Pemakaian Dokumen Operasional Karantina Tumbuhan</h4>
                  <hr>
                  <small><i>Berdasarkan Sertifikasi</i></small>

                  @if(count(collect($dataKt['dataKt']['Dokumen'])->flatten(1)->collapse()) > 0)

                    @foreach(collect($dataKt['dataKt']['Dokumen'])->flatten(1)->collapse() as $key => $dokumen)

                      <h4 class="mt-4">{{ $dokumen->dokumen }} : {{ $dokumen->total }}</h4>

                    @endforeach

                  @else

                    <h4 class="mt-4">0</h4>

                  @endif

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


@endsection

@section('script')

<script>
  $(document).ready(function(){

    $('#change_data').on('submit', function(e){

      e.preventDefault();

      let year = $('#year').val();

      let month = $('#month').val();

      let wilker = $('#wilker').val();

      if (year != '' && month == '' && wilker == '') {

        window.location = '{{ route('show.operasional') }}/' + year;

      } else if(year != '' && month != '' && wilker == '') {

        window.location = '{{ route('show.operasional') }}/' + year + '/' + month;

      } else {

        window.location = '{{ route('show.operasional') }}/' + year + '/' + month + '/' + wilker;

      }

    });

  });
</script>

@endsection