<?php

	class Kelas extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			//checkAksesModule();
			$this->load->library('ssp');
			$this->load->model('model_kelas');
		}

		function data()
		{
			// $sql = "SELECT tk.*, ttk.nama_tingkatan, tj.nama_jurusan 
			// FROM tbl_kelas AS tk, tbl_tingkatan_kelas AS ttk, tbl_jurusan AS tj 
			// WHERE tk.kd_tingkatan = ttk.kd_tingkatan AND tk.kd_jurusan = tj.kd_jurusan"
			// Biasanya menggunakan query untuk mengambil nama dari tabel yang berbeda tapi saling berelasi,
			// karena terlalu panjang, harus menggunakan foreach lagi dan menurut saya sepertinya 
			//tidak bisa melakukan foreach di datatable, maka saya menggunaka create view kita bisa membuat query tersebut menjadi sebuah table

			// nama table
			$table      = 'view_kelas';
			// nama PK
			$primaryKey = 'kd_kelas';
			// list field yang mau ditampilkan
			$columns    = array(
				//tabel db(kolom di database) => dt(nama datatable di view)
				array('db' => 'kd_kelas', 'dt' => 'kd_kelas'),
		        array('db' => 'nama_kelas', 'dt' => 'nama_kelas'),
		        array('db' => 'nama_tingkatan', 'dt' => 'nama_tingkatan'),
		        array('db' => 'nama_jurusan', 'dt' => 'nama_jurusan'),
		        //untuk menampilkan aksi(edit/delete dengan parameter kode kelas)
		        array(
		              'db' => 'kd_kelas',
		              'dt' => 'aksi',
		              'formatter' => function($d) {
		               		return anchor('kelas/edit/'.$d, '<i class="fa fa-edit"></i>', 'class="btn btn-xs btn-primary" data-placement="top" title="Edit"').' 
		               		'.anchor('kelas/delete/'.$d, '<i class="fa fa-times fa fa-white"></i>', 'class="btn btn-xs btn-danger" data-placement="top" title="Delete"');
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
			$this->template->load('template', 'kelas/view');
		}

		function add()
		{
			if (isset($_POST['submit'])) {
				$this->model_kelas->save();
				redirect('kelas');
			} else {
				$this->template->load('template', 'kelas/add');
			}
		}

		function edit()
		{
			if (isset($_POST['submit'])) {
				$this->model_kelas->update();
				redirect('kelas');
			} else {
				$kd_kelas 		= $this->uri->segment(3);
				$data['kelas']	= $this->db->get_where('tbl_kelas', array('kd_kelas' => $kd_kelas))->row_array();
				$this->template->load('template', 'kelas/edit', $data);
			}
		}

		function delete()
		{
			$kode_kelas = $this->uri->segment(3);
			if (!empty($kode_kelas)) {
				$this->db->where('kd_kelas', $kode_kelas);
				$this->db->delete('tbl_kelas');
			}
			redirect('kelas');
		}


		// siswa_aktif() -> untuk menampilkan view peserta didik ->terletak di controller Siswa
		// combobox_kelas() -> untuk menampilkan data kelas sesuai jurusan yang dipilih -> terletak di controller Kelas
		// loadDataSiswa() -> untuk menampilkan data siswa nim dan nama sesuai kode_kelas yang dipilih di filter, lalu ditampilkan ke div id = kelas yang bedada di view/siswa_aktif -> terletak di controller Siswa
		function combobox_kelas()
		{
			$jurusan = $_GET['kd_jurusan'];
			echo "<select id='cbkelas' name='kelas' class='form-control' onChange='loadSiswa()'>";

			$this->db->where('kd_jurusan', $jurusan);
			$kelas = $this->db->get('tbl_kelas');
			foreach ($kelas->result() as $row) {
				echo "<option value='$row->kd_kelas' onChange='loadSiswa()'>$row->nama_kelas</option>";
			}

			echo "</select>";
		}

	}

?>