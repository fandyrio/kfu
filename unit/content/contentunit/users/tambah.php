
       <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah User</h3>
            </div>
            
            <form role="form" action="media.php?content=users&modul=simpan&act=baru" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Username</label>
                  <input type="text" name="username" class="form-control" id="provinsi" required>
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Password</label>
                  <input type="password" name="password" class="form-control" id="provinsi" required>
                </div>              
              

                <div class="form-group">
                    <label for="jm">Karyawan</label>
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM master_karyawan");
                     
                      ?>
                      <select name='id_karyawan' class='form-control select2' required>
                      
                      <option value=''>Pilih Karyawan</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div> 
              <div class="form-group">
                    <label for="jm">Level</label>
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM auth_level");
                     
                      ?>
                      <select name='id_level' class='form-control' required>
                      
                      <option value=''>Pilih Level</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
              </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success btn-flat">SIMPAN</button>
              </div>

            </form>
          </div>
          <!-- /.box -->

             
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      <!-- /.row -->
    
