@extends('intern.layouts.app')

@section('title', 'Data Dokumen Operasional KH')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Dokumen Operasional Karantina Hewan</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('showmenu.operasional.kh') }}">Menu</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('kh.dokumen.index') }}">Dokumen</a></li>
            <li class="breadcrumb-item" aria-current="page">Data</li>
        </ol>
    </nav>
</div>

@endsection

@section('content')

<style type="text/css">

  table > thead > tr > th{
    vertical-align: middle !important;
  }

  i.fa-2x {
    display: inline-block;
    border-radius: 80px;
    box-shadow: 0px 0px 2px #888;
    padding: 0.5em 0.6em;
  }

  .fa-plus-circle{
    background-color: #008000;
    color: #fff;
  }


  .fa-file-excel-o{
    background-color: #F24656;
    color: #fff
  }

  .fa-file-archive-o{
    background-color: #16C2D0;
    color: #fff
  }

  .badge{
    padding: 4px 13px !important;
  }
</style>

<div class="row">
  <div class="col">
    @include('intern.inc.message')
  </div>
</div>

<div class="row mb-3">
  <div class="col">
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

                  <option value="{{ $i }}">{{  bulan($i) }}</option>

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

                <option value="{{ $wilker->id }}" selected>{{ $wilker->nama_wilker }}</option>

                @else

                <option value="{{ $wilker->id }}">{{ $wilker->nama_wilker }}</option>

                @endif
                
              @endforeach

            </select>

          </div>

          <div class="col-md-4 mt-3">
           <button type="submit" class="btn btn-danger">Pilih</button>
          </div>
        </div>
    </form>
  </div>
</div> 

<h3>Ringkasan Data Dokumen Tahun : {{ $tahun }}</h3>

<hr>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header mt-3">
        <b>Persediaan Dokumen <i class="fa fa-clock-o"></i></b>
      </div>
      <div class="card-body">
        <table class="table table-responsive table-striped table-bordered text-center w-100 d-block d-md-table table-ringkasan">
          <thead>
            <tr>
              <th>Wilker</th>
              <th>Dokumen</th>
              <th>Jumlah</th>
              <th>No Seri</th>
            </tr>
          </thead>
          <tbody>
            @forelse($datas['persediaan'] as $dok => $bigdata)

              @foreach($bigdata as $wilker => $data) 

                <tr>
                  <td>{{ $wilker }}</td>
                  <td>{{ $dok }}</td>
                  <td>{{ $data->sum('total') }} set</td>
                  <td>
                    @foreach($data as $d)
                    <div>
                      {{ $d['no_seri'] }}
                    </div>
                     @endforeach
                  </td>
                </tr>

              @endforeach

            @empty

              <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
              </tr>

            @endforelse

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <div class="card-header mt-3">
        <b>Penerimaan Dokumen <i class="fa fa-clock-o"></i></b>
      </div>
      <div class="card-body">
        <table class="table table-responsive table-striped table-bordered text-center w-100 d-block d-md-table table-ringkasan">
          <thead>
            <tr>
              <th>Wilker</th>
              <th>Dokumen</th>
              <th>Jumlah</th>
              <th>No Seri</th>
            </tr>
          </thead>
          <tbody>

            @forelse($datas['penerimaan'] as $dok => $bigdata)

              @foreach($bigdata as $wilker => $data) 

                @foreach($data as $d)

                  <tr>
                    <td>{{ $wilker }}</td>
                    <td>{{ $dok }}</td>
                    <td>{{ $d['total'] }}</td>
                    <td>{{ $d['no_seri'] }}</td>
                  </tr>

                 @endforeach

              @endforeach

            @empty

              <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
              </tr>

            @endforelse

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header mt-3">
        <b>Pemakaian Dokumen <i class="fa fa-clock-o"></i></b>
      </div>
      <div class="card-body">
        <table class="table table-responsive table-striped table-bordered text-center w-100 d-block d-md-table table-ringkasan">
          <thead>
            <tr>
              <th>Wilker</th>
              <th>Dokumen</th>
              <th>Jumlah</th>
              <th>No Seri</th>
            </tr>
          </thead>
          <tbody>
            
            @forelse($datas['pemakaian'] as $dok => $bigdata)

              @foreach($bigdata as $wilker => $data)
          
                <tr>
                  <td>{{ $wilker }}</td>
                  <td>{{ $dok }}</td>
                  <td>{{ $data['total'] }}</td>
                  <td>{{ $data['no_seri'] }}</td>
                </tr>

              @endforeach

            @empty

              <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
              </tr>

            @endforelse

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <div class="card-header mt-3">
        <b>Pembatalan Dokumen <i class="fa fa-clock-o"></i></b>
      </div>
      <div class="card-body">
        <table class="table table-responsive table-striped table-bordered text-center w-100 d-block d-md-table table-ringkasan">
          <thead>
            <tr>
              <th>Wilker</th>
              <th>Dokumen</th>
              <th>Jumlah</th>
              <th>No Seri</th>
            </tr>
          </thead>
          <tbody>

            @forelse($datas['pembatalan'] as $data)
  
              <tr>
                <td>{{ $data->wilker->nama_wilker }}</td>
                <td>{{ str_replace(' ', '', $data->dokumen) }}</td>
                <td>{{ $data->total }}</td>
                <td>{{ $data->no_seri }}</td>
              </tr>

            @empty

              <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
              </tr>

            @endforelse

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


@endsection

@section('script')

<script>

  $(document).ready(function(){

    let year = $('#year').val();

    let month = $('#month').val();

    let wilker = $('#wilker').val();

    $('#change_data').on('submit', function(e){

      e.preventDefault();

      year = $('#year').val();

      month = $('#month').val();

      wilker = $('#wilker').val();

      window.location = '{{ route('kh.dokumen.data') }}/' + year + '/' + month + '/' + wilker;

    });

    /*set datatable for ringkasan data dokumen*/
    $('.table-ringkasan').DataTable({
        "order": [[ 1, "asc" ]]
    });

  });/*End Ready*/

</script>

@endsection