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
        <form method="post" action="<?php echo base_url('surat/aksi_ubah'); ?>" enctype=multipart/form-data>

          <input type="hidden" name="where[id_surat]" value="<?php echo $data['surat']->id_surat; ?>">

          <div class="form-group">
            <label class="control-label">No Surat</label>
            <input class="form-control" type="text" required placeholder="Masukan No Surat" name="data[nosurat]" value="<?php echo $data['surat']->nosurat; ?>">
          </div>

          <div class="form-group">
            <label class="control-label">Tanggal</label>
            <input class="form-control datepicker" type="text" required placeholder="Masukan Tanggal" name="data[tanggal_surat]"  value="<?php echo $this->pustaka->tanggal_indo($data['surat']->tanggal_surat); ?>">
          </div>

          <div class="form-group">
            <label class="control-label">Pengirim</label>
            <input class="form-control" type="text" required placeholder="Masukan Pengirim" name="data[pengirim]" value="<?php echo $data['surat']->pengirim; ?>">
          </div>

          <div class="form-group">
            <label class="control-label">Perihal</label>
            <input class="form-control" type="text" required placeholder="Masukan Perihal" name="data[perihal]" value="<?php echo $data['surat']->perihal; ?>">
          </div>

          <div class="form-group">
            <label class="control-label">Berkas</label>
            <p><a href="<?php echo base_url('tools/download/' . $data['surat']->id_surat); ?>"><?php echo $data['surat']->nama_file; ?></a></p>
            <input class="form-control" type="file" name="berkas">
          </div>

          </div>
          <div class="tile-footer">
            <button id="simpan" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Simpan</button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="<?php echo base_url('surat'); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a> <input type="submit" style="visibility: hidden;">
          </div>
        </form>
    </div>
  </div>
</div>