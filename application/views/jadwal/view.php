<section class="content">
    <div class="row">

        <!-- filter -->
        <div class="col-xs-5">

          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Filter Data</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                    echo form_open('jadwal/cetak_jadwal');
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
                        <td>Tingkatan Kelas</td>
                        <td>
                            <?php echo cmb_dinamis('tingkatan_kelas', 'tbl_tingkatan_kelas', 'nama_tingkatan', 'kd_tingkatan', null, "id='filter_tingkatan' onchange='loadKelas()'") 
                            ?>        
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Kelas</td>
                        <td>
                            <!-- kelas dipanggil melalui serverside karena harus melakukan penyesuaian agar sesuai pada tingkatan apa kelasnya ada apa saja -->
                            <div id="tampilKelas"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-cogs" aria-hidden="true"></i> Generate Jadwal
                            </button>
                            <button type="submit" name="export_jadwal" class="btn btn-danger btn-sm"><i class="fa fa-print" aria-hidden="true"></i> Cetak PDF</button>
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

        <!-- tabel -->
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header  with-border">
              <h3 class="box-title">Data Daftar Pelajaran</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <!-- disini tampil data -->
                <div id="table_daftarpelajaran">
                    <!-- <div class="callout callout-danger">
                        <h4><i class="icon fa fa-warning"></i> Tingkatan Kelas Tidak terdeteksi</h4>
                        <p>Pilih Tingkatan Kelas yang ingin Ditampilkan Data Daftar Pelajaranya di Filter Data Terlebih Dahulu</p>
                    </div> -->
                </div> 



            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                Untuk hari &amp; jam, apabila ingin mengisi dengan hari senin / jam 07.15 - 08.00,
                maka harus merubah hari &amp; jamnya terlebih dahulu.<br> 
                Lalu baru dikembalikan lagi. Jika tidak, data tidak akan tersimpan di dalam database.<br>
                Contoh : kalau mau diisi dengan hari senin, langkah pertama ubah dahulu ke hari selasa lalu baru kembalikan ke hari senin.
         </div>

        </div>
        <!-- /.col -->

    </div>
    <!-- /.row -->
</section>

<script type="text/javascript">
    $(document).ready(function(){
        loadKelas();
    });
</script>

<script type="text/javascript">

    function loadKelas()
    {
        var tingkatan_kelas = $("#filter_tingkatan").val();
        var jurusan         = $("#filter_jurusan").val();
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>jadwal/tampil_kelas',
            data    : 'kd_jurusan='+jurusan+'&kd_tingkatan='+tingkatan_kelas,
            success : function(html) {
                $("#tampilKelas").html(html);
                loadPelajaran();
            }
        })
    }

    function loadPelajaran()
    {
        var tingkatan_kelas = $("#filter_tingkatan").val();
        var jurusan         = $("#filter_jurusan").val();
        var kelas          = $("#kelas").val();
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>jadwal/dataJadwal',
            data    : 'kd_jurusan='+jurusan+'&kd_tingkatan='+tingkatan_kelas+'&kelas='+kelas,
            success : function(html) {
                $("#table_daftarpelajaran").html(html);
            }
        })
    }


    function updateGuru(id)
    {
        var guru = $("#guru"+id).val();
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>jadwal/update_guru',
            data    : 'id_guru='+guru+'&id_jadwal='+id,
            success : function(html) {
                loadDataTingkatan();
            }
        })
    }

    function updateRuangan(id)
    {
        var ruangan = $("#ruangan"+id).val();
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>jadwal/update_ruangan',
            data    : 'kd_ruangan='+ruangan+'&id_jadwal='+id,
            success : function(html) {
                loadDataTingkatan();
            }
        })
    }

    function updateHari(id)
    {
        var hari = $("#hari"+id).val();
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>jadwal/update_hari',
            data    : 'hari='+hari+'&id_jadwal='+id,
            success : function(html) {
                loadDataTingkatan();
            }
        })
    }

    function updateJam(id)
    {
        var jam = $("#jam"+id).val();
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>jadwal/update_jam',
            data    : 'jam='+jam+'&id_jadwal='+id,
            success : function(html) {
                loadData();
            }
        })
    }

</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php
                echo form_open('jadwal/generate_jadwal', 'role="form" class="form-horizontal"');
            ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Generate Jadwal</h4>
            </div>
            <div class="modal-body">

                <table class="table table-bordered">
                    <tr>
                        <td>Kurikulum</td>
                        <td>
                            <?php 
                                echo cmb_dinamis('kurikulum', 'tbl_kurikulum', 'nama_kurikulum', 'id_kurikulum');
                            ?>        
                        </td>
                    </tr>
                    <tr>
                        <td>Semester</td>
                        <td>
                            <?php
                                echo form_dropdown('semester', array('ganjil' => 'Ganjil', 'genap' => 'Genap'), null, "class='form-control'");
                            ?>
                        </td>
                    </tr>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="submit" class="btn btn-primary">Generate Data</button>
            </div>
            </form>
        </div>
    </div>
</div>