          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Add Details</a></li>
			 
              <!--li><a href="#tab_3" data-toggle="tab">Costing</a></li-->
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">  
                <div class="box-footer text-left">

        <?php 
              $result =pg_query($dbconn, "select inv_inventori.* , inv_nama_brand.nama as \"nama_brand\" , inv_satuan.nama as \"nama_satuan\" FROM inv_inventori 
                INNER JOIN inv_nama_brand on inv_nama_brand.id=inv_inventori.id_brand
                INNER JOIN inv_satuan on inv_satuan.id=inv_inventori.id_satuan");                             
         ?>  

        <button class="btn-xs btn-danger" id="cancel_adj_details">Cancel</button>
        <button name="btn" class=" btn-warning btn-xs" id="simpan_adj_ln" >Simpan</button>
            <form method="POST" enctype="multipart/form-data" id="adj_ln">
            <input type="hidden" name="id_inv" id="inv_adj">
             <input type="hidden" name='id_satuan' id="id_satuan_adj">
             <input type="hidden" name='brand_nama' id="brand_nama_adj">
             
              <div class="box-body form-horizontal">
              
              <div class="col-md-8">

                    <div class="row">
                     <div class="form-group">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-6">
                               
                                <select name="nama_brand_adj" class='form-control' required>
                                
                                <option value=''>Pilih</option>
                                <?php 
                                while ($row =pg_fetch_assoc($result)){
                                  echo "<option value='".$row['id']."_".$row['nama_brand']."_".$row['nama_satuan']."_".$row['id_satuan']."'>".$row['nama_brand']."</option>";
                                }
                                ?>
                                </select>
                            </div>
                          </div>

                      <div class="form-group">
                            <label  class="col-sm-2">Reason</label>

                            <div class="col-sm-6">
                             <select name="alasan" class='form-control' required>
                                
                                <option value='hadiah'>Hadiah</option>
                                <option value='berhenti'>berhenti</option>                
                                
                                </select>
                               

                            </div>
                          </div>                 
             

                  <div class="form-group">
                  <label  class="col-sm-2">Jumlah</label>

                  <div class="col-sm-3">                     
                      <input name='jumlah' class='text-right form-control'   id="jumlah_adj"   required >
                      
                  </div>
                    <div class="col-sm-3">                     
                      <input text="text" id="nama_satuan_adj" name="nama_satuan" class='text-right  form-control' readonly>
                            </div>
                    </div>

                    <div class="minus">
                    <div class="form-group">
                         <label  class="col-sm-2">Unit Cost</label>
                           <div class="col-sm-3">                     
                          <input name='unit_cost' id="unit_cost_adj" class='form-control text-right'/>
                           </div>                            
                     </div>

                    <div class="form-group">
                         <label  class="col-sm-2">Total Cost</label>
                           <div class="col-sm-3">                     
                          <input name='total_cost' class='form-control text-right' readonly>
                           </div>                            
                     </div>
                     </div>

                    </div>
                  </div>

                  </div>
                  </form>
			  
              </div>
			  
      				</div>			  
      				</div>
            </div>

          <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              
              <div class="modal-dialog" role="document" style="width: 700px">
                  <div class="modal-content">

                   <div class="modal-body" style="text-align:left">

                    </div>
                    <div class="modal-footer">                    
                    <button type="button" class="btn btn-sm btn-warning" id="save_batch_adj" >oke</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">BATAL</button>
                    </div>
                  </div>
              </div>
          </div>            
