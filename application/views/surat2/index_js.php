<script type="text/javascript">
var table = $('.datatable').DataTable( {
    "scrollX": true,
    "autoWidth": false,
});

function proses(id) {
    swal({
        title: 'Apakah anda yakin?',
        text: "Surat akan diproses!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Proses!'
    }).then(function(result) {
        if (result.value) {
            window.location = "<?php echo base_url('surat2/aksi_proses/'); ?>" + id;
        }
    });
};

function selesai(id) {
    swal({
        title: 'Apakah anda yakin?',
        text: "Surat Selesai Diproses!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Selesai!'
    }).then(function(result) {
        if (result.value) {
            window.location = "<?php echo base_url('surat2/aksi_selesai/'); ?>" + id;
        }
    });
};

function tolak(id) {
    swal({
        title: 'Apakah anda yakin?',
        text: "Surat akan ditolak!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Tolak!'
    }).then(function(result) {
        if (result.value) {
            window.location = "<?php echo base_url('surat2/aksi_tolak/'); ?>" + id;
        }
    });
};

function status(id) {
    $.get( "<?php echo base_url('welcome/ajax_isisurat/'); ?>" + id, function( data ) {
        $.get( "<?php echo base_url('welcome/ajax_detailsurat/'); ?>" + id, function( data ) {
            $("#detailsurat").html(data);
        });

        $("#tabelbodi").html(data);
        $("#modalStatus").modal();
    });
}

function memo(id) {
    $.get( "<?php echo base_url('welcome/ajax_memo/'); ?>" + id, function( data ) {
        $.get( "<?php echo base_url('welcome/ajax_detailmemo/'); ?>" + id, function( data ) {
            $("#detailsuratMemo").html(data);
        });
        $.get( "<?php echo base_url('welcome/ajax_btn_download_memo/'); ?>" + id, function( data ) {
            $("#btn_download_memo").html(data);
        });

        $("#memo").html(data);
        $("#modalMemo").modal();
    });
}

</script>