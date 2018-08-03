<?php

	class User extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			//checkAksesModule();
			$this->load->library('ssp');
			$this->load->model('model_user');
		}

		function data()
		{

			// nama table
			$table      = 'view_user';
			// nama PK
			$primaryKey = 'id_user';
			// list field yang mau ditampilkan
			$columns    = array(
				//tabel db(kolom di database) => dt(nama datatable di view)
				array('db' => 'foto', 
					  'dt' => 'foto',
					  'formatter' => function($d) {
					  		return "<img width='20px' src='".base_url()."/uploads/".$d."'>";
					  }
				),
		        array('db' => 'nama_lengkap', 'dt' => 'nama_lengkap'),
		        array('db' => 'nama_level', 'dt' => 'nama_level'),
		        //untuk menampilkan aksi(edit/delete dengan parameter id user)
		        array(
		              'db' => 'id_user',
		              'dt' => 'aksi',
		              'formatter' => function($d) {
		               		return anchor('user/edit/'.$d, '<i class="fa fa-edit"></i>', 'class="btn btn-xs btn-primary" data-placement="top" title="Edit"').' 
		               		'.anchor('user/delete/'.$d, '<i class="fa fa-times fa fa-white"></i>', 'class="btn btn-xs btn-danger" data-placement="top" title="Delete"');
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
			$this->template->load('template', 'user/view');
		}

		function add()
		{
			if (isset($_POST['submit'])) {
				$uploadFoto = $this->upload_foto_user();
				$this->model_user->save($uploadFoto);
				redirect('user');
			} else {
				$this->template->load('template', 'user/add');
			}
		}

		function edit()
		{
			if (isset($_POST['submit'])) {
				$uploadFoto = $this->upload_foto_user();
				$this->model_user->update($uploadFoto);
				redirect('user');
			} else {
				$id_user 		= $this->uri->segment(3);
				$data['user'] 	= $this->db->get_where('tbl_user', array('id_user' => $id_user))->row_array();
				$this->template->load('template', 'user/edit', $data);
			}
		}

		function delete()
		{
			$kode_user = $this->uri->segment(3);
			if (!empty($kode_user)) {
				$this->db->where('kd_user', $kode_user);
				$this->db->delete('tbl_user');
			}
			redirect('user');
		}

		function upload_foto_user()
		{
			//validasi foto yang di upload
			$config['upload_path']          = './uploads/user/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 1024;
            $this->load->library('upload', $config);

            //proses upload
            $this->upload->do_upload('userfile');
            $upload = $this->upload->data();
            return $upload['file_name'];
		}

		function rule()
		{
			$this->template->load('template', 'user/rule');
		}

		function module()
		{
			$level_user = $_GET['level_user'];
			echo "<table id='mytable' class='table table-striped table-bordered table-hover table-full-width dataTable'>
	                <thead>
	                    <tr>
	                        <th width='50px' class='text-center'>NO</th>
	                        <th>NAMA MODULE</th>
	                        <th>LINK</th>
	                        <th width='100px' class='text-center'> HAK AKSES</th>
	                    </tr>";

	        $menu = $this->db->get('tabel_menu');
	        $no = 1;

	        foreach ($menu->result() as $row) {
	        	echo "<tr>
							<td class='text-center'>$no</td>
							<td>$row->nama_menu</td>
							<td>$row->link</td>
							<td class='text-center'><input type='checkbox' "; 
				$this->check_module($level_user, $row->id);			
				echo		"onClick='addRule($row->id)'></td>
	        		 </tr>";
	        	$no++;
	        }
	        // di checkbox onClick='addRule($row->id)' akan memparsing id menu yang di klik sehingga dapat ditangkap oleh function ajax di addRule->terletak di user/rule
	        echo    "</thead>
	              </table>";
		}

		// function check_module digunakan untuk memanggil checked ke dalam tag html, sehingga apabila datanya ada maka akan menampilkan centang sesuai $id_menu dan $level_user
		function check_module($level_user, $id_menu)
		{
			$data 		= array(
					'id_menu' => $id_menu, 
					'id_level_user' => $level_user );
			$check 		= $this->db->get_where('tbl_user_rule', $data);

			if ($check->num_rows() > 0) {
				echo "checked ";
			}
		}

		function add_rule()
		{
			$level_user	= $_GET['level_user'];
			$id_menu	= $_GET['id_modul'];

			// $leveluser dan idmenu diambil dari function ajax addRule()
			$data 		= array(
					'id_menu' => $id_menu, 
					'id_level_user' => $level_user );

			// $data untuk menampilkan data yang sesuai
			$check 		= $this->db->get_where('tbl_user_rule', $data);

			if ($check->num_rows() < 1) {
				// apabila datanya belum ada (kecil dari 1) maka akan menginsert
				$this->db->insert('tbl_user_rule', $data);
			} else {
				$this->db->where('id_menu', $id_menu);
				$this->db->where('id_level_user', $level_user);
				$this->db->delete('tbl_user_rule');
			}
		}

	}

?>