@extends('intern.layouts.admin')

@section('title', 'E-IKM | Statistik')

@section('barside.title', 'IKM Sumbawa')

@section('content')

<style>
	table tr td:nth-of-type(2), table tr td:nth-of-type(3){
		text-align: left;
	}
</style>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="page-title">
	  <div class="title_left">
	    <h3>Rekapitulasi Hasil Survey {{ $ikm_ket->keterangan }}</h3>
	  </div>
	</div>
</div>

<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	 <div class="col-sm-3">
		<div class="row">
			<label for="select_ikm">Pilih IKM</label>
			<select name="select_ikm" id="select_ikm" class="form-control">
				<option disabled selected>-- Pilih Periode IKM --</option>
				@foreach($ikm as $i)
					<option value="{{ $i->id }}">{{ $i->keterangan }}</option>
				@endforeach
			</select>
		</div>
	  </div>
	  <div class="x_content">
	  	<table id="statistik" class="table table-stripped text-center">
	  		<thead>
	  			<th>No</th>
	  			<th>Pertanyaan</th>
	  			<th>Unsur Pelayanan</th>
	  			<th>Nilai NRR per unsur</th>
	  			<th>Nilai NRR per unsur dibagi jumlah responden</th>
	  			<th>NRR tertimbang per unsur</th>
	  		</thead>
	  		<tbody></tbody>
	  	</table>
	  	<div id="unit_pelayanan"></div>
	  </div>
	</div>
</div>


@endsection

@section('script')

<script>
	$(document).ready(function(){

		let url = '{{ route('api.statistik', $id) }}';

		$('#select_ikm').on('change', function(){

			let id = $(this).val();

			if(id != ''){

				window.location = '{{ route('intern.ikm.statistik.index') }}/'+ id

			}
		});

		$('#statistik').DataTable({
			"ajax":{
	            "url": url,
	            "dataType": "JSON"
            },
	        "paginate" : false,
	        "lengthChange" : false,
	        "order" : false,
	        "searching": false,
	        "bInfo": false,
	        "pageLength" : 15,
	        "language": {
			    "zeroRecords": "Data tidak ditemukan"
			},
	        "columns": [
	            { "data": "DT_Row_Index" },
	            { "data": "allQuestions" },
	            { "data": "unsurPelayanan" },
	            { "data": "totalNilai" },
	            { "data": "rataRataNrr" },
	            { "data": "rataRataPerUnsurPelayanan" }
	        ]
	    });

	   $.ajax({

	   	url : url

	   }).done(function(response){

	   	let sum = [];

	   	$.each(response.data, function(key, value){

	   		sum.push(parseFloat(value.rataRataPerUnsurPelayanan));

	   	});
	   
   		function getSum(total, num) {

		    return total + num;

		}

		let total = sum.reduce(getSum);

		let unsurPelayanan = total * 25;

		let kriteria = '';

		switch(true) {
	        case unsurPelayanan > 88.31:
	            kriteria = '<span style="color: #009900">A (Sangat Baik)</span>';
	            break;
	        case unsurPelayanan > 76.61:
	            kriteria = '<span style="color: #009900">B (Baik)</span>';
	            break;
	        case unsurPelayanan > 65.00:
	            kriteria = '<span style="color: #cc2900">C (Kurang Baik)</span>';
	            break;
	        default: 
	        	kriteria = '<span style="color: #cc2900">D (Tidak Baik)</span>'
	            break;
	    }

   		$("#unit_pelayanan").html(`

   			<h4><b>- Total NRR Tertimbang Per Unsur Pelayanan :  ${total.toFixed(3)}<sup>*</sup>  </b></h4>
   			<hr>
   			<h3><b>- IKM Unit Pelayanan :  ${unsurPelayanan.toFixed(3)}<sup>**</sup> <i>${kriteria}</i> </b></h3>
   			<hr>
   			<h5>Keterangan : </h5>
   			<table class="table">
   				<tr>
   					<td>U1 s/d U9</td>
   					<td>:</td>
   					<td>Unsur Pelayanan</td>
   				</tr>
   				<tr>
   					<td>NRR</td>
   					<td>:</td>
   					<td>Nilai rata-rata</td>
   				</tr>
   				<tr>
   					<td>IKM</td>
   					<td>:</td>
   					<td>Indeks Kepuasan Masyarakat</td>
   				</tr>
   				<tr>
   					<td>*)</td>
   					<td>:</td>
   					<td>Jumlah NRR IKM tertimbang</td>
   				</tr>
   				<tr>
   					<td>**)</td>
   					<td>:</td>
   					<td>Jumlah NRR IKM tertimbang x 25</td>
   				</tr>
   				<tr>
   					<td>NRR Per Unsur</td>
   					<td>:</td>
   					<td>Jumlah nilai per unsur dibagi jumlah kuisioner</td>
   				</tr>
   				<tr>
   					<td>NRR tertimbang per unsur</td>
   					<td>:</td>
   					<td>NRR per unsur x 0,111</td>
   				</tr>
   				<tr>
   					<td colspan="3" class="text-right">
   						<a href="{{ route('intern.ikm.statistik.cetak', $id) }}" class="btn btn-primary" target="_blank">
   							<i class="fa fa-print fa-fw"></i> Cetak Rekapitulasi IKM
   						</a>
   					</td>
   				</tr>
   			</table>
   		`)
	   });

	});
</script>

@endsection

