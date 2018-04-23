
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
       Penawaran Harga
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Penawaran Harga</li>
      </ol>
    </section>
    <section class="content">
      <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-body"> 
		            <?php include"head.php"; ?>
		        </div>
        </div>
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab"> Item Penawaran Harga </a></li>           
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">  
              <div class="box-footer text-left">
                <div id="quotation">
		            </div>
              </div>
              </div>             
            </div>          
            </div>

           <div class="box-body">
            <div class="box-body form-horizontal">  
              <div class="col-md-8">
                <div class="form-group" >
                  <label for="jm" class="col-sm-2">Tanggal</label>
                   <div class="col-sm-6">
                      <input type="text" name="tanggal_lahir" value="<?php echo date('d-m-y') ?>" class="form-control" readonly>
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
