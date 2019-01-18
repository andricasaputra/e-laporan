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
			<td style="border: 1px solid #000; text-align: center">1</td>
			<td style="border: 1px solid #000; text-align: center">KT 12</td>
			<td style="border: 1px solid #000; text-align: center">1000 set</td>
			<td style="border: 1px solid #000; text-align: center">0 set</td>
			<td style="border: 1px solid #000; text-align: center">2 set</td>
			<td style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['total']['KT12'] ?? 0) - ($datas['bodies']['bulanIni']['KT12'] ?? 0) }} set</td>
			<td style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['bulanIni']['KT12'] ?? 0 }} set</td>
			<td style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['total']['KT12'] ?? 0 }} set</td>
			<td style="border: 1px solid #000; text-align: center">-</td>
			<td style="border: 1px solid #000; text-align: center">-</td>
		</tr>

		<tr>
			<td style="border: 1px solid #000; text-align: center">2</td>
			<td style="border: 1px solid #000; text-align: center">KT 10</td>
			<td style="border: 1px solid #000; text-align: center">1000 set</td>
			<td style="border: 1px solid #000; text-align: center">0 set</td>
			<td style="border: 1px solid #000; text-align: center">2 set</td>
			<td style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['total']['KT10'] ?? 0) - ($datas['bodies']['bulanIni']['KT10'] ?? 0) }} set</td>
			<td style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['bulanIni']['KT10'] ?? 0 }} set</td>
			<td style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['total']['KT10'] ?? 0) }} set</td>
			<td style="border: 1px solid #000; text-align: center">-</td>
			<td style="border: 1px solid #000; text-align: center">-</td>
		</tr>

		<tr>
			<td style="border: 1px solid #000; text-align: center">3</td>
			<td style="border: 1px solid #000; text-align: center">KT 9</td>
			<td style="border: 1px solid #000; text-align: center">1000 set</td>
			<td style="border: 1px solid #000; text-align: center">0 set</td>
			<td style="border: 1px solid #000; text-align: center">2 set</td>
			<td style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['total']['KT9'] ?? 0) - ($datas['bodies']['bulanIni']['KT9'] ?? 0) }} set</td>
			<td style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['bulanIni']['KT9'] ?? 0 }} set</td>
			<td style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['total']['KT9'] ?? 0)}} set</td>
			<td style="border: 1px solid #000; text-align: center">-</td>
			<td style="border: 1px solid #000; text-align: center">-</td>
		</tr>

		<tr>
			<td style="border: 1px solid #000; text-align: center">3</td>
			<td style="border: 1px solid #000; text-align: center">SP 5</td>
			<td style="border: 1px solid #000; text-align: center">1000 set</td>
			<td style="border: 1px solid #000; text-align: center">0 set</td>
			<td style="border: 1px solid #000; text-align: center">2 set</td>
			<td style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['total']['SP5'] ?? 0) - ($datas['bodies']['bulanIni']['SP5'] ?? 0) }} set</td>
			<td style="border: 1px solid #000; text-align: center">{{ $datas['bodies']['bulanIni']['SP5'] ?? 0 }} set</td>
			<td style="border: 1px solid #000; text-align: center">{{ ($datas['bodies']['total']['SP5'] ?? 0) }} set</td>
			<td style="border: 1px solid #000; text-align: center">-</td>
			<td style="border: 1px solid #000; text-align: center">-</td>
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