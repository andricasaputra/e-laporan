@if($datas['table_body']->kepala === null)

<script>
	window.location = '{{ route('intern.ikm.statistik.index') }}'
</script>

<?php exit; ?>
@endif

<!DOCTYPE html>
<html>
<head>
	<title>Rekapitulasi Indeks Kepuasan Masyarakat</title>
	<style>
		body{
			font-family: Arial, sans-serif;
		}

		h3{
			text-align: center;
			font-weight: normal;
		}

		table.head{
			margin: auto;
		}

		table.head th, table.head td{
			border: none;
			text-align: left;
			font-size: 11pt;
		}

		table.main{
			width: 100%;
			border-collapse: collapse;
			text-align: center;
			font-size: 9pt;
			margin: 3% 0;
		}

		table.main th, table.main td{
			border: solid 1px black;
			padding: 10px 5px;
		}

		table.main th{
			background-color: #eee;
		}

		div.left-ket{
			width: 50%;
			float: left;
			font-size: 8pt
		}

		div.right-ket{
			width: 50%;
			float: right;
			font-size: 8pt;
		}

		div.right-ket > table{
			border: solid 1px #000;
		}

		div.clear{
			margin-bottom: 3%;
			clear: both;
		}
	</style>
</head>
<body>
	
	<h3>{{ strtoupper('Pengolahan Indeks Kepuasan Masyarakat Per Responden dan unsur pelayanannya') }}</h3>
	<table class="head">
		<tr>
			<td style="width: 200px">Unit Pelayanan</td>
			<td style="width: 40px">:</td>
			<td>Stasiun Karantina Pertanian Kelas I Sumbawa Besar</td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td>:</td>
			<td>Jl. Pelabuhan Badas No.01 Sumbawa Besar</td>
		</tr>
		<tr>
			<td>Tlp/Fax</td>
			<td>:</td>
			<td>(0371) 2629152</td>
		</tr>
	</table>
	<table class="main">
		<thead>
			<tr>
				@foreach($datas['table_header'] as $header)
					<th>{{ $header }}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@php $no = 1 @endphp
			@foreach($datas['table_body']->nilai as $body)
				<tr>
					<td>{{ $no++ }}</td>
					@foreach($body as $b)
						<td>{{ $b->answer->nilai }}</td>
					@endforeach
				</tr>
			@endforeach
			<tr>
				<td>{{ 'NRR Per Unsur' }}</td>
				@foreach($datas['table_body']->nrr as $body)
					<td>{{ $body['nrr'] }}</td>
				@endforeach
			</tr>
			<tr>
				<td>{{ 'NRR Per Unsur' }}</td>
				@foreach($datas['table_body']->nrr as $body)
					<td>{{ number_format((float)$body['rata_nrr'], 3, '.', '') }}</td>
				@endforeach
			</tr>
			<tr>
				<td>{{ 'NRR Tertimbang Per Unsur' }}</td>
				@foreach($datas['table_body']->nrr as $body)
					<td>{{ number_format((float)$body['nrr_perunsur'], 3, '.', '') }}</td>
				@endforeach
			</tr>
			<tr>
				<td>{{ 'Jumlah NRR IKM Tertimbang' }}<sup>*)</sup></td>
				@php $arr = []  @endphp
				@foreach($datas['table_body']->nrr as $body)
					@php $arr[] = $body['nrr_perunsur']  @endphp
					@if(count($arr) == 9)
						<td style="border-left: none;">{{ number_format((float)array_sum($arr), 3, '.', '') }}</td>
					@else
						<td style="border: none; border-bottom: 1px solid #000"></td>
					@endif
				@endforeach
			</tr>
			<tr>
				<td><b>{{ 'IKM Unit Pelayanan' }}<sup>**)</sup></b></td>
				@php $arr = []  @endphp
				@foreach($datas['table_body']->nrr as $body)
					@php $arr[] = $body['nrr_perunsur']  @endphp
					@if(count($arr) == 9)
						<td style="border-left: none;"><b>{{ number_format((float)array_sum($arr) * 25, 3, '.', '') }}</b></td>
					@else
						<td style="border: none; border-bottom: 1px solid #000"></td>
					@endif
				@endforeach
			</tr>
		</tbody>
	</table>

	<div class="left-ket">
		Keterangan : <br>
		<table>
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
				<td>Jumlah NRR Tertimbang x 25</td>
			</tr>
			<tr>
				<td>NRR Per Unsur</td>
				<td>:</td>
				<td>JUmlah nilai per unsur dibagi jumlah kuisioner terisi</td>
			</tr>
			<tr>
				<td>NRR tertimbang per unsur</td>
				<td>:</td>
				<td>NRR per unsur x 0,111</td>
			</tr>
		</table>
	</div>
	<div class="right-ket">
		<table>
			<thead>
				<tr>
					<th>No</th>
					<th>Unsur Pelayanan</th>
					<th>Nilai Rata-rata</th>
				</tr>
			</thead>
			<tbody>
				
				@foreach($datas['table_body']->nrr as $body)

					<tr>

						@php 

						$x = explode('-', $body['unsur_pelayanan']);

						@endphp
						
						<td>{{ $x[0] }}</td>
						<td>{{ $x[1] }}</td>
						<td style="text-align: center;">{{ $body['rata_nrr'] }}</td>

						</tr>

				@endforeach
			</tbody>
		</table>
	</div>
	<div class="clear">&nbsp;</div>
	<div class="left-ket">
		<table>
			<tr>
				<td><b>IKM UNIT PELAYANAN</b></td>
				<td>:</td>
				@php $arr = []  @endphp
				@foreach($datas['table_body']->nrr as $body)
					@php $arr[] = $body['nrr_perunsur']  @endphp
				@endforeach
				<td><b>{{ array_sum($arr) * 25 }}</b></td>
			</tr>
			<tr>
				<td>Mutu Pelayanan : </td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>A (Sangat Baik)</td>
				<td>:</td>
				<td>88,31 - 100,00</td>
			</tr>
			<tr>
				<td>B (Baik)</td>
				<td>:</td>
				<td>76,61 - 88,30</td>
			</tr>
			<tr>
				<td>C (Kurang Baik)</td>
				<td>:</td>
				<td>65,00 - 76,60</td>
			</tr>
			<tr>
				<td>D (Tidak Baik)</td>
				<td>:</td>
				<td>25,00 - 64,99</td>
			</tr>
		</table>
	</div>
	<div class="right-ket">
		<table style="border: none; margin-left: 70px">
			<tr>
				<td style="padding-bottom: 80px;text-align: center;">Kepala Stasiun,</td>
			</tr>
			<tr>
				<td style="text-align: center;"><b>{{ $datas['table_body']->kepala->nama }}</b></td>
			</tr>
			<tr>
				<td style="text-align: center;"><b>NIP. {{ $datas['table_body']->kepala->nip }}</b></td>
			</tr>
		</table>
	</div>

</body>
</html>