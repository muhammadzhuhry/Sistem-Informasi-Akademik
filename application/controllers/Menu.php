<?php
 
	class Menu extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			//checkAksesModule();
			$this->load->library('ssp');
			$this->load->model('model_menu');
		}

		function data()
		{

			// nama table
			$table      = 'tabel_menu';
			// nama PK
			$primaryKey = 'id';
			// list field yang mau ditampilkan
			$columns    = array(
				//tabel db(kolom di database) => dt(nama datatable di view)
				array('db' => 'nama_menu', 'dt' => 'nama_menu'),
		        array('db' => 'link', 'dt' => 'link'),
		        array('db' => 'is_main_menu', 
		        	  'dt' => 'is_main_menu',
		        	  'formatter' => function($d) {
		        	  	// $apabila $d(is_main_menu disini) bernilai 0 akan menampilkan Main menu, jika tidak akan menampilkan Sub Menu
		        	  	return $d == 0 ? 'Main Menu' : 'Sub Menu';
		        	  }
		        	),
		        //untuk menampilkan aksi(edit/delete dengan parameter id)
		        array(
		              'db' => 'id',
		              'dt' => 'aksi',
		              'formatter' => function($d) {
		               		return anchor('menu/edit/'.$d, '<i class="fa fa-edit"></i>', 'class="btn btn-xs btn-primary" data-placement="top" title="Edit"').' 
		               		'.anchor('menu/delete/'.$d, '<i class="fa fa-times fa fa-white"></i>', 'class="btn btn-xs btn-danger" data-placement="top" title="Delete"');
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
			$this->template->load('template', 'menu/view');
		}

		function add()
		{
			if (isset($_POST['submit'])) {
				$this->model_menu->save();
				redirect('menu');
			} else {
				$this->template->load('template', 'menu/add');
			}
		}

		function edit()
		{
			if (isset($_POST['submit'])) {
				$this->model_menu->update();
				redirect('menu');
			} else {
				$id_menu 	  = $this->uri->segment(3);
				$data['menu'] = $this->db->get_where('tabel_menu', array('id' => $id_menu))->row_array();
				$this->template->load('template', 'menu/edit', $data);
			}
		}

		function delete()
		{
			$id_menu = $this->uri->segment(3);
			if (!empty($id_menu)) {
				$this->db->where('id', $id_menu);
				$this->db->delete('tabel_menu');
			}
			redirect('user');
		}

	}

?>