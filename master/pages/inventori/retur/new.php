
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Retur Barang
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
         

         <div class="ghost_batch"></div>
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Detail</a></li>
			  <li><a href="#tab_2" data-toggle="tab">Batch</a></li>
              <!--li><a href="#tab_3" data-toggle="tab">Costing</a></li-->
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">  
                <div class="box-footer text-left">

              <!--?php include "view.php" ?-->
               <!--button id="rq" class="btn-xs btn-primary">load</button-->
               
                <!--button type="submit" class="btn-xs btn-primary">Tambah</button-->
              <div id="retur_barang">
              </div>
			  
              </div>
			  
				</div>
				<div class="tab-pane" id="tab_2">  
                <div class="box-footer text-left">

              <!--?php include "view.php" ?-->
               <!--button id="rq" class="btn-xs btn-primary">load</button-->
               
                <!--button type="submit" class="btn-xs btn-primary">Tambah</button-->
              <div id="batch_retur">
			  aa
              </div>
			  
              </div>
			  
				</div>
              <!-- /.tab-pane -->
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
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
          <!-- nav-tabs-custom -->

        <!-- /.col -->
		
        
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
