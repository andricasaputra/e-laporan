@extends('intern.layouts.app')

@section('title', 'Home Operasional - Halaman Utama')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">Dashboard</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ringkasan Data</li>
        </ol>
    </nav>
</div>

@endsection

@section('content')

<style type="text/css">

</style>

<style type="text/css">
  table td{
    font-size: 12pt;
    font-weight: 600;
  }

  table th, table td:not(:nth-of-type(1)){
    text-align: center;
  }

  i.fa-bar-chart, i.fa-line-chart, i.fa-money, i.fa-book {
    display: inline-block;
    border-radius: 80px;
    box-shadow: 0px 0px 2px #888;
    padding: 0.5em 0.6em;
  }

  .fa-bar-chart{
    background-color: #f73b5e;
    color: #fff
  }

  .fa-line-chart{
    background-color: #2962FF;
    color: #fff;
  }

  .fa-money{
    background-color: #FF8F29;
    color: #fff;
  }

  .fa-book{
    background-color: #12AFAF;
    color: #fff;
  }
</style>

@php 

use App\Http\Controllers\TanggalController as Tanggal; 

use App\Http\Controllers\RupiahController as Rupiah;

@endphp

    @if($dataKh['bulan'] !== null)
      <h3>
        Ringkasan Data Operasional 
        {{ Tanggal::bulan($dataKh['bulan']) }} Tahun {{ $dataKh['tahun'] }}
        {{ $dataKh['wilker'] }}
      </h3>
    @else
      <h3>Ringkasan Data Operasional Tahun {{ $dataKh['tahun'] }}</h3>
    @endif

    <form id="change_data">
      <div class="row mb-3">
        <div class="col-md-4 col-sm-12">
          <label for="year">Pilih Tahun</label>
          <select class="form-control" name="year" id="year">
            @for($i = date('Y') - 3; $i < date('Y') + 2 ; $i++)
        
              @if($i == $dataKh['tahun'])

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
        
              @if($i == $dataKh['bulan'])

                <option value="{{ $i }}" selected>{{ Tanggal::bulan($i) }}</option>

              @else

                <option value="{{ $i }}">{{  Tanggal::bulan($i) }}</option>

              @endif

            @endfor
            
          </select>
        </div>

        <div class="col-md-4 col-sm-12">
          <label for="wilker">Pilih Wilker</label>
          <select class="form-control" name="wilker" id="wilker">

            <option value="">Semua</option>

            @foreach($wilkers as $wilker)

              @if(isset($dataKh['wilker']) && $dataKh['wilker'] == $wilker->nama_wilker)

              <option value="{{ $wilker->id }}" selected>{{ $wilker->nama_wilker }}</option>

              @else

              <option value="{{ $wilker->id }}">{{ $wilker->nama_wilker }}</option>

              @endif
              
            @endforeach

          </select>
        </div>

      </div>

      <div class="row" style="text-align: left;">
        <div class="col-md-4 col-sm-12 mt-3">
         <button type="submit" class="btn btn-danger">Pilih</button>
        </div>
      </div>
    </form>

    <hr>

    <div class="row mt-3">
      <!-- column -->   
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table v-middle">
                        <thead>
                            <tr class="bg-light">
                                <th class="border-top-0">Data</th>
                                <th class="border-top-0">Karantina Hewan</th>
                                <th class="border-top-0">Karantina Tumbuhan</th>
                                <th class="border-top-0">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <i class="fa fa-line-chart"></i>&nbsp;&nbsp;<span style="font-weight: bold;">Frekuensi</span>
                                </td>
                                <td>
                                  {{ collect($dataKh['dataKh']['frekuensiPerKegiatan'])->sum('frekuensi') }} Kali
                                </td>
                                <td>
                                  {{ collect($dataKt['dataKt']['frekuensiPerKegiatan'])->sum('frekuensi') }} Kali
                                </td>
                                <td>
                                    <label class="label label-primary">Berdasarkan Permohonan</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fa fa-bar-chart"></i>&nbsp;&nbsp;<span style="font-weight: bold;">Volume</span>
                                </td>
                                <td>
                                  @foreach(collect($dataKh['dataKh']['totalVolumeBySatuan'])->flatten(1)->collapse() as $key => $volume)

                                   <p>{{ number_format($volume->sum('volume'),0,",",".") ?? 0 }} {{ ucfirst($key) }}</p>

                                  @endforeach
                                </td>
                                <td>
                                  @foreach(collect($dataKt['dataKt']['totalVolumeBySatuan'])->flatten(1)->collapse() as $key => $volume)

                                   <p>{{ number_format($volume->sum('volume'),0,",",".")}} {{ ucfirst($key) }}</p>

                                  @endforeach
                                </td>
                                <td>
                                    <label class="label label-success">Berdasarkan Satuan</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fa fa-money"></i>&nbsp;&nbsp;<span style="font-weight: bold;">PNBP</span>
                                </td>
                                <td>
                                  {{ Rupiah::rp(collect($dataKh['dataKh']['totalPNBP'])->sum('pnbp')) }}
                                </td>
                                <td>
                                  {{ Rupiah::rp(collect($dataKt['dataKt']['totalPNBP'])->sum('pnbp')) }}
                                </td>
                                <td>
                                    <label class="label label-danger">Berdasarkan Sertifikasi</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fa fa-book"></i> &nbsp;&nbsp;<span style="font-weight: bold;">Pemakaian Dokumen</span>
                                </td>
                                <td>
                                  @foreach(collect($dataKh['dataKh']['Dokumen'])->flatten(1)->collapse() as $key => $dokumen)

                                    <p>{{ $dokumen->dokumen }} : {{ $dokumen->total }}</p>

                                  @endforeach
                                </td>
                                <td>
                                  @foreach(collect($dataKt['dataKt']['Dokumen'])->flatten(1)->collapse() as $key => $dokumen)

                                    <p>{{ $dokumen->dokumen }} : {{ $dokumen->total }}</p>

                                  @endforeach
                                </td>
                                <td>
                                    <label class="label label-info">Berdasarkan Sertifikasi</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <label for="frekKh">Pilih Jenis Permohonan</label>
        <select name="frekKh" id="selectCatKh" class="form-control">
          <option value="Domestik Keluar Karantina Hewan">Domestik Keluar</option>
          <option value="Domestik Masuk Karantina Hewan">Domestik Masuk</option>
          <option value="Ekspor Karantina Hewan">Ekspor</option>
          <option value="Impor Karantina Hewan">Impor</option>
        </select>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-8">
          <div class="card">
              <div class="card-body" id="chartFrekuensiKh"></div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="card">
              <div class="card-body">
                  <h4 class="card-title"><i class="fa fa-history" aria-hidden="true"></i> &nbsp;&nbsp;Top 5 Komoditi Karantina Hewan  </h4>
                  <h6>Berdasarkan Frekuensi</h6>
                  <div class="feed-widget">
                      <ul class="list-style-none feed-body m-0 p-b-20">
                        @foreach(collect($dataKh['dataKh']['topFiveFrekuensiKomoditi'])->flatten(1)->sortByDesc('data')->take(5) as $frekuensi)
                          <li class="feed-item">
                            {{ $frekuensi->name }} 
                            <span class="ml-auto font-14 text-muted" style="color: #000 !important; font-weight: bold;">{{ $frekuensi->data }}</span>
                          </li>
                        @endforeach 
                      </ul>
                  </div>
              </div>
          </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <label for="frekKt">Pilih Jenis Permohonan</label>
        <select name="frekKt" id="selectCatKt" class="form-control">
          <option value="Domestik Keluar Karantina Tumbuhan">Domestik Keluar</option>
          <option value="Domestik Masuk Karantina Tumbuhan">Domestik Masuk</option>
          <option value="Ekspor Karantina Tumbuhan">Ekspor</option>
          <option value="Impor Karantina Tumbuhan">Impor</option>
        </select>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-8">
        <div class="card">
            <div class="card-body" id="chartFrekuensiKt"></div>
        </div>
      </div>
      <div class="col-md-4">
          <div class="card">
              <div class="card-body">
                  <h4 class="card-title"><i class="fa fa-history" aria-hidden="true"></i> &nbsp;&nbsp;Top 5 Komoditi Karantina Tumbuhan  </h4>
                  <h6>Berdasarkan Frekuensi</h6>
                  <div class="feed-widget">
                      <ul class="list-style-none feed-body m-0 p-b-20">
                        @foreach(collect($dataKt['dataKt']['topFiveFrekuensiKomoditi'])->flatten(1)->sortByDesc('data')->take(5) as $frekuensi)
                          <li class="feed-item">
                            {{ $frekuensi->name }} 
                            <span class="ml-auto font-14 text-muted" style="color: #000 !important; font-weight: bold;">{{ $frekuensi->data }}</span>
                          </li>
                        @endforeach 
                      </ul>
                  </div>
              </div>
          </div>
      </div>
    </div>

