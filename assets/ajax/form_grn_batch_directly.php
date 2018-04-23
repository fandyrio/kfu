
<!--button class="btn-xs btn-danger" id="cancel_grn_batch_directly">Cancel</button-->
<button class="btn-xs btn-success" id="simpan_grn_batch_directly_update">Simpan</button>
            <form method="POST" enctype="multipart/form-data" id="grn_batch_directly_update">
             <input type="hidden" name='id_satuan'  class='form-control' readonly value="<?php echo $_SESSION['id_satuan'];?>">
             <input type="hidden" name='id_grn_ln'  class='form-control' readonly value="<?php echo $_SESSION['id_grn_ln'];?>">
              <div class=" form-horizontal">
               <div class="row">
              <div class="col-md-6">

                   
                     <div class="form-group">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-7">
							 <input name='nama_brand' class='form-control' readonly value="<?php echo $_SESSION['nama_brand']; ?>">
                              
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
                                <input id="jumlah_po" name='qty'  required class='form-control' onchange="count_on_jumlah_po()">
                                
                            </div>
                            
                            <div class="col-sm-4">                     
                                 <input name='nama_satuan'  class='form-control' readonly value="<?php echo $_SESSION['nama_satuan'];?>">
                                
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
                                <input type="text"  name='expired_date'   class='form-control' id="datepicker5" value="<?php echo date('Y-m-d') ?>" required>
                                
                            </div>                            
                          </div>	  

                  </div>
				  
                  </div>
                </div>

             

             

           



               
                
          
   
          
              