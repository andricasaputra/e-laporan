@extends('intern.layouts.app')

@section('title', 'Menu Operasional KT')

@section('barside')

  @include('intern.inc.barside')

@endsection

@section('content')

<div class="row">
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-body">
        <i class="fa fa-chart-line fa-3x"></i>
        <h4 class="card-text pull-right">
          Data Operasional
        </h4>
      </div>
    </div>
  </div>  
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-body">
        <h4 class="card-text pull-right">
          Upload Laporan Operasional
        </h4>
      </div>
    </div>
  </div> 
  <div class="col-md-4 col-sm-12">
    <div class="card text-center">
      <div class="card-body">
        <h4 class="card-text pull-right">
          Donwload Laporan Operasional
        </h4>
      </div>
    </div>
  </div> 
</div>

@endsection