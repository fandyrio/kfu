

<button class="btn-xs btn-danger" id="cancel_retur_batch">Cancel</button>
<button class="btn-xs btn-success" id="simpan_retur_batch">Simpan</button>
            <form method="POST" enctype="multipart/form-data" id="rquo">
             
              <div class="box-body form-horizontal">
              
              <div class="col-md-6">

                    <div class="row">
                     <div class="form-group">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-7">
                               <?php 
                                $result =pg_query($dbconn, "SELECT * FROM inv_nama_brand");
                               
                                ?>
                                <select name='id_brand' class='form-control' required>
                                
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
                            <label  class="col-sm-2">No Batch</label>
                             <div class="col-sm-3">                     
                                <input id="no_batch" name='no_batch'   class='form-control'>
                                
                            </div>                            
                          </div>
             

                        <div class="form-group">
                            <label  class="col-sm-2">Jumlah</label>
  						          <div class="col-sm-3">                     
                                <input id="jumlah_po" name='jumlah'  required class='form-control' onchange="count_on_jumlah_po()">
                                
                            </div>
                            
                            <div class="col-sm-4">                     
                                
                                <?php 
                                      $result =pg_query($dbconn, "SELECT * FROM inv_satuan");
                                     
                                      ?>
                                      <select  name='id_satuan' required class='form-control'>
                                      
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
                            <label  class="col-sm-2">Net Total</label>
                             <div class="col-sm-3">                     
                                <input id="net_po" name='net_po'  readonly class='form-control'>
                                
                            </div>                            
                          </div>
						  
                          
              
               
                        </div>
                  </div>
				  
				  <div class="col-md-6">
				  <div class="form-group">
                            <label  class="col-sm-2">Tgl. Manufactured </label>
                             <div class="col-sm-6">                     
                                <input type="text" name='tgl_manufactured'  class='form-control' id="datepicker" value="<?php echo date('Y-m-d') ?>" required>
                                
                            </div>                            
                          </div>
					<div class="form-group">
                            <label  class="col-sm-2">Tgl. Expired</label>
                             <div class="col-sm-6">                     
                                <input type="text"  name='tgl_expired'   class='form-control' id="datepicker2" value="<?php echo date('Y-m-d') ?>" required>
                                
                            </div>                            
                          </div>	  

                  </div>
				  
                  </div>
</form>
             

             

           



               
                
          
   
          
              