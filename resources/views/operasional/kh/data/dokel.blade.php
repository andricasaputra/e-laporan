@extends('layouts.app')

@section('title','Operasional - Data Domestik Keluar')			
@section('content')

<style type="text/css">
 table th, table tbody, table td{
    text-align: center !important;
  }
  table td:not(:first-of-type){
	min-width: 150px !important;
  }
</style>

<main class="content-wrapper">
  <div class="container-fluid">
   <div class="row">
      <div class="col-md-10 offset-md-1 card">
          @include('inc.message')
          <div class="card-header">
            Data Domestik Keluar Karantina Hewan
          </div>
          <div class="card-body">
             <table class="table table-responsive table-bordered w-100 d-block d-md-table" id="dokelkh">
              <thead>
              	@foreach($titles as $title)
              		<th>{{ ucwords(str_replace('_', ' ', $title)) }}</th>
              	@endforeach
              </thead>
           </table>
          </div>
      </div>
    </div>
  </div>
</main>

@endsection

@section('custom_scripts')

  <script>
    $(document).ready(function() {

	    datatablesOperasional($('#dokelkh'), '{{ route('api.kh.dokel') }}', 'kh');

  	});
  </script>

@endsection