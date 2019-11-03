@extends('intern.layouts.app')

@section('title','Operasional - Ekspor')		

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Detail Operasional Ekspor Karantina Hewan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kh') }}">Menu Utama</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.data.operasional.kh') }}">Menu Data Operasional Karantina Hewan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('show.statistik.operasional.kh') }}">Statistik</a></li>
            <li class="breadcrumb-item" aria-current="page">Detail Operasional</li>
        </ol>
    </nav>
</div>

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
    <form id="change_data">
        <div class="row mb-3">
          <div class="col-md-4 col-sm-12">
            <label for="year">Pilih Tahun</label>
            <select class="form-control" name="year" id="year">
              @for($i = date('Y') - 3; $i < date('Y') + 2 ; $i++)
          
                @if($i == $tahun)

                  <option value="{{ $i }}" selected>{{ $i }}</option>

                @else

                  <option value="{{ $i }}">{{ $i }}</option>

                @endif

              @endfor
            </select>
          </div>

          <div class="col-md-4 col-sm-12">
            <label for="month">Pilih Bulan</label>
            <select class="form-control" name="month" id="month">
              <option value="all">Semua</option>
              @for($i = 1; $i < 13 ; $i++)
          
                @if($i == $bulan)

                  <option value="{{ $i }}" selected>{{ bulan($i) }}</option>

                @else

                  <option value="{{ $i }}">{{ bulan($i) }}</option>

                @endif

              @endfor
              
            </select>
          </div>

          <div class="col-md-4 col-sm-12">
            <label for="wilker">Pilih Wilker</label>
            <select class="form-control" name="wilker" id="wilker">

              <option value="">Semua</option>

              @foreach($wilkers as $wilker)

                @if($userWilker != 1 && $wilker->id == $userWilker)

<<<<<<< HEAD
                <option value="{{ $wilker->id }}" selected>{{ $wilker->getOriginal('nama_wilker') }}</option>

                @else

                <option value="{{ $wilker->id }}">{{ $wilker->getOriginal('nama_wilker') }}</option>
=======
                <option value="{{ $wilker->id }}" selected>{{ $wilker->nama_wilker }}</option>

                @else

                <option value="{{ $wilker->id }}">{{ $wilker->nama_wilker }}</option>
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

                @endif
                
              @endforeach

            </select>
          </div>

          <div class="col-md-4 mt-3">
           <button type="submit" class="btn btn-danger">Pilih</button>
          </div>
        </div>
    </form>
    <div class="row">
      <div class="col-md-12 card">
          @include('intern.inc.message')
          <div class="card-header">
            <i><b>

              Detail Ekspor Karantina Hewan

              , <span id="wilkerSelect">{{ $userWilker }}</span>

              Bulan <span id="monthSelect">{{ $bulan }}</span>

              Tahun <span id="yearSelect">{{ $tahun }}</span>

            </b></i>
          </div>
          <div class="card-body">
             <table class="table table-responsive table-bordered w-100 d-block d-md-table" id="eksporkh">
              <thead>
              	@foreach($titles as $title)
              		<th>{{ ucwords(str_replace('_', ' ', $title)) }}</th>
              	@endforeach
              </thead>
           </table>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <a href="{{ route('show.statistik.operasional.kh') }}" class="btn btn-primary"><i class="fa fa-angle-double-left"></i> kembali</a>
      </div>
    </div>
  </div>
</main>

@endsection

@section('script')

  <script>

    $(document).ready(function() {

      let container = $('#eksporkh');

      let year = $('#year').val();

      let month = $('#month').val();

      let monthName = $('#month option:selected').text();

      let wilker = {{ $userWilker }};

      let wilkerName = $('#wilker option:selected').text();

      datatablesOperasional(
        container, 
        '{{ route('api.kh.statistik.detail.bigtable.ekspor') }}/' + year + '/' + month + '/' + wilker, 
        'kh'
      );

      $('#yearSelect').html(`${year}`);

      $('#monthSelect').html(`${monthName}`);

      $('#wilkerSelect').html(`${wilkerName}`);

      $('#change_data').on('submit', function(e){

        e.preventDefault()

        container.DataTable().destroy();

        year = $('#year').val();

        month = $('#month').val();

        monthName = $('#month option:selected').text();

        wilker = $('#wilker').val();

        wilkerName = $('#wilker option:selected').text();

        $('#yearSelect').html(`${year}`);

        $('#monthSelect').html(`${monthName}`);

        $('#wilkerSelect').html(`${wilkerName}`);

        if (year != '' && month == '' && wilker == '') {

          datatablesOperasional(container, 
            '{{ route('api.kh.statistik.detail.bigtable.ekspor') }}/' + year, 
          'kh');

        } else if(year != '' && month != '' && wilker == '') {

          datatablesOperasional(container, 
            '{{ route('api.kh.statistik.detail.bigtable.ekspor') }}/' + year + '/' + month, 
          'kh');

        } else {

          datatablesOperasional(container, 
            '{{ route('api.kh.statistik.detail.bigtable.ekspor') }}/' + year + '/' + month + '/' + wilker, 
          'kh');

        }

      });

    });

  </script>

@endsection