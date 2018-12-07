@extends('intern.layouts.app')

@section('title','Operasional - Data Domestik Masuk')		

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

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
      <div class="col-md-2 offset-md-1 mb-3">
        <form action="{{ route('view.select.year') }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Tahun</label>
            <select class="form-control" name="year">
              @for($i = date('Y') - 3; $i < date('Y') + 2 ; $i++)
              
                @if($i == $tahun)

                  <option value="{{ route('kt.view.page.domas', $i) }}" selected>{{ $i }}</option>

                @else

                  <option value="{{ route('kt.view.page.domas', $i) }}">{{ $i }}</option>

                @endif
                
              @endfor
            </select>
          </div>
          <button type="submit">Pilih</button>
        </form>
      </div>
      <div class="col-md-10 offset-md-1 card">
          @include('intern.inc.message')
          <div class="card-header">
            Data Domestik Masuk Karantina Tumbuhan Tahun {{ $tahun }}
          </div>
          <div class="card-body">
             <table class="table table-responsive table-bordered w-100 d-block d-md-table" id="domaskt">
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

@section('script')

  <script>
    $(document).ready(function() {

	    datatablesOperasional($('#domaskt'), '{{ route('api.kt.domas', $tahun) }}', 'kt');
	    
  	});
  </script>

@endsection