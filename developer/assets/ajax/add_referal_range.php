			  <div class="col-sm-12"> 
              <form method="POST" enctype="multipart/form-data" id="referal_range">
              
                 <div class="form-group">
                  <label  class="col-sm-3">Jenis Kelamin</label>

                  <div class="col-sm-4">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM master_jenkel");
                     
                      ?>
                      <select name='id_gender' class='form-control' >
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>

                <div class="form-group text-left" >
                  <label for="jm" class="col-sm-3">Dari Usia
                  </label>

                  <div class="col-sm-3">
                     <input type="text" class="form-control" name="dari_usia">
                  </div>

                  <label for="jm" class="col-sm-2" style="margin: 0px;">Ke Usia</label>

                  <div class="col-sm-3">
                     <input type="text" class="form-control" name="ke_usia">
                  </div>
                </div>

              
                <div class="form-group" >
                  <label for="jm" class="col-sm-3">Low Range</label>

                  <div class="col-sm-3">
                     <input type="text" class="form-control" name="low_range">
                  </div>
                  <label for="jm" class="col-sm-2">High Range</label>

                  <div class="col-sm-3">
                     <input type="text" class="form-control" name="high_range">
                  </div>
                </div>

               

                <div class="form-group" >
                  <label for="jm" class="col-sm-3">Catatan</label>

                  <div class="col-sm-6">
                     <input type="text" class="form-control" name="catatan">
                  </div>
                </div>      

               </form>
              <button type="button" class="btn btn-info btn-sm btn-flat" id="simpan_referal_range">Tambah</button>
			  <br><br>
			  </div>