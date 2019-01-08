@extends('intern.layouts.app')

@section('title', 'Download Laporan KT')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Download Laporan Operasional Karantina Tumbuhan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kt') }}">Menu</a></li>
            <li class="breadcrumb-item" aria-current="page">Download</li>
        </ol>
    </nav>
</div>

@endsection

@php 

use App\Http\Controllers\TanggalController as Tanggal; 

use App\Http\Controllers\RupiahController as Rupiah;

@endphp

@section('content')

<style type="text/css">

  i.fa-2x {
    display: inline-block;
    border-radius: 80px;
    box-shadow: 0px 0px 2px #888;
    padding: 0.5em 0.6em;
  }

  .fa-bus, .fa-exchange{
    background-color: #f73b5e;
    color: #fff
  }

  .fa-truck{
    background-color: #2962FF;
    color: #fff;
  }

  .fa-ship, .fa-file-excel-o{
    background-color: #FF8F29;
    color: #fff;
  }

  .fa-plane, .card-body > .fa-repeat{
    background-color: #12AFAF;
    color: #fff;
  }

  .badge{
    padding: 4px 13px !important;
  }



</style>

<div class="row" id="advancedMenu">
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Download Laporan Operasional
      </div>
      <div class="card-body">
        <i class="fa fa-exchange fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Laporan Operasional
        </h4>
        <a href="" class="btn btn-primary"  data-toggle="modal" data-target="#laporanOperasionalDownloadModal">Download</a>
      </div>
    </div>
  </div>  
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Download Laporan Rekap Komoditas
      </div>
      <div class="card-body">
        <i class="fa fa-repeat fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Laporan Rekap Komoditas
        </h4>
        <a href="" class="btn btn-primary">Download</a>
      </div>
    </div>
  </div> 
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Download Laporan Penggunaan Dokumen
      </div>
      <div class="card-body">
        <i class="fa fa-file-excel-o fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Laporan Penggunaan Dokumen
        </h4>
        <a href="" class="btn btn-primary">Download</a>
      </div>
    </div>
  </div> 
</div>

<!-- Modal Laporan Operasional -->

<!-- Modal -->
<div class="modal fade" id="laporanOperasionalDownloadModal" tabindex="-1" role="dialog" aria-labelledby="laporanOperasionalDownloadModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	<form action="{{ route('kt.download.operasional') }}" method="POST">
	    <div class="modal-content">

	      <div class="modal-header">
	        <h5 class="modal-title" id="laporanOperasionalDownloadModalLabel">Download Laporan Operasional</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

      	  <div class="modal-body">

       		@csrf
       		@method('POST')

       		<div class="form-group">
       			<label for="year">Pilih Tahun</label>
       			<select class="form-control" name="year" id="year">
			        @for($i = date('Y') - 5; $i < date('Y') + 2 ; $i++)

			          @if($i == date('Y'))

			          <option value="{{ $i }}" selected>{{ $i }}</option>

			          @else

			          <option value="{{ $i }}">{{ $i }}</option>

			          @endif

			        @endfor
			     </select>
       		</div>
       		<div class="form-group">
       			<label for="month">Pilih Bulan</label>
       			<select class="form-control" name="month" id="month">

			        <option value="all">Semua bulan</option>
			        
			        @for($i = 1; $i < 13 ; $i++)
			    
			          <option value="{{ $i }}">{{  Tanggal::bulan($i) }}</option>

			        @endfor
			        
			      </select>
       		</div>
       		<div class="form-group">
       			<label for="wilker">Pilih Wilker</label>
       			<select name="wilker_id" id="wilker" class="form-control">
		                 
		        @if(count($all_wilker) > 0)

		            @foreach($wilkers as $wilker)

		              <option value="{{ $wilker->id }}">
		              	{{

		                $wilker->nama_wilker == 'Kantor Induk' ? 'Semua Wilker' : $wilker->nama_wilker

		              	}}
		              </option>

		            @endforeach
		          
		        @endif
		        
		      </select>
       		</div>
       		<div class="form-group">
       			<label for="type">Pilih Permohonan</label>
       			<select class="form-control" name="type" id="type">
			        <option value="all">Semua permohonan</option>
			        <option value="Domas">Domestik Masuk</option>
			        <option value="Dokel">Domestik Keluar</option> 
			        <option value="Ekspor">Ekspor</option> 
			        <option value="Impor">Impor</option>
			        <option value="Reekspor">Re Ekspor</option>
			        <option value="SerahTerima">Serah Terima</option>  
			      </select>
       		</div>
          <div class="form-group">
            <label for="signatory">Pilih Penandatangan Laporan</label>
            <select class="form-control" name="signatory" id="signatory">
              @foreach($pegawai as $p)
                <option value="{{ $p->id }}">{{ $p->nama }}</option>
              @endforeach
                <option value=""></option>
            </select>
          </div>

       		<input type="hidden" name="karantina" value="Kt">

		  </div>

	      <div class="modal-footer"> 
	        <button type="submit" class="btn btn-primary">Download</button>
	      </div>
	    </div>

    </form>

  </div>
</div>

@endsection
