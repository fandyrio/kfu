<?php
	$id=$_GET['id'];

	$result=pg_query($dbconn,"SELECT * FROM auth_level WHERE id='".$id."' ");
	$data = pg_fetch_array($result);


?>	  

      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit</h3>
            </div>
            
            <form role="form" action="media.php?auth=level&modul=simpan&act=edit" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Level</label>
                  <input type="text" name="level" value ="<?php echo $data['nama'] ?> " class="form-control" required autofocus>
                </div>               
              
              <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                
                   <button type="button" value="batal" class="btn btn-warning btn-flat" onClick="window.location='media.php?auth=level';" >BATAL</button>
                  </div>
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
    

