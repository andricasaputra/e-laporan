@extends('intern.layouts.app')

@section('title', 'Menu Operasional KT')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Upload Laporan Operasional Karantina Hewan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kh') }}">Menu</a></li>
            <li class="breadcrumb-item" aria-current="page">Upload</li>
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

  .fa-bus{
    background-color: #f73b5e;
    color: #fff
  }

  .fa-truck{
    background-color: #2962FF;
    color: #fff;
  }

  .fa-ship{
    background-color: #FF8F29;
    color: #fff;
  }

  .fa-plane{
    background-color: #12AFAF;
    color: #fff;
  }

</style>

<div class="row">
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Domas
      </div>
      <div class="card-body">
        <i class="fa fa-bus fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Domestik Masuk
        </h4>
        <a href="{{ route('kh.upload.page.domas') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div>  
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Dokel
      </div>
      <div class="card-body">
        <i class="fa fa-truck fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Domestik Keluar
        </h4>
        <a href="{{ route('kh.upload.page.dokel') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div> 
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Ekspor
      </div>
      <div class="card-body">
        <i class="fa fa-ship fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Ekspor
        </h4>
        <a href="{{ route('kh.upload.page.ekspor') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div> 
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Impor
      </div>
      <div class="card-body">
        <i class="fa fa-plane fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Impor
        </h4>
        <a href="{{ route('kh.upload.page.impor') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col">
    <div class="text-center">
      <a href="{{ route('showmenu.operasional.kh') }}" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> Kembali</a>
    </div>
  </div>
</div>

@endsection