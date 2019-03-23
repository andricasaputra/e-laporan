@extends('intern.layouts.app')

@section('title', 'Import Database')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Import Database</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home') }}">Menu Admin</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('database.menu') }}">Home Database</a></li>
            <li class="breadcrumb-item" aria-current="page">Restore Database</li>
        </ol>
    </nav>
</div>

@endsection

@section('content')

<div class="container" style="width:700px;"> 

  @include('intern.inc.message') 

  <h3 align="center" class="mb-5">Restore Database <small>(<i>E-Laporan Operasional</i>)</small></h3> 

  <form action="{{ route('database.impor') }}" method="post" enctype="multipart/form-data" class="form-loader">

    @csrf

  <div class="form-group">
    <label><strong>Pilih File</strong></label>
    <input type="file" name="filesql" class="form-control">
  </div>

  <input type="submit" name="import" class="btn btn-info" value="Import">

  </form>

  <div class="row mt-5">
    <div class="col text-center mt-3">
      <a href="{{ route('database.menu') }}" class="btn btn-danger">
        <i class="fa fa-angle-double-left"></i> Kembali
      </a>
    </div>
  </div>

</div> 

@endsection