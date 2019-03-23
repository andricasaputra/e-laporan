<!DOCTYPE html>
<html>
<head></head>
<body>
	
	{{-- judul laporan --}}
	REKAPITULASI DATA <br>
	
	LAPORAN KEGIATAN OPERASIONAL KARANTINA HEWAN <br>
	
	{{ strtoupper($datas['permohonan']) }} <br>
	
	{{ strtoupper($datas['wilker']) }} <br>
	
	{{ empty($datas['bulan']) ? '' : 'BULAN : '. strtoupper($datas['bulan']) }} TAHUN : {{ $datas['tahun'] }} <br>
	
	<br>
	
	<table>
		{{-- table header --}}
		<tr>
			
			@foreach($datas['headers'] as $header)
			
			<td valign="middle" style="text-align: center;font-weight: bold;border: 1px solid #000;font-size: 12">{{ $header }}</td>
			
			@endforeach
			
		</tr>

		{{-- table body --}}
		@php $no = 0; @endphp
			
		@forelse($datas['bodies'] as $subdatas)
			
			@foreach($subdatas as $komoditi => $data)
		
				@if(count($subdatas) === 1 && $komoditi == '')
				
					<tr>
						
						<td valign="middle" style="text-align: center;border: 1px solid #000">
							{{ $no += 1 }}
						</td>
						
						<td valign="middle" style="text-align: center;border: 1px solid #000">
							{{ $data['wilker'] }}
						</td>
						
						<td valign="middle" style="text-align: center;border: 1px solid #000">
							Nihil
						</td>
						
						<td valign="middle" style="text-align: center;border: 1px solid #000">
							Nihil
						</td>
						
						<td valign="middle" style="text-align: center;border: 1px solid #000">
							Nihil
						</td>
						
						<td valign="middle" style="text-align: center;border: 1px solid #000">
							Nihil
						</td>
						
						<td valign="middle" style="text-align: center;border: 1px solid #000;width:30;font-size: 9">
							
							Nihil
							
						</td>
						
						<td valign="middle" style="text-align: center;border: 1px solid #000;width:30;font-size: 9">
							
							Nihil
							
						</td>
						
					</tr>
				
				@else
				
					@if($komoditi != '' && $data['volume'] !== 0)
						
						<tr>
							
							<td valign="middle" style="text-align: center;border: 1px solid #000">
								{{ $no += 1 }}
							</td>
							
							<td valign="middle" style="text-align: center;border: 1px solid #000">
								{{ $data['wilker'] }}
							</td>
							
							<td valign="middle" style="text-align: center;border: 1px solid #000">
								{{ $komoditi ?? '-' }}
							</td>
							
							<td valign="middle" style="text-align: center;border: 1px solid #000">
								{{ $data['volume'] ?? '-' }}
							</td>
							
							<td valign="middle" style="text-align: center;border: 1px solid #000">
								{{ $data['satuan'] ?? '-' }}
							</td>
							
							<td valign="middle" style="text-align: center;border: 1px solid #000">
								{{ $data['frekuensi'] ?? '-' }}
							</td>
							
							<td valign="middle" style="text-align: center;border: 1px solid #000;width:30;font-size: 9">

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
							
							<td valign="middle" style="text-align: center;border: 1px solid #000;width:30;font-size: 9">

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
				
				<td valign="middle" style="text-align: center;border: 1px solid #000">
					1
				</td>
				
				<td valign="middle" style="text-align: center;border: 1px solid #000">
					Nihil
				</td>
				
				<td valign="middle" style="text-align: center;border: 1px solid #000">
					Nihil
				</td>
				
				<td valign="middle" style="text-align: center;border: 1px solid #000">
					Nihil
				</td>
				
				<td valign="middle" style="text-align: center;border: 1px solid #000">
					Nihil
				</td>
				
				<td valign="middle" style="text-align: center;border: 1px solid #000">
					Nihil
				</td>
				
				<td valign="middle" style="text-align: center;border: 1px solid #000;width:30;font-size: 9">
					
					Nihil
					
				</td>
				
				<td valign="middle" style="text-align: center;border: 1px solid #000;width:30;font-size: 9">
					
					Nihil
					
				</td>
				
			</tr>
			
		@endforelse
		
		<tr>
			<td></td>
		</tr>
		
		<tr>
			@for($i=1; $i < 5; $i++)
				<td></td>
			@endfor
			<td colspan="4" valign="bottom" style="font-weight: bold;text-align: center;font-size: 16">
				Sumbawa Besar, {{ reverse_tanggal_indo(date('d-m-Y')) }}
			</td>
		</tr>
		
		<tr>
			@for($i=1; $i < 5; $i++)
				<td></td>
			@endfor
			<td colspan="4" valign="top" style="font-weight: bold;text-align: center;font-size: 16">
				{{ $datas['signatory']->jabatan->jabatan }}
			</td>
		</tr>
		
		<tr>
			<td style="height: 100"></td>
		</tr>
		
		<tr>
			@for($i=1; $i < 5; $i++)
				<td></td>
			@endfor
			<td colspan="4" valign="bottom" style="font-weight: bold;text-align: center;font-size: 16">
				{{ $datas['signatory']->nama }}
			</td>
		</tr>
		
		<tr>
			@for($i=1; $i < 5; $i++)
				<td></td>
			@endfor
			<td colspan="4" valign="top" style="font-weight: bold;text-align: center;font-size: 16">
				{{ $datas['signatory']->nip }}
			</td>
		</tr>
		
	</table>
	
	
</body>
</html>