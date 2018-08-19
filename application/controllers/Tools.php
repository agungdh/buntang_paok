<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Apfelbox\FileDownload\FileDownload;
class Tools extends CI_Controller {
	function __construct(){
		parent::__construct();
	}

	function download($id_surat) {
		$surat = $this->db->get_where('surat', ['id_surat' => $id_surat])->row();

		$fileDownload = FileDownload::createFromFilePath('uploads/surat/' . $surat->id_surat);
		$fileDownload->sendDownload($surat->nama_file);
	}

}