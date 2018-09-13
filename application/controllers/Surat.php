<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends CI_Controller {
	function __construct(){
		parent::__construct();

		if ($this->session->login != true) {
			redirect(base_url());
		}
	}

	function index() {
		$data['isi'] = 'surat/index';
		$data['js'] = 'surat/index_js';

		$this->load->view('template/template', $data);
	}

	function tambah() {
		$data['isi'] = 'surat/tambah';
		$data['js'] = 'surat/tambah_js';

		$this->load->view('template/template', $data);
	}

	function ubah($id) {
		$data['isi'] = 'surat/ubah';
		$data['js'] = 'surat/ubah_js';
		$data['data']['surat'] = $this->db->get_where('surat', ['id_surat' => $id])->row();

		$this->load->view('template/template', $data);
	}

	function aksi_tambah() {
		foreach ($this->input->post('data') as $key => $value) {
			switch ($key) {
				case 'tanggal_surat':
					$date=date_create($value);
					$data[$key] = date_format($date,"Y-m-d");
					break;
				default:
					$data[$key] = $value;
					break;
			}
		}

		$berkas = $_FILES['berkas'];
		$data['nama_file'] = $berkas['name'];

		$id_surat = $this->db->query('CALL sp_tambah_surat(?, ?, ?, ?, ?, ?, ?)', [$data['nosurat'], $data['tanggal_surat'], $data['pengirim'], $data['perihal'], $data['nama_file'], $data['id_jenis'], $data['prioritas']])->row()->id;

		move_uploaded_file($berkas['tmp_name'], 'uploads/surat/' . $id_surat);

		redirect(base_url('surat'));
	}

	function aksi_ubah() {
		foreach ($this->input->post('data') as $key => $value) {
			switch ($key) {
				case 'tanggal_surat':
					$date=date_create($value);
					$data[$key] = date_format($date,"Y-m-d");
					break;
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

		$berkas = $_FILES['berkas'];
		
		if ($berkas['size'] != 0) {
			$data['nama_file'] = $berkas['name'];
		}

		$this->db->update('surat', $data, $where);

		if ($berkas['size'] != 0) {
			move_uploaded_file($berkas['tmp_name'], 'uploads/surat/' . $where['id_surat']);
		}

		redirect(base_url('surat'));
	}

	function aksi_hapus($id) {
		$this->db->query('CALL sp_hapus_surat(?)', [$id]);

		unlink('uploads/surat/' . $id);

		redirect(base_url('surat'));
	}

}