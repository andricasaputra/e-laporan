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
            <li class="breadcrumb-item" aria-current="page">Menu</li>
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

</style>

<div class="row">
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Detail Data, Statistik Dan Grafik!
      </div>
      <div class="card-body">
        <i class="fa fa-expand fa-2x mb-4"></i>
        <h4 class="card-text">
          Data Operasional
        </h4>
        <p>Karantina Tumbuhan</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('showmenu.data.operasional.kt') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div>  
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Operasional Bulanan!
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
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Download Laporan Operasional!
      </div>
      <div class="card-body">
        <i class="fa fa-download fa-2x mb-4"></i>
        <h4 class="card-text">
          Donwload Laporan Operasional
        </h4>
        <p>Karantina Tumbuhan</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('kt.homedownload') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div> 
</div>

@endsection