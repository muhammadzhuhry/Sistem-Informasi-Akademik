<?php
 
	class Model_walikelas extends CI_Model
	{
		// menginset data walikelas secaa otomatis ketika insert tahun akademik ->> dimasukan di function add pada controller Tahunakadmeik
		 function insert_walikelas($idTahunAkademik)
		 {
		 	$kelas = $this->db->get('tbl_kelas');
		 	foreach ($kelas->result() as $row) {
		 		$walikelas = array(
		 			'id_guru'				=> '0',
		 			'id_tahun_akademik'		=> $idTahunAkademik,
		 			'kd_kelas'				=> $row->kd_kelas
		 		);
		 		$this->db->insert('tbl_walikelas', $walikelas);
		 	}
		 }

	}

?>