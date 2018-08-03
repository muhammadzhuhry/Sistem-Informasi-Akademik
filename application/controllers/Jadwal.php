<?php

	class Jadwal extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			//checkAksesModule();
			// $this->load->library('ssp');
			$this->load->model('model_jadwal');
		}

		function index()
		{
			// Apabila yang login = guru (id_level_user 3 = guru) maka hanya akan menampilkan jadwal yang hanya diajar oleh guru tersebut
			if ($this->session->userdata('id_level_user') == 3) {
				$sql = "SELECT tj.id_jadwal, tju.nama_jurusan, ttk.nama_tingkatan, tm.nama_mapel, tj.jam, 
						tr.nama_ruangan, tj.hari, tj.semester 
						FROM tbl_jadwal AS tj, tbl_jurusan AS tju, tbl_ruangan AS tr, tbl_mapel AS tm, tbl_tingkatan_kelas AS ttk
						WHERE tj.kd_jurusan = tju.kd_jurusan AND tj.kd_ruangan = tr.kd_ruangan AND tj.kd_mapel = tm.kd_mapel AND tj.kd_tingkatan = ttk.kd_tingkatan AND tj.id_guru =".$this->session->userdata('id_guru');
				$data['jadwal'] =$this->db->query($sql);
				// load daftar ngajar guru
				$this->template->load('template', 'jadwal/jadwal_ajar_guru', $data);
			} else {
				$this->template->load('template', 'jadwal/view');
			}
		}

		function generate_jadwal()
		{
			if (isset($_POST['submit'])) {
				$this->model_jadwal->generateJadwal();
			}
			redirect('jadwal');
		}

		function dataJadwal()
		{
			$kode_jurusan		= $_GET['kd_jurusan'];
			$kode_tingkatan		= $_GET['kd_tingkatan'];
			//$idkurikulum		= $_GET['kurikulumnya'];
			$kelas 				= $_GET['kelas'];

			echo "<table class='table table-striped table-bordered table-hover table-full-width dataTable'>
                    <thead>
                        <tr>
                            <th class='text-center'>NO</th>
                            <th class='text-center'>MATA PELAJARAN</th>
                            <th class='text-center'>GURU</th>
                            <th class='text-center'>RUANGAN</th>
                            <th class='text-center'>HARI</th>
                            <th class='text-center'>JAM</th>
                            <th></th>
                        </tr>
                    </thead>";

  			$sql_datajadwal	= "SELECT tj.id_jadwal, tm.nama_mapel, tg.id_guru, tg.nama_guru, tr.kd_ruangan, tj.hari, 				   tj.jam
							   FROM tbl_jadwal AS tj, tbl_mapel AS tm, tbl_guru AS tg, tbl_ruangan AS tr
							   WHERE tj.kd_mapel = tm.kd_mapel AND tj.id_guru = tg.id_guru AND tj.kd_ruangan = tr.kd_ruangan AND tj.kd_jurusan = '$kode_jurusan' AND tj.kd_kelas = '$kelas'";
			$data_jadwal	= $this->db->query($sql_datajadwal)->result();
			$no = 1;
			$jam_pelajaran	= $this->model_jadwal->jamPelajaran();
			$hari           = array(
								'Senin'  => 'Senin',
								'Selasa' => 'Selasa',
								'Rabu'   => 'Rabu',
								'Kamis'  => 'Kamis',
								'Jumat'  => 'Jumat',
								'Sabtu'  => 'Sabtu'
							  );

			// cmb_dinamis(nama, tabelnya, fieldnya, pknya, selected, extra)
			// untuk selected $row->id, harus memasukan field id terlebih dahulu di $sql_datajadwal
			// sbg contoh $row->id_guru, harus menambahkan tg.id_guru di $sql_datajadwal agar ketika di jalankan querynya pada $data_jadwal akan membuat kolom baru yang berisi id_guru lalu baru bisa diambil idnya agar menampilkan data yang selected sesuai database pada cmb_dinamis.
			foreach ($data_jadwal as $row) {
				echo "<tr>
						<td class='text-center'>$no</td>
						<td>$row->nama_mapel</td>
						
						<td>".cmb_dinamis('guru', 'tbl_guru', 'nama_guru', 'id_guru', $row->id_guru, "id='guru".$row->id_jadwal."' onChange='updateGuru(".$row->id_jadwal.")'")."</td>

						<td>".cmb_dinamis('ruangan', 'tbl_ruangan', 'nama_ruangan', 'kd_ruangan', $row->kd_ruangan, "id='ruangan".$row->id_jadwal."' onChange='updateRuangan(".$row->id_jadwal.")'")."</td>
						
						<td>".form_dropdown('hari', $hari, $row->hari, "class='form-control' id='hari".$row->id_jadwal."' onChange='updateHari(".$row->id_jadwal.")'")."</td>

						<td>".form_dropdown('jam', $jam_pelajaran, $row->jam, "class='form-control' id='jam".$row->id_jadwal."' onChange='updateJam(".$row->id_jadwal.")'")."</td>

						<td  class='text-center'>".anchor('jadwal/delete_dataJadwal/'.$row->id_jadwal, '<i class="fa fa-times fa fa-white"></i>', 'class="btn btn-xs btn-danger" data-placement="top" title="Delete"')."</td>
					 </tr>";
				$no++;
			}

            echo  "</table>";
		}

		function update_guru()
		{
			$idguru 	= $_GET['id_guru'];
			$idjadwal 	= $_GET['id_jadwal'];
			$this->db->where('id_jadwal', $idjadwal);
			$this->db->update('tbl_jadwal', array('id_guru' => $idguru));
		}

		function update_ruangan()
		{
			$kdruangan 	= $_GET['kd_ruangan'];
			$idjadwal 	= $_GET['id_jadwal'];
			$this->db->where('id_jadwal', $idjadwal);
			$this->db->update('tbl_jadwal', array('kd_ruangan' => $kdruangan));
		}

		function update_hari()
		{
			$harinya 	= $_GET['hari'];
			$idjadwal 	= $_GET['id_jadwal'];
			$this->db->where('id_jadwal', $idjadwal);
			$this->db->update('tbl_jadwal', array('hari' => $harinya));
		}

		function update_jam()
		{
			$jamnya 	= $_GET['jam'];
			$idjadwal 	= $_GET['id_jadwal'];
			$this->db->where('id_jadwal', $idjadwal);
			$this->db->update('tbl_jadwal', array('jam' => $jamnya));
		}

		function tampil_kelas()
		{
			echo "<select id='kelas' name='kelas' class='form-control' onChange='loadPelajaran()'>";

			// menggunakan get_where
			// $where = array('kd_tingkatan' => $_GET['kd_tingkatan'], 'kd_jurusan' => $_GET['jurusan']);
			// $kelas = $this->db->get_where('tbl_kelas', $where);

			// menggunakan get
			$this->db->where('kd_jurusan', $_GET['kd_jurusan']);
			$this->db->where('kd_tingkatan', $_GET['kd_tingkatan']);
			$kelas = $this->db->get('tbl_kelas');
			
			foreach ($kelas->result() as $row) {
				echo "<option value='$row->kd_kelas'>$row->nama_kelas</option>";
			}

			echo "</select>";
		}

		function cetak_jadwal() {
	 		$kelas = $_POST['kelas'];
	 		$this->load->library('CFPDF');

	 		$days            = array(
								'SENIN'  => 'SENIN',
								'SELASA' => 'SELASA',
								'RABU'   => 'RABU',
								'KAMIS'  => 'KAMIS',
								'JUMAT'  => 'JUMAT',
								'SABTU'  => 'SABTU'
							 );

	 		$pdf = new FPDF('L', 'mm', 'A4');
	 		$pdf->AddPage();
	 		$pdf->SetFont('Arial','B',12);
        	$pdf->Cell(10,10,'NO',1,0,'L');
        	$pdf->Cell(30,10,'WAKTU',1,0,'L');

        	foreach ($days as $day) {
        		$pdf->Cell(40,10,$day,1,0,'L');
        	}
        	$pdf->Cell(30,10,'',0,1,'L');

        	$jam_ajar = $this->model_jadwal->jamPelajaran();
        	$no=1;

        	foreach ($jam_ajar as $jam) {
        		$pdf->Cell(10,10,$no,1,0,'L');
            	$pdf->Cell(30,10,$jam,1,0,'L');

            	foreach ($days as $day) {
            		$pdf->Cell(40,10,  $this->getPelajaran($jam, $day, $kelas),1,0,'L');
            	}
            	$pdf->Cell(30,10,'',0,1,'L');
            	$no++;
        	}

	 		$pdf->Output();
	 	}

	 	function getPelajaran($jam, $hari, $kelas) {
	 		$sql = "SELECT tj.*,tm.nama_mapel
                   FROM tbl_jadwal as tj, tbl_mapel as tm 
                   WHERE tj.kd_mapel=tm.kd_mapel and tj.kd_kelas='$kelas' and tj.hari='$hari' and tj.jam='$jam'";
	 		$pelajaran = $this->db->query($sql);
	 		if ($pelajaran->num_rows()>0) {
	 			$row = $pelajaran->row_array();
	 			return $row['nama_mapel'];
	 		} else {
	 			return '-';
	 		}
	 	}

	}

?>