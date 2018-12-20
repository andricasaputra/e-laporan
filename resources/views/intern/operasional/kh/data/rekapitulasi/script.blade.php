<script>
  $(document).ready(function(){

    let year = $('#year').val();

    let month = $('#month').val();

    let wilker = $('#wilker').val();

    $('#change_data_rekapitulasi').on('submit', function(e){

      e.preventDefault();

      year = $('#year').val();

      month = $('#month').val();

      wilker = $('#wilker').val();

      if (year != '' && month == '' && wilker == '') {

        window.location = '{{ route('show.rekapitulasi.operasional.kh') }}/' + year;

      } else if(year != '' && month != '' && wilker == '') {

        window.location = '{{ route('show.rekapitulasi.operasional.kh') }}/' + year + '/' + month;

      } else {

        window.location = '{{ route('show.rekapitulasi.operasional.kh') }}/' + year + '/' + month + '/' + wilker;

      }

    });

    /*set table data parameters (container, url, year, month, wilker)*/
    setDataTable(
      'DomasKh', '{{ route('api.kh.domas.rekapitulasi') }}/' + year + '/' + month + '/' + wilker, year, month, wilker
    );

    setDataTable(
      'DokelKh', '{{ route('api.kh.dokel.rekapitulasi') }}/' + year + '/' + month + '/' + wilker, year, month, wilker
    );

    setDataTable(
      'EksporKh', '{{ route('api.kh.ekspor.rekapitulasi') }}/' + year + '/' + month + '/' + wilker, year, month, wilker
    );

    setDataTable(
      'ImporKh', '{{ route('api.kh.impor.rekapitulasi') }}/' + year + '/' + month + '/' + wilker, year, month, wilker
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
          { "data" : "nama_mp" },
          { "data" : "volume" },
          { "data" : "satuan" },
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

          let mp      = $(this).data('mp');

          let detail  = $(this);

          $.ajax({

            url : 
            '{{ route('api.kh.detail.tujuan') }}/' + container + '/' + mp + '/' + year + '/' + month + '/' + wilker,

          }).done(function(response){

            let tr  = detail.closest('tr');

            let row = table.row( tr );

            if ( row.child.isShown() ) {
               // This row is already open - close it
               row.child.hide();
               tr.toggleClass('active')
               tr.removeClass('shown');
            }
            else {
               // Open this row
               row.child(response).show();
               tr.toggleClass('active');
               tr.addClass('shown');
            }
              
          });

      });
    }

  });
</script>