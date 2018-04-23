<?php

 $id=$_GET['id'];
 $_SESSION['id_grn_hdr']=$id;
  $sql = pg_query($dbconn,"Select grn_hdr.* from grn_hdr WHERE grn_hdr.id= $id");
  $data = pg_fetch_array($sql);
?>
  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="">Terima Barang</a></li>
  <li class="breadcrumb-item active">Update Terima Barang</li>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card">
     
               <div class="card-header">
            <i class="icon-user"></i> Terima Barang
          </div>
          <!-- Horizontal Form -->
        <div class="box-header">
                        
                          <div class="col-md-12 text-right">
                                 <button class="btn btn-xs btn-danger" id="cancel_grn_hdr_update">Cancel</button>
                                 <button class="btn btn-xs btn-success" id="simpan_grn_hdr_update">Simpan</button>
                          </div>
              </div>

            <!-- /.box-header -->
            <!-- form start -->
             <form method="POST" enctype="multipart/form-data" id="grn_hdr_update">
             <input type="hidden" value="<?php echo $data['id'];?>" autocomplete="off" class="form-control"  name="id">
              <div class="card-block">
              <div class="row" >
              <div class="col-md-6">

                <div class="form-group row">
                  <label class="col-sm-2 form-control-label">No. Dokumen </label>

                  <div class="col-sm-4">
                      <input type="text" value="<?php echo $data['doc_no'];?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
          <label class="col-sm-2 form-control-label">Tgl. Dokumen </label>
          <div class="col-sm-4">
                      <input type="text" name="doc_date" value="<?php echo $data['doc_date']; ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>
        <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Unit <span id="class">*</span></label>

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
        <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Departemen <span id="class">*</span></label>

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
         <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Supplier</label>

                  <div class="col-sm-10">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier");
                     
                      ?>
                      <select name='id_supplier' class='form-control'  id="supplier_po" disabled>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                          if($data['id_supplier']== $row['id']){
                        echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
                      }else echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>
                

                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Credit Term</label>

                  <div class="col-sm-5">                     
                      <input name='credit_term' class='form-control' value="<?php echo $data['credit_term']; ?>"> hari
                      
                  </div>
                  </div>                  
          
          

             
              </div>
           
              




                <div class="col-sm-6">              
                
              <div class="form-group row" >
                  <label for="jm" class="col-sm-3 form-control-label">No. Invoice</label>

                  <div class="col-sm-8">
                      <input type="text" name="no_invoice"  class="form-control"  value="<?php echo $data['no_invoice']; ?>">
                  </div>
                </div>
                <div class="form-group row" >
                  <label for="jm" class="col-sm-3 form-control-label">Tgl. Invoice <span class="ingatan">*</span></label>

                  <div class="col-sm-8">
                      <input type="text" name="tgl_invoice" value="<?php echo $data['tgl_invoice'];?>" id="datepicker3" class="form-control" required>
                  </div>
                </div>
                  
                  <div class="form-group row">
                  <label  class="col-sm-3 form-control-label">No GL</label>

                  <div class="col-sm-8">                     
                      <input name='gl_no' class='form-control' value="<?php echo $data['gl_no']; ?>">
                      
                  </div>
                  </div>
                </div>
                
                </div>
              </div>
            </form>
            
         

          <!-- Custom Tabs -->
      <div class="ghost_batch"></div>
          <div class="col-md-12 mb-4 angel">
            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Update Detail</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#bar" role="tab" aria-controls="bar">Batch</a>
                                </li>
                        
                        
                            </ul>
            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                  <div id="terima_barang">
                                  </div>
                                </div>
                                <div class="tab-pane" id="bar" role="tabpanel">
                                   <div id="batch_grn">
      
                                </div>
                                </div>
                
            </div>
            <!-- /.tab-content -->
          </div>
      
          <!-- nav-tabs-custom -->

        <!-- /.col -->
    
        
       
  
      <!-- /.row -->
       <div class="box-footer text-right">
               
          </div>


   
     </div>
  </div>
</div>
</div>
</div>
<script src="assets/js/action/grn.js"></script>