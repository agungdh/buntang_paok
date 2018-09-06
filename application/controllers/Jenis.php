<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis extends CI_Controller {
	function __construct(){
		parent::__construct();

		if ($this->session->login != true) {
			redirect(base_url());
		}
	}

	function index() {
		$data['isi'] = 'jenis/index';
		$data['js'] = 'jenis/index_js';

		$this->load->view('template/template', $data);
	}

	function tambah() {
		$data['isi'] = 'jenis/tambah';
		$data['js'] = 'jenis/tambah_js';

		$this->load->view('template/template', $data);
	}

	function ubah($id) {
		$data['isi'] = 'jenis/ubah';
		$data['js'] = 'jenis/ubah_js';
		$data['data']['jenis'] = $this->db->get_where('jenis', ['id_jenis' => $id])->row();

		$this->load->view('template/template', $data);
	}

	function aksi_tambah() {
		foreach ($this->input->post('data') as $key => $value) {
			switch ($key) {
				default:
					$data[$key] = $value;
					break;
			}
		}

		$this->db->insert('jenis', $data);

		redirect(base_url('jenis'));
	}

	function aksi_ubah() {
		foreach ($this->input->post('data') as $key => $value) {
			switch ($key) {
				default:
					$data[$key] = $value;
					break;
			}
		}

		foreach ($this->input->post('where') as $key => $value) {
			switch ($key) {
				default:
					$where[$key] = $value;
					break;
			}
		}

		$this->db->update('jenis', $data, $where);

		redirect(base_url('jenis'));
	}

	function aksi_hapus($id) {
		$this->db->delete('jenis', ['id_jenis' => $id]);

		redirect(base_url('jenis'));
	}

}