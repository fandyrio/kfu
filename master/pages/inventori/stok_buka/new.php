
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Buka Stok
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
              <div id="buka_stok">
              </div>
			  
              </div>
			  
				</div>
				<div class="tab-pane" id="tab_2">  
                <div class="box-footer text-left">

              <!--?php include "view.php" ?-->
               <!--button id="rq" class="btn-xs btn-primary">load</button-->
               
                <!--button type="submit" class="btn-xs btn-primary">Tambah</button-->
              <div id="buka_stok_batch">
	
              </div>
			  
              </div>
			  
				</div>
              <!-- /.tab-pane -->
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
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
