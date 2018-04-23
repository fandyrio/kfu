 <div class="content-wrapper">
    <section class="content-header">
      <h1>
       Stok Adjustment
      </h1>
    
    </section>
   <section class="content">
        <div class="col-xs-12">
                 <div class="box box-primary">
                    <div class="box-body"> 
                      <?php include "head.php"; ?>          
                    </div>
                    </div>

                      <div class ="adj_details_batch"></div>
                      <div class ="adj_tambah_batch"></div>

                      <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#tab_1" data-toggle="tab">Detail</a></li>
                              <li><a href="#tab_2" data-toggle="tab">Batch</a></li>
                        </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_1">  
                                <div class="box-footer text-left">
                                <div id="adj_details">
                                </div>
                              </div>
                        
                                </div>

                                <div class="tab-pane" id="tab_2">  
                                  <div class="box-footer text-left">

                                    <div id="adj_batch">

                                    </div>

                                  </div>
                        
                                </div>
                            </div>
                          </div>


              <div class="box-body">

          
                <div class="box-body form-horizontal">

               
                  <div class="col-md-8">
                    <div class="form-group" >
                      <label for="jm" class="col-sm-2">Catatan</label>

                      <div class="col-sm-6">
                          <input type="textarea" name="catatan" class="form-control" >
                      </div>
                    </div>

                    <div class="form-group" >
                      <label for="jm" class="col-sm-2">Tanggal</label>

                      <div class="col-sm-6">
                          <input type="text" name="tanggal_lahir" value="<?php echo date('Y-m-d') ?>" class="form-control" readonly>
                      </div>
                    </div>


                    <div class="form-group">
                      <label  class="col-sm-2">Responsible</label>

                      <div class="col-sm-6">                     
                          <input name='kode' class='form-control' readonly>
                          
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
