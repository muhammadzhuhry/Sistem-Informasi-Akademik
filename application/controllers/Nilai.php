<?php
 
	class Nilai extends CI_Controller
	{

		function __construct()
		{
			parent::__construct();
			//checkAksesModule();
		}
		
		function index()
		{
			$sql = "SELECT tj.kd_kelas, tj.id_jadwal, tju.nama_jurusan, ttk.nama_tingkatan, tm.nama_mapel, tj.jam, 
					tr.nama_ruangan, tj.hari, tj.semester 
					FROM tbl_jadwal AS tj, tbl_jurusan AS tju, tbl_ruangan AS tr, tbl_mapel AS tm, tbl_tingkatan_kelas AS ttk
					WHERE tj.kd_jurusan = tju.kd_jurusan AND tj.kd_ruangan = tr.kd_ruangan AND tj.kd_mapel = tm.kd_mapel AND tj.kd_tingkatan = ttk.kd_tingkatan AND tj.id_guru =".$this->session->userdata('id_guru');
			$data['jadwal'] =$this->db->query($sql);
			$this->template->load('template', 'nilai/list_kelas', $data);
		}

		function kelas()
		{
			$id_jadwal		= $this->uri->segment(3);
			$jadwal 		= $this->db->get_where('tbl_jadwal', array('id_jadwal' => $id_jadwal))->row_array();
			$kd_kelas 		= $jadwal['kd_kelas'];
			// $kelas 			= "SELECT tk.*, tj.nama_jurusan, ttk.nama_tingkatan 
			// 		  		  FROM tbl_kelas AS tk, tbl_jurusan AS tj, tbl_tingkatan_kelas AS ttk
			// 		  		  WHERE tk.kd_jurusan = tj.kd_jurusan AND tk.kd_tingkatan = ttk.kd_tingkatan AND kd_kelas = '$kd_kelas'";

			// Punya akademik nuris
			
			// $rombel         =   "SELECT rb.nama_rombel,rb.kelas,jr.nama_jurusan, mp.nama_mapel
   			//                 FROM tbl_jadwal AS j,tbl_jurusan as jr, tbl_rombel as rb,tbl_mapel as mp
   			//                 WHERE j.kd_jurusan=jr.kd_jurusan and rb.id_rombel=j.id_rombel and mp.kd_mapel=j.kd_mapel 
   			//                 and j.id_jadwal=13='$id_rombel'";
			
			$kelas 			= "SELECT tk.nama_kelas, tju.nama_jurusan, tm.nama_mapel, ttk.nama_tingkatan 
							  FROM tbl_jadwal AS tj, tbl_jurusan AS tju,  tbl_kelas AS tk, tbl_mapel AS tm, tbl_tingkatan_kelas AS ttk
							  WHERE tj.kd_jurusan = tju.kd_jurusan AND tj.kd_kelas = tk.kd_kelas AND tj.kd_mapel = tm.kd_mapel AND tj.kd_tingkatan = ttk.kd_tingkatan AND tj.id_jadwal = $id_jadwal";
			$siswa 			= "SELECT ts.nim, ts.nama 
							  FROM tbl_riwayat_kelas AS trk, tbl_siswa AS ts 
							  WHERE trk.nim = ts.nim AND trk.kd_kelas = '$kd_kelas' AND trk.id_tahun_akademik =". get_tahun_akademik('id_tahun_akademik') ." ";
			$data['kelas']  = $this->db->query($kelas)->row_array();
			$data['siswa']  = $this->db->query($siswa)->result();
			$this->template->load('template', 'nilai/form_nilai', $data);
		}

		function update_nilai()
		{
			$nim		= $_GET['nim'];
			$idjadwal 	= $_GET['id_jadwal'];
			$nilai 		= $_GET['nilai'];

			$parameter 	= array(
							'nim' => $nim,
							'id_jadwal' => $idjadwal,
							'nilai' => $nilai
						);

			$validasi 	= array(
							'nim' => $nim,
							'id_jadwal' => $idjadwal
						);

			$check 		= $this->db->get_where('tbl_nilai', $validasi);
			if ($check->num_rows() > 0) {
				// Apabila datanya besar dari 0 / ada maka akan melakukan proses update
				$this->db->where('nim', $nim);
				$this->db->where('id_jadwal', $idjadwal);
				$this->db->update('tbl_nilai', array('nilai' => $nilai));
				echo "data diupdate";
			} else {
				// Jika datanya tidak ada maka akan melakukan proses insert
				$this->db->insert('tbl_nilai', $parameter);
				echo "data diinsert";
			}
		}
	}

?>