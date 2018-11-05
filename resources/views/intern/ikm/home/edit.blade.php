@extends('intern.layouts.admin')

@section('title', 'Ubah Jawaban IKM')

@section('barside.title', 'IKM Sumbawa')

@section('content')
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="page-title">
	  <div class="title_left">
	    <h3>Edit Jawaban Responden IKM</h3>
	  </div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
	    <a href="{{ route('intern.ikm.home.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
	    <ul class="nav navbar-right panel_toolbox">
	      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	      </li>
	    </ul>
	    <div class="clearfix"></div>
	  </div>
	  <div class="x_content">

	  	<form action="{{ route('intern.ikm.home.update', $responden->id) }}" method="post" enctype="multipart/form-data">

	  		@csrf
	  		@method('PUT')

	  		@php $no = 1  @endphp

	  		<input type="hidden" name="responden_id"  value="{{ $responden->id }}">
	  		@for($i = 0; $i < count($responden->question); $i++)

	  			<h4>{{ $no++ }} Pertanyaan : {{ $responden->question[$i]->question }}</h4>

	  			<div class="form-group">

		  			<label for="jawaban">Jawaban</label>
	  				<select name="{{ $responden->id }}[]" class="form-control">
		  				<option value="{{ $responden->answer[$i]->id }}">{{ $responden->answer[$i]->answer }}</option>
		  				@foreach($jawaban as $j)
		  					<option value="{{ $j->id }}">{{ $j->answer }}</option>
		  				@endforeach
	  				</select>

		  		</div>

	  		@endfor
		  	<br/>
	  		<div class="pull-right">
	  			<input type="submit" name="submit" value="Simpan" class="btn btn-warning">
	  		</div>

	  	</form>

	  </div>
	</div>
</div>


@endsection

