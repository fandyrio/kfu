<?php
	$id=$_GET['id'];

	$result=pg_query($dbconn,"SELECT * FROM inv_diagnosis_folder WHERE id='".$id."' ");
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
            
            <form role="form" action="media.php?inventori=diagnosis&modul=simpan&act=edit" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
              <div class="box-body">
                <div class="form-group">
                  <label>Kode</label>
                  <input type="text" name="code" class="form-control" value="<?php echo $data['code'] ?>"  required autofocus>
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control"  value="<?php echo $data['nama'] ?>" required>
                </div>
                <div class="form-group">
                  <label>Parent Diafolder</label>
                  <input type="text" name="parent_diafolder" value="<?php echo $data['parent_diafolder'] ?>" class="form-control"  >
                </div>
                  <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                
                   <button type="button" value="batal" class="btn btn-warning btn-flat" onClick="window.location='media.php?inventori=diagnosis';" >BATAL</button>
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
    

