<?php

 $id=$_GET['id'];
  $sql = pg_query($dbconn,"Select grn_hdr.* from grn_hdr WHERE grn_hdr.id= $id");
  $data = pg_fetch_array($sql);
?>
  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="inventori-grn">Terima Barang</a></li>
  <li class="breadcrumb-item active">Lihat Terima Barang</li>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <i class="icon-user"></i> Terima Barang
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
                    <?php echo ": ".$data['doc_no'];?>
                  </div>
          <label class="col-sm-2 form-control-label">Tgl. Dokumen </label>
          <div class="col-sm-4">
                     <?php echo ": ".tgl_indo($data['doc_date']) ?>
                  </div>
                </div>
        <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Unit</label>

                  <div class="col-sm-10">
                     <?php 
                      $u =pg_fetch_array(pg_query($dbconn, "SELECT * FROM master_unit 
                                    where id='$data[id_unit]' ")); 

                          echo ": ".$u['nama'];
                     
                      ?>
                      </select>
                  </div>
                </div>
        <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Departemen</label>

                  <div class="col-sm-10">
                     <?php 
                      $d =pg_fetch_array(pg_query($dbconn, "SELECT * FROM inv_departemen 
                                      where id='$data[id_departemen]'"));
                         echo ": ".$d['nama'];
                     
                      ?>
                     
                  </div>
                </div>
         <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Supplier</label>

                  <div class="col-sm-10">
                     <?php 
                      $i =pg_fetch_array(pg_query($dbconn, "SELECT * FROM inv_info_supplier
                                      where id='$data[id_supplier]'"));
                       echo ": ".$i['nama'];
                      ?>
                    
                  </div>
                </div>
                

                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Credit Term</label>

                  <div class="col-sm-5">                     
                      <?php echo ": ".$data['credit_term']; ?> hari
                      
                  </div>
                  </div>                    
              </div>
           <div class="col-sm-6">              
                
              <div class="form-group row" >
                  <label for="jm" class="col-sm-3 form-control-label">No. Invoice</label>

                  <div class="col-sm-8">
                      <?php echo ": ".$data['no_invoice']; ?>
                  </div>
                </div>
                <div class="form-group row" >
                  <label for="jm" class="col-sm-3 form-control-label">Tgl. Invoice</label>

                  <div class="col-sm-8">
                     <?php echo ": ".tgl_indo($data['tgl_invoice'])?>
                  </div>
                </div>
                  
                  <div class="form-group row">
                  <label  class="col-sm-3 form-control-label">No GL</label>

                  <div class="col-sm-8">                     
                     <?php echo ":".$data['gl_no']; ?>
                      
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
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Lihat Detail</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#bar" role="tab" aria-controls="bar">Lihat Batch</a>
                                </li>
                        
                        
                            </ul>
                    <div class="tab-content">
                    <div class="tab-pane active" id="home" role="tabpanel">
                                  <!-- -->
                  <table id="grn_ln_loader" class="table table-bordered table-striped">
                      <thead>
                      <tr >
                      <th width="10px" style="text-align: center;">No</th>
                        <th width="" style="text-align: center;">Nama Brand</th>
                        <th width="" style="text-align: center;">Qty</th>
                        <th width="" style="text-align: center;">Satuan</th>
                        <th width="" style="text-align: center;">Gross</th>
                        <th width="" style="text-align: center;">Diskon</th>
                        <th width="" style="text-align: center;">Pajak</th>
                        <th width="" style="text-align: center;">Nett</th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $totalgross = 0;
                       $nett_total = 0;
                 
                       $res=pg_query($dbconn,"Select grn_ln.*, inv_satuan.nama  as  \"nama_satuan\" from grn_ln
                       INNER JOIN inv_satuan on inv_satuan.id=grn_ln.id_satuan WHERE grn_ln.id_hdr='$id'");
                     

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
             //$jum +=;
                    $totalgross += $row["gross_total"];
                    $nett_total += $row["nett_total"];                           
                    ?>
                             <tr id="<?php echo $row['id']; ?>" data="<?php echo $row['id_satuan']."_".$row['nama_satuan']; ?>" nama="<?php echo $row['nama_brand']; ?>" style="td {color: blue; background: white !important; }">
                              <td style="text-align: left;"><?php echo $no ?></td>
                              <td style="text-align: left;"><?php echo $row["nama_brand"] ?></td>
                              <td style="text-align: right;"><?php echo $row["qty"] ?></td>
                              <td style="text-align: left;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="text-align: right;"><?php echo number_format($row["gross_total"] ,2,",",".");?></td>
                              <td style="text-align: right;">
                              <?php 
                              if($row["diskon_persen"] ){
                                echo $row["diskon_persen"];
                              }
                              else echo $row["diskon_amount"];
                                ?>
                              </td>
                                            <td style="text-align: right;">
                              <?php 
                              if($row["pajak_persen"] ){
                                echo $row["pajak_persen"];
                              }
                              else echo $row["pajak_amount"];
                                ?>
                              </td>
                            <td style="text-align: right;"><?php  echo  number_format($row["nett_total"],2,",",".");?></td>
               
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
            
                    </table>

                      <div class="row">
                      <div class="col-md-7"> </div>
                      <div class="col-md-5">                   
                
                        <div class="form-horizontal "> 

                            <div class="form-group row " >
                              <label for="jm" class="col-sm-3 form-control-label">Gross Total</label>
                               <div class="col-sm-5">
                                 <?php echo ": ".number_format($totalgross,"0","",".") ?>
                              </div>
                            </div>
   
                            </div>

                             <div class="form-group row" >
                              <label for="jm" class="col-sm-3 form-control-label">Net Cost</label>
                                <div class="col-sm-5">
                                    <?php  echo ": ".number_format($nett_total,"0","",".");?> 
                              </div>
                           
                            </div>

 


                            </div>
           
                          </div>


                                  <!--  -->
                                </div>
                                <div class="tab-pane" id="bar" role="tabpanel">
                                 <div id="batch_grn">
                                 
      
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
</div>
<script src="assets/js/action/grn.js"></script>