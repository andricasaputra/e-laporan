@extends('intern.layouts.app')

@section('title', 'Home Operasional - Halaman Utama')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Rekapitulasi Data Operasional Karantina Hewan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kh') }}">Menu Utama</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('showmenu.data.operasional.kh') }}">Menu Data Operasional Karantina Hewan</a></li>
            <li class="breadcrumb-item" aria-current="page">Rekapitulasi Komoditi</li>
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

@php use App\Http\Controllers\TanggalController as Tanggal; @endphp

<div class="container-fluid">

  <div class="col">

      @if($datas['bulan'] !== null)
      <h3>
          Rekapitulasi Data Operasional Karantina Hewan Bulan 
          {{ Tanggal::bulan($datas['bulan']) }} Tahun {{ $datas['tahun'] }}
          {{ $datas['wilker'] }}
        </h3>
      @else
        <h3>Rekapitulasi Data Operasional Karantina Hewan Tahun {{ $datas['tahun'] }}</h3>
      @endif

      <form id="change_data_rekapitulasi">
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
              <option value="all">Semua</option>
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

          <div class="col-md-4 col-sm-12 mt-3">
           <button type="submit" class="btn btn-danger">Pilih</button>
          </div>

        </div>
      </form>

      @include('intern.operasional.kh.data.rekapitulasi.domas_rekapitulasi')
      @include('intern.operasional.kh.data.rekapitulasi.dokel_rekapitulasi')
      @include('intern.operasional.kh.data.rekapitulasi.ekspor_rekapitulasi')
      @include('intern.operasional.kh.data.rekapitulasi.impor_rekapitulasi')

      <div class="row">
        <div class="col">
          <div class="text-center">
            <a href="{{ route('showmenu.data.operasional.kh') }}" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Kembali</a>
          </div>
        </div>
      </div>

    
  </div>

</div> {{-- end container --}}

@endsection

@section('script')

  @include('intern.operasional.kh.data.rekapitulasi.script')

@endsection