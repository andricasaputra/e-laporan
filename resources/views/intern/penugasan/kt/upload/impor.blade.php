@extends('intern.layouts.app')

@section('title', 'Upload Laporan Penugasan Impor')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Upload Penugasan Impor Karantina Tumbuhan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kt.menu.penugasan.page') }}">Menu</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kt.upload.penugasan.page.home') }}">Upload</a></li>
            <li class="breadcrumb-item" aria-current="page">Impor</li>
        </ol>
    </nav>
</div>

@endsection

@section('content')

<div class="row">
  <div class="col-md-6 offset-md-2 col-sm-12">

    @include('intern.inc.message')

    <div class="card text-center">
      <div class="card-body">
        <h4>Upload Penugasan Impor Karantina Tumbuhan</h4>
        <form action="{{ route('kt.upload.proses.impor') }}" method="post" enctype="multipart/form-data" class="form-loader">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <input type="hidden" name="jenis_permohonan" value="Penugasan Impor">

            <div class="form-group">
              <label for="wilker_id">Nama Wilker</label>
              <select name="wilker_id" class="form-control">
               
                @if(count($wilker) > 0)

                    <option disabled selected>Pilih Wilker</option>

                    @foreach($wilker as $w)

                      <option value="{{ $w->id }}">{{ $w->getOriginal('nama_wilker') }}</option>

                    @endforeach
                  
                @endif
                
              </select>
            </div>

            <div class="form-group">
              <label for="filenya">Pilih File Laporan</label>
              <input type="file" name="filenya" class="form-control">
            </div>
            <input type="submit" name="Import" class="btn btn-success" value="Upload">
        </form>
      </div>
    </div>
    <div class="col">
      <div class="text-center">
        <a href="{{ route('kt.upload.penugasan.page.home') }}" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Kembali</a>
      </div>
    </div>
  </div>  

  @include('intern.operasional.rules.rule')

</div>

@endsection