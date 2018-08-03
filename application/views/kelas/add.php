<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form Tambah Kelas</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php
                echo form_open('kelas/add', 'role="form" class="form-horizontal"');
            ?>

                <div class="box-body">

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Kelas</label>

                      <div class="col-sm-9">
                        <input type="text" name="kd_kelas" class="form-control" placeholder="Masukkan Kode Kelas">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Nama Kelas</label>

                      <div class="col-sm-9">
                        <input type="text" name="nama_kelas" class="form-control" placeholder="Masukkan Nama Kelas">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Tingkatan</label>

                      <div class="col-sm-5">
                        <?php
                          echo cmb_dinamis('tingkatan', 'tbl_tingkatan_kelas', 'nama_tingkatan', 'kd_tingkatan');
                        ?>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Jurusan</label>

                      <div class="col-sm-5">
                        <?php
                          echo cmb_dinamis('jurusan', 'tbl_jurusan', 'nama_jurusan', 'kd_jurusan');
                        ?>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label"></label>

                      <div class="col-sm-1">
                        <button type="submit" name="submit" class="btn btn-primary btn-flat">Simpan</button>
                      </div>

                      <div class="col-sm-1">
                        <?php
                          echo anchor('kelas', 'Kembali', array('class'=>'btn btn-danger btn-flat'));
                        ?>
                      </div>
                  </div>

                </div>
                <!-- /.box-body -->
            </form>
          </div>
          <!-- /.box -->

          <div class="alert alert-info alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    
              <h4><i class="icon fa fa-warning"></i> Alert!</h4>
              Diakhir Kode Kelas harus ditambahkan angka 1/2.<br>
              Contoh : 7-A1 > untuk Kelas 7-A IPA &amp; 7-A2 > untuk Kelas 7-A IPS
          </div>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>