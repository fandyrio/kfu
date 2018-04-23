		      <div class="row">
			
                <div class="col-md-6 ">
				<div class="box-body">
                 <div class="form-group" style="margin-bottom:55px !important;">
                    <label class="col-sm-3">Opsi Billing</label>
					<div class="col-sm-9">
                       <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_opsi_billing");
                     
                      ?>
                      <select name='id_opsi_billing' class='form-control' required >
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
						  if($data['id_opsi_billing'] ==$row['id']){
							  echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
						  }
						  else echo "<option value='".$row['id']."' >".$row['nama']."</option>";
                        
                      }
                      ?>
                      </select>
					</div>
                  </div>
				  <div class="form-group">              
                
					<input type="checkbox" name="ditentukan_pengguna"   >
					<label>Ditentukan Pengguna</label>
                  
					</div>
					<div class="form-group">              
                
					<input type="checkbox" name="tentukan_pengguna"   >
					<label>Tentukan Pengguna</label>
                  
					</div>
				  
				  
				 
                </div>
            	</div>
			 </div>