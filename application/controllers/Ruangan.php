<?php
 
	class Ruangan extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			//checkAksesModule();
			$this->load->library('ssp');
			$this->load->model('model_ruangan');
		}

		function data()
		{

			// nama table
			$table      = 'tbl_ruangan';
			// nama PK
			$primaryKey = 'kd_ruangan';
			// list field yang mau ditampilkan
			$columns    = array(
				//tabel db(kolom di database) => dt(nama datatable di view)
				array('db' => 'kd_ruangan', 'dt' => 'kd_ruangan'),
		        array('db' => 'nama_ruangan', 'dt' => 'nama_ruangan'),
		        //untuk menampilkan aksi(edit/delete dengan parameter kode ruangan)
		        array(
		              'db' => 'kd_ruangan',
		              'dt' => 'aksi',
		              'formatter' => function($d) {
		               		return anchor('ruangan/edit/'.$d, '<i class="fa fa-edit"></i>', 'class="btn btn-xs btn-primary" data-placement="top" title="Edit"').' 
		               		'.anchor('ruangan/delete/'.$d, '<i class="fa fa-times fa fa-white"></i>', 'class="btn btn-xs btn-danger" data-placement="top" title="Delete"');
		            }
		        )
		    );

			$sql_details = array(
				'user' => $this->db->username,
				'pass' => $this->db->password,
				'db'   => $this->db->database,
				'host' => $this->db->hostname
		    );

		    echo json_encode(
		     	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
		     );

		}

		function index()
		{
			$this->template->load('template', 'ruangan/view');
		}

		function add()
		{
			if (isset($_POST['submit'])) {
				$this->model_ruangan->save();
				redirect('ruangan');
			} else {
				$this->template->load('template', 'ruangan/add');
			}
		}

		function edit()
		{
			if (isset($_POST['submit'])) {
				$this->model_ruangan->update();
				redirect('ruangan');
			} else {
				$kode_ruangan	 = $this->uri->segment(3);
				$data['ruangan'] = $this->db->get_where('tbl_ruangan', array('kd_ruangan' => $kode_ruangan))->row_array();
				$this->template->load('template', 'ruangan/edit', $data);
			}
		}

		function delete()
		{
			$kode_ruangan = $this->uri->segment(3);
			if (!empty($kode_ruangan)) {
				$this->db->where('kd_ruangan', $kode_ruangan);
				$this->db->delete('tbl_ruangan');
			}
			redirect('ruangan');
		}

	}

?>