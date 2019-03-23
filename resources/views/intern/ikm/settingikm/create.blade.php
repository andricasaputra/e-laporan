@extends('intern.layouts.admin')

@section('title', 'Setting Jadwal Aplikasi IKM')

@section('barside.title', 'IKM Sumbawa')

@section('content')
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="page-title">
	  <div class="title_left">
	    <h3>Tambah Jadwal settingikm IKM</h3>
	  </div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
	    <a href="{{ route('intern.ikm.settingikm.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
	    <ul class="nav navbar-right panel_toolbox">
	      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	      </li>
	    </ul>
	    <div class="clearfix"></div>
	  </div>
	  <div class="x_content">

	  	<form action="{{ route('intern.ikm.settingikm.store') }}" method="post" enctype="multipart/form-data">

	  		@csrf

	  		<div class="form-group">
	  			<label for="start_date">Waktu Mulai</label>
	  			<input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
	  		</div>
	  		<div class="form-group">
	  			<label for="end_date">Waktu Selesai</label>
	  			<input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
	  		</div>
	  		<div class="form-group">
	  			<label for="keterangan">Keterangan</label>
	  			<input type="text" name="keterangan" class="form-control" value="{{ old('keterangan') }}">
	  		</div>
	  		<div class="pull-right">
	  			<input type="submit" name="submit" value="Simpan" class="btn btn-warning">
	  		</div>

	  	</form>

	  </div>
	</div>
</div>


@endsection
