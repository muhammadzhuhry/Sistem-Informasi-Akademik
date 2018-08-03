<?php

	class Model_kurikulum extends CI_Model
	{

		public $table = "tbl_kurikulum";

		function save()
		{
		 	$data = array(
		 		//tabel di database => name di form
		 		'nama_kurikulum'	=> $this->input->post('nama_kurikulum', TRUE),
		 		'is_aktif'			=> $this->input->post('is_aktif', TRUE)
		 		//'semester_aktif'	= $this->input->post('semester_aktif', TRUE)
		 	);
		 	$this->db->insert($this->table, $data);
		}

		function update()
		{
			$data = array(
		 		//tabel di database => name di form
		 		'nama_kurikulum'	=> $this->input->post('nama_kurikulum', TRUE),
		 		'is_aktif'			=> $this->input->post('is_aktif', TRUE)
		 		//'semester_aktif'	= $this->input->post('semester_aktif', TRUE)
		 	);
		 	$id_kurikulum = $this->input->post('id_kurikulum');
		 	$this->db->where('id_kurikulum', $id_kurikulum);
		 	$this->db->update($this->table, $data);
		}

		function save_detail()
		{
			$data = array(
				'id_kurikulum'	=> $this->input->post('kurikulum', TRUE),
				'kd_mapel'		=> $this->input->post('mapel', TRUE),
				'kd_jurusan'	=> $this->input->post('jurusan', TRUE),
				'kd_tingkatan'	=> $this->input->post('tingkatan', TRUE)
			);
			$this->db->insert('tbl_kurikulum_detail', $data);
		}

	}

?>
