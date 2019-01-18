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
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#laporanOperasionalDownloadModal">Download</a>
      </div>
    </div>
  </div>  
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Download Laporan Rekapitulasi Komoditas
      </div>
      <div class="card-body">
        <i class="fa fa-repeat fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Laporan Rekapitulasi Komoditas
        </h4>
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#laporanRekapitulalsiKomoditiDownloadModal">Download</a>
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
        <a href="#" data-toggle="modal" data-target="#laporanPemakaianDokumenModal" class="btn btn-primary">Download</a>
      </div>
    </div>
  </div> 
</div>

<!-- Modal Laporan Operasional -->

@include('intern.operasional.kt.download.inc.modal_laporan_operasional')
@include('intern.operasional.kt.download.inc.modal_laporan_rekapitulasi_komoditi')
@include('intern.operasional.kt.download.inc.modal_laporan_pemakaian_dokumen')

@endsection

@section('script')

<script>
  $(document).ready(function(){

    $('.pageSetup').hide();

    $('.pageSetupButton').on('click', function(e){

      e.preventDefault();

      $('.pageSetup').slideToggle();

    });

  });/*end ready*/
</script>

@endsection
