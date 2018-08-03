<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form Edit Kelas</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php
                echo form_open('kelas/edit', 'role="form" class="form-horizontal"');
            ?>

                <div class="box-body">

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Kelas</label>

                      <div class="col-sm-9">
                        <input type="text" value="<?php echo $kelas['kd_kelas']; ?>" name="kd_kelas" readonly="true" class="form-control" placeholder="Masukkan Kode Kelas">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Nama Kelas</label>

                      <div class="col-sm-9">
                        <input type="text" value="<?php echo $kelas['nama_kelas']; ?>" name="nama_kelas" class="form-control" placeholder="Masukkan Nama Kelas">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Tingkatan</label>

                      <div class="col-sm-5">
                        <?php
                          echo cmb_dinamis('tingkatan', 'tbl_tingkatan_kelas', 'nama_tingkatan', 'kd_tingkatan', $kelas['kd_tingkatan']);
                        ?>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Jurusan</label>

                      <div class="col-sm-5">
                        <?php
                          echo cmb_dinamis('jurusan', 'tbl_jurusan', 'nama_jurusan', 'kd_jurusan', $kelas['kd_jurusan']);
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
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>