@extends('intern.layouts.app')

@section('title', 'Data SKP')

@section('barside')

  @include('intern.inc.barside_operasional')

@endsection

@section('page-breadcrumb')

<h4 class="page-title">SKP {{ auth()->user()->pegawai->nama }}</h4>
<div class="d-flex align-items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('show.operasional') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Data SKP</li>
        </ol>
    </nav>
</div>

@endsection

@section('content') 

<style>
   table tr th, table tr td:not(:nth-of-type(1)){
    text-align: center;
  }
/*
  table tr td{
    font-size: 9pt;
   
  }*/

  table tr.active{
    background-color:#eee;
  }
</style>

@if($datas['month'] !== null)

  <h4>
    Data SKP 
    {{ $datas['month'] == 'all' 
        ? '' 
        : 'Bulan ' . bulan($datas['month']) }} 
    Tahun {{ $datas['year'] }}

  </h4>

@else

  <h4>Data SKP Tahun {{ $datas['year'] }}</h4>
  
@endif

<form class="form-inline" id="change_data_epersonal d-flex justify-content-end">
  <div class="form-group mb-2">
     <label for="year">Pilih Tahun</label>
      <select class="form-control" name="year" id="year">
        @for($i = date('Y') - 5; $i < date('Y') + 2 ; $i++)
    
          @if($i == $datas['year'])
            <option value="{{ $i }}" selected>{{ $i }}</option>
          @else
            <option value="{{ date('Y') }}">{{ date('Y') }}</option>
          @endif

        @endfor
      </select>
  </div>
  <div class="form-group mx-sm-3 mb-2">
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
  </div>
  <button type="submit" class="btn btn-danger  pull-right">Pilih</button>
  
</form>

<div class="d-flex justify-content-end w-100 mb-3" >
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-download"></i> Ambil Data SKP dari E-personal</button>
</div>

<div class="row">
    <div class="col-sm-12">

      @include('intern.inc.message')

      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Butir Kegiatan SKP</h4>
         <div class="table-responsive">
            <table class="table table-bordered" id="data-skp" style="width: 100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Tanggal</th>
                  <th>Tahun</th>
                  <th>Bulan</th>
                  <th>Kegiatan</th>
                  <th>Butir Kegiatan</th>
                  <th>Target</th>
                  <th>Angka Kredit</th>
                </tr>
              </thead>
              <tbody></tbody>
          </table>
         </div>
        </div>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ambil Data SKP Tahun {{ date('Y') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span id="closeModal" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
          Aksi ini akan mengambil data SKP anda dari E-Personal untuk tahun berjalan (SKP Aktif)
        </p>

        <h3 class="text-center">Yakin Ingin Melanjutkan?</h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button onClick="getSkp()" type="button" class="btn btn-primary">Lanjutkan</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

 <script>

  let year = $('#year').val();

    let month = $('#month').val();

    $('#change_data_epersonal').on('submit', function(e){

      e.preventDefault();

      year = $('#year').val();

      month = $('#month').val();

      window.location = '{{ route('epersonal.index') }}/' + year + '/' + month;

    });
   
    setDataTable(
      'data-skp', '{{ route('epersonal.table.api') }}/' + year + '/' + month, year, month
    );

    function setDataTable(container, url, year, month){

      let tableId = $('#' + container);

      let table = $('#data-skp').DataTable({

        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax":{
           "url": url
        },
        "columns": [
          {"data" : "DT_Row_Index"},
          { "data" : "user_id" }, 
          { "data" : "tanggal" }, 
          { "data" : "tahun" },
          { "data" : "bulan" },
          { "data" : "judul_kegiatan"}, 
          { "data" : "butir_kegiatan" }, 
          { "data" : "target" },
          {"data" : "bk.ak"},
        ],
        "columnDefs": [{
          "defaultContent": "-",
          "targets": "_all"
        }]

      });
    }/*end function*/

    $('#exampleModal').modal({
      backdrop: false,
      show : false
    });

    function getSkp()
    {
      $.ajax({
        url : '{{ route('epersonal.getskp') }}',
        headers : {
          'X-CSRF-TOKEN' : '{{ csrf_token() }}'
        },
        method : 'POST',
        beforeSend : function(){
          $('#closeModal').html('');
          $('.modal-body').html(`<h3 class="text-center">Sedang mengambil data. <br/> Harap Tunggu...</h3>`);
          $('.modal-footer').html('<i>Kecepatan pengambilan data tergantung dari server epersonal. Jangan tutup browser!</i>');

          $('#exampleModal').modal({
            backdrop: 'static',
            keyboard : false
          });
        },
        success : function(res){
          if (res.success) { 
            location.reload(); 
          }
        },
        error : function(err){
          alert(err);
          console.log(err)
        }
      });

      
    }
 </script>

@endsection