@endsection

@section('script')

<script src="{{ asset('js/highcharts.js') }}"></script>

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

      if (year != '' && month == '' && wilker == '') {

        window.location = '{{ route('show.operasional') }}/' + year;

      } else if(year != '' && month != '' && wilker == '') {

        window.location = '{{ route('show.operasional') }}/' + year + '/' + month;

      } else {

        window.location = '{{ route('show.operasional') }}/' + year + '/' + month + '/' + wilker;

      }

    });

    let khValue = 'Domestik Keluar Karantina Hewan';

    let ktValue = 'Domestik Keluar Karantina Tumbuhan';

    let khUrl = '{{ route('api.kh.detail.frekuensi.chart') }}';

    let ktUrl = '{{ route('api.kt.detail.frekuensi.chart') }}';

    $.ajax({

      url : khUrl + '/' + khValue + '/' + year

    }).done(function(response){

      let dataKh = {

        data : [],
        name : []

      };

      $.each(response, function(key, value){

        dataKh.name.push(value.bln) 
        dataKh.data.push(parseInt(value.data))  

      });

      /*Hightchart colors option*/
      Highcharts.setOptions({
        colors: ['#7460EE']
      });

      /*Chart KH*/
      let chartKh = Highcharts.chart('chartFrekuensiKh', {
        credits : false,
        chart: {
            type: 'column'
        },
        title: {
            text: 'Frekuensi Operasional Karantina Hewan'
        },
        subtitle: {
            text: 'Berdasarkan Sertifikasi'
        },
        xAxis: {
            categories:  dataKh.name,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Frekuensi (kali)'
            }
        },
        tooltip: {
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name:'Frekuensi' ,
            data: dataKh.data
        }]
    });

  });/*End Ajax KH*/

  $.ajax({

      url : ktUrl + '/' + ktValue + '/' + year

    }).done(function(response){

      let dataKt = {

        data : [],
        name : []

      };

      $.each(response, function(key, value){

        dataKt.name.push(value.bln) 
        dataKt.data.push(parseInt(value.data))  

      });

      /*Hightchart colors option*/
      Highcharts.setOptions({
        colors: ['#12AFAF', '#F62D51', '#64E572', '#2962FF']
      });

      /*Chart KH*/
      let chartKt = Highcharts.chart('chartFrekuensiKt', {
        credits : false,
        chart: {
            type: 'column'
        },
        title: {
            text: 'Frekuensi Operasional Karantina Tumbuhan'
        },
        subtitle: {
            text: 'Berdasarkan Sertifikasi'
        },
        xAxis: {
            categories:  dataKt.name,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Frekuensi (kali)'
            }
        },
        tooltip: {
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name:'Frekuensi' ,
            data: dataKt.data
        }]
    });

  });/*End Ajax KT*/


  $('#selectCatKh').change(function(){

      khValue = $('#selectCatKh').val();

      $.ajax({

        url : khUrl + '/' + khValue + '/' + year

      }).done(function(response){

        dataKh = {

          data : [],
          name : []

        };

        $.each(response, function(key, value){

          dataKh.name.push(value.bln) 
          dataKh.data.push(parseInt(value.data))  
     
        });

        $('#chartFrekuensiKh').highcharts().destroy();

        chartKh = Highcharts.chart('chartFrekuensiKh', {
        credits : false,
        chart: {
            type: 'column'
        },
        title: {
            text: 'Frekuensi Operasional Karantina Tumbuhan'
        },
        subtitle: {
            text: 'Berdasarkan Sertifikasi'
        },
        xAxis: {
          categories:  dataKh.name,
          crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Frekuensi (kali)'
            }
        },
        tooltip: {
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
          name:'Frekuensi',
          data: dataKh.data
        }]
      });

    });/*End Ajax Select KH*/

  });/*End Select KH*/


  $('#selectCatKt').change(function(){

    ktValue = $('#selectCatKt').val();

    $.ajax({

      url : ktUrl + '/' + ktValue + '/' + year

    }).done(function(response){

      dataKt = {

        data : [],
        name : []

      };

      $.each(response, function(key, value){

        dataKt.name.push(value.bln) 
        dataKt.data.push(parseInt(value.data))  

      });
      
      $('#chartFrekuensiKt').highcharts().destroy();

        chartKt = Highcharts.chart('chartFrekuensiKt', {
          credits : false,
          chart: {
              type: 'column'
          },
          title: {
              text: 'Frekuensi Operasional Karantina Tumbuhan'
          },
          subtitle: {
              text: 'Berdasarkan Sertifikasi'
          },
          xAxis: {
            categories:  dataKt.name,
            crosshair: true
          },
          yAxis: {
              min: 0,
              title: {
                  text: 'Frekuensi (kali)'
              }
          },
          tooltip: {
              shared: true,
              useHTML: true
          },
          plotOptions: {
              column: {
                  pointPadding: 0.2,
                  borderWidth: 0
              }
          },
          series: [{
            name:'Frekuensi',
            data: dataKt.data
          }]
        });

    });/*End Ajax Select KT*/


  });/*End Select KT*/

  });/*End Ready*/
</script>

@endsection