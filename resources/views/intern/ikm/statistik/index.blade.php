@extends('intern.layouts.admin')

@section('title', 'Statistik')

@section('barside.title', 'IKM Sumbawa')

@section('content')

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="page-title">
	  <div class="title_left">
	    <h3>Statistik Hasil Survey IKM</h3>
	  </div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_content">
	  	<table class="table table-bordered">
	  		<thead>
	  			<th>No</th>
	  			<th>Pertanyaan</th>
	  			<th>Unsur Pelayanan</th>
	  			<th>Nilai NPR per unsur</th>
	  			<th>Rata-rata nilai NPR per unsur</th>
	  			<th>NPR tertimbang per unsur</th>
	  		</thead>
	  		<tbody>
	  			@php $no = 1; $no2 = 1  @endphp
	  			@foreach($result as $res)
	  				<tr>
	  					<td>{{ $no++ }}.</td>
	  					@foreach($res->take(1) as $r)
			  			
			  			<td>{{ $r->question->question }}</td>
			  			<td>U{{ $no2++ }}</td>
			  		
			  			@endforeach	
		  					
			  			<td>{{ $res->sum('answer.nilai') }}</td>
			  			<td>{{ $res->sum('answer.nilai') / $res->count() }}</td>
			  			<td>{{ $res->sum('answer.nilai') / $res->count() * 0.11 }}</td>
		  			</tr>
			  	@endforeach
	  		</tbody>
	  	</table>
	  	
	  </div>
	</div>
</div>


@endsection

