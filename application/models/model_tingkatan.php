<?php
 
	class Model_tingkatan extends CI_Model
	{
		
		public $table = "tbl_tingkatan_kelas";

		function save()
		{
			$data = array(
				//tabel di database => name di form
				'kd_tingkatan'		=> $this->input->post('kd_tingkatan', TRUE),
				'nama_tingkatan'	=> $this->input->post('nama_tingkatan', TRUE)
			);
			$this->db->insert($this->table, $data);
		}

		function update()
		{
			$data = array(
				//tabel di database => name di form
				'nama_tingkatan'	=> $this->input->post('nama_tingkatan', TRUE)
			);
			$kode_tingkatan	= $this->input->post('kd_tingkatan');
			$this->db->where('kd_tingkatan', $kode_tingkatan);
			$this->db->update($this->table, $data);
		}

	} 

?>