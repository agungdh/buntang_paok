<script type="text/javascript">
$('.datepicker').datepicker({
  format: "dd-mm-yyyy",
  autoclose: true,
  todayHighlight: true
});

$('#simpan').click(function(){
  $("input[type='submit']").click();
});

$('.select2').select2();

$("#kategori").easyAutocomplete({
	url: function(phrase) {
		return "<?php echo base_url('tools/ajax_kategori'); ?>?kat=" + phrase;
	},

	getValue: "name",

	requestDelay: 200
});
</script>