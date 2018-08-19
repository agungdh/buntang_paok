<script type="text/javascript">
var table = $('.datatable').DataTable( {
    "scrollX": true,
    "autoWidth": false,
});

function proses(id) {
    swal({
        title: 'Apakah anda yakin?',
        text: "Data akan diproses!",
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
        text: "Data akan diselesai!",
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
        text: "Data akan ditolak!",
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
    $.get( "<?php echo base_url('surat/ajax_isisurat/'); ?>" + id, function( data ) {
        $.get( "<?php echo base_url('surat/ajax_detailsurat/'); ?>" + id, function( data ) {
            $("#detailsurat").html(data);
        });

        $("#tabelbodi").html(data);
        $("#exampleModalCenter").modal();
    });
}
</script>