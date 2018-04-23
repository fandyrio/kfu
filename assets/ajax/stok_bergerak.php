   <?php   
    error_reporting(0);
    session_start();
    include_once('../../config/conn.php');
    include_once('../../config/function.php');



          $nama_brand = $_GET['nama'];
          $id_departemen = $_GET['id_departemen'];


          $data = array();
          $data  = BatchEngine_gerak($id_departemen,$nama_brand, $type="1");
          $json_array = json_decode($data, true); // convert to array

          /*foreach($json_array as $json){
             echo $json['doc_no']; // you can access your key value like this if result is array
             //echo $json->doc_no; // you can access your key value like this if result is object
          }*/        
  ?>

      <div class="card-block">

              <table class="table " id="myTable" >
                <thead class="table-dark" >
                <tr>
     	            <th style="text-align: center">No Dok</th>
                   <th style="text-align: center">Tgl Dok</th>
                    <th style="text-align: center">Type</th>
                   <th style="text-align: center">Qty in</th>
                   <th style="text-align: center">Qty out</th>
                   <th style="text-align: center">Base Qty</th>
                   <th style="text-align: center">Satuan</th>
                   <th style="text-align: center">Nett Total</th>
                   <th ></th>
                  
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
                        <td style="text-align:center;"><?php echo $json['doc_no'] ?></td>
                        <td style="text-align:center;"><?php echo tgl_indo($json['doc_date']) ?></td>
                        <td style="text-align:center;"><?php echo $json['type'] ?></td>
                        
                        <?php if($json['qty'] < 0){ ?>
                             <td style="text-align:right;">0</td>
                             
                             <td style="text-align:right;"><?php echo $json['qty'] ?></td>
                             <?php
                          } else{ ?>
                             <td style="text-align:right;"><?php echo $json['qty'] ?></td>
                             
                             <td style="text-align:right;">0</td>

                             <?php
                          }?>
                          
                        <td style="text-align:right;"><?php echo $json['qty'] ?></td>
                        <td style="text-align:center;"><?php echo $json['nama_satuan'] ?></td>
                        <td style="text-align:right;">
                        <?php 
                              echo number_format($json['total'],0,',','.');
                       
                            ?>

                        </td>
                        <td style="text-align:center;"> 
                        <a id="<?php echo $json['id']."_".$json['type'] ?>" class="btn btn-warning btn-xs view_type"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Lihat</a>
                        <a id="<?php echo $json['id_ln']."_".$json['type']."_".$json['nama_satuan'] ?>" class="btn btn-info btn-xs gerak_view_batch"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Lihat Batch</a></td>
                       </tr>
                      
                      <?php } 

                      ?>  
                </tbody>
              </table>

                    <div class="col-md-12 text-right">
                    <br>
                        <div class="form-horizontal ">  
                     
                        <div class="form-group row">
                            <label  class="col-sm-8 form-control-label">Balance</label>
                        <div class="col-sm-2">                     
                                 <input name='jumlah' value="<?php echo $qty ?>" class='text-right  form-control'  required >
                                
                            </div>
                            
                            <div class="col-sm-2">                     
                                
                                <input text="text"  value="<?php echo "Rp ".number_format($total,0,',','.') ?>"  class='text-right  form-control' readonly>
                                
                            </div>
                          </div>
                         </div>              
                      </div>

              </div>
              <div class="row" style="margin: 0px" >
              <div class="card-block">
                <div id="view_gerak_batch">

                </div>
                </div>

              </div>


        <link href="assets/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/datatable_code.js"></script>
