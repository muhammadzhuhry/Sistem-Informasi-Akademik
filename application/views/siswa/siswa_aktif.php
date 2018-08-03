<section class="content">
    <div class="row">

        <!-- filter -->
        <div class="col-xs-4">

          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Filter Data</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                
                <?php
                    echo form_open('siswa/export_excel');
                ?>

                <table class="table table-bordered">
                    <tr>
                        <td>Jurusan</td>
                        <td>
                            <?php echo cmb_dinamis('jurusan', 'tbl_jurusan', 'nama_jurusan', 'kd_jurusan', null, "id='filter_jurusan' onChange='loadKelas()'") 
                            ?>        
                        </td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>    
                            <div id="kelas"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                           <button type="submit" name="export_jadwal" class="btn btn-success btn-sm"><i class="fa fa-print" aria-hidden="true"></i> Export Data</button>
                        </td>
                    </tr>
                </table>

                </form>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-xs-8">

          <div class="box box-primary">
            <div class="box-header  with-border">
              <h3 class="box-title">Data Table Siswa</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div id="dataSiswa"></div>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

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

<!-- siswa_aktif() -> untuk menampilkan view peserta didik ->terletak di controller Siswa -->
<!-- combobox_kelas() -> untuk menampilkan data kelas sesuai jurusan yang dipilih -> terletak di controller Kelas -->
<!-- loadDataSiswa() -> untuk menampilkan data siswa nim dan nama sesuai kode_kelas yang dipilih di filter, lalu ditampilkan ke div id = kelas yang bedada di view/siswa_aktif -> terletak di controller Siswa -->

<script type="text/javascript">
    $(document).ready(function(){
        loadKelas();
    });
</script>

<script type="text/javascript">
    function loadKelas()
    {
        //var tingkatan_kelas = $("#filter_tingkatan").val();
        var jurusan         = $("#filter_jurusan").val();
        
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>kelas/combobox_kelas',
            data    : 'kd_jurusan='+jurusan,
            success : function(html) {
                $("#kelas").html(html);
                var kelas   = $("#cbkelas").val();
                loadSiswa(kelas);
            }
        })
    }

    function loadSiswa(kelas)
    {   
        var kelas   = $("#cbkelas").val();
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>siswa/loadDataSiswa',
            data    : 'kd_kelas='+kelas,
            success : function(html) {
                $("#dataSiswa").html(html);
            }
        })
    }
</script>