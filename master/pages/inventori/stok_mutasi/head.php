   
        <div class="box-header">
              <div class="col-md-12 text-right">
                       <button class="btn btn-xs btn-danger" id="cancel_trf_hdr">Cancel</button>
                       <button class=" btn btn-xs btn-success" id="simpan_trf_hdr">Simpan</button>
                </div>
              </div>

           <form method="POST" enctype="multipart/form-data" id="trf_hdr">
		   
             <!-- Horizontal Form -->
              <div class="box-body form-horizontal" >
              <!-- row -->
              <div class="row">
              <div class="col-md-6" style="padding-left: 0px">

                <div class="form-group">
                  <label class="col-sm-3">No. Mutasi </label>

                  <div class="col-sm-6">
                      <input type="text" value="<?php echo Random("BS") ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
				  
                </div>
                
                <div class="form-group">
                  <label  class="col-sm-3">No. Reference</label>

                  <div class="col-sm-6">                     
                      <input name='refno' class='form-control' required> 
                      
                  </div>
                  </div>

                <div class="form-group">
                  <label  class="col-sm-3">Attention</label>

                  <div class="col-sm-5">                     
                      <input name='attention' class='form-control' required> 
                      
                  </div>
                  </div> 

                </div>

                <div class="col-sm-6">       
                  
                    <div class="form-group" >
                      <label for="jm" class="col-sm-3">Tgl</label>

                      <div class="col-sm-6">
                          <input type="text" name="tgl" value="<?php echo date('Y-m-d') ?>" id="datepicker3" class="form-control" required>
                      </div>
                    </div>
                      
                      <div class="form-group">
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
                  <!-- end row -->



                  <!-- new row -->
                  <div class="row">
                  <div class="col-md-10" style="padding-left: 0px">
                      <div class="form-group" style="padding-left: 0px">
                      <label  class="col-sm-2">Unit</label>

                      <div class="col-sm-4" style="padding-left: 0px">  
                      <?php 
                          $result =pg_query($dbconn, "SELECT * FROM master_unit");
                         
                          ?>
                          <select name='unit' class='form-control' readonly>
                          
                         
                          <?php 
                          while ($row =pg_fetch_assoc($result)){
                            echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                          }
                          ?>  
                          </select>                 
                                               
                      </div>
                       <label  class="col-sm-1" style="padding-left: 0px">to</label>

                      <div class="col-sm-4" style="padding-left: 0px">                      
                        <?php 
                          $result =pg_query($dbconn, "SELECT * FROM master_unit");
                         
                          ?>
                          <select name='id_unit_to' class='form-control' required>
                          
                          <option value=''>Pilih</option>
                          <?php 
                          while ($row =pg_fetch_assoc($result)){
                            echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                          }
                          ?>
                          </select>
                          
                      </div>
                      </div> 

                    <div class="form-group" style="padding-left: 0px">
                      <label  class="col-sm-2">Departemen</label>

                      <div class="col-sm-4" style="padding-left: 0px">                     
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
                       <label  class="col-sm-1" style="padding-left: 0px">to</label>

                      <div class="col-sm-4" style="padding-left: 0px">                      
                        <?php 
                          $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                         
                          ?>
                          <select name='id_departemen_to' class='form-control' required>
                          
                          <option value=''>Pilih</option>
                          <?php 
                          while ($row =pg_fetch_assoc($result)){
                            echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                          }
                          ?>
                          </select>
                          
                      </div>
                      </div>          
                    
                    <div class="form-group" style="padding-left: 0px">
                      <label  class="col-sm-2">Terms</label>

                      <div class="col-sm-4" style="padding-left: 0px">                     
                          <input name='terms' class='form-control' required> 
                          
                      </div>
                  
                      </div> 
                   </div>   
                  </div> 
                  <!-- end row -->                
			  
               </div>
               </form>
                

              <!-- /.box-body -->
              
         

          
        
          
        