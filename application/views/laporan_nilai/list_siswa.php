<section class="content">
    <div class="row">

        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header  with-border">
                <table class="table table-bordered">
                <tr>
                    <td width="200">Tahun Akademik</td>
                    <td> : <?php echo get_tahun_akademik('tahun_akademik'); ?></td>
                </tr>
                <tr>
                    <td>Semester</td>
                    <td> : <?php echo get_tahun_akademik('semester'); ?></td>
                </tr>
                <tr>
                    <td>Jurusan &amp; Tingkatan</td>
                    <td> : <?php echo "Jurusan".' '.$kelas['nama_jurusan'].' '.$kelas['nama_tingkatan']; ?> (<?php echo $kelas['nama_kelas']; ?>)</td>
                </tr>
                </table>
            </div>
            </div>
        </div>
 
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header  with-border">
              <h3 class="box-title">Cetak Raport Siswa</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table class="table table-bordered">
                  <tr>
                      <th class="text-center" width="100">NIM</th>
                      <th>NAMA</th>
                      <th class="text-center" width="100">AKSI</th>
                  </tr>
                  <?php
                    foreach ($siswa->result() as $row) {
                        echo "<tr>
                                <td class='text-center'>$row->nim</td>
                                <td>$row->nama</td>
                                <td>".anchor('laporan_nilai/nilai_semester/'.$row->nim, 'Lihat Laporan Nilai', 'class="btn btn-sm btn-danger"')."</td>
                             </tr>";
                    }
                  ?>
              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>