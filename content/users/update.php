<?php
  $id=$_GET['id'];

  $result=pg_query($dbconn,"SELECT * FROM auth_users WHERE id_users='".$id."' ");
  $data = pg_fetch_array($result);


?>    
      <div class="row">
        <div class="col-md-12">
           <form role="form" action="media.php?content=users&modul=simpan&act=edit" method="post">
                <div class="card-header d-flex align-items-center">
                tambah
              </div>
            <input type="hidden" name="id" value="<?php echo $data['id_users'] ?>">
            <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Username</label>
                  <input type="text" name="username" value ="<?php echo $data['username']?>" class="form-control" readonly>
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">New Password</label>
                  <input type="password" name="password" class="form-control" >
                </div> 
                

                <div class="form-group">
                    <label >Level</label>
                        <?php 
                      $res =pg_query($dbconn, "SELECT * FROM auth_level");
                     
                      ?>
                      <select name='id_level' class='form-control' required>
                      
                      <option value=''>Pilih Level</option>
                      <?php 
                      while ($row =pg_fetch_assoc($res)){
                         if($data['id_level']== $row['id']){
                          echo "<option value='".$data['id_level']."' selected>".$row['nama']."</option>";
                        }else{
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      
                      }
                    }
                      ?>
                      </select>
              </div> 

              <div class="form-group">
                    <label >Karyawan</label>
                        <?php 
                      $res =pg_query($dbconn, "SELECT * FROM master_karyawan");
                     
                      ?>
                      <select name='id_karyawan' class='form-control select2' disabled>
                      
                      <option value=''>Pilih Level</option>
                      <?php 
                      while ($row =pg_fetch_assoc($res)){
                         if($data['id_karyawan']== $row['id']){
                          echo "<option value='".$data['id_karyawan']."' selected>".$row['nama']."</option>";
                        }else{
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      
                      }
                    }
                      ?>
                      </select>
              </div>               
              
              <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-sm btn-success">SIMPAN</button>
                
                   <button type="button" value="batal" class="btn btn-sm btn-warning btn-flat" onClick="window.location='media.php?content=users';" >BATAL</button>
                  </div>
              </div>
            </form>
          </div>
          <!-- /.box -->

             
            <!-- /.box-body -->
          </div>