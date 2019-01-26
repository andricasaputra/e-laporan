<!DOCTYPE html>
<html>
<head></head>
<body>
	{{-- judul laporan --}}
	KEMENTERIAN PERTANIAN <br>
	
	BADAN KARANTINA PERTANIAN <br>

	{{ strtoupper($datas['wilker']) }} <br>
	
	RINCIAN PENERIMAAN DAN PEMAKAIAN DOKUMEN TINDAK KARANTINA <br>
	
	{{ empty($datas['bulan']) ? '' : 'BULAN : '. strtoupper($datas['bulan']) }} TAHUN : {{ $datas['tahun'] }} <br>
	
	<br>

	<table>

		{{-- Header --}}
		<tr>
			<td rowspan="2" valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				No
			</td>
			<td rowspan="2" valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				Dokumen
			</td>
			<td colspan="3" valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">			Penerimaan Dokumen
			</td>
			<td colspan="3" valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				Pemakaian Dokumen
			</td>
			<td rowspan="2" valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				Persediaan
			</td>
			<td rowspan="2" valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				Keterangan
			</td>
		</tr>
		<tr>
			<td valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				Sampai Dengan Bulan Lalu
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				Sampai Dengan Bulan Lalu
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				Sampai Dengan Bulan Lalu
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				Pada Bulan Ini
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				Sampai Dengan Bulan Ini
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				Sampai Dengan Bulan Lalu
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				Pada Bulan Ini
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center;font-weight: bold">
				Sampai Dengan Bulan Ini
			</td>
		</tr>
		{{-- End Header --}}

		{{-- Body --}}

		<tr>
			<td valign="middle" style="border: 1px solid #000; text-align: center">1</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KT 12</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KT12'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KT12'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KT12'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaantotal']['KT12'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KT12'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KT12'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KT12'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaiantotal']['KT12'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KT12'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KT12'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KT12']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KT12']))
					@forelse($datas['bodies']['pembatalantotal']['KT12'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KT12, <br> jumlah : {{ $value }} <br>
						@else
							no seri : {{ $value }}
						@endif
					@empty
						-
					@endforelse
				@endif
			</td>
		</tr>

		<tr>
			<td valign="middle" style="border: 1px solid #000; text-align: center">2</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KT 10</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KT10'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KT10'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KT10'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KT10'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KT10'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KT10'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KT10'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KT10'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KT10'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KT10'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KT10']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KT10']))
					@forelse($datas['bodies']['pembatalantotal']['KT10'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KT10, <br> jumlah : {{ $value }} <br>
						@else
							no seri : {{ $value }}
						@endif
					@empty
						-
					@endforelse
				@endif
			</td>
		</tr>

		<tr>
			<td valign="middle" style="border: 1px solid #000; text-align: center">3</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KT 9</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KT9'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KT9'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KT9'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KT9'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KT9'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KT9'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KT9'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KT9'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KT9'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KT9'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KT9']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KT9']))
					@forelse($datas['bodies']['pembatalantotal']['KT9'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KT9, <br> jumlah : {{ $value }} <br>
						@else
							no seri : {{ $value }}
						@endif
					@empty
						-
					@endforelse
				@endif
			</td>
		</tr>

		<tr>
			<td valign="middle" style="border: 1px solid #000; text-align: center">4</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">SP 5</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['SP5'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['SP5'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['SP5'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['SP5'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['SP5'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['SP5'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['SP5'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['SP5'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['SP5'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['SP5'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['SP5']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center"></td>
		</tr>

		<tr>
			<td valign="middle" style="border: 1px solid #000; text-align: center">5</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KWITANSI</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KWITANSI'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KWITANSI'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KWITANSI'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KWITANSI'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KWITANSI'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KWITANSI'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KWITANSI'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KWITANSI'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KWITANSI'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KWITANSI'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KWITANSI']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KWITANSI']))
					@forelse($datas['bodies']['pembatalantotal']['KWITANSI'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KWITANSI, <br> jumlah : {{ $value }} <br>
						@else
							no seri : {{ $value }}
						@endif
					@empty
						-
					@endforelse
				@endif
			</td>
		</tr>
		{{-- End Body --}}

	</table>

	<table>

		<tr>
			<td colspan="5"></td>
			<td colspan="5" valign="bottom" style="font-weight: bold;text-align: center;font-size: 12">
				Sumbawa Besar, {{ date('d/m/Y') }}
			</td>
		</tr>
		
		<tr>
			<td colspan="5"></td>
			<td colspan="5" valign="top" style="font-weight: bold;text-align: center;font-size: 12">
				{{ $datas['signatory']->jabatan->jabatan }}
			</td>
		</tr>
		
		<tr>
			<td style="height: 100"></td>
		</tr>
		
		<tr>
			<td colspan="5"></td>
			<td colspan="5" valign="bottom" style="font-weight: bold;text-align: center;font-size: 12">
				{{ $datas['signatory']->nama }}
			</td>
		</tr>
		
		<tr>
			<td colspan="5"></td>
			<td colspan="5" valign="top" style="font-weight: bold;text-align: center;font-size: 12">
				{{ $datas['signatory']->nip }}
			</td>
		</tr>

	</table>

	
</body>
</html>