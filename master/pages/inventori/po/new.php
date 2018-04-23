
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Purchase Order
      </h1>
   
    </section>

    <!-- Main content -->
    <section class="content">

        
<!--form method="POST" enctype="multipart/form-data" action="media.php?inventori=inven&modul=simpan&act=baru"-->
    

        <div class="col-xs-12">
          <div class="box box-primary">
 

 
           
            <!-- /.box-header -->
            <div class="box-body">
     
              <?php include "head.php"; ?>
              
            </div>
            <!-- /.box-body -->
          <!-- /.box -->

        </div>
        <!-- /.col -->
         

          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Detail</a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">  
                <div class="box-footer text-left">
              <div id="purchase_order">
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
  
      <!-- /.row -->
       <div class="box-footer text-right">
               
          </div>


      
      <!--/form-->


      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
