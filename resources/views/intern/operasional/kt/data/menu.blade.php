@extends('intern.layouts.app')

@section('title', 'Menu Data Operasional kt')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Menu Data Operasional Karantina Tumbuhan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('showmenu.operasional.kt') }}"> Menu </a></li>
            <li class="breadcrumb-item" aria-current="page">Menu Data Operasional</li>
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

  .fa-bar-chart{
    background-color: #008000;
    color: #fff;
  }

  .fa-book{
    background-color: #115E8C;
    color: #fff
  }

  .fa-line-chart{
    background-color: #FF8F29;
    color: #fff
  }
  
</style>

<div class="row">
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Rekapitulasi Operasional
      </div>
      <div class="card-body">
        <i class="fa fa-book fa-2x mb-4"></i>
        <h4 class="card-text">
          Rekapitulasi Data Operasional
        </h4>
        <p>Karantina Tumbuhan</p>  
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('show.rekapitulasi.operasional.kt') }}" class="btn btn-primary">Detail</a>
      </div>
    </div>
  </div>  
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Statistik Data Operasional
      </div>
      <div class="card-body">
        <i class="fa fa-line-chart fa-2x mb-4"></i>
        <h4 class="card-text">
          Statistik
        </h4>
        <p>Karantina Tumbuhan</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('show.statistik.operasional.kt') }}" class="btn btn-primary">Detail</a>
      </div>
    </div>
  </div> 
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Grafik Data Operasional
      </div>
      <div class="card-body">
        <i class="fa fa-bar-chart fa-2x mb-4"></i>
        <h4 class="card-text">
          Grafik
        </h4>
        <p>Karantina Tumbuhan</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="#" class="btn btn-primary">Detail</a>
      </div>
    </div>
  </div> 
</div>

<div class="row">
  <div class="col">
    <div class="text-center">
      <a href="{{ route('showmenu.operasional.kt') }}" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> Kembali</a>
    </div>
  </div>
</div>

@endsection