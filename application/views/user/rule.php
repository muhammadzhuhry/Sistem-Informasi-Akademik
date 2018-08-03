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
                    echo form_open();
                ?>

                <table class="table table-bordered">
                    <tr>
                        <td>Level User</td>
                        <td>
                            <?php echo cmb_dinamis('level_user', 'tbl_level_user', 'nama_level', 'id_level_user', null, "id='filter_level' onChange='loadData()'") 
                            ?>        
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
              <h3 class="box-title">Data Hak Akses Module</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div id="table-module"></div>

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
        loadData();
    });
</script>

<script type="text/javascript">
    // function loadData digunakan untuk menampilkan table yang ada di function module
    function loadData()
    {
        var level = $("#filter_level").val();
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>user/module',
            data    : 'level_user='+level,
            success : function(html) {
                $("#table-module").html(html);
            }
        })
    }

    function addRule(id_modul)
    {
        var level = $("#filter_level").val();
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>user/add_rule',
            data    : 'level_user='+level+'&id_modul='+id_modul,
            success : function(html) {
                //loadData();
                alert("Sukses Merubah Hak Akses");
            }
        })
        
    }
</script>