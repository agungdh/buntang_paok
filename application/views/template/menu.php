<li><a class="app-menu__item" href="<?php echo base_url('dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>

<?php if ($this->session->level == 's') { ?>
<li><a class="app-menu__item" href="<?php echo base_url('bidang'); ?>"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Bidang</span></a></li>
<?php } ?>

<?php if ($this->session->level == 's') { ?>
<li><a class="app-menu__item" href="<?php echo base_url('jenis'); ?>"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Jenis</span></a></li>
<?php } ?>

<?php if ($this->session->level == 'o') { ?>
<li><a class="app-menu__item" href="<?php echo base_url('surat'); ?>"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Surat</span></a></li>
<?php } else { ?>
<li><a class="app-menu__item" href="<?php echo base_url('surat2'); ?>"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Surat</span></a></li>
<?php } ?>

<?php if ($this->session->level == 's') { ?>
<li><a class="app-menu__item" href="<?php echo base_url('user'); ?>"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">User</span></a></li>
<?php } ?>