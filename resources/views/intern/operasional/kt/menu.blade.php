@extends('intern.layouts.app')

@section('title', 'Menu Operasional KT')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Menu Operasional Karantina Tumbuhan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Menu Karantina Tumbuhan</li>
        </ol>
    </nav>
</div>

@endsection

@section('content')

<style type="text/css">

  i.fa-2x {
    display: inline-block;
    border-radius: 80px;
    box-shadow: 0px 0px 2px #888;
    padding: 0.5em 0.6em;
  }

  .fa-expand{
    background-color: #008000;
    color: #fff;
  }

  .fa-upload{
    background-color: #2962FF;
    color: #fff
  }

  .fa-download{
    background-color: #F24656;
    color: #fff
  }

  .fa-file{
    background-color: #16C2D0;
    color: #fff
  }

  .card{
    min-height: 300px ;
  }

</style>

<div class="row">
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Detail Rekapitulasi, Statistik Dan Grafik!
      </div>
      <div class="card-body">
        <i class="fa fa-expand fa-2x mb-4"></i>
        <h4 class="card-text">
          Lihat Data Operasional
        </h4>
        <p>Karantina Tumbuhan</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('showmenu.data.operasional.kt') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div>  
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Operasional!
      </div>
      <div class="card-body">
        <i class="fa fa-upload fa-2x mb-4"></i>
        <h4 class="card-text">
          Upload Laporan Operasional
        </h4>
        <p>Karantina Tumbuhan</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('kt.homeupload') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div> 
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Download Laporan Operasional!
      </div>
      <div class="card-body">
        <i class="fa fa-download fa-2x mb-4"></i>
        <h4 class="card-text">
          Download Laporan Operasional
        </h4>
        <p>Karantina Tumbuhan</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('kt.homedownload') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div> 
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
       Data & Penerimaan Dokumen Operasional!
      </div>
      <div class="card-body">
        <i class="fa fa-file fa-2x mb-4"></i>
        <h4 class="card-text">
          Dokumen Operasional
        </h4>
        <p>Karantina Tumbuhan</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('kt.dokumen.index') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div> 
</div>

@endsection