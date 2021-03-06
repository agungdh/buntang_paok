<div class="app-title">
  <div>
    <h1><i class="fa fa-book"></i> Surat</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Surat</li>
  </ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">
        <div class="tile-title-w-btn">
          <h3 class="title">Data Surat</h3>
          <p><a class="btn btn-primary icon-btn" href="<?php echo base_url('surat/tambah'); ?>"><i class="fa fa-plus"></i>Surat</a></p>
        </div>
        <table class="table table-hover table-bordered datatable">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>No Surat</th>
              <th>Pengirim</th>
              <th>Perihal</th>
              <th>Jenis</th>
              <th>Prioritas</th>
              <th>Lampiran</th>
              <th>Status</th>
              <th>Proses</th>
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
                  <?php 
                if ($item->prioritas =='st') {
                  echo "<td> <a class='btn btn-danger btn-sm' > <font color='white' > Sangat Penting</font></a></td>";
                }elseif ($item->prioritas=='t') {
                  echo "<td> <a class='btn btn-warning btn-sm' > <font color='white' > Penting</font></a></td>";
                }else{
                  echo "<td> <a class='btn btn-info btn-sm' > <font color='white' > Biasa</font></a></td>";
                }

                 ?>

                <td><a href="<?php echo base_url('tools/download/' . $item->id_surat); ?>"><?php echo $item->nama_file; ?></a></td>
                <?php
                switch ($item->status) {
                  case 'm':
                      $status = 'Surat Masuk';
                      break;
                    case 'd':
                      $status = 'Surat Didisposisi';
                      break;
                    case 'p':
                      $status = 'Surat Diproses';
                      break;
                    case 's':
                      $status = 'Surat Selesai Diproses';
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
                <td>
                  <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url('surat/ubah/' . $item->id_surat); ?>" data-toggle="tooltip" title="Ubah"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-primary" href="javascript:void(0)" onclick="hapus('<?php echo $item->id_surat; ?>')" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                  </div>
                </td>
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