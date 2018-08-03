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
            
                <table class="table table-bordered">
                    <tr>
                        <td>Jurusan</td>
                        <td>
                            <?php echo cmb_dinamis('jurusan', 'tbl_jurusan', 'nama_jurusan', 'kd_jurusan', null, "id='filter_jurusan' onChange='loadData()'") 
                            ?>        
                        </td>
                    </tr>
                    <tr>
                        <td>Tingkatan Kelas</td>
                        <td>
                            <?php echo cmb_dinamis('tingkatan_kelas', 'tbl_tingkatan_kelas', 'nama_tingkatan', 'kd_tingkatan', null, "id='filter_tingkatan' onChange='loadData()'") 
                            ?>        
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                                echo anchor('kurikulum/add_detail/'.$this->uri->segment(3), '<button class="btn bg-navy btn-flat margin"> Tambah Data</button>');
                            ?>
                            <?php
                                echo anchor('kurikulum', 'Kembali', array('class'=>'btn btn-danger btn-flat'));
                            ?>
                        </td>
                    </tr>
                </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <!-- tabel -->
        <div class="col-xs-8">

          <div class="box box-primary">
            <div class="box-header  with-border">
              <h3 class="box-title">Data Daftar Pelajaran</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <!-- disini tampil data -->
                <div id="table_daftarpelajaran"  class="text-center">
                    <div class="callout callout-danger text-left">
                        <h4><i class="icon fa fa-warning"></i> Tingkatan Kelas Tidak terdeteksi</h4>
                        <p>Pilih Tingkatan Kelas yang ingin Ditampilkan Data Daftar Pelajaranya di Filter Data Terlebih Dahulu</p>
                    </div>
                </div>                

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

    </div>
    <!-- /.row -->
</section>

<script type="text/javascript">
    $(document).ready(function(){
        //loadData();
    });
</script>

<script type="text/javascript">
    function loadData()
    {
        var tingkatan_kelas = $("#filter_tingkatan").val();
        var jurusan         = $("#filter_jurusan").val();
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>kurikulum/dataKurikulumDetail',
            data    : 'kd_jurusan='+jurusan+'&kd_tingkatan='+tingkatan_kelas+'&kurikulumnya=<?php echo $this->uri->segment(3) ?>',
            success : function(html) {
                $("#table_daftarpelajaran").html(html);
            }
        })
    }
</script>
