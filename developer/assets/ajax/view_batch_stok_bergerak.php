  <?php

    $nama = $_GET["nama"];
    $batch = explode("_", $nama);
    //var_dump($batch[1]);
    if($batch[1]=='GRN'){
     // var_dump($batch[0]);

      $res = pg_query($dbconn, "select grn_batch.no_batch, grn_batch.qty, grn_batch.expired_date as \"tgl_expired\", grn_batch.manufacdate as \"tgl_manufac\" from grn_batch where id_grn_ln='".$batch[0]."'");
      $row = pg_fetch_array($res);
    }
    if($batch[1]=='TRF'){


      $res = pg_query($dbconn, "select stok_trf_batch.* from stok_trf_batch where id_ln='".$batch[0]."'");
      $row = pg_fetch_array($res);

    }
    if($batch[1]=='ADJ'){


      $res = pg_query($dbconn, "select stok_adj_batch.no_batch, stok_adj_batch.qty, stok_adj_batch.expired_date as \"tgl_expired\", stok_adj_batch.manufacdate as \"tgl_manufac\" from stok_adj_batch where id_adj_ln='".$batch[0]."'");
      $row = pg_fetch_array($res);

    }
      if($batch[1]=='OPN'){


      $res = pg_query($dbconn, "select stok_buka_batch.* from stok_buka_batch where id_stok_buka_qty='".$batch[0]."'");
      $row = pg_fetch_array($res);

    }

  ?>

               <table class="table table-bordered table-striped" style="margin-top: 100px">
                <thead>
                <tr>
                 <th >Batch No</th>
                 <th >Qty</th> 
                 <th >Satuan</th>  
                 <th >Tgl.expire</th>
                 <th >Manufacture</th>  
                                   
                </tr>
                </thead>
                <tbody>


                       <tr >

                      <td style="vertical-align:middle;"><?php echo $row['no_batch'] ?></td>

                        <td  style="vertical-align:middle;" ><?php echo $row['qty'] ?></td>
                         <td style="vertical-align:middle;" ><?php echo $batch[2] ?></td>

                        <td style="vertical-align:middle;" ><?php echo $row['tgl_expired'] ?></td>

                        <td style="vertical-align:middle;" ><?php echo $row['tgl_manufac'] ?></td>
 
                      </tr>
                    
            
                </tbody>
              

              </table>