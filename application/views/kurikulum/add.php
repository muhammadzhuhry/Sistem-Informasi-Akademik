<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form Tambah Kurikulum</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php
                echo form_open('kurikulum/add', 'role="form" class="form-horizontal"');
            ?>

                <div class="box-body">

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Nama Kurikulum</label>

                      <div class="col-sm-9">
                        <input type="text" name="nama_kurikulum" class="form-control" placeholder="Masukkan Nama Kurikulum">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Is Aktif</label>

                      <div class="col-sm-5">
                        <?php
                          echo form_dropdown('is_aktif', array('Pilih Status', 'N'=>'Tidak Aktif', 'Y'=>'Aktif'), null, "class='form-control'");
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
                          echo anchor('kurikulum', 'Kembali', array('class'=>'btn btn-danger btn-flat'));
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
