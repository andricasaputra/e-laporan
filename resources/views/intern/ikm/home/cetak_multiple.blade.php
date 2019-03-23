<?php

if(empty($datas->responden->all()) || is_null($datas->responden)):
	
	 header('Location: ikm');

endif;

?>

<style type="text/css">
	h2, h3{
		font-weight: bold;
		margin-bottom: -30px
	}

	li div.wrap{
		display: inline-block
	}

	table.table-info, table.table-info th, table.table-info td{
		border: solid 1px  #a6a6a6;
		border-collapse: collapse;
		
	}

	table.table-info tr td{
		padding-top: 5px;
		padding-bottom:  5px;
		width: 170px;
		padding-left: 5px;
		padding-right: 30px
	}

	hr {
        border: none;
        height: 1px;
        color: black; 
        background-color: black;
    }
</style>

@foreach ($datas->responden as $key => $value)

	<page backtop="7mm" backbottom="7mm" backleft="5mm" backright="5mm">

		<page_header>

			<img src="{{ asset('images/web-sumbawa4x.png') }}" style="width: 90px;position: relative;">

			<div style="margin:auto; position: relative; text-align: center; margin-left: -200px">

				<h3 style="margin-bottom: -10px">Badan Karantina Pertanian</h3>

				<h4 style="margin-bottom: -10px">Stasiun Karantina Pertanian Kelas I Sumbawa Besar</h4>

				<p style="margin-bottom: -10px">Jln. Pelabuhan Badas No. 01 Sumbawa Besar</p>

				<p>stakabadas@gmail.com - (0371) 2629152 - www.skkp1sumbawabesar.org</p>

			</div>

			<hr>

		</page_header>

		<page_footer> 

	        <hr>

			<p style="text-align: center;">
				Terimakasih Bapak/Ibu/Saudara telah bersedia mengisi lembar survei ini.
				<br>
				Mohon lembar survey evaluasi yang telah diisi diserahkan kembali kepada petugas infoguide
			</p>
				
	    </page_footer> 

	    <div class="judul" style="margin-top: 120px;text-align: center;">
	    	<b style="font-size: 16px;">Data Responden</b>
	    </div>		

		<table class="table-info" style="margin-top: 20px">
			<tr>
				<td >Jenis Layanan</td>
				<td style="text-align: center;">:</td>
				<td><b>{{ $value->layanan->jenis_layanan }}</b></td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td style="text-align: center;">:</td>
				<td><b>{{ $value->jenis_kelamin }}</b></td>
			</tr>
			<tr>
				<td>Umur</td>
				<td style="text-align: center;">:</td>
				<td><b>{{ $value->umur->umur }}</b></td>
			</tr>
			<tr>
				<td>Pendidikan Terakhir</td>
				<td style="text-align: center;">:</td>
				<td><b>{{ $value->pendidikan->pendidikan }}</b></td>
			</tr>
			<tr>
				<td>Pekerjaan Utama</td>
				<td style="text-align: center;">:</td>
				<td><b>{{ $value->pekerjaan->pekerjaan }}</b></td>
			</tr>
		</table>

		<br/><br/>

		<b style="font-size: 14px;">Pendapat Responden Tentang Kualitas Pelayanan</b>

		<br/>

		<table>
			
			@php $no = 1 @endphp

			@foreach($question_answer as $no2 => $question)

				<tr>
					<td>{{ $no++ }}. </td>

					<td colspan="4">
						<h5 style="font-weight: normal; font-size: 10.5pt"> {{ $question->question }} </h5>
					</td>

				</tr>

				<tr>

					<td></td>

					@foreach($question->question_answer as $key => $j)


						@if($value->answer->all()[$no2]->answer == $j->answer)

							<td style="font-size: 9pt"><b><u>{{ $key + 1 }}. {{ $j->answer }}</u></b></td>

						@else

							<td style="font-size: 9pt">{{ $key + 1 }}. {{ $j->answer }}</td>

						@endif

						
					@endforeach	

				</tr>

			@endforeach
				
		</table>
			
	</page>

@endforeach


