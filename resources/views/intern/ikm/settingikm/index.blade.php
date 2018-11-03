@extends('intern.layouts.admin')

@section('title', 'E-IKM | Setting Jadwal IKM')

@section('barside.title', 'IKM Sumbawa')

@section('content')
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="page-title">
	  <div class="title_left">
	    <h3>Jadwal IKM</h3>
	  </div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
	    <a href="{{ route('intern.ikm.settingikm.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Jadwal</a>
	    <ul class="nav navbar-right">
	      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	      </li>
	    </ul>
	    <div class="clearfix"></div>
	  </div>
	  <div class="x_content">
	    <table class="table table-striped table-bordered text-center datatable" width="100%">
	      <thead>
	        <tr>
	          <th>No</th>
	          <th>Waktu Mulai</th>
	          <th>Selesai</th>
	          <th>Status</th>
	          <th>Keterangan</th>
	          <th>Action</th>
	        </tr>
	      </thead>
	      <tbody>
	      	@php $no = 1 @endphp
	      	@foreach($settingikm as $setting)
	      		<tr>
		      		<td>{{ $no++ }}</td>
		      		<td>{{ $setting->start_date }}</td>
		      		<td>{{ $setting->end_date }}</td>
		      		<td>	
	      				@if($setting->is_open == 0)
	      					<a href="#" class="btn btn-danger btn-xs">Close</a>
	      				@else
	      					<a href="#" class="btn btn-success btn-xs">Open</a>
	      				@endif		
		      		</td>
		      		<td>{{ $setting->keterangan }}</td>
		      		<td>
		      			<a href="{{ route('intern.ikm.settingikm.edit', $setting->id) }}" class="btn btn-success btn-xs"> Edit</a>
		      			<form action="{{ route('intern.ikm.settingikm.destroy', $setting->id) }}" method="POST">
		      				@csrf
	      					@method('DELETE')
			      			<button type="submit" class="btn btn-danger btn-xs" onclick=" return confirm('Apakah Anda Yakin Ingin Menghapus File Ini?')">
	      						Delete
	      					</button>
		      			</form>
		      		</td>
	      		</tr>
	      	@endforeach
	      </tbody>
	    </table>
	  </div>
	</div>
</div>




@endsection