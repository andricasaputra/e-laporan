<script>
  $(document).ready(function(){

    let year = $('#year').val();

    let month = $('#month').val();

    let wilker = $('#wilker').val();

    $('#change_data_rekapitulasi_kt').on('submit', function(e){

      e.preventDefault();

      year = $('#year').val();

      month = $('#month').val();

      wilker = $('#wilker').val();

      window.location = '{{ route('show.rekapitulasi.operasional.kt') }}/' + year + '/' + month + '/' + wilker;

    });

    /*set table data parameters (container, url, year, month, wilker)*/
    setDataTable(
      'DomasKt', '{{ route('api.kt.domas.rekapitulasi') }}/' + year + '/' + month + '/' + wilker, year, month, wilker
    );

    setDataTable(
      'DokelKt', '{{ route('api.kt.dokel.rekapitulasi') }}/' + year + '/' + month + '/' + wilker, year, month, wilker
    );

    setDataTable(
      'EksporKt', '{{ route('api.kt.ekspor.rekapitulasi') }}/' + year + '/' + month + '/' + wilker, year, month, wilker
    );

    setDataTable(
      'ImporKt', '{{ route('api.kt.impor.rekapitulasi') }}/' + year + '/' + month + '/' + wilker, year, month, wilker
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
          { "data" : "nama_komoditas" },
          { "data" : "volume", render: $.fn.dataTable.render.number( '.', ',', 0 ) },
          { "data" : "sat_netto" },
          { "data" : "frekuensi" },
          { "data" : "pnbp" },
          {
            "class": "details-control",
            "orderable":false,
            "data":"action",
            "defaultContent": "-"
          },
        ]

      });

      $(tableId).on('click', 'a.detail-mp', function (e) {

          e.preventDefault();

          let mpStr   = $(this).data('mp');

          let mp      = mpStr.replace('/', '--');

          let detail  = $(this);

          $.ajax({

            url : 
            '{{ route('api.kt.detail.tujuan') }}/' + container + '/' + mp + '/' + year + '/' + month + '/' + wilker,

          }).done(function(response){

            let tr  = detail.closest('tr');

            let row = table.row( tr );

            if ( row.child.isShown() ) {
               // This row is already open - close it
               row.child.hide();
               tr.toggleClass('active')
               tr.removeClass('shown');

            } else {
               // Open this row
               row.child(response).show();
               tr.toggleClass('active');
               tr.addClass('shown');

               $('.table-detail-rekap').DataTable();
            }
              
          });

      });
    }/*end function*/

  });
</script>