    <?php
    $id_departemen="1";
    ?>              
                 <table  class="table">
                      <thead>
                      <tr>
                      <th width="10px">No</th>
                        <th width="">Nama Brand</th>
                        <th width="">QTY Sekarang</th>
                        <th width="">QTY Baru</th>
                        <th width="">Beda</th>
                        <th width="">Satuan</th>
                        <th width="10px">Total Harga</th>
                        <th width="">Full Batch</th>
                         <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $totalgross = 0;
                       $sql="Select distinct inv_nama_brand.nama, inv_inventori.id as \"id_inv\", inv_inventori.id_satuan, inv_satuan.nama as \"nama_satuan\" FROM inv_nama_brand  Inner JOIN inv_inventori on inv_inventori.id_brand = inv_nama_brand.id
                          INner join inv_satuan ON  inv_inventori.id_satuan  =inv_satuan.id ";
                       $res=pg_query($dbconn,$sql);

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
                        $q="Select v.*,a.qtyin, a.no_batch, a.doc_date, a.expired_date, a.doc_no, a.manufacdate ,  
                              b.availableqty, b.availablecost,b.id_satuan
                              from view_inventoribatchbalance v 
                              left outer join view_inventoriavailablebatch a on a.id_hdr=v.id_hdr and a.id_ln=v.id_ln and a.id_batch=v.id_batch and a.id_departemen=v.id_departemen
                              left outer join view_inventoriavailablelist b on b.id_departemen=v.id_departemen and b.nama=v.nama 
                         WHERE   v.id_departemen='".$id_departemen."' AND v.nama='".$row['nama']."' ";
                         var_dump($q);
                        $execute =pg_query($dbconn,$q); 
    						
                           ?>

                             <tr id="<?php echo $row["nama"] ?>" satuan="<?php echo $row["id_satuan"] ?>" nama_satuan="<?php echo $row["nama_satuan"] ?>" data_id_inv="<?php echo $row["id_inv"] ?>">
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                              <td>
                                <?php
                                // while ($data=pg_fetch_assoc($execute)) {
                                  ?>
                                <input name="balance_qty" type="text" value="<?php echo '10';?>" class="text-right" style="width: 50px;"><?php //}?>
                                </td>
                              <td><input name="qty_baru" type="text" value="0" class="text-right qty_baru" style="width: 50px;"></td>
                              <td><input name="beda" type="text" value="0" class="text-right" style="width: 50px;" readonly></td>
                               <td><?php echo $row["nama_satuan"] ?></td>
                                <td><input name="total_harga" type="text" value="0" class="text-right" style="width: 50px;"></td>
                                 <td><input name="fullbatch" type="checkbox" disabled ></td>
                              
                              
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
					  
                    </table>

              <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              
              <div class="modal-dialog" role="document" style="width: 700px">
                  <div class="modal-content">

                   <div class="modal-body" style="text-align:left">

                    </div>
                    <div class="modal-footer">                    
                    <button type="button" class="btn btn-sm btn-warning" id="save_batch_penyesuaian" >oke</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">BATAL</button>
                    </div>
                  </div>
              </div>
          </div>

			
			