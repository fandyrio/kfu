               <table id="penyesuaian_batch_load" class="table table-bordered table-striped">
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
                 $nama_brand = $_GET['nama_brand'];
                 $dept       = $_GET['departemen'];
                 
                 $_SESSION['stt_nama_brand'] = $_GET['nama_brand'];
                 $_SESSION['stt_id_satuan'] = $_GET['id_satuan'];
                 $_SESSION['stt_beda_qty'] = $_GET['beda_qty'];
                 $_SESSION['stt_"qty_baru'] = $_GET['"qty_baru'];
                 $_SESSION['stt_balance_qty'] = $_GET['balance_qty'];



                 //var_dump($_GET);

                 $res=pg_query($dbconn,"Select v.*,a.qtyin, a.no_batch, a.doc_date, a.expired_date, a.doc_no, a.manufacdate ,   
                    b.availableqty, b.availablecost,b.id_satuan
                    from view_inventoribatchbalance v 
                    left outer join view_inventoriavailablebatch a on a.id_hdr=v.id_hdr and a.id_ln=v.id_ln and a.id_batch=v.id_batch and a.id_departemen=v.id_departemen
                    left outer join view_inventoriavailablelist b on b.id_departemen=v.id_departemen and b.nama=v.nama
                   WHERE v.nama='".$nama_brand."' and v.id_departemen='".$dept."'");
                

                 while ($row=pg_fetch_assoc($res)) {

                      $harga_unit = $row['availablecost']/$row['availableqty'];
                           ?>
                       <tr id="<?php echo $row['id'] ?>" id_batch="<?php echo $row['stockbal']."_".$harga_unit ?>" >
                      <td style="vertical-align:middle;"><input type="checkbox" id="ceklis" value="<?php echo $row['id_hdr']."_".$row['id_ln']."_".$row['id_batch']."_".$row['no_batch']."_".$row['expired_date']."_".$row['manufacdate']."_".$harga_unit."_".$row['id_satuan'] ?>" 
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
                        <?php echo $row['qtyin'] ?></td>

                        <td style="vertical-align:middle;" >
                        <?php echo $harga_unit ?></td>  
                        <td style="vertical-align:middle;" >
                        <?php echo $harga_unit ?></td>  
                        <td style="vertical-align:middle;" ><input type="hidden"  /></td>
                        <td style="vertical-align:middle;" ><input type="hidden" /><?php echo $row['stockbal'] ?></td> 

                        <td style="vertical-align:middle;" class="keyvalue"> <input class="clickable" name="taken[]" style="width: 40px;" type="text" disabled> <input style="width: 40px;" type="hidden" name="total_cost[]" disabled></td>  
                      </tr>
                    <?php } ?>
                    
            
                </tbody>
              

              </table>