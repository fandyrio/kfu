<?php
	$id=$_GET['id'];

	$result=pg_query($dbconn,"SELECT * FROM inv_info_supplier WHERE id='".$id."' ");
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
            
            <form role="form" action="media.php?inventori=info_supplier&modul=simpan&act=edit" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
              <div class="box-body">
                              
              <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control"  value ="<?php echo $data['nama'] ?>" required autofocus>
                </div>  
                <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" name="alamat" class="form-control"  value ="<?php echo $data['alamat'] ?>">
                </div>
                <div class="form-group">
                  <label>Telepon</label>
                  <input type="text" name="telepon" class="form-control"  value ="<?php echo $data['telepon'] ?>">
                </div>
			
              <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                
                  <button type="button" value="batal" class="btn btn-warning btn-flat" onClick="window.location='media.php?inventori=info_supplier';" >BATAL</button>
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
    

