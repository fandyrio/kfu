<?php
	$id=$_GET['id'];

	$result=pg_query($dbconn,"SELECT * FROM master_icd10 WHERE id='".$id."' ");
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
            
            <form role="form" action="media.php?inventori=icd10&modul=simpan&act=edit" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
              <div class="box-body">
                 <div class="form-group">
                  <label>Code</label>
                  <input type="text" name="code" class="form-control"  value ="<?php echo $data['code'] ?>" required autofocus>
                </div> 
				
				<div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" value ="<?php echo $data['nama'] ?> " class="form-control" required>
                </div> 
				  <div class="form-group">
                  <label>Sex</label>
                  <input type="text" name="sex" class="form-control" value ="<?php echo $data['sex'];?>">
                </div>
				        <div class="form-group">
                    <label for="jm">Diagonis Folder</label>
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_diagnosis_folder");
                     
                      ?>
                      <select name="id_diagnosis" class="form-control select2"  style="width: 100%;"  required>
                      
                       <option value=''>Pilih Diagnosis Folder</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
        						  if($data['id_diagnosis_folder']==$row['id']){
        							  echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";}
        						  else echo "<option value='".$row['id']."'>".$row['nama']."</option>";


                      }
                      ?>
                      </select>
                  </div>
				        <div class="form-group">
                  <label>Deskripsi</label>
                  <input type="text" name="deskripsi" class="form-control" value ="<?php echo $data['deskripsi'];?>">
                </div>
				        <div class="form-group">
                  <label>Force Link</label>
                  <input type="text" name="force_link" class="form-control" value ="<?php echo $data['force_link'] ?>">
                </div>            
              
              <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                
                   <button type="button" value="batal" class="btn btn-warning btn-flat" onClick="window.location='media.php?inventori=icd10';" >BATAL</button>
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
    

