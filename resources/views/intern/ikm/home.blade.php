@extends('intern.layouts.admin')

@section('title', 'Home')

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
	    <table id="adminHeadlineTable" class="table table-striped table-bordered text-center" width="100%">
	      <thead>
	        <tr>
	          <th width="3%">No</th>
	          <th width="15%">Judul Headline</th>
	          <th width="25%">Deskripsi</th>
	          <th width="32%">Gambar</th>
	          <th width="7%">Tanggal Dibuat</th>
	          <th width="5%">Status</th>
	          <th width="13%">Action</th>
	        </tr>
	      </thead>
	    </table>
	  </div>
	</div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDeleteHeadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <form action="" method="post">

	  		@csrf
        	@method('DELETE')

        	<input type="hidden" name="id" id="headlineId">
        	
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