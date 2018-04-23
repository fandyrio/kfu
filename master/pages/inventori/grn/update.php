<?php

 $id=$_GET['id'];
 $_SESSION['id_grn_hdr']=$id;
  $sql = pg_query($dbconn,"Select grn_hdr.* from grn_hdr WHERE grn_hdr.id= $id");
  $data = pg_fetch_array($sql);
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Terima Barang
      </h1>
   
    </section>

    <!-- Main content -->
    <section class="content">

        
<!--form method="POST" enctype="multipart/form-data" action="media.php?inventori=inven&modul=simpan&act=baru"-->
    

        <div class="col-xs-12">
          <div class="box box-primary">
 

            <!-- /.box-header -->
            <div class="box-body">
     
                  <div id="loading" style="
        visibility:hidden;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 ) 
              url('images/life.gif') 
              50% 50% 
              no-repeat;
}"></div>
          <!-- Horizontal Form -->
        <div class="box-header">
                        
                          <div class="col-md-12 text-right">
                                 <button class="btn-xs btn-danger" id="cancel_grn_hdr_update">Cancel</button>
                                 <button class="btn-xs btn-success" id="simpan_grn_hdr_update">Simpan</button>
                          </div>
              </div>

            <!-- /.box-header -->
            <!-- form start -->
           <form method="POST" enctype="multipart/form-data" id="grn_hdr_update">
             <input type="hidden" value="<?php echo $data['id'];?>" autocomplete="off" class="form-control"  name="id">
       
              <div class="box-body form-horizontal" >
              <div class="col-md-6">

                <div class="form-group">
                  <label class="col-sm-2">No Dok </label>

                  <div class="col-sm-4">
                      <input type="text" value="<?php echo $data['doc_no'];?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
          <label class="col-sm-2">Tgl. Dok </label>
          <div class="col-sm-4">
                      <input type="text" name="doc_date" value="<?php echo $data['doc_date']; ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>
        <div class="form-group">
                  <label  class="col-sm-2">Unit</label>

                  <div class="col-sm-10">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM master_unit");
                     
                      ?>
                      <select name='id_unit' class='form-control' disabled>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        if($data['id_unit']== $row['id']){
                        echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
                      }
                       else {
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      }
                      ?>
                      </select>
                  </div>
                </div>
        <div class="form-group">
                  <label  class="col-sm-2">Departemen</label>

                  <div class="col-sm-10">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                     
                      ?>
                      <select name='id_departemen' class='form-control' disabled>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                         if($data['id_departemen']== $row['id'])
                        echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
                      else echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>
         <div class="form-group">
                  <label  class="col-sm-2">Supplier</label>

                  <div class="col-sm-10">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier");
                     
                      ?>
                      <select name='id_supplier' class='form-control' required id="supplier_po">
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>
                

                <div class="form-group">
                  <label  class="col-sm-2">Credit Term</label>

                  <div class="col-sm-5">                     
                      <input name='credit_term' class='form-control' value="<?php echo $data['credit_term']; ?>"> hari
                      
                  </div>
                  </div>                  
          
          

             
              </div>



                <div class="col-sm-6">              
                
              <div class="form-group" >
                  <label for="jm" class="col-sm-3">No. Invoice</label>

                  <div class="col-sm-8">
                      <input type="text" name="no_invoice"  class="form-control"  value="<?php echo $data['no_invoice']; ?>">
                  </div>
                </div>
                <div class="form-group" >
                  <label for="jm" class="col-sm-3">Tgl. Invoice</label>

                  <div class="col-sm-8">
                      <input type="text" name="tgl_invoice" value="<?php echo $data['tgl_invoice'];?>" id="datepicker3" class="form-control" required>
                  </div>
                </div>
                  
                  <div class="form-group">
                  <label  class="col-sm-3">No GL</label>

                  <div class="col-sm-8">                     
                      <input name='gl_no' class='form-control' value="<?php echo $data['gl_no']; ?>">
                      
                  </div>
                  </div>
                </div>
                
                </div>
                

              <!-- /.box-body -->
              
         

          
        
          
        
              
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
              <div id="terima_barang_update">
              </div>
        
              </div>
        
        </div>
        <div class="tab-pane" id="tab_2">  
                <div class="box-footer text-left">

              <!--?php include "view.php" ?-->
               <!--button id="rq" class="btn-xs btn-primary">load</button-->
               
                <!--button type="submit" class="btn-xs btn-primary">Tambah</button-->
              <div id="batch_grn_update">
      
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
