<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct(){
		parent::__construct();
	}

	function index() {
		$this->load->view('main');
	}

	function login() {
		$data_user = $this->db->get_where('user', ['username' => $this->input->post('username'), 'password' => hash("sha512", $this->input->post('password'))])->row();

		if ($data_user != null) {			
			$array_data_user = array(
				'id_user'  => $data_user->id_user,
				'nama'  => $data_user->nama,
				'username'  => $data_user->username,
				'level'  => $data_user->level,
				'id_bidang'  => $data_user->id_bidang,
				'login'  => true
			);

			$this->session->set_userdata($array_data_user);

			echo json_encode(['login' => true]);
		} else {
			$data['header'] = "ERROR !!!";
			$data['pesan'] = "Password Salah !!!";
			$data['status'] = "error";

			$data['login'] = false;

			echo json_encode($data);
		}
	}

	function ajax_isisurat($id_surat) {
		foreach ($this->db->get_where('log_surat', ['id_surat' => $id_surat])->result() as $item) {
			switch ($item->aksi) {
              case 'm':
                $status = 'Surat Masuk';
                break;
              case 'd':
              	$log_surat_sebelumnya = $this->db->query('SELECT *
              												FROM log_surat
              												WHERE id_surat = ?
              												AND id_log_surat < ?
              												ORDER BY id_log_surat DESC
              												LIMIT 1', [$item->id_surat, $item->id_log_surat])->row();
              	$serah = false;
              	if ($log_surat_sebelumnya->aksi == 'm' && $log_surat_sebelumnya->id_bidang == null) {
              		$dari = 'Sekertaris';
              		if ($item->id_bidang == null) {
              			$serah = true;
              		}
              	} elseif ($log_surat_sebelumnya->aksi == 'd' && $log_surat_sebelumnya->id_bidang == null) {
              		$dari = 'Kepala Dinas';
              	} else {
              		$dari = $this->db->get_where('bidang', ['id_bidang' => $log_surat_sebelumnya->id_bidang])->row()->bidang;
              	}

              	if ($serah == true) {
              		$status = 'Sekretaris Menyerahkan Surat Kepada Kepala Dinas';
              	} else {
	                $status = 'Surat Didisposisi Dari ' . $dari . ' Kepada ';
	                if ($item->id_bidang != null) {
	                	$status .= $this->db->get_where('bidang', ['id_bidang' => $item->id_bidang])->row()->bidang;
	                } else {
	                	$status .= 'Kepala Dinas';
	                }
              	}
                break;
              case 'p':
	              $status = 'Surat Diproses';
	              break;
	            case 's':
	              $status = 'Surat Selesai Proses';
	              break;
	            case 't':
	              $status = 'Surat Ditolak';
	              break;
              default:
                redirect(base_url());
                break;
            }
			?>
			<tr>
				<td><?php echo $this->pustaka->tanggal_waktu_indo($item->waktu); ?></td>
				<td><?php echo $status; ?></td>
			</tr>
			<?php
			if ($status == 'Surat Masuk') {
				?>
				<tr>
					<td><?php echo $this->pustaka->tanggal_waktu_indo($item->waktu); ?></td>
					<td>Surat Diterima Sekretaris</td>
				</tr>
				<?php
			}
			?>
			<?php			
		}
	}

	function ajax_detailsurat($id_surat) {
		$surat = $this->db->get_where('surat', ['id_surat' => $id_surat])->row();
		?>
		<table>
          <tbody>
            <tr>
              <td>Tanggal</td>
              <td id="tanggal">: <?php echo $this->pustaka->tanggal_indo($surat->tanggal_surat); ?></td>
            </tr>
            <tr>
              <td>No Surat</td>
              <td id="nosurat">: <?php echo $surat->nosurat; ?></td>
            </tr>
            <tr>
              <td>Pengirim</td>
              <td id="pengirim">: <?php echo $surat->pengirim; ?></td>
            </tr>
            <tr>
              <td>Perihal</td>
              <td id="perihal">: <?php echo $surat->perihal; ?></td>
            </tr>
            <tr>
              <td>Berkas</td>
              <td id="berkas">: <a href="<?php echo base_url('tools/download/' . $surat->id_surat); ?>"><?php echo $surat->nama_file; ?></a></td>
            </tr>
             
          </tbody>
        </table>
		<?php
	}

}