<div class="app-title">
  <div>
    <h1><i class="fa fa-edit"></i> Surat</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Surat</li>
  </ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Ubah Surat</h3>
      <div class="tile-body">
        <form method="post" action="<?php echo base_url('surat2/aksi_disposisi'); ?>" enctype=multipart/form-data>

          <input type="hidden" name="id_surat" value="<?php echo $data['surat']->id_surat; ?>">

          <div class="form-group">
            <label class="control-label">No Surat</label>
            <input class="form-control" type="text" required placeholder="Masukan No Surat" value="<?php echo $data['surat']->nosurat; ?>" readonly>
          </div>

          <div class="form-group">
            <label class="control-label">Tanggal</label>
            <input class="form-control" type="text" required placeholder="Masukan Tanggal"  value="<?php echo $this->pustaka->tanggal_indo($data['surat']->tanggal_surat); ?>" readonly>
          </div>

          <div class="form-group">
            <label class="control-label">Pengirim</label>
            <input class="form-control" type="text" required placeholder="Masukan Pengirim" value="<?php echo $data['surat']->pengirim; ?>" readonly>
          </div>

          <div class="form-group">
            <label class="control-label">Perihal</label>
            <input class="form-control" type="text" required placeholder="Masukan Perihal" value="<?php echo $data['surat']->perihal; ?>" readonly>
          </div>

          <div class="form-group">
            <label class="control-label">Berkas</label>
            <p><a href="<?php echo base_url('tools/download/' . $data['surat']->id_surat); ?>"><?php echo $data['surat']->nama_file; ?></a></p>
          </div>

          <div class="form-group">
            <label class="control-label">Disposisi</label>
            <select class="form-control select2" required name="id_bidang" id="id_bidang">
              <?php
              if ($this->session->level != 'kd') {
                ?>
                <option value="kd">Kepala Dinas</option>
                <?php
              }
              ?>
              <?php
              foreach ($this->db->query('SELECT *
                                          FROM bidang
                                          WHERE id_bidang != ?', [$this->session->id_bidang != null ? $this->session->id_bidang : ''])->result() as $item) {
                ?>
                <option value="<?php echo $item->id_bidang; ?>">Bidang <?php echo $item->bidang; ?></option>
                <?php
              }
              ?>
            </select>
          </div>

          </div>
          <div class="tile-footer">
            <button id="simpan" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Disposisi</button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="<?php echo base_url('surat2'); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a> <input type="submit" style="visibility: hidden;">
          </div>
        </form>
    </div>
  </div>
</div>