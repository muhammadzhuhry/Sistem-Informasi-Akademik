<?php
 
	class Jurusan extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			//checkAksesModule();
			$this->load->library('ssp');
			$this->load->model('model_jurusan');
		}

		function data()
		{

			// nama table
			$table      = 'tbl_jurusan';
			// nama PK
			$primaryKey = 'kd_jurusan';
			// list field yang mau ditampilkan
			$columns    = array(
				//tabel db(kolom di database) => dt(nama datatable di view)
				array('db' => 'kd_jurusan', 'dt' => 'kd_jurusan'),
		        array('db' => 'nama_jurusan', 'dt' => 'nama_jurusan'),
		        //untuk menampilkan aksi(edit/delete dengan parameter kode jurusan)
		        array(
		              'db' => 'kd_jurusan',
		              'dt' => 'aksi',
		              'formatter' => function($d) {
		               		return anchor('jurusan/edit/'.$d, '<i class="fa fa-edit"></i>', 'class="btn btn-xs btn-primary" data-placement="top" title="Edit"').' 
		               		'.anchor('jurusan/delete/'.$d, '<i class="fa fa-times fa fa-white"></i>', 'class="btn btn-xs btn-danger" data-placement="top" title="Delete"');
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
			$this->template->load('template', 'jurusan/view');
		}

		function add()
		{
			if (isset($_POST['submit'])) {
				$this->model_jurusan->save();
				redirect('jurusan');
			} else {
				$this->template->load('template', 'jurusan/add');
			}
		}

		function edit()
		{
			if (isset($_POST['submit'])) {
				$this->model_jurusan->update();
				redirect('jurusan');
			} else {
				$kode_jurusan		= $this->uri->segment(3);
				$data['jurusan']	= $this->db->get_where('tbl_jurusan', array('kd_jurusan' => $kode_jurusan))->row_array();
				$this->template->load('template', 'jurusan/edit', $data);
			}
		}

		function delete()
		{
			$kode_jurusan = $this->uri->segment(3);
			if (!empty($kode_jurusan)) {
				$this->db->where('kd_jurusan', $kode_jurusan);
				$this->db->delete('tbl_jurusan');
			}
			redirect('jurusan');
		}

	}

?>