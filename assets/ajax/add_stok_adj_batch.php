                           <div class="col-md-12 mb-4 angel">
                            <ul class="nav nav-tabs" role="tablist">
                               <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#home" role="tab" aria-controls="home"> Tambah Detail</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#bar" role="tab" aria-controls="bar">Tambah Batch</a>
                                </li>
                        
                            </ul>

                            <div class="tab-content">
                               <div class="tab-pane" id="home" role="tabpanel">
                                  <div id="adj_details">
                                  </div>
                                </div>
                                <div class="tab-pane active" id="bar" role="tabpanel">
                                  <div id="adj_batch">
            <button class="btn-xs btn-success" id="simpan_adj_batch">Simpan</button>
            <form method="POST" enctype="multipart/form-data" id="adj_batch_temp">
             <input type="hidden" name='id_satuan'  class='form-control' readonly value="<?php echo $_SESSION['id_satuan'];?>">
             <input type="hidden" name='id_adj_ln'  class='form-control' readonly value="<?php echo $_SESSION['id_adj_ln'];?>">
              <div class="form-horizontal">
               <div class="row">
              <div class="col-md-6">

                   
                     <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Nama brand</label>

                            <div class="col-sm-7">
               <input name='nama_brand' class='form-control' readonly value="<?php echo $_SESSION['nama_brand']; ?>">
                              
                            </div>
                          </div>
            <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">No Batch <span class="ingatan">*</span></label>
                             <div class="col-sm-3">                     
                                <input id="no_batch" name='no_batch'   class='form-control'>
                                
                            </div>                            
                          </div>
             
                        <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Jumlah</label>
                        <div class="col-sm-3">                     
                                <input id="jumlah_po" name='qty' value="<?php echo $_SESSION['jumlah']; ?>"  required class='form-control' onchange="count_on_jumlah_po()">
                                
                            </div>
                            
                            <div class="col-sm-4">                     
                                 <input name='nama_satuan'  class='form-control' readonly value="<?php echo $_SESSION['nama_satuan'];?>">
                                
                            </div>
                          </div>

                          <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Remark</label>
                            <div class="col-sm-7">                     
                                <input name="catatan" required class='form-control' >
                                
                            </div>                         
                           
                          
               
                        </div>
                        </div>     
                  
          
          <div class="col-md-6">
          <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Tgl. Manufactured </label>
                             <div class="col-sm-6">                     
                                <input type="text" name='manufacdate'  class='form-control' id="datepicker4" value="<?php echo date('Y-m-d') ?>" required>
                                
                            </div>                            
                          </div>
          <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Tgl. Expired</label>
                             <div class="col-sm-6">                     
                                <input type="text"  name='expired_date'   class='form-control' id="datepicker5" value="<?php echo date('Y-m-d') ?>" required>
                                
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

             

           



               
                
          
   
          
              