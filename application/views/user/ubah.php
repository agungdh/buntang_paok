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
      <h3 class="tile-title">Ubah User</h3>
      <div class="tile-body">
        <form id="form_ubah" method="post" action="<?php echo base_url('user/aksi_ubah'); ?>">
          
          <input type="hidden" name="where[id_user]" value="<?php echo $data['user']->id_user; ?>">

          <div class="form-group">
            <label class="control-label">Nama</label>
            <input class="form-control" required type="text" placeholder="Masukan Nama" name="data[nama]" value="<?php echo $data['user']->nama; ?>">
          </div>

          <div class="form-group">
            <label class="control-label">Username</label>
            <input class="form-control" required type="text" placeholder="Masukan Username" name="data[username]" value="<?php echo $data['user']->username; ?>">
          </div>

          <div class="form-group">
            <label class="control-label">Level</label>
            <select class="form-control select2" required name="data[level]" id="level">
              <option <?php echo $data['user']->level == 'kd' ? 'selected' : null; ?> value="kd">Kepala Dinas</option>
              <option <?php echo $data['user']->level == 's' ? 'selected' : null; ?> value="s">Sekertaris</option>
              <option <?php echo $data['user']->level == 'kb' ? 'selected' : null; ?> value="kb">Kepala Bidang</option>
              <option <?php echo $data['user']->level == 'o' ? 'selected' : null; ?> value="o">Operator</option>
            </select>
          </div>

          <div class="form-group">
            <label class="control-label">Bidang</label>
            <select class="form-control select2" required name="data[id_bidang]" id="id_bidang">
              <?php
              foreach ($this->db->get('bidang')->result() as $item) {
                ?>
                <option <?php echo $item->id_bidang == $data['user']->id_bidang ? 'selected' : null; ?> value="<?php echo $item->id_bidang; ?>"><?php echo $item->bidang; ?></option>
                <?php
              }
              ?>
            </select>
          </div>

          </div>
          <div class="tile-footer">
            <button id="simpan_ubah" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Simpan</button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="<?php echo base_url('user'); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a> <input type="submit" id="submit_ubah" style="visibility: hidden;">
          </div>
        </form>
    </div>
  </div>

  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Ubah Password</h3>
      <div class="tile-body">
        <form id="form_ubah_password" method="post" action="<?php echo base_url('user/aksi_ubah_password'); ?>">
          
          <input type="hidden" name="where[id_user]" value="<?php echo $data['user']->id_user; ?>">

          <div class="form-group">
            <label class="control-label">Password</label>
            <input class="form-control" id="password" required type="password" placeholder="Masukan Password" name="data[password]">
          </div>

          <div class="form-group">
            <label class="control-label">Ulangi Password</label>
            <input class="form-control" id="password2" required type="password" placeholder="Ulangi Password">
          </div>

          </div>
          <div class="tile-footer">
            <button id="simpan_ubah_password" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Simpan</button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="<?php echo base_url('user'); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a> <input type="submit" id="submit_ubah_password" style="visibility: hidden;">
          </div>
        </form>
    </div>
  </div>
</div>