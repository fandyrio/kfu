  <?php

      error_reporting(0);
    $id= 0;
    if($_GET['id']){
      $id=$_GET['id'];
      $_SESSION['id_adj_ln_temp'] =$id;

    }else $_SESSION['id_adj_ln_temp']=0;
    if($_GET['nama']){
        $_SESSION['nama_brand_trf']= $_GET['nama'];
    }
    //var_dump($batch[1]);

  ?>

          <div class="form-group row">
           <!-- <div class="col-sm-3">
                <button  id="add_trf_ln" class="btn btn-xs btn-primary">Select all batch</button>
                </div>    -->     
          <div class="col-sm-6">
                <input name='terms' value="<?php echo $_SESSION['nama_brand_trf']; ?>" class='form-control' id="batch_nama" readonly> 
                </div>
            </div>

               <table class="table table-bordered "">
                <thead class="table-secondary">
                <tr>
                       <th width="10px">No</th>
                        <th >Batch No</th>
                        <th >QTY</th>
                        <th >Satuan</th>
                        <th>Manufacture</th>
                        <th >Tgl. Expire</th>
                        <th>Remark</th>
                                   
                </tr>
                </thead>
                <tbody>

            <?php  

          
             $res = pg_query($dbconn,"Select stok_adj_batch.*, inv_satuan.nama  as  \"nama_satuan\" from stok_adj_batch
                                   INNER JOIN inv_satuan on inv_satuan.id=stok_adj_batch.id_satuan WHERE  stok_adj_batch.id_ln='".$_SESSION['id_adj_ln_temp']."'");

          

                  $no=1;

                  

                   while ($row=pg_fetch_assoc($res)) {

                  ?>

                       <tr >

                     <td style="vertical-align:middle;"><?php echo $no++ ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["no_batch"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["manufacdate"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["expired_date"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["catatan"] ?></td>
                             
                      </tr>

                      <?php } ?>
                    
            
                </tbody>
              

              </table>