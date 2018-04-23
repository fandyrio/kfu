<?php
	$id=$_GET['id'];

	$result=pg_query($dbconn,"SELECT * FROM inv_departemen WHERE id='".$id."' ");
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
            
            <form role="form" action="media.php?inventori=departemen&modul=simpan&act=edit" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
              <div class="box-body">
                              
              <div class="form-group">
                  <label for="exampleInputEmail1">Kode</label>
                  <input type="text" name="code" class="form-control"  value ="<?php echo $data['code'] ?>" autofocus required>
                </div>  
				<div class="form-group">
                  <label for="exampleInputEmail1">Nama Departemen</label>
                  <input type="text" name="nama" class="form-control"  value ="<?php echo $data['nama'] ?>">
                </div>
              <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                
                  <button type="button" value="batal" class="btn btn-warning btn-flat" onClick="window.location='media.php?inventori=departemen';" >BATAL</button>
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
    

