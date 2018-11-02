$(document).ready(function(){

	/*$('textarea').ckeditor();*/

    $('.datatable').DataTable();

    /*tableAdminHeadline();

    tableAdminBerita();

    function columnCounter(table){
        table.on('draw.dt', function () {
        var info = table.page.info();
        table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + info.start;
            });
        });
    }

    function tableAdminHeadline(){

        var tableHeadline = $('#adminHeadlineTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "api/apiheadline",
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": [0, 5]
            }],
            "columns":[
                { "data": null},
                { "data": "judul" },
                { "data": "deskripsi" },
                { "data": "gambar" },
                { "data": "created_at" },
                { "data": "status" },
                { "data": "action" }
            ]
        });

        columnCounter(tableHeadline);
        
    }

    function tableAdminBerita(){

        var tableBerita = $('#adminBeritaTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "api/apiberita",
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "columns":[
                { "data": null},
                { "data": "penulis" },
                { "data": "judul" },
                { "data": "isi" },
                { "data": "gambar" },
                { "data": "status" },
                { "data": "action" }
            ]
        });

        columnCounter(tableBerita);

    }

    $(document).on('click', '#deleteHeadline', function(e){

        e.preventDefault();
        let id = $( this ).data( 'id' );

        $('#modalDeleteHeadline').modal('show');

        let idInForm = $("#modalDeleteHeadline #headlineId").val(id);

    });

    $(document).on('click', '#deleteBerita', function(e){

        e.preventDefault();
        let id = $( this ).data( 'id' );

        $('#modalDeleteBerita').modal('show');

        let idInForm = $("#modalDeleteBerita #beritaId").val(id);

    });*/

    window.setTimeout(function() {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function() {
            $(this).hide();
        });
    }, 5000);


});/*End Ready*/