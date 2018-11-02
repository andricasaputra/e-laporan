@extends('intern.layouts.admin')

@section('title', 'Ubah Jawaban IKM')

@section('barside.title', 'IKM Sumbawa')

@section('content')
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="page-title">
	  <div class="title_left">
	    <h3>Edit Pertanyaan IKM</h3>
	  </div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
	    <a href="{{ route('intern.ikm.question.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
	    <ul class="nav navbar-right panel_toolbox">
	      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	      </li>
	    </ul>
	    <div class="clearfix"></div>
	  </div>
	  <div class="x_content">

	  	<form action="{{ route('intern.ikm.question.update', $question->id) }}" method="post" enctype="multipart/form-data">

	  		@csrf
	  		@method('PUT')

	  		<div class="form-group">
	  			<label for="pertanyaan">Pertanyaan</label>
	  			<input type="text" name="pertanyaan" class="form-control" value="{{ $question->question }}">
	  		</div>
	  		<div class="form-group">
	  			<label for="jawaban_1">Jawaban 1</label>
	  			<select name="jawaban_1" class="form-control">

	  				<option value="{{ $question->answer[0]->id }}">{{ $question->answer[0]->answer }}</option>

	  				@foreach($answers as $answer)

	  					<option value="{{ $answer->id }}">{{ $answer->answer }}</option>

	  				@endforeach

	  			</select>
	  		</div>
	  		<div class="form-group">
	  			<label for="jawaban_2">Jawaban 2</label>
	  			<select name="jawaban_2" class="form-control">

	  				<option value="{{ $question->answer[1]->id }}">{{ $question->answer[1]->answer }}</option>

	  				@foreach($answers as $answer)

	  					<option value="{{ $answer->id }}">{{ $answer->answer }}</option>

	  				@endforeach

	  			</select>
	  		</div>
	  		<div class="form-group">
	  			<label for="jawaban_3">Jawaban 3</label>
	  			<select name="jawaban_3" class="form-control">

	  				<option value="{{ $question->answer[2]->id }}">{{ $question->answer[2]->answer }}</option>

	  				@foreach($answers as $answer)

	  					<option value="{{ $answer->id }}">{{ $answer->answer }}</option>

	  				@endforeach

	  			</select>
	  		</div>
	  		<div class="form-group">
	  			<label for="jawaban_4">Jawaban 4</label>
	  			<select name="jawaban_4" class="form-control">

	  				<option value="{{ $question->answer[3]->id }}">{{ $question->answer[3]->answer }}</option>

	  				@foreach($answers as $answer)

	  					<option value="{{ $answer->id }}">{{ $answer->answer }}</option>

	  				@endforeach

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
