<?php
 
	class Model_jadwal extends CI_Model
	{
		
		function jamPelajaran() {
	 		 $jam_pelajaran	= array(
            	'07.15 - 08.00' => '07.15 - 08.00',
            	'08.00 - 08.45' => '08.00 - 08.45',
            	'08.45 - 09.30' => '08.45 - 09.30',
            	'09.30 - 10.00' => '09.30 - 10.00',
            	'10.00 - 10.45' => '10.00 - 10.45',
            	'10.45 - 11.30' => '10.45 - 11.30',
            	'11.30 - 12.15' => '11.30 - 12.15',
            	'12.15 - 13.00' => '12.15 - 13.00',
            	'13.00 - 13.30' => '13.00 - 13.30',
            	'13.30 - 14.15' => '13.30 - 14.15',
            	'14.15 - 15.00' => '14.15 - 15.00',
            );
	 		 return $jam_pelajaran;
	 	}

	 	function generateJadwal()
	 	{
	 		$idkurikulum	 = $this->input->post('kurikulum');
			$semester		 = $this->input->post('semester');

			// Mengambil detail data dari kurikulum yang dipilih (tbl_kurikulum_detail)
			$kurikulumDetail = $this->db->get_where('tbl_kurikulum_detail', array('id_kurikulum' => $idkurikulum));

			// Ambil tahun akademik yang aktif
			$tahunakademik 	 = $this->db->get_where('tbl_tahun_akademik', array('is_aktif' => 'Y'))->row_array();

			foreach ($kurikulumDetail->result() as $row) {

				// ambil kelas berdasarkan tingkatan dan jurusan
				$kelasnya = $this->db->get_where('tbl_kelas', array('kd_jurusan' => $row->kd_jurusan, 'kd_tingkatan' => $row->kd_tingkatan));

				foreach ($kelasnya->result() as $row_kelas) {
					$data = array(
						'id_tahun_akademik' => $tahunakademik['id_tahun_akademik'], 
						'semester'			=> $semester,
						'kd_jurusan'		=> $row->kd_jurusan, 
						'kd_tingkatan'		=> $row->kd_tingkatan, //sama seperti kelas di akademik
						'kd_kelas'			=> $row_kelas->kd_kelas, //sama seperti rombel di akademik
						'kd_mapel'			=> $row->kd_mapel, 
						'id_guru'			=> 0, 
						'jam'				=> '', 
						'kd_ruangan'		=> '000', 
						'hari'				=> ''
					);
					$this->db->insert('tbl_jadwal', $data);
				}

			}
	 	}

	}

?>