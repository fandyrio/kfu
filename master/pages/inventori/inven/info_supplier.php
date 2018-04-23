             <div class="row">
           <div class="box-body">
                <div class="col-md-6 ">
                 <div class="form-group" style="margin-bottom:55px !important;">
                    <label class="col-sm-3">Info Supplier</label>
                          <div class="col-sm-9">
                       <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier");
                     
                      ?>
                      <select name='id_infosupplier' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
             
                         echo "<option value='".$row['id']."' >".$row['nama']."</option>";
                        
                      }
                      ?>
                      </select>
                      </div>
                  </div>

                  <div class="form-group" style="margin-bottom:55px !important;">
                    <label class="col-sm-3">Satuan</label>
                          <div class="col-sm-9">
                       <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_satuan");
                     
                      ?>
                      <select name='id_satuan' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
             
                         echo "<option value='".$row['id']."' >".$row['nama']."</option>";
                        
                      }
                      ?>
                      </select>
                      </div>
                  </div>

               </div>
              </div>
            </div>