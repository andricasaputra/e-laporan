@extends('intern.layouts.app')

@section('title', 'Upload Laporan Penugasan KT')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Upload Laporan Penugasan Karantina Tumbuhan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kt.menu.penugasan.page') }}">Menu</a></li>
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

  .fa-bus, .fa-exchange{
    background-color: #f73b5e;
    color: #fff
  }

  .fa-truck, .fa-money{
    background-color: #2962FF;
    color: #fff;
  }

  .fa-ship, .fa-file-excel-o{
    background-color: #FF8F29;
    color: #fff;
  }

  .fa-plane, .card-body > .fa-repeat{
    background-color: #12AFAF;
    color: #fff;
  }

  .badge{
    padding: 4px 13px !important;
  }

  .card{
    min-height: 280px ;
  }

  .card-footer{

    position: absolute; bottom: 0; left: 0; right: 0;

  }

</style>

<div class="row">
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Penugasan Domas
      </div>
      <div class="card-body">
        <i class="fa fa-bus fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Penugasan Domestik Masuk
        </h4>
        <div class="card-footer bg-white">
           <a href="{{ route('kt.upload.penugasan.page.domas') }}" class="btn btn-default">Masuk</a>
        </div>
       
      </div>
    </div>
  </div>  
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Penugasan Dokel
      </div>
      <div class="card-body">
        <i class="fa fa-truck fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Penugasan Domestik Keluar
        </h4>
        <div class="card-footer bg-white">
           <a href="{{ route('kt.upload.penugasan.page.dokel') }}" class="btn btn-default">Masuk</a>
        </div>
      </div>
    </div>
  </div> 
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Penugasan Ekspor
      </div>
      <div class="card-body">
        <i class="fa fa-ship fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Penugasan Ekspor
        </h4>
        <div class="card-footer bg-white">
           <a href="{{ route('kt.upload.penugasan.page.ekspor') }}" class="btn btn-default">Masuk</a>
        </div></a>
      </div>
    </div>
  </div> 
  <div class="col-md-3 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Penugasan Impor
      </div>
      <div class="card-body">
        <i class="fa fa-plane fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Penugasan Impor
        </h4>
        <div class="card-footer bg-white">
           <a href="{{ route('kt.upload.penugasan.page.impor') }}" class="btn btn-default">Masuk</a>
        </div>
      </div>
    </div>
  </div>
</div>

<hr>

<div class="row mt-4 mb-2">
  <div class="col mb-3">
    <div class="text-center">
      <a href="{{ route('kt.menu.penugasan.page') }}" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> Kembali</a>
    </div>
  </div>
</div>


@endsection

@section('script')

@endsection