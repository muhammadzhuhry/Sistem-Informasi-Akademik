<html>
<head>
  <title>Form Import</title>
  
  <!-- Load File jquery.min.js yang ada difolder js -->
  <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
  
  <script>
  $(document).ready(function(){
    // Sembunyikan alert validasi kosong
    $("#kosong").hide();
  });
  </script>
</head>
<body>
  <h3>Form Import</h3>
  <hr>
  
  <a href="<?php echo base_url("csv/import_data.csv"); ?>">Download Format</a>
  <br>
  <br>
  
  <!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
  <form method="post" action="<?php echo base_url("Siswa/form"); ?>" enctype="multipart/form-data">
    <!-- 
    -- Buat sebuah input type file
    -- class pull-left berfungsi agar file input berada di sebelah kiri
    -->
    <input type="file" name="file">
    
    <!--
    -- Buat sebuah tombol submit untuk melakukan preview terlebih dahulu data yang akan di import
    -->
    <input type="submit" name="preview" value="Preview">
  </form>
  
  <?php
  if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form 
    if(isset($upload_error)){ // Jika proses upload gagal
      echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
      die; // stop skrip
    }
    
    // Buat sebuah tag form untuk proses import data ke database
    echo "<form method='post' action='".base_url('Siswa/import')."'>";
    
    // Buat sebuah div untuk alert validasi kosong
    echo "<div style='color: red;' id='kosong'>
    Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum terisi semua.
    </div>";
    
    echo "<table border='1' cellpadding='8'>
    <tr>
      <th colspan='5'>Preview Data</th>
    </tr>
    <tr>
      <th>NIM</th>
      <th>Nama</th>
      <th>Tanggal Lahir</th>
      <th>Tempat Lahir</th>
    </tr>";
    
    $numrow = 1;
    $kosong = 0;
    
    // Lakukan perulangan dari data yang ada di csv
    // $sheet adalah variabel yang dikirim dari controller
    foreach($sheet as $row){ 
      // START -->
      // Skrip untuk mengambil value nya
      $cellIterator = $row->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
      
      $get = array(); // Valuenya akan di simpan kedalam array,dimulai dari index ke 0
      foreach ($cellIterator as $cell) {
        array_push($get, $cell->getValue()); // Menambahkan value ke variabel array $get
      }
      // <-- END
      
      // Ambil data value yang telah di ambil dan dimasukkan ke variabel $get
      $nim = $get[0]; // Ambil data NIS
      $nama = $get[1]; // Ambil data nama
      $tanggal_lahir = $get[2]; // Ambil data Tanggal Lahir
      $tempat_lahir = $get[3]; // Ambil data Tempat Lahir
      
      // Cek jika semua data tidak diisi
      if(empty($nim) && empty($nama) && empty($tanggal_lahir) && empty($tempat_lahir))
        continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
      
      // Cek $numrow apakah lebih dari 1
      // Artinya karena baris pertama adalah nama-nama kolom
      // Jadi dilewat saja, tidak usah diimport
      if($numrow > 1){
        // Validasi apakah semua data telah diisi
        $nim_td = ( ! empty($nim))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
        $nama_td = ( ! empty($nama))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
        $tanggal_lahir_td = ( ! empty($tanggal_lahir))? "" : " style='background: #E07171;'"; // Jika Tanggal Lahir kosong, beri warna merah
        $tempat_lahir_td = ( ! empty($tempat_lahir))? "" : " style='background: #E07171;'"; // Jika Tempat Lahir kosong, beri warna merah
        
        // Jika salah satu data ada yang kosong
        if(empty($nim) or empty($nama) or empty($tanggal_lahir) or empty($tempat_lahir)){
          $kosong++; // Tambah 1 variabel $kosong
        }
        
        echo "<tr>";
        echo "<td".$nim_td.">".$nim."</td>";
        echo "<td".$nama_td.">".$nama."</td>";
        echo "<td".$tanggal_lahir_td.">".$tanggal_lahir."</td>";
        echo "<td".$tempat_lahir_td.">".$tempat_lahir."</td>";
        echo "</tr>";
      }
      
      $numrow++; // Tambah 1 setiap kali looping
    }
    
    echo "</table>";
    
    // Cek apakah variabel kosong lebih dari 1
    // Jika lebih dari 1, berarti ada data yang masih kosong
    if($kosong > 1){
    ?>  
      <script>
      $(document).ready(function(){
        // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
        $("#jumlah_kosong").html('<?php echo $kosong; ?>');
        
        $("#kosong").show(); // Munculkan alert validasi kosong
      });
      </script>
    <?php
    }else{ // Jika semua data sudah diisi
      echo "<hr>";
      
      // Buat sebuah tombol untuk mengimport data ke database
      echo "<button type='submit' name='import'>Import</button> ";
      echo "<a href='".base_url("Siswa")."'>Cancel</a>";
    }
    
    echo "</form>";
  }
  ?>
</body>
</html>