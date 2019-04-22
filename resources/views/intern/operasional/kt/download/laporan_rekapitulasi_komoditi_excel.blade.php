<!DOCTYPE html>
<html>
<head></head>
<body>

	{{-- judul laporan --}}
	REKAPITULASI DATA <br>
	
	LAPORAN KEGIATAN OPERASIONAL KARANTINA TUMBUHAN <br>
	
	{{ strtoupper($datas['permohonan']) }} <br>
	
	{{ strtoupper($datas['wilker']) }} <br>
	
	{{ empty($datas['bulan']) ? '' : 'BULAN : '. strtoupper($datas['bulan']) }} TAHUN : {{ $datas['tahun'] }} <br><br>
	
	<table>
		{{-- table header --}}
		<tr>
			
			@foreach($datas['headers'] as $header)
			
				<td>{{ $header }}</td>
			
			@endforeach
			
		</tr>
		
		{{-- table body --}}
		@php $no = 0; @endphp

		@forelse($datas['bodies'] as $subdatas)
			
			@foreach($subdatas as $komoditi => $data)
			
				@if(count($subdatas) === 1 && $komoditi == '')
				
					<tr>
						
						<td>{{ $no += 1 }}</td>
						
						<td>{{ $data['wilker'] }}</td>
						
						<td>Nihil</td>
						
						<td>Nihil</td>
						
						<td>Nihil</td>
						
						<td>Nihil</td>
						
						<td>Nihil</td>
						
						<td>Nihil</td>
						
					</tr>
				
				@else
				
					@if($komoditi != '' && $data['volume'] !== 0)
						
						<tr>
							
							<td>{{ $no += 1 }}</td>
							
							<td>{{ $data['wilker'] }}</td>
							
							<td>{{ $komoditi ?? '-' }}</td>
							
							<td>{{ $data['volume'] ?? '-' }}</td>
							
							<td>{{ $data['satuan'] ?? '-' }}</td>
							
							<td>{{ $data['frekuensi'] ?? '-' }}</td>
							
							<td>
								{{-- jika permohonan seperti kondisi dibawah ini, maka pakai negara untuk asal --}}
								@if($datas['permohonan'] == 'Ekspor' || $datas['permohonan'] == 'Impor' || $datas['permohonan'] == 'Reekspor')
								
									@foreach($data['negara_asal'] as $negara_asal => $value)
									
										@if(! $loop->last)
											{{ $negara_asal ?? '-' }},
										@else
											{{ $negara_asal ?? '-' }}
										@endif
										
									@endforeach

								{{-- selain itu pakai nama daerah --}}
								@else

									@foreach($data['kota_asal'] as $kota_asal => $value)
									
										@if(! $loop->last)
											{{ $kota_asal ?? '-' }},
										@else
											{{ $kota_asal ?? '-' }}
										@endif
									
									@endforeach

								@endif

							</td>
							
							<td>

								{{-- jika permohonan seperti kondisi dibawah ini, maka pakai negara untuk tujuan --}}
								@if($datas['permohonan'] == 'Ekspor' || $datas['permohonan'] == 'Impor' || $datas['permohonan'] == 'Reekspor')
									
									@foreach($data['negara_tuju'] as $negara_tuju => $value)
									
										@if(! $loop->last)
											{{ $negara_tuju ?? '-' }},
										@else
											{{ $negara_tuju ?? '-' }}
										@endif
									
									@endforeach

								{{-- selain itu pakai nama daerah --}}
								@else

									@foreach($data['kota_tuju'] as $kota_tuju => $value)
								
										@if(! $loop->last)
											{{ $kota_tuju ?? '-' }},
										@else
											{{ $kota_tuju ?? '-' }}
										@endif
									
									@endforeach

								@endif
								
							</td>
							
						</tr>
				
					@endif
				
				@endif
			
			@endforeach
			
		@empty
		
			<tr>
				<td colspan="8">Nihil</td>
			</tr>
			
		@endforelse
		
		<tr>
			<td></td>
		</tr>
		
		<tr>
			@for($i = 1; $i < 5; $i++)
				<td></td>
			@endfor
			<td colspan="4">
				Sumbawa Besar, {{ reverse_tanggal_indo(date('d-m-Y')) }}
			</td>
		</tr>
		
		<tr>
			@for($i = 1; $i < 5; $i++)
				<td></td>
			@endfor
			<td colspan="4">
				{{ $datas['signatory']->jabatan->jabatan }}
			</td>
		</tr>

		@for($i = 0; $i < 4; $i++)
			<tr>
				<td></td>
			</tr>
		@endfor
		
		<tr>
			@for($i=1; $i < 5; $i++)
				<td></td>
			@endfor
			<td colspan="4">
				{{ $datas['signatory']->nama }}
			</td>
		</tr>
		
		<tr>
			@for($i = 1; $i < 5; $i++)
				<td></td>
			@endfor
			<td colspan="4">
				'{{ $datas['signatory']->nip }}
			</td>
		</tr>
		
	</table>
	
</body>
</html>