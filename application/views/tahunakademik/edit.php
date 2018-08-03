<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form Edit Tahun Akademik</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php
                echo form_open('tahunakademik/edit', 'role="form" class="form-horizontal"');
                echo form_hidden('id_tahunakademik', $tahunakademik['id_tahun_akademik']);
            ?>

                <div class="box-body">

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Tahun Akademik</label>

                      <div class="col-sm-9">
                        <input type="text" value="<?php echo $tahunakademik['tahun_akademik']; ?>" name="tahun_akademik" class="form-control" placeholder="Masukkan Tahun Akademik">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Is Aktif</label>

                      <div class="col-sm-5">
                        <?php
                          // echo form_dropdown('is_aktif', array('Pilih Status', 'N'=>'Tidak Aktif', 'Y'=>'Aktif'), $tahunakademik['is_aktif'], "class='form-control'");
                          echo form_dropdown('semester', array('Pilih Semester', 'ganjil' => 'Ganjil', 'genap' => 'Genap'), NULL, "class='form-control' disabled='disabled'");
                        ?>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Semester</label>

                      <div class="col-sm-5">
                        <?php
                          if ($tahunakademik['is_aktif'] == 'Y') {
                            echo form_dropdown('semester', array('Pilih Semester', 'ganjil' => 'Ganjil', 'genap' => 'Genap'), $tahunakademik['semester'], "class='form-control'");
                          } else {
                            echo form_dropdown('semester', array('Pilih Semester', 'ganjil' => 'Ganjil', 'genap' => 'Genap'), NULL, "class='form-control' disabled='disabled'");
                          }
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
                          echo anchor('tahunakademik', 'Kembali', array('class'=>'btn btn-danger btn-flat'));
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
