@extends('intern.layouts.app')

@section('title', 'Home Operasional - Halaman Utama')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Statistik Data Operasional Karantina Hewan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kh') }}">Menu Utama</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.data.operasional.kh') }}">Menu Data Operasional Karantina Hewan</a></li>
            <li class="breadcrumb-item" aria-current="page">Statistik Data Operasional Karantina Hewan</li>
        </ol>
    </nav>
</div>

@endsection
@section('content')

<style type="text/css">
  .card {
    width: 100%;
    margin-bottom: 5%;
  }

  table tr th, table tr td:not(:nth-child(1)) {
    text-align: center;
  }
</style>

@php use App\Http\Controllers\TanggalController as Tanggal; @endphp

<div class="container-fluid">

  <div class="col">
    
    @if($datas['bulan'] !== null)
      <h3>
        Statistik Data Operasional Karantina Hewan Bulan 
        {{ Tanggal::bulan($datas['bulan']) }} Tahun {{ $datas['tahun'] }}
        {{ $datas['wilker'] }}
      </h3>
    @else
      <h3>Statistik Data Operasional Karantina Hewan Tahun {{ $datas['tahun'] }}</h3>
    @endif

    <form id="change_data">
      <div class="row mb-3">
        <div class="col-md-4 col-sm-12">
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

        <div class="col-md-4 col-sm-12">
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

        <div class="col-md-4 col-sm-12">
          <label for="wilker">Pilih Wilker</label>
          <select class="form-control" name="wilker" id="wilker">

            <option value="">Semua</option>

            @foreach($wilkers as $wilker)

              @if(isset($datas['wilker']) && $datas['wilker'] == $wilker->nama_wilker)

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

    <h3>Frekuensi <i class="fa fa-bar-chart" aria-hidden="true"></i></h3>

    <hr>

    <div class="row">
      @foreach($datas['dataKh']['frekuensiPerKegiatan'] as $key => $data)
        <div class="col-sm-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="row">
                <div class="col-sm-12 card_body_welcome" style="min-height: 150px">
                    <h4 class="card-title">{{ $key }}</h4>
                    <hr>
                    <small><i>Berdasarkan Sertifikasi</i></small>
                    <h5 class="card-text mt-2"><i>Frekuensi : {{ $data['frekuensi'] }}</i></h5>
                </div>
              </div>
              <a href="{{ $data['link'] }}" class="btn btn-primary"><i class="fa fa-info-circle" aria-hidden="true"></i>  Detail</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <h3>Volume <i class="fa fa-area-chart" aria-hidden="true"></i></h3>

    <hr>

    <div class="row">
      @foreach($datas['dataKh']['totalVolumeBySatuan'] as $key => $data)
        <div class="col-sm-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="row">
                <div class="col-sm-12 card_body_welcome" style="min-height: 150px">
                    <h4 class="card-title">{{ $key }}</h4>
                    <hr>
                    <small><i>Berdasarkan Satuan</i></small>
                    @if(count($data['volume']) > 0)
                      @foreach($data['volume'] as $k => $volume)
                      <h5 class="card-text mt-2">
                        <i> Volume :  {{ $volume->sum('volume') }} {{ ucfirst($k) }}</i>
                      </h5>
                      @endforeach
                    @else
                      <h5 class="card-text mt-2">
                        <i> Volume :  0</i>
                      </h5>
                    @endif
                </div>
              </div>
              <a href="{{ $data['link'] }}" class="btn btn-default"><i class="fa fa-info-circle" aria-hidden="true"></i>  Detail</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <h3>PNBP <i class="fa fa-money" aria-hidden="true"></i></h3>

    <hr>

    <div class="row">
      @foreach($datas['dataKh']['totalPNBP'] as $key => $data)
        <div class="col-sm-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="row">
                <div class="col-sm-12 card_body_welcome" style="min-height: 150px">
                    <h4 class="card-title">{{ $key }}</h4>
                    <hr>
                    <small><i>Berdasarkan Jenis Permohonan</i></small>
                      <h5 class="card-text mt-2">
                        <i>PNBP :  {{ $data['pnbp'] }}</i>
                      </h5>
                </div>
              </div>
              <a href="{{ $data['link'] }}" class="btn btn-warning" style="color: #000"><i class="fa fa-info-circle" aria-hidden="true"></i>  Detail</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <h3>Pemakaian Dokumen <i class="fa fa-book" aria-hidden="true"></i></h3>

    <hr>

    <div class="row">
      @foreach($datas['dataKh']['Dokumen'] as $key => $data)
        <div class="col-sm-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="row">
                <div class="col-sm-12 card_body_welcome" style="min-height: 150px">
                    <h4 class="card-title">{{ $key }}</h4>
                    <hr>
                    <small><i>Berdasarkan Frekuensi</i></small>
                    @if(count($data['dokumen']) > 0)
                      @foreach($data['dokumen'] as $dokumen)
                        <h5 class="card-text mt-2">
                          <i> {{ $dokumen['dokumen'] }} :  {{ $dokumen['total'] }} Dokumen</i>
                        </h5>
                      @endforeach
                    @else
                      <h5 class="card-text mt-2">
                        <i>0 Dokumen</i>
                      </h5>
                    @endif
                </div>
              </div>
              <a href="{{ $data['link'] }}" class="btn btn-success"><i class="fa fa-info-circle" aria-hidden="true"></i>  Detail</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="row">
      <div class="col">
        <div class="text-center">
          <a href="{{ route('showmenu.data.operasional.kh') }}" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> Kembali</a>
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

        window.location = '{{ route('show.statistik.operasional.kh') }}/' + year;

      } else if(year != '' && month != '' && wilker == '') {

        window.location = '{{ route('show.statistik.operasional.kh') }}/' + year + '/' + month;

      } else {

        window.location = '{{ route('show.statistik.operasional.kh') }}/' + year + '/' + month + '/' + wilker;

      }

    });

  });
</script>

@endsection