<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {
	function __construct(){
		parent::__construct();

		if ($this->session->login != true) {
			redirect(base_url());
		}
	}

	function index() {
		$data['isi'] = 'profil/index';
		$data['js'] = 'profil/index_js';
		$data['data']['user'] = $this->db->get_where('user', ['id_user' => $this->session->id_user])->row();

		$this->load->view('template/template', $data);
	}

	function aksi_ubah() {
		$fav = $_FILES['foto'];
		if ($fav['size'] != 0) {
			move_uploaded_file($fav['tmp_name'], 'uploads/userimage/temp/' . $this->session->id_user);

			$image = new \Gumlet\ImageResize('uploads/userimage/temp/' . $this->session->id_user);
			$image->crop(64, 64);
			$image->save('uploads/userimage/' . $this->session->id_user);

			unlink('uploads/userimage/temp/' . $this->session->id_user);
		}

		foreach ($this->input->post('data') as $key => $value) {
			$data[$key] = $value;
		}

		foreach ($this->input->post('where') as $key => $value) {
			$where[$key] = $value;
		}

		$this->db->update('user', $data, $where);

		$this->session->set_userdata('nama', $data['nama']);

		redirect(base_url());
	}

	function aksi_ubah_password() {
		foreach ($this->input->post('data') as $key => $value) {
			$data[$key] = hash('sha512', $value);
		}

		foreach ($this->input->post('where') as $key => $value) {
			$where[$key] = $value;
		}

		$this->db->update('user', $data, $where);

		redirect(base_url());
	}

}