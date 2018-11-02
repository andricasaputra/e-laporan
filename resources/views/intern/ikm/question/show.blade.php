@extends('intern.layouts.admin')

@section('title', 'Detail Pertanyaan IKM')

@section('barside.title', 'IKM Sumbawa')

@section('content')

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="page-title">
	  <div class="title_left">
	    <h3>Detail Pertanyaan</h3>
	  </div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
	    <a href="{{ route('intern.ikm.question.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
	    <ul class="nav navbar-right">
	      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	      </li>
	    </ul>
	    <div class="clearfix"></div>
	  </div>
	  <div class="x_content">
	  	<h4>{{$question->question}}</h4>
	  	@foreach($answers as $answer)
		  	<p>{{ $answer->answer }}</p>
	  	@endforeach
	  </div>
	</div>
</div>

@endsection



