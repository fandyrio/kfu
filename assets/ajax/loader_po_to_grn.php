               <div class="col-md-12">
                <div class="form-group row">
                  <label  class="col-sm-12">
                    <?php
                     $result_supp =pg_fetch_assoc(pg_query($dbconn, "SELECT nama FROM inv_info_supplier"));
                    echo "<b>PO Dari : <br> ".$result_supp['nama']."</b>";

                    ?>

                  </label>

                    
              </div>
               
               </div>
              <div class="col-md-6">
                 
             <div class="form-group row">
                  <label  class="col-sm-3">Available PO</label>

                  <div class="col-sm-7">
                     <?php 
                     session_start();
                      $result =pg_query($dbconn, "Select po_hdr.*, po_ln.id as \"id_po_ln\",
                    po_ln.jumlah, po_ln.id_satuan, po_ln.nama_brand,po_ln.total_harga, inv_satuan.nama as \"nama_satuan\" from po_hdr  
                    INNER JOIN po_ln on po_ln.id_hdr= po_hdr.id
                   INNER JOIN inv_satuan on inv_satuan.id = po_ln.id_satuan 
                   WHERE po_hdr.id_unit='$_SESSION[id_units]'");                     
                      ?>
                      <select name='load_id_po' class='form-control' required id="load_id_po">
                      
                      <option value=''><strong>No Doc || Nama Brand || Jumlah</strong></option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id_po_ln']."_".$row['nama_brand']."_".$row['id_satuan']."'>".$row['doc_no']." || ".$row['nama_brand']." || ".$row['jumlah']."</option>";
                      }
                      ?>
                      </select>
                    
                  </div>  
              </div>
               <div class="form-group row" >
                    <label for="jm" class="col-sm-3">Jumlah </label>
                          <div class="col-sm-4">
                            <input type="text" id="po_qty" name="po_qty"  class="form-control">  
                   </div>
                           
               </div>
                
               </div>
            
             <div class="col-md-6">
              <div class="form-group row" >
                    <label for="jm" class="col-sm-4">No Batch </label>
                          <div class="col-sm-4">
                            <input type="text" id="no_batch_po" name="no_batch_po"  class="form-control">  
                   </div>
                           
               </div>
               <div class="form-group row" >
                    <label for="jm" class="col-sm-4">Tgl Manufactur </label>
                          <div class="col-sm-4">
                            <input type="text" id="tgl_manufacture" name="tgl_manufacture" value="<?php echo date('Y-m-d'); ?>"  class="form-control">  
                   </div>
                           
               </div>
               <div class="form-group row" >
                    <label for="jm" class="col-sm-4">Tgl Expired </label>
                          <div class="col-sm-4">
                            <input type="text" id="tgl_expired" name="tgl_expired"  class="form-control"  value="<?php echo date('Y-m-d'); ?>">  
                   </div>
                           
               </div>
             </div>
            
       