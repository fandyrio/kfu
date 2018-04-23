        <div class="card-header">
            <i class="icon"></i> Tambah Pengembalian Barang
          </div>
         <div class="box-header">
         <br>
                          <div class="col-md-12 text-right">
                                <button class="btn btn-xs btn-danger" id="cancel_retur_hdr">Cancel</button>
                                 <button class="btn btn-xs btn-success" id="simpan_retur_hdr">Simpan</button>
                                
                          </div>
              </div>


           <form method="POST" class="form-horizontal" enctype="multipart/form-data" id="retur_hdr">
              <div class="card-block" >
              <div class="row">
              <div class="col-md-6">

                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">No. Dokumen </label>

                  <div class="col-sm-9">
                      <input type="text" value="<?php echo random_doc("sr"); ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
        				
                </div>
				      <div class="form-group row">
                  <label  class="col-sm-3 form-control-label">Departemen</label>

                  <div class="col-sm-9">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                     
                      ?>
                      <select name='id_departemen' id="id_departemen" class='form-control' required>
                      
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
                  <label  class="col-sm-3 form-control-label">Supplier</label>

                  <div class="col-sm-9">
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
                  <label  class="col-sm-3 form-control-label">Catatan</label>

                  <div class="col-sm-9">                     
                      <input name='catatan' class='form-control' required>
                      
                  </div>
                  </div>                  
				  
				  

				     
              </div>



                <div class="col-sm-6" style="padding-left: 30px;">			        
                
          		
                <div class="form-group row" >
                  <label for="jm" class="col-sm-2 form-control-label ">Tgl. Dokumen</label>

                  <div class="col-sm-8">
                      <input type="text" name="tgl_invoice"   class="form-control dates" required>
                  </div>
                </div>
                </div>
                
                </div>
              </div>

                

             </form>

              <!-- /.box-body -->
              
         

          
        
          
        