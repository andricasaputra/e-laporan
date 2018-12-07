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
  .card {
    width: 100%;
    margin-bottom: 5%;
    border: 1px solid #eaeaea;
  }
</style>

@php use App\Http\Controllers\TanggalController as Tanggal; @endphp



    @if($datas['bulan'] !== null)
       <h3>Ringkasan Data Operasional Bulan {{ Tanggal::bulan($datas['bulan']) }} Tahun {{ $datas['tahun'] }}</h3>
    @else
      <h3>Ringkasan Data Operasional Tahun {{ $datas['tahun'] }}</h3>
    @endif

    <form id="change_data">
      <div class="row mb-3">
          <div class="col-6">
            <label for="year">Pilih Tahun</label>
            <select class="form-control" name="year" id="year">
              @for($i = date('Y') - 3; $i < date('Y') + 2 ; $i++)
          
                @if($i == $datas['tahun'])

                  <option value="{{ $i }}" selected>{{ $i }}</option>

                @else

                  <option value="{{ $i }}">{{ $i }}</option>

                @endif

              @endfor
            </select>
          </div>

          <div class="col-6">
            <label for="month">Pilih Bulan</label>
            <select class="form-control" name="month" id="month">
              <option value="">Semua</option>
              @for($i = 1; $i < 13 ; $i++)
          
                @if($i == $datas['bulan'])

                  <option value="{{ $i }}" selected>{{ Tanggal::bulan($i) }}</option>

                @else

                  <option value="{{ $i }}">{{  Tanggal::bulan($i) }}</option>

                @endif

              @endfor
              
            </select>
          </div>
          <div class="col-4 mt-3">
             <button type="submit" class="btn btn-danger">Pilih</button>
            </div>
          </div>
    </form>

    <div class="row">
      @foreach($datas['kh'] as $key => $data)
        <div class="col-sm-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 card_body">
                    <h4 class="card-title">{{ $key }}</h4>
                    <small><i>Berdasarkan Sertifikasi</i></small>
                    <h5 class="card-text"><i>Frekuensi : {{ $data['frekuensi'] }}</i></h5>
                    <a href="{{ $data['link'] }}" class="btn btn-primary">Detail</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="row">
      @foreach($datas['kt'] as $key => $data)
        <div class="col-sm-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 card_body_welcome">
                    <h4 class="card-title">{{ $key }}</h4>
                    <small><i>Berdasarkan Sertifikasi</i></small>
                    <h5 class="card-text"><i>Frekuensi : {{ $data['frekuensi'] }}</i></h5>
                    <a href="{{ $data['link'] }}" class="btn btn-success">Detail</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="row">
      @foreach($datas['pnbp'] as $key => $data)
        <div class="col-sm-3">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 card_body_welcome">
                    <h4 class="card-title">{{ $key }}</h4>
                    <small><i>Berdasarkan Sertifikasi</i></small>
                    <h5 class="card-text"><i>Total : {{ $data }}</i></h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>



@endsection

@section('script')

<script>
  $(document).ready(function(){

    $('#change_data').on('submit', function(e){

      e.preventDefault();

      let year = $('#year').val();

      let month = $('#month').val();

      if (year != '' && month == '') {

        window.location = '{{ route('show.operasional') }}/' + year;

      } else {

        window.location = '{{ route('show.operasional') }}/' + year + '/' + month;

      }

    });

  });
</script>

@endsection