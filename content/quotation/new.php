<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="inventori-quotation">Permintaan Penawaran</a></li>
  <li class="breadcrumb-item active">Tambah Permintaan Penawaran</li>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card">

              <?php include_once "head.php"; ?>



                        <div class="col-md-12 mb-4">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Item Penawaran Harga</a>
                                </li>
                        
                        
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                  <div id="quotation">
                                  </div>
                                </div>
                
                            </div>
                        </div>



           <div class="card-block">
            <div class=" form-horizontal">  
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
              

        </div>

          <div class="box-footer text-right">
               
          </div>
  </div>
  </div>
  </div>
  </div>

   <script src="assets/js/action/quo.js"></script>
