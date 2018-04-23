
       <div class="row">
        <!-- left column -->
        <div class="col-md-12">
  
            <form role="form" action="media.php?content=users&modul=simpan&act=baru" method="post">
            <div class="card-header d-flex align-items-center">
                tambah
              </div>

              <div class="card-body">
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
                      $result =pg_query($dbconn, "SELECT * FROM master_karyawan_unit u
                          where not exists(
                            SELECT null
                              from auth_users a where a.id_karyawan=u.id_karyawan
                            ) AND u.id_unit ='$_SESSION[id_units]'");
                     
                      ?>
                      <select name='id_karyawan' class='form-control select2' required>
                      
                      <option value=''>Pilih Karyawan</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        $d=pg_fetch_array(pg_query($dbconn, "SELECT * FROM master_karyawan where id= '$row[id_karyawan]'"));
                        echo "<option value='".$row['id_karyawan']."'>".$d  ['nama']."</option>";
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

              <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success btn-flat">SIMPAN</button>
              </div>

              </div>

            </form>

             
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      <!-- /.row -->
    
