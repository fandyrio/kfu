 <?php

  $id  =$_GET['id'];
  $sql = pg_query($dbconn,"Select grn_batch.*, inv_satuan.nama as \"nama_satuan\" from grn_batch
        INNER JOIN inv_satuan on inv_satuan.id=grn_batch.id_satuan WHERE grn_batch.id= $id");

  $data = pg_fetch_array($sql);
  

?> 
<button  class="btn btn-xs btn-danger" id="cancel_grn_batch_directly_edit">Cancel</button>
<button  type="submit" class="btn btn-xs btn-success" id="simpan_grn_batch_directly_edit_update">Simpan</button>
            <form method="POST" enctype="multipart/form-data" id="grn_batch_update">
              <input type="hidden" name='id'  class='form-control'  value="<?php echo $id;?>">
             <input type="hidden" name='id_satuan'  class='form-control' readonly value="<?php echo $data['id_satuan'];?>">
             <input type="hidden" name='id_grn_ln_temp'  class='form-control' readonly value="<?php echo $data['id_grn_ln_temp'];?>">
              <div class="form-horizontal">
              <div class="row">
              <div class="col-md-6">                    
                     <div class="form-group row">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-7">
							               <input name='nama_brand' class='form-control' readonly value="<?php echo $data['nama_brand']; ?>">
                              
                            </div>
                    </div>
						<div class="form-group row">
                            <label  class="col-sm-2">No Batch</label>
                             <div class="col-sm-3">                     
                                <input id="no_batch" name='no_batch' value="<?php echo $data['no_batch']; ?>"  class='form-control' readonly>
                                
                            </div>                            
                          </div>
             

                        <div class="form-group row">
                            <label  class="col-sm-2">Jumlah</label>
  						          <div class="col-sm-3">                     
                                <input id="jumlah_po" name='qty'  value="<?php echo $data['qty']; ?>" required class='form-control' onchange="count_on_jumlah_po()">
                                
                            </div>
                            
                            <div class="col-sm-4">                     
                                 <input name='nama_satuan'  class='form-control' readonly value="<?php echo $data['nama_satuan'];?>">
                                
                            </div>
                          </div>
                          
						 
						  
                          
              
               
                        
                  </div>
				  
				  <div class="col-md-6">
				  <div class="form-group row">
                            <label  class="col-sm-2">Tgl. Manufactured </label>
                             <div class="col-sm-6">                     
                                <input type="text" name='manufacdate'  class='form-control' id="datepicker4" value="<?php echo $data['manufacdate'] ?>" >
                                
                            </div>                            
                          </div>
					<div class="form-group row">
                            <label  class="col-sm-2">Tgl. Expired</label>
                             <div class="col-sm-6">                     
                                <input type="text"  name='expired_date'   class='form-control' id="datepicker5" value="<?php  echo $data['expired_date'] ?>" >
                                
                            </div>                            
                          </div>	  

                  </div>
				  
                  </div>
                </div>
                </form>

             

             

           



               
                
          
   
          
              