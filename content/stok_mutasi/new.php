<?php
  $_SESSION["id_trf_hdr"]="";
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="inventori-stok-mutasi">Mutasi Stok</a></li>
  <li class="breadcrumb-item active">Mutasi Stok</li>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card">
     
              <?php include_once "head.php"; ?>
              
               <div class="trf_batch"></div>
              <div class="col-md-12 mb-4 angel">
                  <ul class="nav nav-tabs" role="tablist">
                         <li class="nav-item">
                           <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Details</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" data-toggle="tab" href="#bar" role="tab" aria-controls="bar">Batch</a>
                          </li>
                       
                        
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                  <div id="stok_mutasi_ln">
                                  </div>
                                </div>
                                <div class="tab-pane" id="bar" role="tabpanel">
                                   <div id="stok_mutasi_batch">
    
                                    </div>
                                </div>
                
                            </div>
                           
                        </div>


		  


      
            <div class=" form-horizontal">

            <div class="card-block">
              <div class="col-md-8">
                <div class="form-group row" >
                  <label for="jm" class="col-sm-2 form-control-label">Catatan</label>

                  <div class="col-sm-6">
                      <input type="textarea" name="catatan" class="form-control" >
                  </div>
                </div>

                <div class="form-group row" >
                  <label for="jm" class="col-sm-2 form-control-label">Tanggal</label>

                  <div class="col-sm-6">
                      <input type="text" name="tanggal_lahir" value="<?php echo date('Y-m-d') ?>" class="form-control" readonly>
                  </div>
                </div>


                <div class="form-group row">
                  <label  class="col-sm-2">Responsible</label>

                  <div class="col-sm-6">                     
                      <input name='kode' class='form-control' readonly>
                      
                  </div>
                  </div>
             </div>
             </div>
		
        
            </div>
            </div>
  
      <!-- /.row -->
             <div class="box-footer text-right">
                     
            </div>

            </div>
          </div>
        </div>
      </div>


          <!-- load -->
<!--           <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
              
              <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">

                   <div class="modal-body" style="text-align:left">

                    </div>
                    <div class="modal-footer">                    
                    <button type="button" class="btn btn-sm btn-warning" id="save_batch_trf" >oke</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">BATAL</button>
                    </div>
                  </div>
              </div>
          </div> -->


          <!-- edit -->
      <!--     <div class="modal fade" id="confirm-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              
              <div class="modal-dialog modal-lg" role="document" style="width: 700px">
                  <div class="modal-content">

                   <div class="modal-body" style="text-align:left">

                    </div>
                    <div class="modal-footer">                    
                    <button type="button" class="btn btn-sm btn-warning" id="save_edit_batch_trf">oke</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">BATAL</button>
                    </div>
                  </div>
              </div>
          </div> -->


          <script src="assets/js/action/stok_transfer.js"></script>




