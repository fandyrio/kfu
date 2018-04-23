			       <div class="row">
			         <div class="col-xs-6 text-left">
			   
              <div class="box-body">
                <div class="form-group" style="margin-bottom:5px !important;">
                    <label for="jm">Kategori</label>
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_obat_kategori");
                     
                      ?>
                      <select name='id_kategori' class='form-control select2' required>
                      
                      <option value=''>Pilih Kategori Obat</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>

				        <div class="form-group" style="margin-bottom:5px !important;">
                    <label for="jm">Kelas Pengobatan</label>
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_kelas_pengobatan");
                     
                      ?>
                      <select name='id_pengobatan' class='form-control select2' required>
                      
                      <option value=''>Pilih Kelas Pengobatan</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>

				          <div class="form-group" style="margin-bottom:5px !important;">
                    <label for="jm">Route</label>
                       <input type="text" name="form" class="form-control" >
                     
                  </div>

				           <div class="form-group" style="margin-bottom:5px !important;">
                    <label for="jm">Narkotika</label>
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_narkotika");
                     
                      ?>
                      <select name='id_narkotika' class='form-control select2'>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>

				           <div class="form-group" style="margin-bottom:5px !important;">
                    <label for="jm">Kategori Kehamilan</label>
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_kategori_kehamilan");
                     
                      ?>
                      <select name='id_kategori_kehamilan' class='form-control select2'>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>

				           

				           <div class="form-group" style="margin-bottom:5px !important;">
                    <label for="jm">Kelas ATC</label>
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM master_tbl_atccode");
                     
                      ?>
                      <select name='id_atccode' class='form-control select2' >
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['code']."-".$row['deskripsi']."</option>";
                      }
                      ?>
                      </select>
                  </div>

				          <div class="form-group" style="margin-bottom:5px !important;">
                    <label for="jm">MIMS</label>
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_satuan");
                     
                      ?>
                      <select name='id_mims' class='form-control select2' >
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>

                  <!-- /.box-body -->
              </div>
              
             </div>
                <div class="col-md-6 ">
				            <div class="box-body">

                     <div class="form-group" style="margin-bottom:5px !important;">
                    <label for="jm">Satuan</label>
                        <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_satuan");
                     
                      ?>
                      <select name='id_satuan' class='form-control select2' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>

				        <div class="form-group">
                <div class="col-md-4">
        				<input type="checkbox" name="print_label"  >
                          <label>Print Label</label>
                          </div>
                <div class="col-md-5">
        				<input type="checkbox" name="edc"  >
                          <label>Kontrol Expired Date</label>
                          </div>
                <div class="col-md-3">                        
        				<input type="checkbox" name="otc"   >
                         <label> OTC</label>
                         </div>
                          
                </div>
				
                </div>
            </div>
			   </div>