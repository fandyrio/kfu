     <?php
     $id_departemen='1';   
     $res=pg_query($dbconn,"Select v.*,a.qtyin, a.no_batch, a.doc_date, a.expired_date, a.doc_no, a.manufacdate ,   
                    b.availableqty, b.availablecost,b.id_satuan
                    from view_inventoribatchbalance v 
                    left outer join view_inventoriavailablebatch a on a.id_hdr=v.id_hdr and a.id_ln=v.id_ln and a.id_batch=v.id_batch and a.id_departemen=v.id_departemen
                    left outer join view_inventoriavailablelist b on b.id_departemen=v.id_departemen and b.nama=v.nama
                   WHERE   v.id_departemen='".$id_departemen."'"); 
     // var_dump(pg_fetch_assoc($res));
    
     ?>         
                  <table  id="stok_saat_ini" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                      <th width="">Nama Brand</th>
                        <th width="">Balance Quality</th>
                        <th width="">Base UOM</th>
                        <th width="">Balance Cost </th>
                         <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;                  
     

                         while ($row=pg_fetch_assoc($res)) {
                        $no++;

                           ?>
                             <tr data-mit-brand="<?php echo $row["nama"]; ?>" data-mit-departemen="<?php echo $id_departemen; ?>" data-bal="<?php echo $row["availableqty"];?>">
                              <td style="vertical-align:middle;"><?php echo $row["nama"]; ?></td>
                              <td style="vertical-align:middle;"><?php echo $row['availableqty'];?></td>
                              <td style="vertical-align:middle;"><?php echo $row['id_satuan']; ?></td>
                              <td style="vertical-align:middle;"><?php echo $row['availablecost'];?></td>
                              
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
                    </table>