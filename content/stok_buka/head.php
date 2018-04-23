
          <!-- Horizontal Form -->
        <div class="box-header">
                        
                          <div class="col-md-12 text-right">
                                 <button class="btn btn-xs btn-danger" id="cancel_bs_hdr">Cancel</button>
                                 <button class="btn btn-xs btn-success" id="simpan_bs_hdr">Simpan</button>
                          </div>
              </div>

            <!-- /.box-header -->
            <!-- form start -->
           <form method="POST"  class="form-horizontal" enctype="multipart/form-data" id="bs_hdr">
		   
             <div class="card-block">
              <div class="row">
              <div class="col-md-6">

                <div class="form-group row">
                  <label class="col-sm-3">No Dok </label>

                  <div class="col-sm-8">
                      <input type="text" value="<?php echo Random("BS") ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
				  
                </div>
				
				    <div class="form-group row">
                  <label  class="col-sm-3">Departemen</label>

                  <div class="col-sm-8">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                     
                      ?>
                      <select name='id_departemen' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>
				 
                

                <div class="form-group row">
                  <label  class="col-sm-3">Komentar</label>

                  <div class="col-sm-5">                     
                      <input name='komentar' class='form-control' required> hari
                      
                  </div>
                  </div>                  
				  
				  

				     
              </div>



                <div class="col-sm-6">       
                
          		
                <div class="form-group row" >
                  <label for="jm" class="col-sm-3">Tgl</label>

                  <div class="col-sm-6">
                      <input type="text" name="doc_date" value="<?php echo date('Y-m-d') ?>" id="datepicker3" class="form-control" required>
                  </div>
                </div>
                  
                  <div class="form-group row">
                  <label class="col-sm-3">Status</label>

                  <div class="col-sm-6">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='H'>Hapus</option>
                      
                      </select>
                            </div>
                  </div>
                </div>
                
                </div>
                </div>
                </form>
         

          
        
          
        