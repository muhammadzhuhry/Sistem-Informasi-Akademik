<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form Edit Menu</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php
                echo form_open('menu/edit', 'role="form" class="form-horizontal"');
                echo form_hidden('id', $menu['id']);
            ?>

                <div class="box-body">

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Nama Menu</label>

                      <div class="col-sm-9">
                        <input type="text" value="<?php echo $menu['nama_menu']; ?>" name="nama_menu" class="form-control" placeholder="Masukkan Nama Menu">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Link</label>

                      <div class="col-sm-9">
                        <input type="text" value="<?php echo $menu['link']; ?>" name="link" class="form-control" placeholder="Masukkan Link Menu">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Icon</label>

                      <div class="col-sm-6">
                        <input type="text" value="<?php echo $menu['icon']; ?>" name="icon" class="form-control" placeholder="Masukkan Icon Menu">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Is Main Menu</label>

                      <div class="col-sm-6">

                        <!-- kalo menggunakan cmb_dinamis tidak bisa memilih menjadi main menu karena pilihan main menu tidak tersedia, makanya menggunakan cmb manual sehingga bisa menambhakan pilihan baru -->
                        <select name="is_main_menu" class="form-control">
                              <option value="0">Main Menu</option>
                              <?php
                                $tabelmenu = $this->db->get('tabel_menu');
                                foreach ($tabelmenu->result() as $row) {
                                  echo "<option value='$row->id' ";
                                  echo $row->id == $menu['is_main_menu'] ? 'selected' : '' ;
                                  echo ">$row->nama_menu</option> ";
                                }
                              ?>
                        </select>

                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label"></label>

                      <div class="col-sm-1">
                        <button type="submit" name="submit" class="btn btn-primary btn-flat">Simpan</button>
                      </div>

                      <div class="col-sm-1">
                        <?php
                          echo anchor('menu', 'Kembali', array('class'=>'btn btn-danger btn-flat'));
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