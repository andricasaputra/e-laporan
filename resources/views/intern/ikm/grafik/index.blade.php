@extends('intern.layouts.admin')

@section('title', 'E-IKM | Grafik')

@section('barside.title', 'IKM Sumbawa')

@section('content')

<style type="text/css">
	#total_responden, #nilai_ikm, #layanan_kh, #layanan_kt{
		width: 100%;
		min-height: 310px
	}
</style>
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="page-title">
	  <div class="title_left">
	    <h3>Statistik & Grafik {{ $ikm_ket->keterangan }}</h3>
	    <h5>
	    	Periode Survey : 
	    	{{ date('d-M-Y', strtotime($ikm_ket->start_date)) }} 
	    	s/d 
	    	{{ date('d-M-Y', strtotime($ikm_ket->end_date)) }}
	    </h5>
	  </div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12">
	<div class="row" style="margin-bottom: 1%">
		<div class="col-sm-4 col-sm-12 col-xs-12">
			<div class="row">
				<label for="select_ikm">Pilih IKM</label>
				<select name="select_ikm" id="select_ikm" class="form-control">
					<option disabled selected>-- Pilih Periode IKM --</option>
					@foreach($ikm as $i)
						<option value="{{ $i->id }}">{{ $i->keterangan }}</option>
					@endforeach
				</select>
			</div>
		 </div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_content">
			  	<div class="row">
			  		<div class="col-md-12 text-center" id="nilai_ikm">
						<h2></h2>
						<div class="card card-default">
						  <div class="card-body" style="margin: 70px 0">
						  	<h1 style="font-size: 50pt"></h1>
						  	<i class="fa fa-check-circle" style="font-size: 30pt"></i>
						  </div>
						</div>
					</div>
			  	</div>
			  </div>
			</div>
		</div>

		<div class="col-md-3 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_content">
			  	<div class="row">
			  		<div class="col-md-12 text-center" id="total_responden">
						<h2></h2>
						  <div class="card-body" style="margin: 70px 0">
						  	<h1 style="font-size: 50pt"></h1>
						  	<i class="fa fa-line-chart" style="font-size: 30pt"></i>
						  </div>
					</div>
			  	</div>
			  </div>
			</div>
		</div>

		<div class="col-md-3 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_content">
			  	<div class="row">
			  		<div class="col-md-12 text-center" id="layanan_kh">
						<h2></h2>
						  <div class="card-body" style="margin: 70px 0">
						  	<h1 style="font-size: 50pt"></h1>
						  	<i class="fa fa-paw" style="font-size: 30pt"></i>
						  </div>
					</div>
			  	</div>
			  </div>
			</div>
		</div>

		<div class="col-md-3 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_content">
			  	<div class="row">
			  		<div class="col-md-12 text-center" id="layanan_kt">
						<h2></h2>
						  <div class="card-body" style="margin: 70px 0">
						  	<h1 style="font-size: 50pt"></h1>
						  	<i class="fa fa-leaf" style="font-size: 30pt"></i>
						  </div>
					</div>
			  	</div>
			  </div>
			</div>
		</div>
	</div>
</div>

@include('intern.ikm.grafik.chart')

@endsection

@include('intern.ikm.grafik.script')