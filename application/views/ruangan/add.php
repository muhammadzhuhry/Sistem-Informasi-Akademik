<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form Tambah Ruangan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php
                echo form_open('ruangan/add', 'role="form" class="form-horizontal"');
            ?>

                <div class="box-body">



                  <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Ruangan</label>

                      <div class="col-sm-9">
                        <input type="text" name="kd_ruangan" class="form-control" placeholder="Masukkan Kode Ruangan">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Nama Ruangan</label>

                      <div class="col-sm-9">
                        <input type="text" name="nama_ruangan" class="form-control" placeholder="Masukkan Nama Ruangan">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label"></label>

                      <div class="col-sm-1">
                        <button type="submit" name="submit" class="btn btn-primary btn-flat">Simpan</button>
                      </div>

                      <div class="col-sm-1">
                        <?php
                          echo anchor('ruangan', 'Kembali', array('class'=>'btn btn-danger btn-flat'));
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
              Diakhir Kode Ruangan harus ditambahkan angka 1/2.<br>
              Contoh : VIIA1 > untuk Ruangan Kelas VII-A IPA &amp; VIIA2 > untuk Ruangan Kelas VII-A IPS
          </div>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>