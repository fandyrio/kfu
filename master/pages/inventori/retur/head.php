
          <!-- Horizontal Form -->
        <div class="box-header">
                        
                          <div class="col-md-12 text-right">
                                 <button class="btn-xs btn-danger" id="cancel_retur_hdr">Cancel</button>
                                 <button class="btn-xs btn-success" id="simpan_retur_hdr">Simpan</button>
                          </div>
              </div>

            <!-- /.box-header -->
            <!-- form start -->
           <form method="POST" enctype="multipart/form-data" id="retur_hdr">
              <div class="box-body form-horizontal" >
              <div class="col-md-6">

                <div class="form-group">
                  <label class="col-sm-2">No Dok </label>

                  <div class="col-sm-4">
                      <input type="text" value="<?php echo Random("STR") ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
				  <label class="col-sm-2">Tgl. Dok </label>
				  <div class="col-sm-4">
                      <input type="text" name="doc_date" value="<?php echo date('Y-m-d') ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>
				<div class="form-group">
                  <label  class="col-sm-2">Departemen</label>

                  <div class="col-sm-10">
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
				 <div class="form-group">
                  <label  class="col-sm-2">Supplier</label>

                  <div class="col-sm-10">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier");
                     
                      ?>
                      <select name='id_supplier' class='form-control' required id="supplier_po">
                      
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
                  <label  class="col-sm-2">Catatan</label>

                  <div class="col-sm-5">                     
                      <input name='catatan' class='form-control' required>
                      
                  </div>
                  </div>                  
				  
				  

				     
              </div>



                <div class="col-sm-6">			        
                
          		
                <div class="form-group" >
                  <label for="jm" class="col-sm-3">Tgl. Dok</label>

                  <div class="col-sm-8">
                      <input type="text" name="tgl_invoice" value="<?php echo date('Y-m-d') ?>" id="datepicker2" class="form-control" required>
                  </div>
                </div>
                </div>
                
                </div>
                

             </form>

              <!-- /.box-body -->
              
         

          
        
          
        