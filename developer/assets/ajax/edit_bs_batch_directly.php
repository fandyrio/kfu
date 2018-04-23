<?php
  $id=$_GET['id'];
  $sql = pg_query($dbconn,"Select stok_buka_batch_temp.*, inv_satuan.nama as \"nama_satuan\"
                      
                      from stok_buka_batch_temp
                       INNER JOIN inv_satuan on inv_satuan.id=stok_buka_batch_temp.id_satuan WHERE stok_buka_batch_temp.id= $id");
  $data = pg_fetch_array($sql);
?>
<!--button class="btn-xs btn-danger" id="cancel_grn_batch_directly">Cancel</button-->
<button class="btn-xs btn-success" id="save_bs_batch_directly_edit">Simpan</button>
            <form method="POST" enctype="multipart/form-data" id="bs_batch_directly_temp_edit">
              <input type="hidden" name='id'  class='form-control'  value="<?php echo $data['id'];?>">
             <input type="hidden" name='id_satuan'  class='form-control'  value="<?php echo $data['id_satuan'];?>">
             <input type="hidden" name='id_stok_buka_qty_temp'  class='form-control'  value="<?php echo $data['id_stok_buka_qty_temp'];?>">
              <div class="box-body form-horizontal">
              
              <div class="col-md-6">

                    <div class="row">
                     <div class="form-group">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-7">
							 <input name='nama_brand' class='form-control' readonly value="<?php echo $_SESSION['nama_brand_bs']; ?>">
                              
                            </div>
                          </div>
						<div class="form-group">
                            <label  class="col-sm-2">No Batch</label>
                             <div class="col-sm-3">                     
                                <input type="text" value="<?php echo $data['no_batch']; ?>" id="no_batch" name='no_batch'   class='form-control' readonly>
                                
                            </div>                            
                          </div>
             

                        <div class="form-group">
                            <label  class="col-sm-2">Jumlah</label>
  						          <div class="col-sm-3">                     
                                <input id="jumlah_po" name='qty'  value="<?php echo $data['qty']; ?>" class='form-control' onchange="count_on_jumlah_po()">
                                
                            </div>
                            
                            <div class="col-sm-4">                     
                                 <input name='nama_satuan'  class='form-control' readonly value="<?php echo $data['nama_satuan'];?>">
                                
                            </div>
                          </div>
                          
						 
						  
                          
              
               
                        </div>
                  </div>
				  
				  <div class="col-md-6">
				  <div class="form-group">
                            <label  class="col-sm-2">Tgl. Manufactured </label>
                             <div class="col-sm-6">                     
                                <input type="text" name='manufacdate'  class='form-control' id="datepicker4" value="<?php echo date('Y-m-d') ?>" required>
                                
                            </div>                            
                          </div>
					<div class="form-group">
                            <label  class="col-sm-2">Tgl. Expired</label>
                             <div class="col-sm-6">                     
                                <input type="text"  name='expired_date'   class='form-control' id="datepicker5" value="<?php echo date('Y-m-d', strtotime('+1 years')); ?>" required>
                                
                            </div>                            
                          </div>	  

                  </div>
				  
                  </div>

             

             

           



               
                
          
   
          
              