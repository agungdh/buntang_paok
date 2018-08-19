<script type="text/javascript">
$('#simpan').click(function(){
  $("input[type='submit']").click();
});

$('.select2').select2();

cekLevel();

$("#level").change(function() {
	cekLevel();
});

function cekLevel() {
	if ($("#level").val() != 'kb') {
		$("#id_bidang").prop('disabled', true);
	} else {
		$("#id_bidang").prop('disabled', false);
	}
}
</script>