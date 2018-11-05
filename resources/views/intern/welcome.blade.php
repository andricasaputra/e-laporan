@extends('intern.layouts.welcome_app')

@section('content')

<style type="text/css">
  .card_body_welcome{
    color: #fff
  }

  .card-body{
    -webkit-box-shadow: 10px 10px 4px -4px rgba(0,0,0,0.24);
    -moz-box-shadow: 10px 10px 4px -4px rgba(0,0,0,0.24);
    box-shadow: 10px 10px 4px -4px rgba(0,0,0,0.24);
  }
</style>

<main class="content-wrapper">
    <div class="mdc-layout-grid">
      <div class="mdc-layout-grid__inner">
        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
          <div class="mdc-card">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-7">
                <section class="purchase__card_section">
                  Selamat Datang <b>{{ Auth::user()->name }}</b>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body" style="background-color: #00A9F4">
              <div class="row">
                <div class="col-sm-3 text-center" style="color: #fff">
                   <i class="fa fa-book fa-5x"></i>
                </div>
                <div class="col-sm-9 card_body_welcome">
                    <h3 class="card-title">E - Laporan Operasional</h3>
                    <p class="card-text">Status : In Progress</p>
                    <a href="{{ route('intern.operasional.home') }}" class="btn btn-success">Masuk Ke Aplikasi!</a>                    
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body" style="background-color: #3E50B4">
              <div class="row">
                <div class="col-sm-3 text-center" style="color: #fff">
                   <i class="fa fa-file-text fa-5x"></i>
                </div>
                <div class="col-sm-9 card_body_welcome">
                    <h3 class="card-title">E - Surat Tugas</h3>
                    <p class="card-text">Status : In Planning</p>
                    <a href="#" class="btn btn-danger">Masuk Ke Aplikasi!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body" style="background-color: #82B440">
              <div class="row">
                <div class="col-sm-3 text-center" style="color: #fff">
                   <i class="fa fa-check-circle fa-5x"></i>
                </div>
                <div class="col-sm-9 card_body_welcome">
                    <h3 class="card-title">E - IKM</h3>
                    <p class="card-text">Status : In Planning</p>
                    <a href="{{ route('intern.ikm.home.index') }}" class="btn btn-default">Masuk Ke Aplikasi!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card-body" style="background-color: #E91E63">
              <div class="row">
                <div class="col-sm-3 text-center" style="color: #fff">
                   <i class="fa fa-file fa-5x"></i>
                </div>
                <div class="col-sm-9 card_body_welcome">
                    <h3 class="card-title">E - IPNBK</h3>
                    <p class="card-text">Status : In Planning</p>
                    <a href="#" class="btn btn-warning">Masuk Ke Aplikasi!</a>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div> 

</main>
@endsection
