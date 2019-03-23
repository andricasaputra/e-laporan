@extends('intern.layouts.app')

@section('title', 'Download Laporan KH')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Download Laporan Operasional Karantina Hewan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kh') }}">Menu</a></li>
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

  .fa-truck{
    background-color: #f73b5e;
    color: #fff;
  }

  .fa-file-o{
    background-color: #FF8F29;
    color: #fff;
  }

  .fa-paw{
    background-color: #12AFAF;
    color: #fff;
  }

</style>

<div class="row" id="advancedMenu">
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Download Laporan Operasional
      </div>
      <div class="card-body">
        <i class="fa fa-truck fa-2x mb-3"></i>
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
        <i class="fa fa-paw fa-2x mb-3"></i>
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
        <i class="fa fa-file-o fa-2x mb-3"></i>
        <h4 class="card-text mb-3">
          Laporan Penggunaan Dokumen
        </h4>
        <a href="#" data-toggle="modal" data-target="#laporanPemakaianDokumenModal" class="btn btn-primary">Download</a>
      </div>
    </div>
  </div> 
</div>

<hr>

<div class="row">
  <div class="col text-center">
    <a href="{{ route('showmenu.operasional.kh') }}" class="btn btn-danger">
          <i class="fa fa-angle-double-left"></i> Kembali
        </a>
  </div>
</div>

<!-- Modal Laporan Operasional -->

@include('intern.operasional.kh.download.inc.modal_laporan_operasional')
@include('intern.operasional.kh.download.inc.modal_laporan_rekapitulasi_komoditi')
@include('intern.operasional.kh.download.inc.modal_laporan_pemakaian_dokumen')

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
