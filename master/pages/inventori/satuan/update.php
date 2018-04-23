<?php
	$id=$_GET['id'];

	$result=pg_query($dbconn,"SELECT * FROM inv_satuan WHERE id='".$id."' ");
	$data = pg_fetch_array($result);


?>	  

      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit</h3>
            </div>
            
            <form role="form" action="media.php?inventori=satuan&modul=simpan&act=edit" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
              <div class="box-body">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" value ="<?php echo $data['nama'] ?>" class="form-control" required autofocus>
                </div>  
				<div class="form-group">
                  <label>Deskripsi</label>
                  <input type="text" name="deskripsi" class="form-control"  value ="<?php echo $data['deskripsi'] ?>">
                </div>
				<div class="form-group">
                  <label>Short Deskripsi</label>
                  <input type="text" name="short_deskripsi" class="form-control"  value ="<?php echo $data['short_deskripsi'] ?>">
                </div>
				<div class="form-group">
                  <label>Parent Satuan</label>
                  <input type="text" name="parent_satuan" class="form-control"  value ="<?php echo $data['parent_satuan'] ?>">
                </div>
				<div class="form-group">
                  <label>Qty</label>
                  <input type="text" name="qty" class="form-control"  value ="<?php echo $data['qty'] ?>">
                </div>
				<div class="form-group">
				<input type="checkbox" name="active"  <?php if($data['active'] =='Y') echo 'checked'; ?>>
                  <label>Active</label>
                  
                
				<input type="checkbox" name="base_satuan"   <?php if($data['base_satuan'] =='Y') echo 'checked'; ?>>
                 <label>Base Satuan</label>
                  
                </div>
				
              
              <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                
                   <button type="button" value="batal" class="btn btn-warning btn-flat" onClick="window.location='media.php?inventori=satuan';" >BATAL</button>
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
    

