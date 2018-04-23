<?php
	$id=$_GET['id'];

	$result=pg_query($dbconn,"SELECT * FROM administrator WHERE username='".$_SESSION['id_users']."' ");
	$data = pg_fetch_array($result);

?>	  

      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h4 class="box-title">Update Account</h4>
            </div>
            
            <form role="form" action="media.php?umum=profile&modul=simpan" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id_users'] ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Username</label>
                  <input type="text" name="username" value ="<?php echo $data['username'];?>" class="form-control" autofocus>
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Password Lama</label>
                  <input type="password" name="old_password"  class="form-control">
                </div> 
                <div class="form-group">
               
                  <label for="exampleInputEmail1">Password Baru <span style="color:red;">*</span></label>
                  <input type="password" name="new_pass"  class="form-control">
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1"> Confirm Password Baru <span style="color:red;">*</span></label>
                  <input type="password" name="confirm_pass" class="form-control">
                </div>               
              
              <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>                
                   <button type="button" value="batal" class="btn btn-warning btn-flat" onClick="window.location='media.php';" >BATAL</button>

                  </div>

                    <i><span style="color:red;">*</span> Kosongkan jika hanya mengubah username</i><br>
              </div>
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
    

