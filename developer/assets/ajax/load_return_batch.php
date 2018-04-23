               <table id="retur_batch_load" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th></th>
                 <th >Batch No</th>
                   <th >Doc Date</th>              
                   <th >Tgl.expire</th>
                   <th >Manufacture</th>
                   <th >Qty</th>      
                   <th >Harga Unit</th>
                   <th>Price</th>
                  <th >Reserved Quantity</th>
                  <th>Available</th>
                  <th>Taken</th>       
                </tr>
                </thead>
                <tbody>
          <?php
                 $nama_brand = $_GET['brand'];
                 $brand= str_replace('_', ' ', $nama_brand);
                 $q = "Select grn_hdr.*, grn_batch.no_batch, grn_batch.expired_date,  grn_batch.manufacdate,grn_batch.nama_brand,grn_batch.id_satuan, grn_ln.harga_unit, grn_ln.price,grn_batch.qty
                  from grn_hdr
                  INNER JOIN grn_ln on grn_ln.id_grn_hdr=grn_hdr.id
                  INNER JOIN grn_batch on grn_batch.id_grn_ln=grn_ln.id_grn_ln
                   WHERE grn_batch.nama_brand='".$brand."'";
                 $res=pg_query($dbconn,$q);
                 //var_dump($q);

                 while ($row=pg_fetch_assoc($res)) {
                           ?>

                       <tr id="<?php echo $row['id'] ?>" id_batch="<?php echo $row['qty']."_".$row['harga_unit'] ?>" >

                      <td style="vertical-align:middle;"><input type="checkbox" id="ceklis" value="<?php echo $row['no_batch']."_".$row['expired_date']."_".$row['manufacdate']."_".$row['harga_unit']."_".$row['id_satuan']."_".$row['price']?>" 
                        name="checkbox[]"/></td>

                        <td  style="vertical-align:middle;" >
                        <?php echo $row['no_batch'] ?></td>

                        <td style="vertical-align:middle;" >
                        <?php echo $row['doc_date'] ?></td>

                        <td style="vertical-align:middle;" >
                        <?php echo $row['expired_date'] ?></td>

                        <td style="vertical-align:middle;" >
                       <?php echo $row['manufacdate'] ?></td>

                        <td style="vertical-align:middle;" >
                        <?php echo $row['qty'] ?></td>

                        <td style="vertical-align:middle;" >
                        <?php echo $row['harga_unit'] ?></td>  
                        <td style="vertical-align:middle;" >
                        <?php echo $row['price'] ?></td>  
                        <td style="vertical-align:middle;" ><input type="hidden"  /><?php echo $row['qty'] ?></td>
                        <td style="vertical-align:middle;" ><input type="hidden" /><?php echo $row['qty'] ?></td> 

                        <td style="vertical-align:middle;" class="keyvalue"> <input class="clickable" name="taken[]" style="width: 40px;" type="text" disabled> <input style="width: 40px;" type="hidden" name="total_cost[]" disabled></td>  
                      </tr>
                    <?php } ?>
                    
            
                </tbody>
              

              </table>