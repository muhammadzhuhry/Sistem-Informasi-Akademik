<?php

	class Model_siswa extends CI_Model
	{

		public $table ="tbl_siswa";

		function save($foto)
		{
			$data = array(
				//tabel di database => name di form
				'nim'           => $this->input->post('nim', TRUE),
				'nama'          => $this->input->post('nama', TRUE),
				'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
				'tempat_lahir'  => $this->input->post('tempat_lahir', TRUE),
				'gender'        => $this->input->post('gender', TRUE),
				'kd_agama'	    => $this->input->post('agama', TRUE),
				'foto'			=> $foto,
				'kd_kelas'	    => $this->input->post('kelas', TRUE),
			);
			$this->db->insert($this->table, $data);

			// ketika pengguna menginsert data siswa, maka data nim, kd_kelas dan tahun_akademik_aktif akan otomatis terinsert dengan sendirinya ke tbl_riwayat_kelas
			$tahun_akademik = $this->db->get_where('tbl_tahun_akademik', array('is_aktif' => 'Y'))->row_array();
			$riwayat = array(
							'nim' 				=> $this->input->post('nim', TRUE),
							'kd_kelas'			=> $this->input->post('kelas', TRUE),
							'id_tahun_akademik'	=> $tahun_akademik['id_tahun_akademik']
						); 
			$this->db->insert('tbl_riwayat_kelas', $riwayat);
		}

		function update($foto)
		{
			if (empty($foto)) {
				//update tanpa foto
				$data = array(
					'nama'          => $this->input->post('nama', TRUE),
					'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
					'tempat_lahir'  => $this->input->post('tempat_lahir', TRUE),
					'gender'        => $this->input->post('gender', TRUE),
					'kd_agama'	    => $this->input->post('agama', TRUE),
					'kd_kelas'	    => $this->input->post('kelas', TRUE),
				);
			} else {
				//update dengan foto
				$data = array(
					'nama'          => $this->input->post('nama', TRUE),
					'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
					'tempat_lahir'  => $this->input->post('tempat_lahir', TRUE),
					'gender'        => $this->input->post('gender', TRUE),
					'kd_agama'	    => $this->input->post('agama', TRUE),
					'foto'			=> $foto,
					'kd_kelas'	    => $this->input->post('kelas', TRUE),
				);
			}

			$nim	= $this->input->post('nim');
			$this->db->where('nim', $nim);
			$this->db->update($this->table, $data);
		}

		// Fungsi untuk melakukan proses upload file
	  	public function upload_csv($filename){
		    $this->load->library('upload'); // Load librari upload
		    
		    $config['upload_path'] = './csv/';
		    $config['allowed_types'] = 'csv';
		    $config['max_size']  = '2048';
		    $config['overwrite'] = true;
		    $config['file_name'] = $filename;
		  
		    $this->upload->initialize($config); // Load konfigurasi uploadnya
		    if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
		      // Jika berhasil :
		      $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
		      return $return;
		    }else{
		      // Jika gagal :
		      $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
		      return $return;
		    }
		  }
	  
		// Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
		public function insert_multiple($data){
		    $this->db->insert_batch('tbl_siswa', $data);
		}

	}
	
?>
