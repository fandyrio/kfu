<?php
  
    $id = $_GET["id"];
    $result=pg_query($dbconn,"SELECT * FROM lab_analisis_referal_range WHERE id='".$id."' ");
    $data = pg_fetch_array($result);

?>

			  <div class="col-sm-12"> 
              <form method="POST" enctype="multipart/form-data" id="edit_referal_range">
              <input type="hidden" name="id" value="<?php echo $data["id"] ?>">
              
                 <div class="form-group">
                  <label  class="col-sm-3">Gender</label>

                  <div class="col-sm-4">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM master_jenkel");
                     
                      ?>
                      <select name='id_gender' class='form-control' >
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){


                        if($data['id_jenkel']== $row['id']){
                          echo "<option value='".$data['id_jenkel']."' selected>".$row['nama']."</option>";
                        }else{
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                          }
                      }
                      ?>
                      </select>
                  </div>
                </div>

                <div class="form-group text-left" >
                  <label for="jm" class="col-sm-3">Dari Usia
                  </label>

                  <div class="col-sm-3">
                     <input type="text" value="<?php echo $data["usia_awal"] ?>" class="form-control" name="dari_usia">
                  </div>

                  <label for="jm" class="col-sm-2" style="margin: 0px;">Ke Usia</label>

                  <div class="col-sm-3">
                     <input type="text"  value="<?php echo $data["usia_akhir"] ?>" class="form-control" name="ke_usia">
                  </div>
                </div>

              
                <div class="form-group" >
                  <label for="jm" class="col-sm-3">Low Range</label>

                  <div class="col-sm-3">
                     <input type="text"  value="<?php echo $data["nilai_rendah"] ?>" class="form-control" name="low_range">
                  </div>
                  <label for="jm" class="col-sm-2">High Range</label>

                  <div class="col-sm-3">
                     <input type="text"  value="<?php echo $data["nilai_tinggi"] ?>" class="form-control" name="high_range">
                  </div>
                </div>

               

                <div class="form-group" >
                  <label for="jm" class="col-sm-3">Catatan</label>

                  <div class="col-sm-6">
                     <input type="text" class="form-control"  value="<?php echo $data["catatan"] ?>" name="catatan">
                  </div>
                </div>      

               </form>
              <button type="button" class="btn btn-info btn-sm btn-flat" id="simpan_edit_range">Simpan</button>
              <button type="button" class="btn btn-warning btn-sm btn-flat" id="batal_range">Batal</button>
			  </div>