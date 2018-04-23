<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="">Pengembalian Barang</a></li>
  <li class="breadcrumb-item active">Tambah Pengembalian Barang</li>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card">
     
              <?php include "head.php"; ?>
              
   
             <!-- Custom Tabs -->
              <div class="ghost_batch"></div>
              <div class="col-md-12 mb-4 angel">
                  <ul class="nav nav-tabs" role="tablist">
                         <li class="nav-item">
                           <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Detail </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" data-toggle="tab" href="#bar" role="tab" aria-controls="bar">Batch</a>
                          </li>
                       
                        
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                  <div id="retur_barang">
                                  </div>
                                </div>
                                <div class="tab-pane" id="bar" role="tabpanel">
                                   <div id="batch_retur">
      
                                     </div>
                                </div>
                
                            </div>
                           
                        </div>
         

      		  <div class="box-body">
                  <div class="box-body form-horizontal">  
                    <div class="col-md-8">
                      <div class="form-group row" >
                        <label for="jm" class="col-sm-2">Tanggal</label>
                         <div class="col-sm-6">
                            <input type="text" name="tanggal_lahir" value="<?php echo date('d-m-y') ?>" class="form-control" readonly>
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
          <!-- nav-tabs-custom -->

        <!-- /.col -->
		
        
        </div>
  
      <!-- /.row -->
       <div class="box-footer text-right">
               
          </div>

      </div>
    </div>
  </div>
</div>
<script src="assets/js/action/retur.js"></script>

<script type="text/javascript">
           $(document).ready(function(){
      $(".dates").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
      
       
    });
        </script>
