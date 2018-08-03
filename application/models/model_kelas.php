<?php
 
	class Model_kelas extends CI_Model
	{
		
		public $table = "tbl_kelas";

		function save()
		{
			$data = array(
				//tabel di database => name di form
				'kd_kelas'            => $this->input->post('kd_kelas', TRUE),
				'nama_kelas'          => $this->input->post('nama_kelas', TRUE),
				'kd_tingkatan'		  => $this->input->post('tingkatan', TRUE),
				'kd_jurusan'		  => $this->input->post('jurusan', TRUE)
			);
			$this->db->insert($this->table, $data);
		}

		function update()
		{
			$data = array(
				//tabel di database => name di form
				'nama_kelas'          => $this->input->post('nama_kelas', TRUE),
				'kd_tingkatan'		  => $this->input->post('tingkatan', TRUE),
				'kd_jurusan'		  => $this->input->post('jurusan', TRUE)
			);
			$kode_kelas	= $this->input->post('kd_kelas');
			$this->db->where('kd_kelas', $kode_kelas);
			$this->db->update($this->table, $data);
		}

	}

?>