@extends('intern.layouts.app')

@section('title', 'Home Operasional - Halaman Utama')

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
            <form action="{{ route('post.tahun.operasional.kh') }}" method="POST">
              @csrf
              <div class="form-group">
                <label>Tahun</label>
                <select class="form-control" name="year">
                  @for($i = date('Y') - 3; $i < date('Y') + 2 ; $i++)
              
                    @if($i == $datas['tahun'])

                      <option value="{{ $i }}" selected>{{ $i }}</option>

                    @else

                      <option value="{{ $i }}">{{ $i }}</option>

                    @endif

                  @endfor
                </select>
              </div>
              <button type="submit">Pilih</button>
            </form>
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