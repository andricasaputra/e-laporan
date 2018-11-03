@extends('intern.layouts.admin')

@section('title', 'Home')

@section('barside.title', 'IKM Sumbawa')

@section('content')

<style type="text/css">
	table td:not(:first-of-type){
		text-align: left;
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
	  <div class="x_title">
		<a href="{{ route('intern.ikm.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
		<ul class="nav navbar-right panel_toolbox">
		  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		  </li>
		</ul>
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">
	  	<div id="info_responden"></div>
	    <table id="adminShowIkm" class="table table-striped table-bordered text-center" width="100%">
	      <thead>
	        <tr>
	          <th>No</th>
	          <th>Pertanyaan</th>
	          <th>Jawaban</th>
	          <th>Nilai</th>
	        </tr>
	      </thead>
	    </table>
	  </div>
	</div>
</div>

</div>

@endsection

@section('scripts')

  <script>

    $(document).ready(function() {

    	let url = '{{ route('api.show', $responden->id) }}';

    	let data = [

	    	{ "data" : "DT_Row_Index", orderable: false, searchable: false},
	        { "data" : "question.question" },
	        { "data" : "answer.answer" },
	        { "data" : "answer.nilai" }

		]

	    $('#adminShowIkm').DataTable({

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

        $.ajax({

        	url : url

        }).done(function(result){
        	
        	$('#info_responden').html(

        	`<h4>IKM Periode: ${result.data[0].ikm.keterangan}</h4>
        	<h4>ID Responden: ${result.data[0].responden.id}</h4>
        	`

        );
        });

  	});

  </script>

@endsection