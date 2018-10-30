@extends('intern.layouts.admin')

@section('title', 'Tambah IKM')

@section('barside.title', 'IKM Sumbawa')

@section('content')
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="page-title">
	  <div class="title_left">
	    <h3>Tambah Pertanyaan IKM</h3>
	  </div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
	    <a href="{{ route('intern.ikm.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
	    <ul class="nav navbar-right panel_toolbox">
	      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	      </li>
	    </ul>
	    <div class="clearfix"></div>
	  </div>
	  <div class="x_content">

	  	<form action="{{ route('intern.ikm.store') }}" method="post" enctype="multipart/form-data">

	  		@csrf

	  		<div class="form-group">
	  			<label for="judul">Pertanyaan</label>
	  			<input type="text" name="pertanyaan" class="form-control" value="{{ old('pertanyaan') }}">
	  		</div>
	  		<div class="form-group">
	  			<label for="jawaban">Jawaban</label>
	  			<select name="jawaban" class="form-control">
	  				<option value="1">1</option>
		  			<option value="2">2</option>
		  			<option value="3">3</option>
		  			<option value="4">4</option>
	  			</select>
	  		</div>
	  		<div class="pull-right">
	  			<input type="submit" name="submit" value="Simpan" class="btn btn-warning">
	  		</div>

	  	</form>

	  </div>
	</div>
</div>


@endsection
