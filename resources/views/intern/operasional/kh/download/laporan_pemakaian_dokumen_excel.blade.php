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
			<td valign="middle" style="border: 1px solid #000; text-align: center">FORMULIR 1</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['FORM1'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['FORM1'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['FORM1'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaantotal']['FORM1'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['FORM1'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['FORM1'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['FORM1'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaiantotal']['FORM1'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['FORM1'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['FORM1'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['FORM1']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['FORM1']))
					@forelse($datas['bodies']['pembatalantotal']['FORM1'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan FORM1, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">FORMULIR 2</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['FORM2'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['FORM2'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['FORM2'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['FORM2'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['FORM2'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['FORM2'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['FORM2'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['FORM2'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['FORM2'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['FORM2'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['FORM2']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['FORM2']))
					@forelse($datas['bodies']['pembatalantotal']['FORM2'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan FORM2, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 1</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH1'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH1'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH1'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH1'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH1'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH1'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH1'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH1'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH1'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH1'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH1']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH1']))
					@forelse($datas['bodies']['pembatalantotal']['KH1'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH1, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 2</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH2'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH2'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH2'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH2'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH2'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH2'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH2'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH2'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH2'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH2'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH2']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH2']))
					@forelse($datas['bodies']['pembatalantotal']['KH2'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH2, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">5</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 3</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH3'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH3'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH3'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH3'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH3'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH3'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH3'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH3'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH3'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH3'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH3']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH3']))
					@forelse($datas['bodies']['pembatalantotal']['KH3'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH3, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">6</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 4</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH4'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH4'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH4'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH4'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH4'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH4'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH4'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH4'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH4'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH4'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH4']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH4']))
					@forelse($datas['bodies']['pembatalantotal']['KH4'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH4, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">7</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 5</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH5'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH5'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH5'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH5'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH5'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH5'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH5'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH5'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH5'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH5'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH5']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH5']))
					@forelse($datas['bodies']['pembatalantotal']['KH5'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH5, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">8</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 6</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH6'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH6'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH6'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH6'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH6'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH6'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH6'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH6'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH6'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH6'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH6']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH6']))
					@forelse($datas['bodies']['pembatalantotal']['KH6'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH6, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">9</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 7</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH7'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH7'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH7'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH7'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH7'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH7'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH7'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH7'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH7'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH7'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH7']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH7']))
					@forelse($datas['bodies']['pembatalantotal']['KH7'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH7, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">10</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 8A</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH8A'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH8A'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH8A'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH8A'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH8A'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH8A'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH8A'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH8A'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH8A'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH8A'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH8A']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH8A']))
					@forelse($datas['bodies']['pembatalantotal']['KH8A'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH8A, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">11</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 8B</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH8B'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH8B'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH8B'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH8B'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH8B'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH8B'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH8B'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH8B'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH8B'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH8B'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH8B']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH8B']))
					@forelse($datas['bodies']['pembatalantotal']['KH8B'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH8B, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">12</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 9A</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH9A'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH9A'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH9A'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH9A'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH9A'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH9A'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH9A'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH9A'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH9A'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH9A'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH9A']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH9A']))
					@forelse($datas['bodies']['pembatalantotal']['KH9A'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH9A, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">13</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 9B</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH9B'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH9B'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH9B'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH9B'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH9B'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH9B'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH9B'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH9B'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH9B'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH9B'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH9B']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH9B']))
					@forelse($datas['bodies']['pembatalantotal']['KH9B'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH9B, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">14</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 10A</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH10A'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH10A'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH10A'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH10A'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH10A'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH10A'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH10A'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH10A'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH10A'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH10A'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH10A']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH10A']))
					@forelse($datas['bodies']['pembatalantotal']['KH10A'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH10A, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">15</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 10B</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH10B'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH10B'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH10B'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH10B'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH10B'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH10B'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH10B'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH10B'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH10B'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH10B'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH10B']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH10B']))
					@forelse($datas['bodies']['pembatalantotal']['KH10B'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH10B, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">16</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 11</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH11'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH11'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH11'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH11'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH11'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH11'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH11'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH11'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH11'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH11'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH11']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH11']))
					@forelse($datas['bodies']['pembatalantotal']['KH11'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH11, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">17</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">DEC 11</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['DEC11'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['DEC11'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['DEC11'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['DEC11'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['DEC11'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['DEC11'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['DEC11'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['DEC11'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['DEC11'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['DEC11'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['DEC11']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['DEC11']))
					@forelse($datas['bodies']['pembatalantotal']['DEC11'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan DEC11, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">18</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 12</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH12'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH12'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH12'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH12'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH12'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH12'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH12'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH12'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH12'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH12'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH12']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH12']))
					@forelse($datas['bodies']['pembatalantotal']['KH12'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH12, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">19</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">DEC 12</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['DEC12'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['DEC12'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['DEC12'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['DEC12'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['DEC12'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['DEC12'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['DEC12'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['DEC12'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['DEC12'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['DEC12'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['DEC12']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['DEC12']))
					@forelse($datas['bodies']['pembatalantotal']['DEC12'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan DEC12, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">20</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KT 13</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH13'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH13'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH13'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH13'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH13'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH13'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH13'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH13'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH13'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH13'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH13']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH13']))
					@forelse($datas['bodies']['pembatalantotal']['KH13'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH13, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">21</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">DEC 13</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['DEC13'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['DEC13'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['DEC13'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['DEC13'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['DEC13'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['DEC13'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['DEC13'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['DEC13'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['DEC13'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['DEC13'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['DEC13']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['DEC13']))
					@forelse($datas['bodies']['pembatalantotal']['DEC13'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan DEC13, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">22</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">KH 14</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH14'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['KH14'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['KH14'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['KH14'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH14'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['KH14'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['KH14'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['KH14'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['KH14'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['KH14'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['KH14']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['KH14']))
					@forelse($datas['bodies']['pembatalantotal']['KH14'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan KH14, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">23</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">DEC 14</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['DEC14'] ?? 0) - ($datas['bodies']['penerimaanbulanIni']['DEC14'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['penerimaanbulanIni']['DEC14'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['penerimaantotal']['DEC14'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['DEC14'] ?? 0) - ($datas['bodies']['pemakaianbulanIni']['DEC14'] ?? 0) }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['pemakaianbulanIni']['DEC14'] ?? 0 }} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['pemakaiantotal']['DEC14'] ?? 0)}} set</td>
			<td valign="middle" style="border: 1px solid #000; text-align: center">
				{{ 
					($datas['bodies']['penerimaantotal']['DEC14'] ?? 0) - 
					($datas['bodies']['pemakaiantotal']['DEC14'] ?? 0) - 
					($datas['bodies']['pembatalantotal']['DEC14']['total'] ?? 0)
				}}
			</td>
			<td valign="middle" style="border: 1px solid #000; text-align: left">
				@if(isset($datas['bodies']['pembatalantotal']['DEC14']))
					@forelse($datas['bodies']['pembatalantotal']['DEC14'] as $dokumen => $value)
						@if($loop->first)
							Pembatalan DEC14, <br> jumlah : {{ $value }} <br>
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
			<td valign="middle" style="border: 1px solid #000; text-align: center">24</td>
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
				Sumbawa Besar, {{ reverse_tanggal_indo(date('d-m-Y')) }}
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