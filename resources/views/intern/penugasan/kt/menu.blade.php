@extends('intern.layouts.app')

@section('title', 'Menu Penugasan KT')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Menu Penugasan Karantina Tumbuhan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Menu Karantina Tumbuhan</li>
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

  .fa-expand{
    background-color: #008000;
    color: #fff;
  }

  .fa-upload{
    background-color: #2962FF;
    color: #fff
  }

  .fa-download{
    background-color: #F24656;
    color: #fff
  }

  .fa-file{
    background-color: #16C2D0;
    color: #fff
  }

  .card{
    min-height: 300px ;
  }

</style>

<div class="row">
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Detail Penugasan!
      </div>
      <div class="card-body">
        <i class="fa fa-expand fa-2x mb-4"></i>
        <h4 class="card-text">
          Lihat Detail Penugasan
        </h4>
        <p>Karantina Tumbuhan</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('kt.view.penugasan.home') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div>  
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Upload Laporan Penugasan!
      </div>
      <div class="card-body">
        <i class="fa fa-upload fa-2x mb-4"></i>
        <h4 class="card-text">
          Upload Laporan Penugasan
        </h4>
        <p>Karantina Tumbuhan</p>
      </div>
      <div class="card-footer bg-transparent">
        <a href="{{ route('kt.upload.penugasan.page.home') }}" class="btn btn-default">Masuk</a>
      </div>
    </div>
  </div> 
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-header">
        Download Laporan Penugasan!
      </div>
      <div class="card-body">
        <i class="fa fa-download fa-2x mb-4"></i>
        <h4 class="card-text">
          Download Laporan Penugasan
        </h4>
        <p>Karantina Tumbuhan</p>
      </div>
      <div class="card-footer bg-transparent">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModal">Download</button>
        {{-- <a href="{{ route('kt.homedownload') }}" class="btn btn-default">Masuk</a> --}}
      </div>
    </div>
  </div> 
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('kt.penugasan.download') }}">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Download Bukti Fisik Penugasan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span id="closeModal" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <label for="year">Pilih Tahun</label>
            <select class="form-control" name="year" id="year">
              @for($i = date('Y') - 5; $i < date('Y') + 2 ; $i++)
          
                @if($i == $datas['year'])

                  <option value="{{ $i }}" selected>{{ $i }}</option>

                @else

                  <option value="{{ $i }}">{{ $i }}</option>

                @endif

              @endfor
            </select>

            <label for="month">Pilih Bulan</label>
            <select class="form-control" name="month" id="month">
              <option value="all">Semua Bulan</option>

              <option value="{{ date('m') - 1 }}">Bulan Lalu</option>
              
              @for($i = 1; $i < 13 ; $i++)
          
                @if($i == $datas['month'])

                  <option value="{{ $i }}" selected>{{ bulan($i) }}</option>

                @else

                  <option value="{{ $i }}">{{ bulan($i) }}</option>

                @endif

              @endfor
              
            </select>
            <label for="wilker">Pilih Wilker</label>
            <select name="wilker_id" id="wilker" class="form-control">
                    
              @foreach($wilkers as $wilker)
              
              @if($wilker->id === 1)
              
              <option value="">Semua Wilker</option>
              
              @else
              
              <option value="{{ $wilker->id }}">{{ $wilker->getOriginal('nama_wilker') }}</option>
              
              @endif
              
              @endforeach
              
            </select>

            <label for="signatory">Pilih Penandatangan (Kepala)</label>
            <select class="form-control" name="signatory" id="signatory">
              @foreach($pegawai as $p)
              <option value="{{ $p->id }}">{{ $p->nama }}</option>
              @endforeach
              <option value=""></option>
            </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Download</button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection