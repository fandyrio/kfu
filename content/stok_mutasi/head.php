        <div class="card-header">
            <i class="icon-user"></i> Stok Mutasi
          </div>
         <div class="box-header">
               <div class="col-md-12 text-right">
                                 <button class="btn btn-xs btn-danger" id="cancel_trf_hdr">Cancel</button>
                       <button class=" btn btn-xs btn-success" id="simpan_trf_hdr">Simpan</button>

                                
                          </div>
              </div>
            
           <form method="POST" class="form-horizontal" enctype="multipart/form-data" id="trf_hdr">
            <input id="submit_handle" type="submit" style="display: none">
		    
              <div class="card-block">
              <div class="row">
              <div class="col-md-7" >

                <div class="form-group row">
                  <label class="col-sm-2 form-control-label">No. Mutasi </label>

                  <div class="col-sm-6">
                      <input type="text" value="<?php echo random_doc("mutasi");?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
				  
                </div>
                
                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">No. Reference</label>

                  <div class="col-sm-6">                     
                      <input name='refno' id="refno" class='form-control' required> 
                      
                  </div>
                  </div>

                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Attention</label>

                  <div class="col-sm-5">                     
                      <input name='attention' class='form-control' > 
                      
                  </div>
                  </div> 

                </div>

                <div class="col-sm-5">       
                  
                    <div class="form-group row" >
                      <label for="jm" class="col-sm-2 form-control-label">Tgl <span class="ingatan">*</span></label>

                      <div class="col-sm-6">
                          <input type="text" name="tgl" value="<?php echo date('d-m-Y') ?>" id="datepicker3" class="form-control" >
                      </div>
                    </div>
                      
                      <div class="form-group row">
                      <label class="col-sm-2 form-control-label">Status <span class="ingatan">*</span></label>

                      <div class="col-sm-6">
                     
                          <select name='status' class='form-control' >
                          
                          <option value='A'>Aktif</option>
                          <option value='H'>Hapus</option>
                          
                          </select>
                                </div>
                      </div>
                  </div>
                  </div>

                  <div class="row">
                  <div class="col-md-7" >
                      <div class="form-group row" >
                      <label  class="col-sm-2 form-control-label">Unit <span class="ingatan">*</span></label>

                       <div class="col-sm-4" >  
                      <input type="hidden" name="unit" value="<?php $row['id']  ?>" class="form-control" >

                     
                      <?php 
                          $result =pg_query($dbconn, "SELECT * FROM master_unit where id='$_SESSION[id_units]'");
                          $row =pg_fetch_array($result)
                      ?>
                         
                          
                           <input type="hidden" name="unit" value="<?php echo $row['id']  ?>" class="form-control" >

                           <input type="text" value="<?php echo $row['nama']  ?>" class="form-control" readonly>                
                                               
                      </div>
                       <label  class="form-control-label" style="padding-right: 5px">ke</label>

                      <div class="col-sm-4" style="padding-left: 0px">                      
                        <?php 
                          $result =pg_query($dbconn, "SELECT * FROM master_unit");
                         
                          ?>
                          <select name='id_unit_to' class='form-control' >
                          
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
                      <label  class="col-sm-2 form-control-label">Departemen <span class="ingatan">*</span></label>

                      <div class="col-sm-4" >                     
                         <?php 
                          $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                         
                          ?>
                          <select name='id_departemen' class='form-control' >
                          
                          <option value=''>Pilih</option>
                          <?php 
                          while ($row =pg_fetch_assoc($result)){
                            echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                          }
                          ?>
                          </select>
                          
                      </div>
                       <label  class="form-control-label" style="padding-right: 5px">ke</label>

                      <div class="col-sm-4" style="padding-left: 0px">                      
                        <?php 
                          $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                         
                          ?>
                          <select name='id_departemen_to' class='form-control' >
                          
                          <option value=''>Pilih</option>
                          <?php 
                          while ($row =pg_fetch_assoc($result)){
                            echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                          }
                          ?>
                          </select>
                          
                      </div>
                      </div>          
                    
                    <div class="form-group row" >
                      <label  class="col-sm-2 form-control-label">Terms</label>

                      <div class="col-sm-4" >                     
                          <input name='terms' class='form-control' > 
                          
                      </div>
                  
                      </div> 
                   </div> 
                   </div>                
			  
             
               </form>
                  </div>

              <!-- /.box-body -->
              
         

          
        
          
        