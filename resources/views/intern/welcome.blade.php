@extends('intern.layouts.welcome_app')

@section('content')

<style type="text/css">
  .card_body_welcome{
    color: #000
  }

  .btn{
    border-radius: 30px !important;
  }

  .btn-default{
    background-color: #3E50B4;
    color: #fff;
  }

  .btn-default:hover {
    background-color: #2e3b85;
    color: #fff;
  }

  .card, .card-body{
    outline: none;
  }

  .card-body{
    -webkit-box-shadow: 10px 10px 4px -4px rgba(0,0,0,0.10);
    -moz-box-shadow: 10px 10px 4px -4px rgba(0,0,0,0.10);
    box-shadow: 10px 10px 4px -4px rgba(0,0,0,0.10);
  }


  i.fa{
     margin-top: 15px;
  }

  @media only screen and (max-width: 700px){
    .card{
      display: block;
      text-align: center;
    }
    
    i.fa{
        margin-top: 0;
        margin-bottom: 10px;
    }
  }
</style>

  <div class="row">
    <div class="col-sm-12 mb-4">
      <div class="card">
        <div class="card-body welcome">
          Selamat Datang <b>{{ auth()->user()->pegawai->nama }}</b>
        </div>
      </div>
    </div>
  
    <div class="col-md-12">
      @include('intern.inc.message')
    </div>  

    <div class="col-md-6 col-sm-12 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3 text-center">
               <i class="mdi mdi-library-books fa-5x"></i>
            </div>
            <div class="col-sm-9 card_body_welcome">
                <h3 class="card-title">E - Laporan Operasional</h3>
                <p class="card-text">Status : App Version 2.0</p>
                <a href="{{ route('show.operasional') }}" class="btn btn-success">Masuk Ke Aplikasi!</a> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3 text-center">
               <i class="fa fa-envelope fa-4x"></i>
            </div>
            <div class="col-sm-9 card_body_welcome">
                <h3 class="card-title">E - Persuratan</h3>
                <p class="card-text">Status : In Planning</p>
                <a href="#" class="btn" style="background-color: #D62D20; color:#fff">Masuk Ke Aplikasi!</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-sm-12 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3 text-center">
               <i class="mdi mdi-checkbox-marked-circle fa-5x"></i>
            </div>
            <div class="col-sm-9 card_body_welcome">
                <h3 class="card-title">E - IKM</h3>
                <p class="card-text">
                  Periode : {{ $ikm->keterangan ?? 'Tidak ada survey ikm yang aktif untuk saat ini' }}<br>
                  Status : App Version 1.0
                </p>
                <a href="{{ route('intern.ikm.home.index') }}" class="btn btn-default">Masuk Ke Aplikasi!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3 text-center">
               <i class="mdi mdi-file-check fa-5x"></i>
            </div>
            <div class="col-sm-9 card_body_welcome">
                <h3 class="card-title">E - IPNBK</h3>
                <p class="card-text">
                  Periode : - <br>
                  Status : In Planning
                </p>
                <a href="#" class="btn" style="background-color: #ffb31a; color: #fff">Masuk Ke Aplikasi!</a>
            </div>
          </div>
        </div>
      </div> 
    </div>

    <div class="col-md-6 col-sm-12 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3 text-center">
               <i class="mdi mdi-web fa-5x"></i>
            </div>
            <div class="col-sm-9 card_body_welcome">
                <h3 class="card-title">Website Admin Panel</h3>
                <p class="card-text">Status : In Planning</p>
                <a href="#" class="btn" style="background-color: #996633; color:#fff">Masuk Ke Aplikasi!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3 text-center">
               <i class="mdi mdi-settings fa-5x"></i>
            </div>
            <div class="col-sm-9 card_body_welcome">
                <h3 class="card-title">Aplikasi Manajemen</h3>
                <p class="card-text">Status : In Progress</p>
                <a href="{{ route('users.index') }}" class="btn" style="background-color: #0087CB; color:#fff">Masuk Ke Aplikasi!</a>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection
