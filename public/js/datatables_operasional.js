// Global Datatables Locale Language
$(document).ready(function(){
    $.extend( true, $.fn.dataTable.defaults, {
      language: {
          "sEmptyTable":   "Tidak ada data yang tersedia pada tabel ini",
          "sProcessing":   "Sedang memproses...",
          "sLengthMenu":   "Tampilkan _MENU_ entri",
          "sZeroRecords":  "Tidak ditemukan data yang sesuai",
          "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
          "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
          "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
          "sInfoPostFix":  "",
          "sSearch":       "Cari:",
          "sUrl":          "",
          "oPaginate": {
            "sFirst":    "Pertama",
            "sPrevious": "Sebelumnya",
            "sNext":     "Selanjutnya",
            "sLast":     "Terakhir"
          }
      }
    });
});

function datatablesOperasional(container, url, type){

	let scrollX = false;

	let columnsKt =  [

    	{ "data" : "DT_Row_Index", orderable: false, searchable: false},
      { "data" : "bulan" },
      { "data" : "wilker.nama_wilker" },
  		{ "data" : "no_permohonan" },
  		{ "data" : "no_aju" },
  		{ "data" : "tanggal_permohonan" },
  		{ "data" : "jenis_permohonan" },
  		{ "data" : "nama_pemohon" },
  		{ "data" : "nama_pengirim" },
  		{ "data" : "alamat_pengirim" },
  		{ "data" : "nama_penerima" },
  		{ "data" : "alamat_penerima" },
  		{ "data" : "jumlah_kemasan" },
  		{ "data" : "kota_asal" },
  		{ "data" : "asal" },
  		{ "data" : "kota_tujuan" },
  		{ "data" : "tujuan" },
  		{ "data" : "port_asal" },
  		{ "data" : "port_tujuan" },
  		{ "data" : "moda_alat_angkut_terakhir" },
  		{ "data" : "tipe_alat_angkut_terakhir" },
  		{ "data" : "nama_alat_angkut_terakhir" },
  		{ "data" : "status_internal" },
  		{ "data" : "lokasi_mp" },
  		{ "data" : "tempat_produksi" },
  		{ "data" : "nama_tempat_pelaksanaan" },
  		{ "data" : "peruntukan" },
  		{ "data" : "golongan" },
  		{ "data" : "kode_hs" },
  		{ "data" : "nama_komoditas" },
  		{ "data" : "nama_komoditas_en" },
  		{ "data" : "volume_netto" },
  		{ "data" : "sat_netto" },
  		{ "data" : "volume_bruto" },
  		{ "data" : "sat_bruto" },
  		{ "data" : "volume_lain" },
  		{ "data" : "sat_lain" },
  		{ "data" : "volumeP1" },
  		{ "data" : "nettoP1" },
  		{ "data" : "volumeP8" },
  		{ "data" : "nettoP8" },
  		{ "data" : "dok_pelepasan" },
  		{ "data" : "nomor_dok_pelepasan" },
  		{ "data" : "tanggal_pelepasan" },
  		{ "data" : "no_seri" },
      { "data" : "no_kwitansi" },
  		{ "data" : "dokumen_pendukung" },
  		{ "data" : "kontainer" },
  		{ "data" : "biaya_perjalanan_dinas" },
  		{ "data" : "total_pnbp" }	

	];

	let columnsKh = [

    	{ "data" : "DT_Row_Index", orderable: false, searchable: false},
      { "data" : "bulan" },
      { "data" : "wilker.nama_wilker" },
      { "data" : "no_permohonan" },
      { "data" : "no_aju" },
      { "data" : "tanggal_permohonan" },
      { "data" : "jenis_permohonan" },
      { "data" : "nama_pemohon" },
      { "data" : "nama_pengirim" },
      { "data" : "alamat_pengirim" },
      { "data" : "nama_penerima" },
      { "data" : "alamat_penerima" },
      { "data" : "jumlah_kemasan" },
      { "data" : "kota_asal" },
      { "data" : "asal" },
      { "data" : "kota_tuju" },
      { "data" : "tujuan" },
      { "data" : "port_asal" },
      { "data" : "port_tuju" },
      { "data" : "moda_alat_angkut_terakhir" },
      { "data" : "tipe_alat_angkut_terakhir" },
      { "data" : "nama_alat_angkut_terakhir" },
      { "data" : "status_internal" },
      { "data" : "peruntukan" },
      { "data" : "jenis_mp" },
      { "data" : "kelas_mp" },
      { "data" : "kode_hs" },
      { "data" : "nama_mp" },
      { "data" : "nama_latin" },
      { "data" : "jumlah" },
      { "data" : "satuan" },
      { "data" : "jantan" },
      { "data" : "betina" },
      { "data" : "netto" },
      { "data" : "sat_netto" },
      { "data" : "bruto" },
      { "data" : "sat_bruto" },
      { "data" : "keterangan" },
      { "data" : "breed" },
      { "data" : "volumeP1" },
      { "data" : "nettoP1" },
      { "data" : "volumeP8" },
      { "data" : "nettoP8" },
      { "data" : "dok_pelepasan" },
      { "data" : "nomor_dok_pelepasan" },
      { "data" : "tanggal_pelepasan" },
      { "data" : "no_seri" },
      { "data" : "no_kwitansi" },
      { "data" : "dokumen_pendukung" },
      { "data" : "kontainer" },
      { "data" : "biaya_perjalanan_dinas" },
      { "data" : "total_pnbp" }

	]

	if ($(window).width() > 800) {

		scrollX = true;

	}
	
	if (type == 'kt') {

		$(container).DataTable({

      "processing": true,
      "serverSide": true,
      "scrollX": scrollX,
      "ajax":{
         "url": url,
         "method": "POST",
         "dataType": "JSON"
      },
      "columns": columnsKt,
			"columnDefs": [{
			    "defaultContent": "-",
			    "targets": "_all"
			}]

    });

	}else{

		$(container).DataTable({

      "processing": true,
      "serverSide": true,
      "scrollX": scrollX,
      "ajax":{
         "url": url,
         "method": "POST",
         "dataType": "JSON"
      },
      "columns": columnsKh,
			"columnDefs": [{
			    "defaultContent": "-",
			    "targets": "_all"
			}]

    });

	}
}

function dataTablesPnbpOperasional(container, url)
{
    let columns = [

      { "data" : "DT_Row_Index", orderable: false, searchable: false},
      { "data" : "bulan" },
      { "data" : "upt" },
      { "data" : "wilker.nama_wilker" },
      { "data" : "kode_transaksi" },
      { "data" : "no_kwitansi" },
      { "data" : "tgl_kwitansi" },
      { "data" : "jumlah" },
      { "data" : "kode_billing" },
      { "data" : "tgl_billing" },
      { "data" : "kode_transaksi_simponi" },
      { "data" : "ntpn" },
      { "data" : "tgl_bayar" },
      { "data" : "bank_persepsi" }

    ];

    $(container).DataTable({

      "processing": true,
      "serverSide": true,
      "scrollX": true,
      "ajax":{
         "url": url,
         "method": "POST",
         "dataType": "JSON"
      },
      "columns": columns,
      "columnDefs": [{
          "defaultContent": "-",
          "targets": "_all"
      }]

    });
}



