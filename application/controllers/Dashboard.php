<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();

		if ($this->session->login != true) {
			redirect(base_url());
		}
	}

	function index() {
		$data['isi'] = "dashboard/index";
		$data['js'] = "dashboard/index_js";
		
		$this->load->view("template/template", $data);
	}

}