<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat2 extends CI_Controller {
	function __construct(){
		parent::__construct();

		if ($this->session->login != true) {
			redirect(base_url());
		}
	}

	function index() {
		$data['isi'] = 'surat2/index';
		$data['js'] = 'surat2/index_js';

		$this->load->view('template/template', $data);
	}

	function tambah() {
		$data['isi'] = 'surat2/tambah';
		$data['js'] = 'surat2/tambah_js';

		$this->load->view('template/template', $data);
	}

	function disposisi($id) {
		$data['isi'] = 'surat2/disposisi';
		$data['js'] = 'surat2/disposisi_js';
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

		$id_surat = $this->db->query('CALL sp_tambah_surat(?, ?, ?, ?, ?)', [$data['nosurat'], $data['tanggal_surat'], $data['pengirim'], $data['perihal'], $data['nama_file']])->row()->id;

		move_uploaded_file($berkas['tmp_name'], 'uploads/surat2/' . $id_surat);

		redirect(base_url('surat2'));
	}

	function aksi_disposisi() {
		$id_surat = $this->input->post('id_surat');
		$id_bidang = $this->input->post('id_bidang');
		$level = $id_bidang == 'kd' ? 'kd' : 'kb';

		$this->db->query('CALL sp_disposisi_surat(?, ?, ?)', [$id_surat, $level, $id_bidang]);

		redirect(base_url('surat2'));
	}

	function aksi_proses($id) {
		$this->db->query('CALL sp_proses_surat(?)', [$id]);

		redirect(base_url('surat2'));
	}

	function aksi_selesai($id) {
		$this->db->query('CALL sp_selesai_surat(?)', [$id]);

		redirect(base_url('surat2'));
	}

	function aksi_tolak($id) {
		$this->db->update('surat', ['status' => 't'], ['id_surat' => $id]);
		$this->db->insert('log_surat', ['id_surat' => $id, 'waktu' => date('Y-m-d H:i:s'), 'aksi' => 't']);

		redirect(base_url('surat2'));
	}

	function ajax_isisurat($id_surat) {
		foreach ($this->db->get_where('log_surat', ['id_surat' => $id_surat])->result() as $item) {
			switch ($item->aksi) {
              case 'm':
                $status = 'Surat Masuk';
                break;
              case 'd':
                $status = 'Disposisi Surat (';
                if ($item->id_bidang != null) {
                	$status .= $this->db->get_where('bidang', ['id_bidang' => $item->id_bidang])->row()->bidang;
                } else {
                	$status .= 'Sekertaris';
                }
                $status .= ')';
                break;
              case 'p':
                $status = 'Proses Surat';
                break;
              case 's':
                $status = 'Proses Selesai';
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