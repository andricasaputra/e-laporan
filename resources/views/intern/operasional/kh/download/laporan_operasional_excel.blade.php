<!DOCTYPE html>
<html>
<head></head>
<body>

	{{-- judul laporan --}}
	LAPORAN KEGIATAN OPERASIONAL KARANTINA HEWAN <br>

	{{ strtoupper($datas['wilker']) }} <br>

	PERMOHONAN : {{ strtoupper($datas['permohonan']) }} <br>

	{{ empty($datas['bulan']) ? '' : 'BULAN : '. strtoupper($datas['bulan']) }} TAHUN : {{ $datas['tahun'] }} <br>

	<br>
	
	<table>
		{{-- table header --}}
		<tr>
			
			@foreach($datas['headers'] as $header)

				<th style="text-align: center;border: 1px solid #000">{{ $header }}</th>

			@endforeach

		</tr>
		{{-- end table header --}}


		{{-- table body --}}
		@if(count($datas['bodies']) > 0)

			@foreach($datas['bodies'] as $no => $body)
					
				<tr>
					
					<td valign="middle" style="text-align: center;border: 1px solid #000">{{ $no + 1 }}</td>

					@foreach($body->getAttributes() as $key => $value)
					
						<td valign="middle" style="text-align: center;border: 1px solid #000">{{ $value }}</td>

					@endforeach

				</tr>
				
			@endforeach

		@else

			<tr>

				<td valign="middle" colspan="37" style="font-weight: bold;text-align: center;border: 1px solid #000">
				NIHIL
				</td>

			</tr>

		@endif

		{{-- membuat tambahan row --}}
		@for($i=1; $i < 5; $i++)
			<tr>
				<td></td>
			</tr>
		@endfor

		{{-- end table body --}}

		{{-- jumlah pnbp & komoditi section --}}
		<tr>
			<td></td>
			<td colspan="5" style="font-weight: bold;text-align: left;font-size: 22">
				Jumlah Imbalan Jasa Karantina 
				{{ empty($datas['bulan']) ? '' : 'Bulan '. ucfirst($datas['bulan']) }} 
				Tahun {{ $datas['tahun'] }}
			</td>
			<td style="font-weight: bold;text-align: right;font-size: 16">
				{{ $datas['totalPnbp'] }}
			</td>
		</tr>

		<tr>
			<td></td>
		</tr>

		<tr>
			<td></td>
			<td colspan="5" style="font-weight: bold;text-align: left;font-size: 22">
				Jumlah Komoditi {{ ucwords($datas['permohonan']) }}
				{{ empty($datas['bulan']) ? '' : 'Bulan '. ucfirst($datas['bulan']) }} 
				Tahun {{ $datas['tahun'] }}
			</td>
			@if(count($datas['totalVolume']) === 0)
				<td style="font-weight: bold;text-align: right;font-size: 16">0</td>
			@else
				@foreach($datas['totalVolume'] as $totalVolume)
					<td style="font-weight: bold;text-align: right;font-size: 16">
						{{ $totalVolume->volume == 0 ? '0' : number_format($totalVolume->volume, 0, ',', '.') }} {{ ucwords($totalVolume->satuan) }}
					</td>
				@endforeach
			@endif	
		</tr>

		{{-- end jumlah pnbp & komoditi section --}}

		<tr>
			<td></td>
		</tr>

		{{-- keterangan section --}}
		<tr>
			<td></td>
			<td></td>
			<td colspan="4" style="font-weight: bold;text-align: center;font-size: 18">
				{{ count($datas['bodies']) > 0 ? 'KETERANGAN : ' : '' }}
			</td>
		</tr>

		<tr>
			<td></td>
		</tr>

		@foreach($datas['volumeKomoditi'] as $key => $volumeKomoditi)
			
			<tr>
				<td></td>
				<td></td>
				<td style="text-align: left;font-weight: bold;font-size: 18">{{ ucwords(strtolower($volumeKomoditi['nama_mp'])) }}</td>
				<td style="text-align: center;font-weight: bold;font-size: 18"> = </td>
				<td style="text-align: right;font-weight: bold;font-size: 18">{{ number_format($volumeKomoditi['volume'], 0, ',', '.') }}</td>
				<td style="font-weight: bold;text-align: center;font-size: 18">{{ ucwords($volumeKomoditi['satuan']) }}</td>
			</tr>

		@endforeach

		{{-- end keterangan section --}}

		{{-- penandatngan section --}}

			{{-- Jika jumlah data array kurang dari 4, maka penandatangan terletak dibawah 
				/ setelah keterangan --}}

		<tr>
			<td></td>
		</tr>
		<tr>
			@for($i=1; $i < 28; $i++)
				<td></td>
			@endfor
			<td colspan="6" style="font-weight: bold;text-align: center;font-size: 34">Sumbawa Besar, {{ date('d/m/Y') }} </td>
		</tr>
		<tr>
			@for($i=1; $i < 28; $i++)
				<td></td>
			@endfor
			<td colspan="6" style="font-weight: bold;text-align: center;font-size: 34">{{ $datas['signatory']->jabatan->jabatan }} </td>
		</tr>
		<tr>
			<td style="height: 200"></td>
		</tr>
		<tr>
			@for($i=1; $i < 28; $i++)
				<td></td>
			@endfor
			<td colspan="6" style="font-weight: bold;text-align: center;font-size: 34">{{ $datas['signatory']->nama }} </td>
		</tr>
		<tr>
			@for($i=1; $i < 28; $i++)
				<td></td>
			@endfor
			<td colspan="6" style="font-weight: bold;text-align: center;font-size: 34">{{ $datas['signatory']->nip }}</td>
		</tr>

		{{-- end penandatngan section --}}

	</table>

</body>
</html>

