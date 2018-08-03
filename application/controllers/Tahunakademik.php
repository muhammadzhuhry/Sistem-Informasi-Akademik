<?php

	class Tahunakademik extends CI_Controller
	{

		function __construct()
		{
			parent::__construct();
			//checkAksesModule();
			$this->load->library('ssp');
			$this->load->model('model_tahunakademik');
		}

		function data()
		{

			// nama table
			$table      = 'tbl_tahun_akademik';
			// nama PK
			$primaryKey = 'id_tahun_akademik';
			// list field yang mau ditampilkan
			$columns    = array(
				//tabel db(kolom di database) => dt(nama datatable di view)
				array('db' => 'id_tahun_akademik', 'dt' => 'id_tahun_akademik'),
		        array('db' => 'tahun_akademik', 'dt' => 'tahun_akademik'),
		        array(
		        	  'db' => 'is_aktif',
		        	  'dt' => 'is_aktif',
		        	  'formatter' => function($d) {
		        	  	//Apabila $d bernilai Y maka akan menampilkan 'Aktif' apabila bernilai selain y akan menampilkan 'Tidak aktif'
		        	  	return $d == 'Y' ? 'Aktif' : 'Tidak Aktif';
		        	  }
		        	),
		        //untuk menampilkan aksi(edit/delete dengan parameter kode tahunakademik)
		        array(
		              'db' => 'id_tahun_akademik',
		              'dt' => 'aksi',
		              'formatter' => function($d) {
		               		return anchor('tahunakademik/aktif/'.$d, 'Aktifkan', 'class="btn btn-xs bg-orange" data-placement="top" title="Aktif"').'
		               		'.anchor('tahunakademik/edit/'.$d, '<i class="fa fa-edit"></i>', 'class="btn btn-xs btn-primary" data-placement="top" title="Edit"').'
		               		'.anchor('tahunakademik/delete/'.$d, '<i class="fa fa-times fa fa-white"></i>', 'class="btn btn-xs btn-danger" data-placement="top" title="Delete"');
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
			$this->template->load('template', 'tahunakademik/view');
		}

		function add()
		{
			if (isset($_POST['submit'])) {
				$this->model_tahunakademik->save();

				// untuk mengambil id tahun akdemik terakhir yang diinputkan
				$idTahunAkademik = $this->db->insert_id();

				$this->load->model('model_walikelas');
				// insert data dummy walikelas secara otomatis ketika add tahun akademik baru
				$this->model_walikelas->insert_walikelas($idTahunAkademik);
				redirect('tahunakademik');
			} else {
				$this->template->load('template', 'tahunakademik/add');
			}
		}

		function edit()
		{
			if (isset($_POST['submit'])) {
					$this->model_tahunakademik->update();
					redirect('tahunakademik');
				} else {
					$id_tahunakademik 		= $this->uri->segment(3);
					$data['tahunakademik']	= $this->db->get_where('tbl_tahun_akademik', array('id_tahun_akademik' => $id_tahunakademik))->row_array();
					$this->template->load('template', 'tahunakademik/edit', $data);
				}
			}

		function delete()
		{
			$id_tahunakademik = $this->uri->segment(3);
			if (!empty($id_tahunakademik)) {
				$this->db->where('id_tahun_akademik', $id_tahunakademik);
				$this->db->delete('tbl_tahun_akademik');
			}
			redirect('tahunakademik');
		}

		function aktif()
		{
			$id_tahunakademik = $this->uri->segment(3);
			//$query = "SELECT * FROM tbl_tahun_akademik WHERE id_tahun_akademik = '$id_tahunakademik' AND is_aktif='Y'";
			//$aktif = $this->db->query($query)->result();
			$off_all = "UPDATE tbl_tahun_akademik SET is_aktif = 'N' WHERE is_aktif = 'Y'";
			$off 	 = $this->db->query($off_all);
			$on 	 = "UPDATE tbl_tahun_akademik SET is_aktif = 'Y' WHERE id_tahun_akademik = '$id_tahunakademik'";
			$active	 = $this->db->query($on);
			redirect('tahunakademik');
		}

	}

?>
