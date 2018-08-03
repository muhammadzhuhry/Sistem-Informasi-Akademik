<?php
 
	class Model_user extends CI_Model
	{

		public $table = "tbl_user";
		
		// mengambil data $username & $password dari hasil parsing controller Auth function check_login() dan mencocokanya dengan data yang ada di database
		function login($username, $password)
		{
			$this->db->where('username', $username);
			$this->db->where('password', md5($password));
			$user = $this->db->get('tbl_user')->row_array();
			return $user;
		}

		function save($foto)
		{
			$data = array(
				//tabel di database => name di form
				'nama_lengkap'            => $this->input->post('nama_lengkap', TRUE),
				'username'          	  => $this->input->post('username', TRUE),
				'password'          	  => md5( $this->input->post('password', TRUE) ),
				'id_level_user'           => $this->input->post('level_user', TRUE),
				'foto'					  => $foto
			);
			$this->db->insert($this->table, $data);
		}

		function update($foto)
		{
			if (empty($foto)) {
				$data = array(
					//tabel di database => name di form
					'nama_lengkap'            => $this->input->post('nama_lengkap', TRUE),
					'username'          	  => $this->input->post('username', TRUE),
					'password'          	  => md5( $this->input->post('password', TRUE) ),
					'id_level_user'           => $this->input->post('level_user', TRUE),
				);
			} else {
				$data = array(
					//tabel di database => name di form
					'nama_lengkap'            => $this->input->post('nama_lengkap', TRUE),
					'username'          	  => $this->input->post('username', TRUE),
					'password'          	  => md5( $this->input->post('password', TRUE) ),
					'id_level_user'           => $this->input->post('level_user', TRUE),
					'foto'					  => $foto
				);
			}		
			$id_user 	= $this->input->post('id_user', TRUE);
			$this->db->where('id_user', $id_user);
			$this->db->update($this->table, $data);
		}

	}

?>