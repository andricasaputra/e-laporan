@extends('intern.layouts.admin')

@section('title', 'E-IKM | Home')

@section('barside.title', 'IKM Sumbawa')

@section('content')

<style>

  div.give-padding{
    display: none;
  }

  @media only screen and (max-width: 700px){
    div.give-padding{
      display: block;
      margin-bottom: 10px
    }
  }
  
</style>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="page-title">
	  <div class="title_left">
	    <h3>Hasil Survey IKM</h3>
	  </div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_content">
      <div class="row">
        
        <div class="col-md-2">
          <div class="form-group">
            <label>Pilih Periode IKM</label>
              <select class="form-control" name="ikm_id" id="ikm_id">
               
                <option disabled selected>-- Pilih Periode IKM --</option>
                @foreach($ikm as $i)
                  <option value="{{ $i->id }}">{{ $i->keterangan }}</option>
                @endforeach

              </select>
              
            </div>

        </div>

        <div class="col-md-2"></div>

        <div class="col-md-8">
          <div class="form-group pull-right">
              <a href="{{ route('intern.ikm.statistik.index') }}" class="btn btn-primary">
                <i class="fa fa-area-chart"></i> Rekapitulasi IKM
              </a>
              <div class="give-padding"></div>
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-print"></i> Cetak Rekapitulasi Responden
              </button>
              {{-- <a href="{{ route('intern.ikm.home.masscetak', $ikmId) }}" class="btn btn-primary" target="_blank">
                <i class="fa fa-print"></i> Cetak Rekapitulasi Responden
              </a> --}}
          </div>
        </div>
      </div>
	    <table id="adminHomeIkm" class="table table-striped table-bordered text-center" width="100%">
	      <thead>
	        <tr>
	          <th>No</th>
            <th>Periode</th>
	          <th>Responden ID</th>
	          <th>Layanan</th>
	          <th>Jenis Kelamin</th>
	          <th>Umur</th>
	          <th>Pendidikan</th>
	          <th>Pekerjaan</th>
            <th>Waktu Survey</th>
            <th>Nilai Rata-rata</th>
	          <th>Action</th>
	        </tr>
	      </thead>
	    </table>
	  </div>
	</div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDeleteIkm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
      	<h3>Apakah Anda Yakin Ingin Meghapus Data Ini?</h3><br>
        <form action="{{route('intern.ikm.home.destroy', 'delete')}}" method="post">

	  		  @csrf
        	@method('DELETE')

        	<input type="hidden" name="id" id="ikmId">
        	
        	<input type="submit" name="delete" value="Ya" class="btn btn-primary">

        	<button type="button" class="btn btn-success" data-dismiss="modal">Tidak</button>
	  	</form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('intern.ikm.home.masscetak') }}" method="POST">

        @csrf
        @method('POST')

         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cetak rekapitulasi responden</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row" style="margin-bottom: 30px">
              <div class="col-md-12">
                  <div class="alert alert-info" style="font-weight: 500">
                    <b>Info!</b> Jika jumlah data responden yang akan dicetak lebih dari 20,
                  disarankan untuk cetak secara berkala / dicicil agar proses cetak lebih cepat
                  </div>  
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <input type="hidden" name="jadwal" value="{{ $ikmId }}">
                <label for="halaman_awal">Halaman Awal</label>
                <input type="number" name="halaman_awal" min="1" class="form-control" placeholder="Halaman Awal">
              </div>

              <div class="col-md-6">
                <label for="jumlah">Jumlah Halaman</label>
                <input type="number" name="jumlah" min="1" class="form-control" placeholder="Jumlah Halaman">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Cetak</button>
          </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('script')

  <?php $cek = Auth::user()->role->first()->id; ?>

  @if($cek  === 1 || $cek  === 2 || $cek  === 3)

    <script>
    
      $(document).ready(function() {

        $('#ikm_id').on('change', function(){

          let ikm_id = $(this).val();

          window.location = '{{ route('intern.ikm.home.index') }}/' + ikm_id;

        });

        let url = '{{ route('api.ikm', $ikmId) }}';
        let data = [

          { "data" : "DT_Row_Index", orderable: false, searchable: false},
          { "data" : "ikm[0].keterangan" },
          { "data" : "id" },
          { "data" : "layanan.jenis_layanan" },
          { "data" : "jenis_kelamin" },
          { "data" : "umur.umur" },
          { "data" : "pekerjaan.pekerjaan" },
          { "data" : "pendidikan.pendidikan" },
          { "data" : "created_at" },
          { "data" : ""},
          { "data" : "action" , orderable: false, searchable: false}

      ]

        $('#adminHomeIkm').DataTable({

              "processing": true,
              "serverSide": true,
              "ajax":{
                 "url": url,
                 "method": "POST",
                 "dataType": "JSON"
              },
              "columns": data,
              "columnDefs": [{
                  "defaultContent": "-",
                  "targets": "_all"
              }]

          });

      });

      $(document).on('click', '#deleteIkm', function(e){

          e.preventDefault();
          let id = $( this ).data( 'id' );

          $('#modalDeleteIkm').modal('show');

          let idInForm = $("#modalDeleteIkm #ikmId").val(id);

      });
    </script>

  @else

    <script>
    
      $(document).ready(function() {

        $('#ikm_id').on('change', function(){

          let ikm_id = $(this).val();

          window.location = '{{ route('intern.ikm.home.index') }}/' + ikm_id;

        });

        let url = '{{ route('api.ikm', $ikmId) }}';
        let data = [

          { "data" : "DT_Row_Index", orderable: false, searchable: false},
          { "data" : "ikm[0].keterangan" },
          { "data" : "id" },
          { "data" : "layanan.jenis_layanan" },
          { "data" : "jenis_kelamin" },
          { "data" : "umur.umur" },
          { "data" : "pekerjaan.pekerjaan" },
          { "data" : "pendidikan.pendidikan" },
          { "data" : "created_at" },
          { "data" : ""},
          { "data" : "-" , orderable: false, searchable: false}

      ]

        $('#adminHomeIkm').DataTable({

              "processing": true,
              "serverSide": true,
              "ajax":{
                 "url": url,
                 "method": "POST",
                 "dataType": "JSON"
              },
              "columns": data,
              "columnDefs": [{
                  "defaultContent": "-",
                  "targets": "_all"
              }]

          });

      });

      $(document).on('click', '#deleteIkm', function(e){

          e.preventDefault();
          let id = $( this ).data( 'id' );

          $('#modalDeleteIkm').modal('show');

          let idInForm = $("#modalDeleteIkm #ikmId").val(id);

      });
    </script>

  @endif

  

@endsection