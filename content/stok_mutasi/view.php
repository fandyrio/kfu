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
                  <label class="col-sm-2 form-control-label">No. Mutasi </label>

                  <div class="col-sm-6">
                      <input type="text" value="<?php echo $data["doc_no"]?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
          
                </div>
                
                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">No. Reference</label>

                  <div class="col-sm-6">                     
                      <input name='refno' class='form-control' value="<?php echo $data["refno"]?>" readonly> 
                      
                  </div>
                  </div>

                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Attention</label>

                  <div class="col-sm-5">                     
                      <input name='attention'  value="<?php echo $data["attention_to"]?>" class='form-control' readonly> 
                      
                  </div>
                  </div> 

                </div>

                <div class="col-sm-5">       
                  
                    <div class="form-group row" >
                      <label for="jm" class="col-sm-2 form-control-label">Tgl</label>

                      <div class="col-sm-6">
                          <input type="text" name="tgl" value="<?php echo $data["proses_date"] ?>" id="datepicker3" class="form-control" readonly>
                      </div>
                    </div>
                      
                      <div class="form-group row">
                      <label class="col-sm-2 form-control-label">Status</label>

                      <div class="col-sm-6">
                     
                          <select name='status' class='form-control' readonly>
                          
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
                      <label  class="col-sm-2 form-control-label">Unit</label>

                       <div class="col-sm-4" >  
                     

                     
                      <?php 
                          $result =pg_query($dbconn, "SELECT * FROM master_unit where id='".$data["dari_unit"]."'");
                          $row =pg_fetch_array($result)
                      ?>
                         
                          
                           <input type="hidden" name="unit" value="<?php echo $row['id']  ?>" class="form-control" >

                           <input type="text" value="<?php echo $row['nama']  ?>" class="form-control" readonly>                
                                               
                      </div>
                       <label  class="form-control-label" style="padding-right: 5px">ke</label>

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
                      <label  class="col-sm-2 form-control-label">Departemen</label>

                      <div class="col-sm-4" >                     
                         <?php 
                          $result =pg_query($dbconn, "SELECT * FROM inv_departemen where id='".$data["dari_departemen"]."'");
                           $row =pg_fetch_array($result)

                         
                          ?>

                          
                           <input type="text" value="<?php echo $row['nama']  ?>" class="form-control" readonly>

                          
                      </div>
                       <label  class="form-control-label" style="padding-right: 5px">ke</label>

                      <div class="col-sm-4" style="padding-left: 0px">                      

                          <?php 
                          $result =pg_query($dbconn, "SELECT * FROM inv_departemen where id='".$data["ke_departemen"]."'");
                           $row =pg_fetch_array($result)
                         
                          ?>

                           

                           <input type="text" value="<?php echo $row['nama']  ?>" class="form-control" readonly>
                          
                      </div>
                      </div>          
                    
                    <div class="form-group row" >
                      <label  class="col-sm-2 form-control-label">Terms</label>

                      <div class="col-sm-4" >                     
                          <input name='terms' value="<?php echo $data['terms']  ?>" class='form-control' readonly> 
                          
                      </div>
                  
                      </div> 
                   </div> 
                   </div>                
        
             
               </form>
              
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
                                             
                  <table id="trf_batch_ln"  class=" table ">
                      <thead class="table-secondary">
                      <tr>
                      <th width="10px">No</th>
                        <th width="">Nama Brand</th>
                        <th width="">QTY</th>
                        <th width="">Satuan</th>
                        <th width="">Jumlah</th>  
                        <th>With Batch</th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $totalgross = 0;

                         $res=pg_query($dbconn,"Select stok_trf_ln.*, inv_satuan.nama  as  \"nama_satuan\" from stok_trf_ln
                            INNER JOIN inv_satuan on inv_satuan.id=stok_trf_ln.id_satuan WHERE id_hdr = '".$_SESSION["id_trf_hdr"]."'");

                  

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
                        //$jum +=;
                        //$totalgross += $row["gross_total"];
                           ?>
                              <tr id="<?php echo $row['id']; ?>" data="<?php echo $row['id_satuan']."_".$row['nama_satuan']; ?>" nama="<?php echo $row['nama_brand']; ?>" style="td {color: blue; background: white !important; }">
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                              <td style="vertical-align:middle;">
                                 <?php
                                  if($row['with_batch'] ==1)
                                      echo "<input type='checkbox' checked disabled>";
                                    
                                  else
                                          echo "<input type='checkbox' disabled>";
                                    ?>

                              </td>

                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
            
                    </table>   
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
                  <label class="col-sm-2 form-control-label">Catatan</label>

                  <div class="col-sm-6">
                      <input type="textarea" value="<?php echo $data['catatan']  ?>" name="catatan" class="form-control" readonly>
                  </div>
                </div>

                <div class="form-group row" >
                  <label class="col-sm-2 form-control-label">Tanggal</label>

                  <div class="col-sm-6">
                      <input type="text" name="tanggal_lahir" value="<?php echo $data['proses_date'] ?>" class="form-control" readonly>
                  </div>
                </div>


                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Responsible</label>

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



          <script src="assets/js/action/stok_transfer.js"></script>




