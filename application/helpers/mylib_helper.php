<?php

	function cmb_dinamis($name, $table, $field, $pk, $selected=null, $extra=null)
	{
		$ci   = get_instance();
		$cmb  = "<select name='$name' class='form-control' $extra>";

		$data = $ci->db->get($table)->result();
		foreach ($data as $row) {
			$cmb .= "<option value='".$row->$pk."'";
			//Apabila $selected bernilai sama dengan nilai $pk maka akan bernilai selected selain itu akan bernilai null
			$cmb .= $selected == $row->$pk ? 'selected' : '';
			$cmb .= ">".$row->$field."</option>";
		}
		$cmb .= "</select>";

		return $cmb;
	}

	// untuk mendapatkan tahun akademik aktif dan biar mudah untuk dipanggil 
	function get_tahun_akademik($field)
	{
		$ci    = get_instance();
		$ci->db->where('is_aktif', 'Y');
		$tahun = $ci->db->get('tbl_tahun_akademik')->row_array();
		//$tahun = $ci->db->get_where('tbl_tahun_akademik', array('is_aktif' => 'Y'))->row_array(); >> menggunaka get_where
		return $tahun[$field];
	}

	function checkAksesModule()
	{
		$ci   = get_instance();

		$controller = $ci->uri->segment(1);
		$method		= $ci->uri->segment(2);

		if (empty($method)) {
			$url = $controller;
		} else {
			$url = $controller.'/'.$method;
		}

		$menu = $ci->db->get_where('tabel_menu', array('link' => $url))->row_array();
		$level_User = $ci->session->userdata('id_level_user');

		// Untuk mengatasi session yang terhapus karena tidak diapa-apakan lebih dari 30 menit maka dibuat fungsi if bila $level user kosong maka akan me redirect ke halaman login

		if (!empty($level_User)) {
			$check = $ci->db->get_where('tbl_user_rule', array('id_level_user' => $level_User, 'id_menu' => $menu['id']));
		
			if ($check->num_rows() < 1 AND $method != 'data' AND $method != 'add' AND $method != 'edit' AND $method != 'delete' AND $method != 'upload_foto_siswa' AND $method != 'siswa_aktif' AND $method != 'loadDataSiswa' AND $method != 'export_excel' AND $method != 'upload_foto_siswa') {
				echo "Anda Tidak Boleh Akses Module Ini";
				die;
			}
		} else {
			redirect ('auth/');
		}
	}

	function check_nilai($nim, $id_jadwal)
	{
		$ci   = get_instance();

		$nilai = $ci->db->get_where('tbl_nilai', array('nim' => $nim, 'id_jadwal' => $id_jadwal));
		if ($nilai->num_rows() > 0) {
			$row = $nilai->row_array();
			return $row['nilai'];
		} else {
			return 0;
		}
	}

	function Terbilang($x) {
        $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        if ($x < 12)
            return " " . $abil[$x];
        elseif ($x < 20)
            return Terbilang($x - 10) . "belas";
        elseif ($x < 100)
            return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
        elseif ($x < 200)
            return " seratus" . Terbilang($x - 100);
        elseif ($x < 1000)
            return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
        elseif ($x < 2000)
            return " seribu" . Terbilang($x - 1000);
        elseif ($x < 1000000)
            return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
        elseif ($x < 1000000000)
            return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
    }

?>