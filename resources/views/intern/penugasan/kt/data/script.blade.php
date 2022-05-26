<script>
  $(document).ready(function(){

    let year = $('#year').val();

    let month = $('#month').val();

    let wilker = $('#wilker').val();

    $('#change_data_penugasan').on('submit', function(e){

      e.preventDefault();

      year = $('#year').val();

      month = $('#month').val();

      wilker = $('#wilker').val();

      window.location = '{{ route('kt.view.penugasan.home') }}/' + year + '/' + month + '/' + wilker;

    });

    setDataTable(
      'PenugasanDokelKt', '{{ route('api.kt.dokel.penugasan') }}/' + year + '/' + month + '/' + wilker, year, month, wilker
    );

    function setDataTable(container, url, year, month, wilker){

      let tableId = $('#' + container);

      let table = $(tableId).DataTable({

        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax":{
           "url": url
        },
        "columns": [
          { "data" : "wilker_id" }, 
          { "data" : "user_id" }, 
          { "data" : "bulan" }, 
          { "data" : "no" }, 
          { "data" : "no_permohonan" }, 
          { "data" : "no_aju" },
          { "data" : "tanggal_permohonan" }, 
          { "data" : "jenis_permohonan" }, 
          { "data" : "nama_wilker" }, 
          { "data" : "nama_pengirim" }, 
          { "data" : "alamat_pengirim" }, 
          { "data" : "nama_penerima" }, 
          { "data" : "alamat_penerima" }, 
          { "data" : "nama_tercetak" }, 
          { "data" : "nama_latin_tercetak" },
          { "data" : "bentuk_tercetak" }, 
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
          { "data" : "dok_pelepasan" },
          { "data" : "nomor_dok_pelepasan" }, 
          { "data" : "tanggal_pelepasan" }, 
          { "data" : "no_surat_tugas" }, 
          { "data" : "tgl_surat_tugas" }, 
          { "data" : "deskripsi" },
          { "data" : "petugas" }, 
          { "data" : "dokumen_pendukung" },
          { "data" : "kontainer" }, 
          { "data" : "created_at" }, 
          { "data" : "updated_at" },
        ]

      });

      // $(tableId).on('click', 'a.detail-mp', function (e) {

      //     e.preventDefault();

      //     let mpStr   = $(this).data('mp');

      //     let mp      = mpStr.replace('/', '--');

      //     let detail  = $(this);

      //     $.ajax({

      //       url : 
      //       '{{ route('api.kt.detail.tujuan') }}/' + container + '/' + mp + '/' + year + '/' + month + '/' + wilker,

      //     }).done(function(response){

      //       let tr  = detail.closest('tr');

      //       let row = table.row( tr );

      //       if ( row.child.isShown() ) {
      //          // This row is already open - close it
      //          row.child.hide();
      //          tr.toggleClass('active')
      //          tr.removeClass('shown');

      //       } else {
      //          // Open this row
      //          row.child(response).show();
      //          tr.toggleClass('active');
      //          tr.addClass('shown');

      //          $('.table-detail-rekap').DataTable();
      //       }
              
      //     });

      // });
    }/*end function*/

  });
</script>