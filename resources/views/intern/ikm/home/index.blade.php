@extends('intern.layouts.admin')

@section('title', 'E-IKM | Home')

@section('barside.title', 'IKM Sumbawa')

@section('content')
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
      <div class="col-md-1">
          <div class="form-group">
            <label>Pilih Tahun</label>
            <select class="form-control" name="year" id="year">
             
              @if(last(request()->segments()) == 'home')

                <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>

              @endif

              @for($i = date('Y') - 3; $i < date('Y') + 2 ; $i++)

                @if(last(request()->segments()) == $i)
        
                  <option value="{{ $i }}" selected>{{ $i }}</option>

                @else

                  <option value="{{ $i }}">{{ $i }}</option>
                  
                @endif

              @endfor

            </select>
            
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

@endsection

@section('script')

  @if(Auth::user()->role_id == 1)

    <script>
    
      $(document).ready(function() {

        $('#year').on('change', function(){

          let year = $(this).val();

          window.location = '{{ route('intern.ikm.home.index') }}/' + year;

        });

        let url = '{{ route('api.ikm', $tahun) }}';
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

        $('#year').on('change', function(){

          let year = $(this).val();

          window.location = '{{ route('intern.ikm.home.index') }}/' + year;

        });

        let url = '{{ route('api.ikm', $tahun) }}';
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