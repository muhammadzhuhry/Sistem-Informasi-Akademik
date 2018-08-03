<?php
 
	class Tingkatan extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			//checkAksesModule();
			$this->load->library('ssp');
			$this->load->model('model_tingkatan');
		}

		function data()
		{

			// nama table
			$table      = 'tbl_tingkatan_kelas';
			// nama PK
			$primaryKey = 'kd_tingkatan';
			// list field yang mau ditampilkan
			$columns    = array(
				//tabel db(kolom di database) => dt(nama datatable di view)
				array('db' => 'kd_tingkatan', 'dt' => 'kd_tingkatan'),
		        array('db' => 'nama_tingkatan', 'dt' => 'nama_tingkatan'),
		        //untuk menampilkan aksi(edit/delete dengan parameter kode tingkatan)
		        array(
		              'db' => 'kd_tingkatan',
		              'dt' => 'aksi',
		              'formatter' => function($d) {
		               		return anchor('tingkatan/edit/'.$d, '<i class="fa fa-edit"></i>', 'class="btn btn-xs btn-primary" data-placement="top" title="Edit"').' 
		               		'.anchor('tingkatan/delete/'.$d, '<i class="fa fa-times fa fa-white"></i>', 'class="btn btn-xs btn-danger" data-placement="top" title="Delete"');
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
			$this->template->load('template', 'tingkatan/view');
		}

		function add()
		{
			if (isset($_POST['submit'])) {
				$this->model_tingkatan->save();
				redirect('tingkatan');
			} else {
				$this->template->load('template', 'tingkatan/add');
			}
		}

		function edit()
		{
			if (isset($_POST['submit'])) {
				$this->model_tingkatan->update();
				redirect('tingkatan');
			} else {
				$kode_tingkatan		= $this->uri->segment(3);
				$data['tingkatan']	= $this->db->get_where('tbl_tingkatan_kelas', array('kd_tingkatan' => $kode_tingkatan))->row_array();
				$this->template->load('template', 'tingkatan/edit', $data);
			}
		}

		function delete()
		{
			$kode_tingkatan = $this->uri->segment(3);
			if (!empty($kode_tingkatan)) {
				$this->db->where('kd_tingkatan', $kode_tingkatan);
				$this->db->delete('tbl_tingkatan_kelas');
			}
			redirect('tingkatan');
		}

	}

?>