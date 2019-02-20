@extends('intern.layouts.app')

@section('title', 'Home Database')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Database Menu</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home') }}">Menu Admin</a></li>
            <li class="breadcrumb-item" aria-current="page">Home Database</li>
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

  .fa-download{
    background-color: #008000;
    color: #fff;
  }

  .fa-upload{
    background-color: #FFBC34;
    color: #fff
  }

</style>

<div class="col-md-12">
  @include('intern.inc.message')
</div>  

<div class="row">
  <div class="col-md-6 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Export
      </div>
      <div class="card-body">
        <i class="fa fa-download fa-2x mb-4"></i>
        <h4 class="card-text">
          Backup
        </h4>
        <p>Export Database</p>
      </div>
      <div class="card-footer bg-transparent">
        <form action="{{ route('database.export') }}" method="POST">
        	@csrf
        	<button type="submit" class="btn btn-primary">Export</button>
        </form>
      </div>
    </div>
  </div>  
  <div class="col-md-6 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Import
      </div>
      <div class="card-body">
        <i class="fa fa-upload fa-2x mb-4"></i>
        <h4 class="card-text">
          Restore
        </h4>
        <p>Import Database</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('database.page.impor') }}" class="btn btn-primary">Masuk</a>
      </div>
    </div>
  </div>  
</div>

<div class="row">
	<div class="col text-center">
		<a href="{{ route('admin.home') }}" class="btn btn-danger">
        	<i class="fa fa-angle-double-left"></i> Kembali
      	</a>
	</div>
</div>

@endsection