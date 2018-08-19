<script type="text/javascript">
$('#simpan_ubah').click(function(){
  $("#submit_ubah").click();
});

$('#simpan_ubah_password').click(function(){
  $("#submit_ubah_password").click();
});

$('.select2').select2();

$('#form_ubah_password').submit(function() {
	if ($("#password").val() != $("#password2").val()) {
		swal("Error !!!", "Password Tidak Sama !!!", "error");
		return false;
	} else {
		$("#form_ubah_password").submit();			
	}
});

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