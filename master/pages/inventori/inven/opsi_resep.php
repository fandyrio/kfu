		      <div class="row">
			
                <div class="col-xs-12 ">
				<table class="table table-bordered table-hover">
				<tr align="center">
				<th>Kode</th>
				<th>Dosage</th>
				<th>Ambil</th>
				<th>Satuan</th>
				<th>Perhari</th>
				<th>Indikasi</th>
				<th>Intruksi</th>
				</tr>
				
				<tr>
				<td> <input type="text" name="resepkode"  placeholder="kode" style="width:140px;"></td>
				<td><input type="text" name="dosage"  placeholder="dosage"></td>
				<td><input type="text" name="ambil"  placeholder="ambil" style="width:40px;"></td>
				<td><?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_satuan");
                     
                      ?>
                      <select name='satuan' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
						  
						  echo "<option value='".$row['id']."' >".$row['nama']."</option>";
                        
                      }
                      ?>
                      </select>
				</td>
				<td><input type="text" name="perhari"  placeholder="1" style="width:40px;"></td>
				<td>
				<?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_indikasi");
                     
                      ?>
                      <select name='indikasi' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
						  
						  echo "<option value='".$row['id']."' >".$row['nama']."</option>";
                        
                      }
                      ?>
                      </select>
				</td>
				<td>
				<?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_intruksi_obat");
                     
                      ?>
                      <select name='intruksi' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
						  
						  echo "<option value='".$row['id']."' >".$row['nama']."</option>";
                        
                      }
                      ?>
                      </select>
				</td>
				</tr>
				</table>
            	</div>
			 </div>