<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <table>
  <tbody>
    <tr>
      <td>Tanggal</td>
      <td id="tanggal">: <?php echo $this->pustaka->tanggal_indo($surat->tanggal_surat); ?></td>
    </tr>
    <tr>
      <td>No Surat</td>
      <td id="nosurat">: <?php echo $surat->nosurat; ?></td>
    </tr>
    <tr>
      <td>Pengirim</td>
      <td id="pengirim">: <?php echo $surat->pengirim; ?></td>
    </tr>
    <tr>
      <td>Perihal</td>
      <td id="perihal">: <?php echo $surat->perihal; ?></td>
    </tr>
  </tbody>
</table>
<hr>
<?php
  echo str_replace("\n", '<br>', $log_surat_terakhir->memo);
?>
</body>
</html>