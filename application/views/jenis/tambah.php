<div class="app-title">
  <div>
    <h1><i class="fa fa-edit"></i> Jenis</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item">Jenis</li>
  </ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Tambah Jenis</h3>
      <div class="tile-body">
        <form method="post" action="<?php echo base_url('jenis/aksi_tambah'); ?>" enctype=multipart/form-data>

          <div class="form-group">
            <label class="control-label">Jenis</label>
            <input class="form-control" type="text" required placeholder="Masukan Jenis" name="data[jenis]">
          </div>

          </div>
          <div class="tile-footer">
            <button id="simpan" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Simpan</button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="<?php echo base_url('jenis'); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a> <input type="submit" style="visibility: hidden;">
          </div>
        </form>
    </div>
  </div>
</div>