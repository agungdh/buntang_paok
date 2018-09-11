<?php
// var_dump($tabel);
// var_dump($form);
?>

<?php
$now = date('YmdHis');
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo JUDUL; ?></title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(''); ?>assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(''); ?>assets/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <?php
    if (file_exists('uploads/favicon')) {
      $favicon = 'uploads/favicon';
    } else {
      $favicon = 'assets/favicon.png';
    }
    ?>
    <link rel="shortcut icon" href="<?php echo base_url($favicon) . '?time=' . $now; ?>"/>

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <div class="container">
        <a class="navbar-brand" href="javascript:void(0)"><?php echo JUDUL; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <?php
              if ($this->session->login == true) {
                $url = 'dashboard';
                $text = 'APP';
              } else {
                $url = 'login';
                $text = 'Login';
              }
              ?>
              <a class="navbar-brand" href="<?php echo base_url($url); ?>"><?php echo $text; ?></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    
      <br>
      <br>
      <br>
      <body>
      <div class="container">
        <h3 class="title">Grafik Surat</h3>
        <div class="row">
          <div class="embed-responsive embed-responsive-16by9">
            <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
          </div>
        </div>
        <br>
        <div class="row">
          <h3 class="title">Data Surat</h3>
          <table class="table datatable" id="table">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>No Surat</th>
                <th>Pengirim</th>
                <th>Perihal</th>
                <th>Jenis</th>
                <th>Prioritas</th>
                <th>Berkas</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($this->db->get('surat')->result() as $item) {
                ?>
                <tr>
                  <td><?php echo $this->pustaka->tanggal_indo($item->tanggal_surat); ?></td>
                  <td><?php echo $item->nosurat; ?></td>
                  <td><?php echo $item->pengirim; ?></td>
                  <td><?php echo $item->perihal; ?></td>
                  <td><?php echo $this->db->get_where('jenis', ['id_jenis' => $item->id_jenis])->row()->jenis; ?></td>
                <?php
                switch ($item->prioritas) {
                  case 'st':
                    $prioritas = 'Sangat Tinggi';
                    break;
                  
                  case 't':
                    $prioritas = 'Tinggi';
                    break;
                  
                  case 'n':
                    $prioritas = 'Normal';
                    break;
                  
                  default:
                    redirect(base_url());
                    break;
                }
                ?>
                <td><?php echo $prioritas; ?></td>
                  <td><a href="<?php echo base_url('tools/download/' . $item->id_surat); ?>"><?php echo $item->nama_file; ?></a></td>
                  <?php
                  switch ($item->status) {
                    case 'm':
                      $status = 'Surat Masuk';
                      break;
                    case 'd':
                      $status = 'Disposisi Surat';
                      break;
                    case 'p':
                      $status = 'Proses Surat';
                      break;
                    case 's':
                      $status = 'Proses Selesai';
                      break;
                    case 't':
                      $status = 'Surat Ditolak';
                      break;
                    default:
                      redirect(base_url());
                      break;
                  }
                  ?>
                  <td><a href="javascript:void(0)" onclick="status('<?php echo $item->id_surat; ?>')"><?php echo $status; ?></a></td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Data Riwayat Surat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalmbodi">
        <div id="detailsurat"></div>
        <table class="table">
          <thead>
            <tr>
              <th>Waktu</th>
              <th>Proses</th>
            </tr>
          </thead>
          <tbody id="tabelbodi">
            
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</body>

        <script src="<?php echo base_url(''); ?>assets/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/js/main.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/chart.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/jquery.vmap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/jquery.vmap.sampledata.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/jquery.vmap.world.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/jquery-ui.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/'); ?>daterangepicker/daterangepicker.js"></script>

    <script type="text/javascript">
var table = $('.datatable').DataTable( {
    "scrollX": true,
    "autoWidth": false,
});

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

<script type="text/javascript">
var data = {
            labels: [
            
            <?php
            for ($i=0; $i <= 4; $i++) {
                  $array[] = $this->pustaka->tanggal_indo_string_bulan_tahun(date("m-Y", strtotime("-" . $i . " months")));
            }
            foreach (array_reverse($array) as $item) {
                  echo '"'.$item.'",';
             }
             unset($array);
            ?>
            ],
            datasets: [
                  {
                        label: "Surat Masuk",
                        fillColor: "rgba(220,220,220,0.2)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: [
                        <?php
                        for ($i=0; $i <= 4; $i++) {
                              $bulan = explode('-', date("m-Y", strtotime("-" . $i . " months")))[0];
                              $tahun = explode('-', date("m-Y", strtotime("-" . $i . " months")))[1];

                              $array[] = $this->db->query("
                                    SELECT count(*) total
                                    FROM surat
                                    WHERE month(tanggal_surat) = ?
                                    AND year(tanggal_surat) = ?
                              ", [$bulan, $tahun])->row()->total;             
                        }
                        foreach (array_reverse($array) as $item) {
                              echo '"'.$item.'",';
                         }
                         unset($array);
                        ?>
                        ]
                  }
            ]
      };
      var pdata = [
            {
                  value: 300,
                  color:"#F7464A",
                  highlight: "#FF5A5E",
                  label: "Red"
            },
            {
                  value: 50,
                  color: "#46BFBD",
                  highlight: "#5AD3D1",
                  label: "Green"
            },
            {
                  value: 100,
                  color: "#FDB45C",
                  highlight: "#FFC870",
                  label: "Yellow"
            }
      ]

var ctxl = $("#lineChartDemo").get(0).getContext("2d");
var lineChart = new Chart(ctxl).Line(data, {
   responsive : true,
   animation: true,
   barValueSpacing : 5,
   barDatasetSpacing : 1,
   tooltipFillColor: "rgba(0,0,0,0.8)",                
   multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
});
</script>

  </body>

</html>