<?php
  $_SESSION['id_adj_hdr']="";
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="inventori-stok-adjustment">Stok Adjustment</a></li>
  <li class="breadcrumb-item active">Tambah Stok Adjustmen</li>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card">
     
                  <div class="card-header">
            <i class="icon-user"></i> Stok Adjustment
          </div>


              <?php
               $id=$_GET['id'];
               $_SESSION["id_adj_hdr"]=$id;
               $res =pg_query($dbconn, "SELECT * FROM stok_adj_hdr where id='$id'");
               $data =pg_fetch_array($res);

             ?>   
            
            <form id="adjustment_hdr">
              
              <div class="form-horizontal" >
                <div class="card-block">
                <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-2 form-control-label">No Dokumen</label>
                  <div class="col-sm-8">
                      <?php echo ": ".$data["doc_no"]?>
                  </div>
                  </div>
                 <div class="form-group row">
                  <label class="col-sm-2 form-control-label">Unit  </label>

                  <div class="col-sm-8">
                        <?php 
                          $result =pg_query($dbconn, "SELECT * FROM master_unit where id='".$data["id_unit"]."'");
                          $row =pg_fetch_array($result)
                      ?>
                           <?php echo ": ".$row['nama']  ?>
                  </div>

                </div>


                 <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Departemen</label>

                  <div class="col-sm-8">
                      <?php 
                          $result =pg_query($dbconn, "SELECT * FROM inv_departemen where id='".$data["id_departemen"]."'");
                           $row =pg_fetch_array($result)                       
                          ?>
                           <?php echo ": ".$row['nama']  ?>
                  </div>
                </div>
                </div>

                <div class="col-md-6">
                           <div class="form-group row">
                          <label class="col-sm-3 form-control-label">Tanggal Dokumen  </label>

                          <div class="col-sm-8">
                             <?php echo ": ".$data['doc_date'] ?>
                          </div>

                         </div>

                </div>
                </div>
                </div> 
              </div>
                </form> 
                    

                      <div class ="adj_details_batch"></div>
                      <div class ="adj_tambah_batch"></div>

                      
                          
                           <div class="col-md-12 mb-4 angel">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Item Adjustmen</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#bar" role="tab" aria-controls="bar">Batch</a>
                                </li>
                        
                        
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                <div class="box-footer text-left">
                
              </div>
               <table id="stok_adj" class="table table-bordered table-striped">
                <thead class="table-secondary">
                <tr>
                  <th>No</th>
                   <th >Nama Brand </th>
                   <th >Qty</th>
                   <th >Satuan</th>
                   <th>amount</th>
                   
                </tr>
                </thead>
                <tbody>
             <?php

        
                  $res=pg_query($dbconn,"Select stok_adj_ln.*, inv_satuan.nama  as  \"nama_satuan\" from stok_adj_ln
                       INNER JOIN inv_satuan on inv_satuan.id=stok_adj_ln.id_satuan WHERE stok_adj_ln.id_hdr='".$_SESSION['id_adj_hdr']."'");

              
                  $no=1;
                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr id="<?php echo $row['id']; ?>" data="<?php echo $row['id_satuan']."_".$row['nama_satuan']; ?>" nama="<?php echo $row['nama_brand']; ?>" style="td {color: blue; background: white !important; }">
                       <td><?php echo $no++ ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["total_harga"] ?></td>

                        
                       </tr>
                    
                 
                 <?php } ?> 
                </tbody>
              
                </table>
                                </div>
                                <div class="tab-pane" id="bar" role="tabpanel">
                                   <div id="adj_batch">
      
                                </div>
                                </div>
                
                            </div>
                           
                        </div>


              <div class="box-body">

                <div class="card-block">
                <div class="box-body form-horizontal">

               
                  <div class="col-md-6">
                    <div class="form-group row" >
                      <label  class="col-sm-2 form-control-label">Catatan</label>

                      <div class="col-sm-6">
                          <input type="textarea" name="catatan" value="<?php echo $data['catatan'] ?>" class="form-control" >
                      </div>
                    </div>

                    <div class="form-group row" >
                      <label  class="col-sm-2 form-control-label">Tanggal</label>

                      <div class="col-sm-6">
                          <input type="text" name="tanggal_lahir" value="<?php echo $data['createddate'] ?>" class="form-control" readonly>
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
              
            </div>

      </div>
       <div class="box-footer text-right">
               
          </div>

    </section>
  </div>

      <script src="assets/js/action/stok_adj.js"></script>




  
