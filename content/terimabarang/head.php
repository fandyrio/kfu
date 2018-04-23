 <div class="card-header">
            <i class="icon-user"></i> Terima Barang
          </div>
          <!-- Horizontal Form -->
        <div class="box-header">
                        
                          <div class="col-md-12 text-right">
                                 <button class="btn btn-xs btn-danger" id="cancel_grn_hdr">Cancel</button>
                                 <button class="btn btn-xs btn-success" id="simpan_grn_hdr">Simpan</button>
                          </div>
         </div>

            <!-- /.box-header -->
            <!-- form start -->
           <form method="POST" enctype="multipart/form-data" id="grn_hdr">
		      <input type="submit" id="noober" style="display: none;">
              <div class="form-horizontal" >
                <div class="card-block">
              <div class="row">
              <div class="col-sm-7" style="padding-right: 20px;">

                <div class="form-group row">
                  <label class="col-sm-2 form-control-label">No. Dokumen </label>

                  <div class="col-sm-4">
                      <input type="text"  value="<?php echo random_doc("tb"); ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
				          <label class="col-sm-2 form-control-label">Tgl. Dokumen </label>
				          <div class="col-sm-4">
                      <input type="text" name="doc_date" value="<?php echo date('d-m-Y') ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>
				<div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Unit <span class="ingatan">*</span></label>

                  <div class="col-sm-4">
                     <?php 
                      $row =pg_fetch_array(pg_query($dbconn, "SELECT * FROM master_unit where id='$_SESSION[id_units]'"));
                     
                      ?>

                      <input type="hidden" name="id_unit" class="form-control" value="<?php echo $row['id']  ?>">
                      <?php echo $row['nama']  ?>
                    
                  </div>
                </div>
				<div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Departemen <span class="ingatan">*</span></label>

                  <div class="col-sm-10">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                     
                      ?>
                      <select name='id_departemen' id='id_departemen' class='form-control' required>
                      
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
                  <label  class="col-sm-2 form-control-label">Supplier <span class="ingatan">*</span></label>

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
                

                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Credit Term</label>

                  <div class="col-sm-3">                     
                      <input name='credit_term' class='form-control' required> hari
                      
                  </div>
                  </div>                  
				  
				  

				     
              </div>



                <div class="col-sm-5" style="padding-left: 20px;">			        
                
          		<div class="form-group row" >
                  <label for="jm" class="col-sm-3 form-control-label">No. Invoice</label>

                  <div class="col-sm-8">
                      <input type="text" name="no_invoice"  class="form-control" >
                  </div>
                </div>
                <div class="form-group row" >
                  <label for="jm" class="col-sm-3 form-control-label">Tgl. Invoice <span id="class">*</span></label>

                  <div class="col-sm-8">
                      <input type="text" name="tgl_invoice" value="<?php echo date('d-m-Y')  ?>" id="datepicker3" class="form-control" required>
                  </div>
                </div>
                  
                  <div class="form-group row">
                  <label  class="col-sm-3 form-control-label">No GL</label>

                  <div class="col-sm-8">                     
                      <input name='gl_no' class='form-control' >
                      
                  </div>
                  </div>
                </div>
                
               
              </div>
               </div>
             </div>
           </form>
           
           
                

              <!-- /.box-body -->
              
         

          
        
          
        