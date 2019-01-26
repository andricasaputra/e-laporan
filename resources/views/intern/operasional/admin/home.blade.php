@extends('intern.layouts.app')

@section('title', 'Home Admin')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Admin Dashboard</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Home Admin</li>
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

  .fa-book{
    background-color: #008000;
    color: #fff;
  }

  .fa-database{
    background-color: #FFBC34;
    color: #fff
  }

  .fa-line-chart{
    background-color: #F24656;
    color: #fff
  }

</style>

<div class="row">
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Dokumen Operasional
      </div>
      <div class="card-body">
        <i class="fa fa-book fa-2x mb-4"></i>
        <h4 class="card-text">
          Dokumen Operasional
        </h4>
        <p>Setting Dokumen Operasional KH & KT</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('admin.setting.dokumen.index') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div>  
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Backup & Restore Database
      </div>
      <div class="card-body">
        <i class="fa fa-database fa-2x mb-4"></i>
        <h4 class="card-text">
          Database
        </h4>
        <p>Backup & Restore Database</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('kt.homeupload') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div> 
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Pengumuman Update Aplikasi
      </div>
      <div class="card-body">
        <i class="fa fa-line-chart fa-2x mb-4"></i>
        <h4 class="card-text">
          Pengumuman
        </h4>
        <p>Pegumuman Update Aplikasi</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div> 
</div>

@endsection