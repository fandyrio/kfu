<?php
  $_SESSION['id_adj_hdr']="";
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="inventori-stok-adjustment">Stok Adjustment</a></li>
  <li class="breadcrumb-item active">Tambah Stok Adjustmen</li>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card">
     
              <?php include "head.php"; ?>
                    

                      <div class ="adj_details_batch"></div>
                      <div class ="adj_tambah_batch"></div>

                      
                          
                           <div class="col-md-12 mb-4 angel">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Item Adjustmen</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#bar" role="tab" aria-controls="bar">Batch</a>
                                </li>
                        
                        
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                  <div id="adj_details">
                                  </div>
                                </div>
                                <div class="tab-pane" id="bar" role="tabpanel">
                                   <div id="adj_batch">
                                    aaaa
                                </div>
                                </div>
                
                            </div>
                           
                        </div>


              <div class="box-body">

                <div class="card-block">
                <div class="box-body form-horizontal">

               
                  <div class="col-md-6">
                    <div class="form-group row" >
                      <label  class="col-sm-2 form-control-label">Catatan</label>

                      <div class="col-sm-6">
                          <input type="textarea" name="catatan" class="form-control" >
                      </div>
                    </div>

                    <div class="form-group row" >
                      <label  class="col-sm-2 form-control-label">Tanggal</label>

                      <div class="col-sm-6">
                          <input type="text" name="tanggal_lahir" value="<?php echo date('Y-m-d') ?>" class="form-control" readonly>
                      </div>
                    </div>


                    <div class="form-group row">
                      <label  class="col-sm-2 form-control-label">Responsible</label>

                      <div class="col-sm-6">                     
                          <input name='kode' class='form-control' readonly>
                          
                      </div>
                      </div>
                 </div>
                 </div>
                 </div>
              
            </div>

      </div>
       <div class="box-footer text-right">
               
          </div>

    </section>
  </div>

      <script src="assets/js/action/stok_adj.js"></script>




  
