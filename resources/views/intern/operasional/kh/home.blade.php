@extends('intern.layouts.app')

@section('title', 'Home Operasional - Halaman Utama')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Data Operasional Karantina Hewan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kh') }}">Menu</a></li>
            <li class="breadcrumb-item" aria-current="page">Data Operasional Karantina Hewan</li>
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
</style>

<main class="content-wrapper">
    <div class="mdc-layout-grid">
      <div class="mdc-layout-grid__inner">
        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
          <div class="mdc-card">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-7">
                <section class="purchase__card_section">
                    Data Operasional Tahun {{ $datas['tahun'] }}
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">

      <div class="col">
        
        <div class="row mb-3">
          <div class="col-md-2 col-sm-12">
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
        </div>

        <div class="row">
          @foreach($datas['kh'] as $key => $data)
            <div class="col-sm-3">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 card_body_welcome">
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
        
      </div>

    </div> {{-- end container --}}

</main>

@endsection

@section('script')

<script>
  $(document).ready(function(){

    $('#year').on('change', function() {

      let year = $(this).val();

      window.location = '{{ route('show.operasional.kh') }}/' + year;

    });

  });
</script>

@endsection