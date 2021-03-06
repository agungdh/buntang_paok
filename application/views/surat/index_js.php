<script type="text/javascript">
var table = $('.datatable').DataTable( {
    "scrollX": true,
    "autoWidth": false,
});

function hapus(id) {
    swal({
        title: 'Apakah anda yakin?',
        text: "Surat akan dihapus!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus!'
    }).then(function(result) {
        if (result.value) {
            window.location = "<?php echo base_url('surat/aksi_hapus/'); ?>" + id;
        }
    });
};

function status(id) {
    $.get( "<?php echo base_url('welcome/ajax_isisurat/'); ?>" + id, function( data ) {
        $.get( "<?php echo base_url('welcome/ajax_detailsurat/'); ?>" + id, function( data ) {
            $("#detailsurat").html(data);
        });

        $("#tabelbodi").html(data);
        $("#exampleModalCenter").modal();
    });
}
</script>