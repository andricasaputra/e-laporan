<!DOCTYPE html>
<html>
<head></head>
<body>
	
	LAPORAN KEGIATAN OPERASIONAL KARANTINA TUMBUHAN <br>
	UPT : STASIUN KARANTINA PERTANIAN KELAS I SUMBAWA BESAR <br>
	PERMOHONAN : {{ strtoupper($permohonan) }} <br>
	{{ empty($bulan) ? '' : 'BULAN : '. strtoupper($bulan) }} TAHUN : {{ $tahun }} <br><br>
	
	<table>

		<tr>
			
			@foreach($headers as $header)

				<td>{{ $header }}</td>

			@endforeach

		</tr>

		@foreach($bodies as $no => $body)
				
			<tr>

				<td valign="middle">{{ $no + 1 }}</td>

				@foreach($body->getAttributes() as $key => $value)

				<td valign="middle">{{ $value }}</td>

				@endforeach

			</tr>
			
		@endforeach


	</table>

</body>
</html>

