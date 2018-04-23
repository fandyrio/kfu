
          <!-- Horizontal Form -->
          <div class="box box-info">
           <div class="box-header with-border">
              <h3 class="box-title">Tambah Inventory</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
              <div class="box-body form-horizontal">
              <div class="col-md-8">

                <div class="form-group">
                  <label class="col-sm-2 form-control-label">Nama Generik</label>

                  <div class="col-sm-9">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_nama_generik");
                     
                      ?>
                      <select name='id_generik' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>

                <div class="form-group" >
                  <label for="jm" class="col-sm-2">Nama Brand</label>

                  <div class="col-sm-9">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_nama_brand");
                     
                      ?>
                      <select name='id_brand' class='form-control' required id="inventori_nama"> 
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>

				         <div class="form-group">
                  <label  class="col-sm-2">Form</label>

                  <div class="col-sm-6">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_form");
                     
                      ?>
                      <select name='id_form' class='form-control' >
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>

                <div class="form-group">
                  <label  class="col-sm-2">Kode</label>

                  <div class="col-sm-6">                     
                      <input name='kode' class='form-control'>
                      
                  </div>
                  </div>
				        <div class="form-group">
                  <label  class="col-sm-2">Strength</label>

                  <div class="col-sm-6">                     
                      <input name='strength' class='form-control' >
                      
                  </div>
                </div>
              </div>



                <div class="col-sm-4">
			           <div class="form-group">
                  <label  class="col-sm-3">Register</label>

                  <div class="col-sm-6">                     
                      <input name='register' class='form-control' >
                      
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3">Aktif</label>

                  <div class="col-sm-9">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='active'>Aktif</option>
                      <option value='discontinue'>Tidak Dilanjutkan</option>
                      <option value='deleted'>Hapus</option>
                      
                      </select>
                  </div>
                </div>
				 <div class="form-group">
					 
					 <label class="col-sm-3"> Alasan </label>

						<div class="col-sm-9">				  
						  <input name='alasan' class='form-control' placeholder="Isi Jika Dilanjutkan">
						  
					  </div>
                  </div>
                </div>
                
				  
                </div>

              </div>
             

              <!-- /.box-body -->
              
         
          </div>

          
        
          
        