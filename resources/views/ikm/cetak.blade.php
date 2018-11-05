<!DOCTYPE html>
<html>
<head>
	<title>Cetak Hasil Survey</title>

	<link href="{{ asset('images/favicon-32x32.png') }}" rel="icon">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

	<style type="text/css">

		#document_print {

    		font-family: Arial, Helvetica, sans-serif;

		}

		h2, h3{

			font-weight: bold;
			margin-bottom: -1px

		}

		@media print {

		    #document_print {

		       display: block;

		    }
		}

	</style>
	
</head>
<body>

<div id="document_print">

	<div class="col-12">
		<img src="{{ asset('images/web-sumbawa4x.png') }}" style="width: 120px">
		<div class="text-center" style="margin-top: -10%">
			<h2>Badan Karantina Pertanian</h2>
			<h3>Stasiun Karantina Pertanian Kelas I Sumbawa Besar</h3>
			<p style="font-size: 14pt;margin-bottom: -1px">Jln. Pelabuhan Badas No. 01 Sumbawa Besar</p>
			<p>stakabadas@gmail.com | www.skkp1sumbawabesar.org</p>
			<hr size="1" style="border: solid 0.1px #000">
		</div>
		<div class="col-12 mt-5">
			<b style="font-size: 18px;">Data Responden</b>
			<table class="table table-bordered">
				<tr>
					<td>Jenis Layanan</td>
					<td>{{ $responden->layanan->jenis_layanan }}</td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td>{{ $responden->jenis_kelamin }}</td>
				</tr>
				<tr>
					<td>Umur</td>
					<td>{{ $responden->umur->umur }}</td>
				</tr>
				<tr>
					<td>Pendidikan Terakhir</td>
					<td>{{ $responden->pendidikan->pendidikan }}</td>
				</tr>
				<tr>
					<td>Pekerjaan Utama</td>
					<td>{{ $responden->pekerjaan->pekerjaan }}</td>
				</tr>
			</table>
			
		</div>

		<div class="col-12 mt-5">
			<b style="font-size: 18px;">Pendapat Responden Tentang Kualitas Pelayanan</b>
			<ol>
				@php $no = 1 @endphp
				@for($i = 0; $i < count($responden->question); $i++)
		  			<h5 class="mb-3"><li> {{ $responden->question[$i]->question }} </li></h5>
			  		<h5 class="mb-3"><b>{{ $responden->answer[$i]->answer }}</b></h5>
	  			@endfor	
			</ol>
		</div>

		<hr>

		<div class="col-12">
			<p>
				Terimakasih Bapak/Ibu/Saudara telah bersedia mengisi lembar survei ini.
				<br>
				Mohon lembar survey evaluasi yang telah diisi diserahkan kembali kepada petugas infoguide
			</p>
			
		</div>

	</div>

</div>

<script>

	window.onload = function() { 

		window.print()

	}

</script>
</body>
</html>