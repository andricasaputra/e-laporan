<!DOCTYPE html>
<html>
	<head></head>
	<body>

		{{-- judul laporan --}}
		LAPORAN KEGIATAN OPERASIONAL KARANTINA TUMBUHAN <br>
		
		{{ strtoupper($datas['wilker']) }} <br>
		
		PERMOHONAN : {{ strtoupper($datas['permohonan']) }} <br>
		
		{{ empty($datas['bulan']) ? '' : 'BULAN : '. strtoupper($datas['bulan']) }} TAHUN : {{ $datas['tahun'] }} <br>
		
		<br>
		
		<table>
			{{-- table header --}}
			<tr>
				
				@foreach($datas['headers'] as $header)
				
					<th valign="middle">{{ $header }}</th>
				
				@endforeach
				
			</tr>
			{{-- end table header --}}
			
			{{-- table body --}}
			@forelse($datas['bodies'] as $body)
			
				<tr>
					<td valign="middle">{{ $loop->index + 1 }}</td>
					
					@foreach($body->getAttributes() as $key => $value)
					
						<td valign="middle">{{ $value ?? '-' }}</td>
					
					@endforeach
				</tr>
			
			@empty
			
				<tr>
					<td valign="middle" colspan="36">
						NIHIL
					</td>
				</tr>
			
			@endforelse
			
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
				<td colspan="5">
					Jumlah Imbalan Jasa Karantina
					{{ empty($datas['bulan']) ? '' : 'Bulan '. ucfirst($datas['bulan']) }}
					Tahun {{ $datas['tahun'] }}
				</td>
				<td>
					{{ $datas['totalPnbp'] }}
				</td>
			</tr>
			
			<tr>
				<td></td>
			</tr>
			
			<tr>
				<td></td>
				<td colspan="5">
					Jumlah Komoditi {{ ucwords($datas['permohonan']) }}
					{{ empty($datas['bulan']) ? '' : 'Bulan '. ucfirst($datas['bulan']) }}
					Tahun {{ $datas['tahun'] }}
				</td>
				@if(count($datas['totalVolume']) === 0)
					<td>0</td>
				@else
					@foreach($datas['totalVolume'] as $totalVolume)
						<td>
							{{ $totalVolume->volume == 0 ? '0' : $totalVolume->volume }} {{ ucwords($totalVolume->sat_netto) }}
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
				<td colspan="4">
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
					<td colspan="2">{{ ucwords(strtolower($volumeKomoditi['nama_komoditas'])) }}</td>
					<td> = </td>
					<td>{{ $volumeKomoditi['volume'] }}</td>
					<td>{{ ucwords($volumeKomoditi['sat_netto']) }}</td>
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
				<td colspan="6">Sumbawa Besar, {{ reverse_tanggal_indo(date('d-m-Y')) }}</td>
			</tr>
			<tr>
				@for($i=1; $i < 28; $i++)
					<td></td>
				@endfor
				<td colspan="6">{{ $datas['signatory']->jabatan }} </td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				@for($i=1; $i < 28; $i++)
					<td></td>
				@endfor
				<td colspan="6">{{ $datas['signatory']->nama }} </td>
			</tr>
			<tr>
				@for($i=1; $i < 28; $i++)
					<td></td>
				@endfor
				<td colspan="6">'{{ $datas['signatory']->nip }}</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			
			{{-- end penandatngan section --}}
			
		</table>
		
	</body>
</html>