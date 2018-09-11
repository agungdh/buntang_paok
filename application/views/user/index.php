<div class="app-title">
  <div>
    <h1><i class="fa fa-users"></i> User</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">User</li>
  </ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">
        <div class="tile-title-w-btn">
          <h3 class="title">Data User</h3>
          <p><a class="btn btn-primary icon-btn" href="<?php echo base_url('user/tambah'); ?>"><i class="fa fa-plus"></i>User</a></p>
        </div>
        <table class="table table-hover table-bordered datatable">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Username</th>
              <th>Level</th>
              <th>Bidang</th>
              <th>Proses</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($this->db->get('user')->result() as $item) {
              ?>
              <tr>
                <td><?php echo $item->nama; ?></td>
                <td><?php echo $item->username; ?></td>
                <?php
                switch ($item->level) {
                  case 'kd':
                    $level = 'Kepala Dinas';
                    break;
                  case 's':
                    $level = 'Sekertaris';
                    break;
                  case 'kb':
                    $level = 'Kepala Bidang';
                    break;
                  case 'o':
                    $level = 'Operator';
                    break;                  
                  default:
                    redirect(base_url());
                    break;
                }
                ?>
                <td><?php echo $level; ?></td>
                <?php
                if ($item->id_bidang != null) {
                  $bidang = $this->db->get_where('bidang', ['id_bidang' => $item->id_bidang])->row()->bidang;
                } else {
                  $bidang = '-';
                }
                ?>
                <td><?php echo $bidang ; ?></td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url('user/ubah/' . $item->id_user); ?>" data-toggle="tooltip" title="Ubah"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-primary" href="javascript:void(0)" onclick="hapus('<?php echo $item->id_user; ?>')" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                  </div>
                </td>
              </tr>
              <?php
            } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  </div>
</div>