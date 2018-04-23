   <?php 
      error_reporting(0);
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
              <button type="button" onclick="location.href=''" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Cetak Invoice</button>
              <table class="table">
                <thead>
                <tr>
     	            <th>Tanggal Transaksi</th>
                  <th >Nama Item</th>
                  <th >Harga Unit</th>
                  <th >Qty</th>
                  <th >Satuan</th>
                  <th >Jumlah</th>
                  <th >Dibayar Oleh</th>
                  <th >Group</th> 
                  <th >Billing Paket</th> 
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
                        <td scope="row"><?php echo $json['doc_no'] ?></td>
                        <td ><?php echo $json['doc_date'] ?></td>
                        <td ><?php echo $json['type'] ?></td>
                         <td scope="row"><?php echo $json['doc_no'] ?></td>
                        <td ><?php echo $json['doc_date'] ?></td>
                        <td ><?php echo $json['type'] ?></td>
                        
                         <td scope="row"><?php echo $json['doc_no'] ?></td>
                        <td ><?php echo $json['doc_date'] ?></td>
                        <td ><?php echo $json['type'] ?></td>
                         <td ><?php echo "Paket" ?></td>
                        
                        
                       
                        <!--td> 
                        <a id="<?php echo $json['id']."_".$json['type'] ?>" class="btn btn-warning btn-xs view_type"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</a>
                        <a id="<?php echo $json['id_ln']."_".$json['type']."_".$json['nama_satuan'] ?>" class="btn btn-info btn-xs gerak_view_batch"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view Batch</a></td-->
                       </tr>
                      
                      <?php } 

                      ?>  
                </tbody>
              </table>


              </div>
              
