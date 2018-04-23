<?php
	$id=$_GET['id'];

	$result=pg_query($dbconn,"SELECT * FROM inv_obat WHERE id='".$id."' ");
	$data = pg_fetch_array($result);


?>	  

      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Update Obat</h3>
            </div>
            
            <form role="form" action="media.php?inventori=obat&modul=simpan&act=edit" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
              <div class="box-body">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" value ="<?php echo $data['nama'] ?> " class="form-control" required>
                </div>  
				<div class="form-group">
                    <label for="jm">Kategori</label>
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_obat_kategori");
                     
                      ?>
                      <select name='id_kategori' class='form-control' required>
                      
                      <option value=''>Pilih Kategori Obat</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
						  if($data['id_kategori'] ==$row['id']){
							  echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
						  }
						  else echo "<option value='".$row['id']."' >".$row['nama']."</option>";
                        
                      }
                      ?>
                      </select>
                  </div>
              
              <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-success">SIMPAN</button>
                
                   <button type="button" value="batal" class="btn btn-warning" onClick="window.location='media.php?inventori=obat';" >BATAL</button>
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
    

