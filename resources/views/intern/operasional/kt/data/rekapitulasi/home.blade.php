@extends('intern.layouts.app')

@section('title', 'Rekapitulasi Komoditi KT')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Rekapitulasi Data Operasional Karantina Tumbuhan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kt') }}">Menu Utama</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('showmenu.data.operasional.kt') }}">Menu Data Operasional Karantina Tumbuhan</a></li>
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

@if($datas['bulan'] !== null)

  <h4>
    Rekapitulasi Data Operasional Karantina Tumbuhan 
    {{ $datas['bulan'] == 'all' 
        ? '' 
        : 'Bulan ' . bulan($datas['bulan']) }} 
    Tahun {{ $datas['tahun'] }}
    {{ $datas['wilker'] === null ? 'Semua Wilker' : $datas['wilker']->getOriginal('nama_wilker') }}
  </h4>

@else

  <h4>Rekapitulasi Data Operasional Karantina Tumbuhan Tahun {{ $datas['tahun'] }}</h4>
  
@endif

<form id="change_data_rekapitulasi_kt">
  <div class="row mb-3">
    <div class="col-md-4 col-sm-12">
      <label for="year">Pilih Tahun</label>
      <select class="form-control" name="year" id="year">
        @for($i = date('Y') - 5; $i < date('Y') + 2 ; $i++)
    
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
        <option value="all">Semua Bulan</option>
        
        @for($i = 1; $i < 13 ; $i++)
    
          @if($i == $datas['bulan'])

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

        <option value="">Semua</option>

        @foreach($wilkers as $wilker)

          @if(isset($datas['wilker']) && $datas['wilker']->getOriginal('nama_wilker') == $wilker->getOriginal('nama_wilker'))

          <option value="{{ $wilker->id }}" selected>{{ $wilker->getOriginal('nama_wilker') }}</option>

          @else

          <option value="{{ $wilker->id }}">{{ $wilker->getOriginal('nama_wilker') }}</option>

          @endif
          
        @endforeach

      </select>
    </div>

    <div class="col-md-4 col-sm-12 mt-3">
     <button type="submit" class="btn btn-danger">Pilih</button>
    </div>

  </div>
</form>

@include('intern.operasional.kt.data.rekapitulasi.domas_rekapitulasi')
@include('intern.operasional.kt.data.rekapitulasi.dokel_rekapitulasi')
@include('intern.operasional.kt.data.rekapitulasi.ekspor_rekapitulasi')
@include('intern.operasional.kt.data.rekapitulasi.impor_rekapitulasi')

<div class="row">
  <div class="col">
    <div class="text-center">
      <a href="{{ route('showmenu.data.operasional.kt') }}" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Kembali</a>
    </div>
  </div>
</div>

@endsection

@section('script')

  @include('intern.operasional.kt.data.rekapitulasi.script')

@endsection