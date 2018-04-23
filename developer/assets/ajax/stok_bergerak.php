   <?php 
      error_reporting(0);
          $nama_brand = $_GET['nama'];
          $id_departemen = $_GET['id_departemen'];

          /*$response = array(); 
          $res=pg_query($dbconn,"Select grn_hdr.doc_no,grn_hdr.doc_date, grn_ln.*, inv_satuan.nama as \"nama_satuan\" from grn_hdr INNER JOIN grn_ln on grn_ln.id_grn_hdr=grn_hdr.id INNER JOIN inv_satuan on inv_satuan.id=grn_ln.id_satuan 
             WHERE grn_ln.nama_brand='".$nama_brand."'");

    
          while ($row = pg_fetch_assoc($res)) {
              $bergerak = array();
              
              $bergerak["id"] = $row["id_grn_hdr"];
              $bergerak["id_ln"] = $row["id_grn_ln"];
              $bergerak["doc_no"] = $row["doc_no"];
              $bergerak["doc_date"] = $row["doc_date"];
              $bergerak["type"] = "GRN";
              $bergerak["qty_in"] = $row["qty"];
              $bergerak["qty_out"] = "0";
              $bergerak["nama_satuan"] = $row["nama_satuan"];
              $bergerak["total_grn"] = $row["nett_total"];
             //$bergerak["pengalaman"] = $row["pengalaman"];    
              array_push($response, $bergerak);
          }


          $result=pg_query($dbconn,"Select stok_trf_hdr.doc_no, stok_trf_hdr.doc_date, stok_trf_ln.*, inv_satuan.nama as \"nama_satuan\" from stok_trf_hdr INNER JOIN stok_trf_ln on stok_trf_ln.id_trf_hdr=stok_trf_hdr.id INNER JOIN inv_satuan on inv_satuan.id=stok_trf_ln.id_satuan 
             WHERE stok_trf_ln.nama_brand='".$nama_brand."'");


    
          while ($data = pg_fetch_assoc($result)) {
              $bergerak = array();
              $bergerak["id"] = $data["id_trf_hdr"];
              $bergerak["id_ln"] = $data["id_ln"];
              $bergerak["doc_no"] = $data["doc_no"];
              $bergerak["doc_date"] = $data["doc_date"];
              $bergerak["type"] = "TRF";
              $bergerak["qty_in"] ="0" ;
              $bergerak["qty_out"] = $data["qty"];
              $bergerak["nama_satuan"] = $data["nama_satuan"];
              $bergerak["total_trf"] = $data["total_cost"];
             //$bergerak["pengalaman"] = $row["pengalaman"];    
              array_push($response, $bergerak);
          }*/
          //$response["success"] = 1;
          //echo json_encode($response); 

          //$data = json_encode($response); 
          $data = array();
          $data  = BatchEngine_gerak($id_departemen,$nama_brand, $type="1");
          $json_array = json_decode($data, true); // convert to array

          /*foreach($json_array as $json){
             echo $json['doc_no']; // you can access your key value like this if result is array
             //echo $json->doc_no; // you can access your key value like this if result is object
          }*/        
  ?>

        <div class="row" style="margin: 0px">

              <table id="example10" class="table table-bordered table-striped">
                <thead>
                <tr>
     	            <th>Tgl Dok.</th>
                   <th >No Dok.</th>
                    <th >Type</th>
                   <th >Qty in</th>
                   <th >Qty out</th>
                   <th >Base Qty</th>
                   <th >Satuan</th>
                   <th >Nett Total</th>
                   <th width="150px"></th>
                  
                </tr>
                </thead>
                <tbody>
            <?php


              $qty =0;
              $total =0;


                   foreach($json_array as $json){
                      $qty += $json['qty'];
                      $total += $json['total'];
                    ?>
                      <tr>
                        <td style="vertical-align:middle;"><?php echo $json['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['doc_date'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['type'] ?></td>
                        
                        <?php if($json['qty'] < 0){ ?>
                             <td style="vertical-align:middle;">0</td>
                             
                             <td style="vertical-align:middle;"><?php echo $json['qty'] ?></td>
                             <?php
                          } else{ ?>
                             <td style="vertical-align:middle;"><?php echo $json['qty'] ?></td>
                             
                             <td style="vertical-align:middle;">0</td>

                             <?php
                          }?>
                          
                        <td style="vertical-align:middle;"><?php echo $json['qty'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['nama_satuan'] ?></td>
                        <td style="vertical-align:middle;">
                        <?php 
                              echo number_format($json['total'],0,',','.');
                       
                            ?>

                        </td>
                        <td> 
                        <a id="<?php echo $json['id']."_".$json['type'] ?>" class="btn btn-warning btn-xs view_type"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</a>
                        <a id="<?php echo $json['id_ln']."_".$json['type']."_".$json['nama_satuan'] ?>" class="btn btn-info btn-xs gerak_view_batch"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view Batch</a></td>
                       </tr>
                      
                      <?php } 

                      ?>  
                </tbody>
              </table>

                  <div class="row">
                  <div class="col-md-6 text-left">                   
                  </div>
                    <div class="col-md-6 text-right">
                       <div class="box-body">
                        <div class="box-body form-horizontal ">  
                     
                        <div class="form-group">
                            <label  class="col-sm-2">Balance</label>
                        <div class="col-sm-4">                     
                                 <input name='jumlah' value="<?php echo $qty ?>" class='text-right  form-control'  required >
                                
                            </div>
                            
                            <div class="col-sm-4">                     
                                
                                <input text="text"  value="<?php echo "Rp ".number_format($total,0,',','.') ?>"  class='text-right  form-control' readonly>
                                
                            </div>
                          </div>
                         </div>              
                      </div>
                  </div>
                  </div>

              </div>
              <div class="row" style="margin: 0px" >
                <div id="view_gerak_batch">

                </div>

              </div>
