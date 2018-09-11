<div class="app-title">
  <div>
    <h1><i class="fa fa-edit"></i> User</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">User</li>
  </ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Tambah User</h3>
      <div class="tile-body">
        <form method="post" action="<?php echo base_url('user/aksi_tambah'); ?>">
          
          <div class="form-group">
            <label class="control-label">Nama</label>
            <input class="form-control" type="text" required placeholder="Masukan Nama" name="data[nama]">
          </div>

          <div class="form-group">
            <label class="control-label">Username</label>
            <input class="form-control" type="text" required placeholder="Masukan Username" name="data[username]">
          </div>

          <div class="form-group">
            <label class="control-label">Password</label>
            <input class="form-control" type="password" required placeholder="Masukan Password" name="data[password]">
          </div>

          <div class="form-group">
            <label class="control-label">Level</label>
            <select class="form-control select2" required name="data[level]" id="level">
              <option value="kd">Kepala Dinas</option>
              <option value="s">Sekertaris</option>
              <option value="kb">Kepala Bidang</option>
              <option value="o">Operator</option>
            </select>
          </div>

          <div class="form-group">
            <label class="control-label">Bidang</label>
            <select class="form-control select2" required name="data[id_bidang]" id="id_bidang">
              <?php
              foreach ($this->db->get('bidang')->result() as $item) {
                ?>
                <option value="<?php echo $item->id_bidang; ?>"><?php echo $item->bidang; ?></option>
                <?php
              }
              ?>
            </select>
          </div>

          </div>
          <div class="tile-footer">
            <button id="simpan" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Simpan</button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="<?php echo base_url('user'); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a> <input type="submit" style="visibility: hidden;">
          </div>
        </form>
    </div>
  </div>
</div>