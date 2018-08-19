<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {
	function __construct(){
		parent::__construct();

		if ($this->session->login != true) {
			redirect(base_url());
		}
	}

	function index() {
		$data['isi'] = 'config/index';
		$data['js'] = 'config/index_js';
		$data['data']['config'] = $this->db->get('config')->row();

		$this->load->view('template/template', $data);
	}

	function aksi_ubah() {
		$fav = $_FILES['favicon'];
		if ($fav['size'] != 0) {
			move_uploaded_file($fav['tmp_name'], 'uploads/favicon');
		}

		foreach ($this->input->post('data') as $key => $value) {
			$data[$key] = $value;
		}

		$this->db->update('config', $data);

		redirect(base_url());
	}

}