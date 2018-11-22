<!DOCTYPE html>
<html>
<head>
	<title>Cetak Hasil Survey</title>

	<link href="{{ asset('images/favicon-32x32.png') }}" rel="icon">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

	<style type="text/css">

		#document_print {

			display: none;
    		font-family: Arial, Helvetica, sans-serif;

		}

		h2, h3{

			font-weight: bold;
			margin-bottom: -1px

		}

		div.wrap{
			width: 400px;
			display: inline-block
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
			<p>stakabadas@gmail.com - (0371) 2629152 - www.skkp1sumbawabesar.org</p>
			<hr size="1" style="border: solid 0.1px #000">
		</div>
		<div class="col-12 mt-5">
			<b style="font-size: 18px;">Data Responden</b>
			<table class="table table-bordered mt-2">
				<tr>
					<td>Jenis Layanan</td>
					<td><b>{{ $responden->layanan->jenis_layanan }}</b></td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td><b>{{ $responden->jenis_kelamin }}</b></td>
				</tr>
				<tr>
					<td>Umur</td>
					<td><b>{{ $responden->umur->umur }}</b></td>
				</tr>
				<tr>
					<td>Pendidikan Terakhir</td>
					<td><b>{{ $responden->pendidikan->pendidikan }}</b></td>
				</tr>
				<tr>
					<td>Pekerjaan Utama</td>
					<td><b>{{ $responden->pekerjaan->pekerjaan }}</b></td>
				</tr>
			</table>
			
		</div>

		<div class="col-12 mt-3">
			<b style="font-size: 18px;">Pendapat Responden Tentang Kualitas Pelayanan</b>
			<ol class="mt-2">

				@php $no = 0 @endphp

				@foreach($question_answer as $question)

					<h5 class="mb-3"><li> {{ $question->question }} </li></h5>

						@php $answer = $answers[$no++]->answer @endphp

		  				@foreach($question->question_answer as $key => $j)

		  					@if($j->answer == $answer)

		  						<div class="wrap" style="text-decoration: underline;"><h5><b>{{ $key + 1 }}. {{ $j->answer }}</b></h5></div>

		  					@else

		  						<div class="wrap"><h5>{{ $key + 1 }}. {{ $j->answer }}</h5></div>

		  					@endif

						@endforeach	

				@endforeach
				
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