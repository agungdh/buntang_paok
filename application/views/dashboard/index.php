<div class="app-title">
  <div>
    <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Dashboard</li>
  </ul>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Grafik Surat</h3>
      <div class="embed-responsive embed-responsive-16by9">
        <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">
        <div class="tile-title-w-btn">
          <h3 class="title">Data Surat</h3>
        </div>
        <table class="table table-hover table-bordered datatable">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>No Surat</th>
              <th>Pengirim</th>
              <th>Perihal</th>
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