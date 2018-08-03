<?php
 
	class Model_menu extends CI_Model
	{
		
		public $table = "tabel_menu";

		function save()
		{
			$data = array(
				//tabel di database => name di form
				'nama_menu'          => $this->input->post('nama_menu', TRUE),
				'link'         		 => $this->input->post('link', TRUE),
				'icon'            	 => $this->input->post('icon', TRUE),
				'is_main_menu'       => $this->input->post('is_main_menu', TRUE)
			);
			$this->db->insert($this->table, $data);
		}

		function update()
		{
			$data = array(
				//tabel di database => name di form
				'nama_menu'          => $this->input->post('nama_menu', TRUE),
				'link'         		 => $this->input->post('link', TRUE),
				'icon'            	 => $this->input->post('icon', TRUE),
				'is_main_menu'       => $this->input->post('is_main_menu', TRUE)
			);
			$id_menu 	= $this->input->post('id');
			$this->db->where('id', $id_menu);
			$this->db->update($this->table, $data);
		}

	}

?>