  

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="inventori-stok-mutasi">Mutasi Stok</a></li>
  <li class="breadcrumb-item active">Mutasi Stok</li>
</ol>

<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card">
     
          <div class="card-header">
            <i class="icon-user"></i> Edit Stok Mutasi
          </div>
         <div class="box-header">

        <div class="pull-right">
                        <button class="btn btn-xs btn-danger" id="cancel_trf_hdr">Cancel</button>
                       <button class=" btn btn-xs btn-success" id="simpan_edit_trf_hdr">Simpan</button>
                                
                          </div>
              </div>


            <?php
               $id=$_GET['id'];
               $_SESSION["id_trf_hdr"]=$id;
               $res =pg_query($dbconn, "SELECT * FROM stok_trf_hdr where id='$id'");
               $data =pg_fetch_array($res);

             ?>   
            
           <form method="POST" class="form-horizontal" enctype="multipart/form-data" id="trf_hdr">
            <input type="hidden" name="id_trf_hdr" value="<?php echo $_SESSION["id_trf_hdr"] ?>">
              <div class="card-block">
              <div class="row">
              <div class="col-md-7" >

                <div class="form-group row">
                  <label class="col-sm-2">No. Mutasi </label>

                  <div class="col-sm-6">
                      <input type="text" value="<?php echo $data["doc_no"]?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
          
                </div>
                
                <div class="form-group row">
                  <label  class="col-sm-2">No. Reference</label>

                  <div class="col-sm-6">                     
                      <input name='refno' class='form-control' value="<?php echo $data["refno"]?>" required> 
                      
                  </div>
                  </div>

                <div class="form-group row">
                  <label  class="col-sm-2">Attention</label>

                  <div class="col-sm-5">                     
                      <input name='attention'  value="<?php echo $data["attention_to"]?>" class='form-control' required> 
                      
                  </div>
                  </div> 

                </div>

                <div class="col-sm-5">       
                  
                    <div class="form-group row" >
                      <label for="jm" class="col-sm-2">Tgl</label>

                      <div class="col-sm-6">
                          <input type="text" name="tgl" value="<?php echo $data["proses_date"] ?>" id="datepicker3" class="form-control" required>
                      </div>
                    </div>
                      
                      <div class="form-group row">
                      <label class="col-sm-2">Status</label>

                      <div class="col-sm-6">
                     
                          <select name='status' class='form-control' required>
                          
                          <option value='A'>Aktif</option>
                          <option value='H'>Hapus</option>
                          
                          </select>
                                </div>
                      </div>
                  </div>
                  </div>

                  <div class="row">
                  <div class="col-md-7" >
                      <div class="form-group row" >
                      <label  class="col-sm-2">Unit</label>

                       <div class="col-sm-4" >  
                                        
                      <?php 
                          $result =pg_query($dbconn, "SELECT * FROM master_unit where id='".$data["dari_unit"]."'");
                          $row =pg_fetch_array($result)
                      ?>
                         
                          
                           <input type="hidden" name="unit" value="<?php echo $row['id']  ?>" class="form-control" >

                           <input type="text" value="<?php echo $row['nama']  ?>" class="form-control" readonly>                
                                               
                      </div>
                       <label  class="" style="padding-right: 5px">ke</label>

                      <div class="col-sm-4" style="padding-left: 0px">                      
                 

                     
                      <?php 
                          $result =pg_query($dbconn, "SELECT * FROM master_unit where id='".$data["ke_unit"]."'");
                          $row =pg_fetch_array($result)
                      ?>
                         
                          
                           <input type="hidden" name="id_unit_to" value="<?php echo $row['id']  ?>" class="form-control" >

                           <input type="text" value="<?php echo $row['nama']  ?>" class="form-control" readonly>
                    
                          
                      </div>
                      </div> 

                    <div class="form-group row">
                      <label  class="col-sm-2">Departemen</label>

                      <div class="col-sm-4" >                     
                         <?php 
                          $result =pg_query($dbconn, "SELECT * FROM inv_departemen where id='".$data["dari_departemen"]."'");
                           $row =pg_fetch_array($result)

                         
                          ?>

                           <input type="hidden" name="id_departemen" value="<?php echo $row['id']  ?>" class="form-control" >

                           <input type="text" value="<?php echo $row['nama']  ?>" class="form-control" readonly>

                          
                      </div>
                       <label  class="" style="padding-right: 5px">ke</label>

                      <div class="col-sm-4" style="padding-left: 0px">                      

                          <?php 
                          $result =pg_query($dbconn, "SELECT * FROM inv_departemen where id='".$data["ke_departemen"]."'");
                           $row =pg_fetch_array($result)
                         
                          ?>

                           <input type="hidden" name="id_departemen_to" value="<?php echo $row['id']  ?>" class="form-control" >

                           <input type="text" value="<?php echo $row['nama']  ?>" class="form-control" readonly>
                          
                      </div>
                      </div>          
                    
                    <div class="form-group row" >
                      <label  class="col-sm-2">Terms</label>

                      <div class="col-sm-4" >                     
                          <input name='terms' value="<?php echo $data['terms']  ?>" class='form-control' required> 
                          
                      </div>
                  
                      </div> 
                   </div> 
                   </div>                
        
             
               </form>
                  </div>

              <!-- /.box-body -->
              
               <div class="trf_batch"></div>
              <div class="col-md-12 mb-4 angel">
                  <ul class="nav nav-tabs" role="tablist">
                         <li class="nav-item">
                           <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Details</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" data-toggle="tab" href="#bar" role="tab" aria-controls="bar">Batch</a>
                          </li>
                       
                        
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                  <div id="stok_mutasi_ln">
                                  </div>
                                </div>
                                <div class="tab-pane" id="bar" role="tabpanel">
                                   <div id="stok_mutasi_batch">
    
                                    </div>
                                </div>
                
                            </div>
                           
                        </div>


      


      
            <div class=" form-horizontal">

           
              <div class="col-md-8">
                <div class="form-group row" >
                  <label for="jm" class="col-sm-2">Catatan</label>

                  <div class="col-sm-6">
                      <input type="textarea" value="<?php echo $data['catatan']  ?>" name="catatan" class="form-control" >
                  </div>
                </div>

                <div class="form-group row" >
                  <label for="jm" class="col-sm-2">Tanggal</label>

                  <div class="col-sm-6">
                      <input type="text" name="tanggal_lahir" value="<?php echo $data['proses_date'] ?>" class="form-control" readonly>
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
  
      <!-- /.row -->
             <div class="box-footer text-right">
                     
            </div>

            </div>
          </div>
        </div>
      </div>



          <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
              
              <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">

                   <div class="modal-body" style="text-align:left">

                    </div>
                    <div class="modal-footer">                    
                    <button type="button" class="btn btn-sm btn-warning" id="save_batch_trf" >oke</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">BATAL</button>
                    </div>
                  </div>
              </div>
          </div>


          <script src="assets/js/action/stok_transfer.js"></script>




