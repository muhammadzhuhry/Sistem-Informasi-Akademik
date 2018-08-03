<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header  with-border">
                <?php
                    $nim   = $this->uri->segment(3);
                    $query = "SELECT ts.nama
                            FROM tbl_nilai AS tn, tbl_siswa AS ts
                            WHERE tn.nim = ts.nim AND tn.nim = '$nim'";
                    $nama = $this->db->query($query)->row_array();
                ?>
              <h3 class="box-title">Data Nilai Siswa <?php echo $nama['nama']; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <!-- button add -->

              <table id="mytable" class="table table-striped table-bordered table-hover table-full-width dataTable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="50px">NO</th>
                        <th>Nama Mapel</th>
                        <th>Nilai</th>
                        <th class="text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        $no = 1;
                        foreach ($nilai_siswa->result() as $row) {
                            
                            // nilai
                            if($row->nilai > 90){
                                $Keterangan = '<p class="text-green">Sangat baik</p>';
                            }elseif($row->nilai > 80 and $row->nilai <= 90){
                                $Keterangan = '<p class="text-green">Baik</p>';
                            }elseif($row->nilai > 70 and $row->nilai <= 80){
                                $Keterangan = '<p class="text-yellow">Cukup</p>';
                            }else{
                                $Keterangan = '<p class="text-red">Kurang</p>';
                            }

                            echo "<tr>
                                    <td>$no</td>
                                    <td>$row->nama_mapel</td>
                                    <td>$row->nilai</td>
                                    <td class='text-center'>$Keterangan</td>
                                 </tr>";
                            $no++;
                        }
                    ?>
                </tbody>
              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-sm-1">
            <?php
                echo anchor('siswa/siswa_aktif', 'Kembali', array('class'=>'btn btn-danger btn-flat'));
            ?>
        </div>
    </div>
    <!-- /.row -->
</section>

<!-- punya lama -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.0/jquery.dataTables.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.js"></script> -->

<!-- baru tapi cdn -->
<!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"> -->

<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<script>
    $(document).ready(function() {
        $('#mytable').DataTable( {
            "order": [[ 1, "asc" ]]
        } );
    } );
</script>