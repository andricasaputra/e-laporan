@extends('intern.layouts.app')

@section('title', 'Home Operasional - Halaman Utama')

@section('content')

<style type="text/css">
  .card {
    width: 100%;
    margin-bottom: 5%;
  }
</style>

<?php use App\Http\Controllers\TanggalController as Tanggal; ?>

<main class="content-wrapper">
    <div class="mdc-layout-grid">
      <div class="mdc-layout-grid__inner">
        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
          <div class="mdc-card">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-7">
                <section class="purchase__card_section">
                  @if($datas['bulan'] !== null)
                     Data Operasional Bulan {{ Tanggal::bulan($datas['bulan']) }} Tahun {{ $datas['tahun'] }}
                  @else
                    Data Operasional Tahun {{ $datas['tahun'] }}
                  @endif
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">

      <div class="col">

        <form id="change_data">
          <div class="row mb-3">
            <div class="col-md-12">
              <div class="row">

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Tahun</label>
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
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Bulan</label>
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
                </div>

                <div class="col-md-4" style="margin-top: 2.5%">
                  <button type="submit" class="btn btn-primary">Pilih</button>
                </div>
                
              </div>
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
                        <a href="{{ $data['link'] }}" class="btn btn-default btn-xs">Detail</a>
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
                        <a href="{{ $data['link'] }}" class="btn btn-success btn-xs">Detail</a>
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
        
      </div>

    </div> {{-- end container --}}

</main>

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