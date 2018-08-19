<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidang extends CI_Controller {
	function __construct(){
		parent::__construct();

		if ($this->session->login != true) {
			redirect(base_url());
		}
	}

	function index() {
		$data['isi'] = 'bidang/index';
		$data['js'] = 'bidang/index_js';

		$this->load->view('template/template', $data);
	}

	function tambah() {
		$data['isi'] = 'bidang/tambah';
		$data['js'] = 'bidang/tambah_js';

		$this->load->view('template/template', $data);
	}

	function ubah($id) {
		$data['isi'] = 'bidang/ubah';
		$data['js'] = 'bidang/ubah_js';
		$data['data']['bidang'] = $this->db->get_where('bidang', ['id_bidang' => $id])->row();

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

		$this->db->insert('bidang', $data);

		redirect(base_url('bidang'));
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

		$this->db->update('bidang', $data, $where);

		redirect(base_url('bidang'));
	}

	function aksi_hapus($id) {
		$this->db->delete('bidang', ['id_bidang' => $id]);

		redirect(base_url('bidang'));
	}

}