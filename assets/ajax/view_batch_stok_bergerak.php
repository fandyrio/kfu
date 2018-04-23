  <?php
    error_reporting(0);
    session_start();
    include_once('../../config/conn.php');
    include_once('../../config/function.php');

    $nama = $_GET["nama"];
    $batch = explode("_", $nama);
    //var_dump($batch[1]);
    if($batch[1]=='GRN'){
     // var_dump($batch[0]);

      $res = pg_query($dbconn, "select grn_batch.no_batch, grn_batch.qty, grn_batch.expired_date as \"tgl_expired\", grn_batch.manufacdate as \"tgl_manufac\" from grn_batch where id_ln='".$batch[0]."'");
      $row = pg_fetch_array($res);
    }
    if($batch[1]=='TRF'){


      $res = pg_query($dbconn, "select stok_trf_batch.* from stok_trf_batch where id_ln='".$batch[0]."'");
      $row = pg_fetch_array($res);

    }
    if($batch[1]=='ADJ'){


      $res = pg_query($dbconn, "select stok_adj_batch.no_batch, stok_adj_batch.qty, stok_adj_batch.expired_date as \"tgl_expired\", stok_adj_batch.manufacdate as \"tgl_manufac\" from stok_adj_batch where id_ln='".$batch[0]."'");
      $row = pg_fetch_array($res);

    }
      if($batch[1]=='OPN'){


      $res = pg_query($dbconn, "select stok_buka_batch.* from stok_buka_batch where id_qty='".$batch[0]."'");
      $row = pg_fetch_array($res);

    }
    if($batch[1]=='RSP'){


      $res = pg_query($dbconn, "select pasien_resep_batch.* from pasien_resep_batch where id='".$batch[0]."'");
      $row = pg_fetch_array($res);
     

    }

  ?>


              <div class="card-blok">
               <table class="table table-bordered" >
                <thead class="table-secondary">
                <tr>
                 <th style="text-align: center">Batch No</th>
                 <th style="text-align: center">Qty</th> 
                 <th style="text-align: center">Satuan</th>  
                 <th style="text-align: center">Tgl.expire</th>
                 <th style="text-align: center">Manufacture</th>  
                                   
                </tr>
                </thead>
                <tbody>


                       <tr >

                      <td style="text-align:center;"><?php echo $row['no_batch'] ?></td>

                        <td  style="text-align:right;" ><?php echo $row['qty'] ?></td>
                         <td style="text-align:center;" ><?php echo $batch[2] ?></td>

                        <td style="text-align:center;" ><?php echo tgl_indo($row['tgl_expired']) ?></td>

                        <td style="text-align:center;" ><?php echo tgl_indo($row['tgl_manufac']) ?></td>
 
                      </tr>
                    
            
                </tbody>
              

              </table>
              </div>