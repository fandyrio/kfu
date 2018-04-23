 <?php
    $id_supplier=$_GET['id'];
    session_start();
    //var_dump($id_supplier);

 ?>
    <button type="submit" class="btn-xs btn-info" id="cancel_load_q">Cancel</button>
    <button type="submit" class="btn-xs btn-primary" id="simpan_load_q">Insert</button>
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                <th></th>
                   <th >Doc No</th>
                  <th >Doc Date</th>
                  <th >Supplier</th>
                  <th >Nama Brand</th>
                   <th >Kuantiti</th>
                   <th >Satuan</th>
                  
                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"Select rq_hdr.*, inv_info_supplier.nama as \"nama_supplier\", auth_users.username \"nama_admin\", 
				 rq_ln.jumlah,rq_ln.nama_brand, inv_satuan.nama as \"nama_satuan\" from rq_hdr
                   INNER JOIN inv_info_supplier on inv_info_supplier.id= rq_hdr.id_supplier
                   INNER JOIN auth_users on auth_users.id_users= rq_hdr.createdby
                   INNER JOIN rq_ln on rq_ln.id_rq= rq_hdr.id
                   INNER JOIN inv_satuan on inv_satuan.id = rq_ln.id_satuan

                   WHERE rq_hdr.id_supplier='".$id_supplier."' and rq_hdr.unit_id='$_SESSION[id_units]'");

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                       <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id'] ?>" name="q_checkbox[]" /></td>
                        <td style="vertical-align:middle;"><?php echo $row['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['doc_date'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_supplier'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['jumlah'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_satuan'] ?></td>
                        
                       
                        </tr>
                    
                 
                 <?php } 

                 ?> 
                </tbody>
              

              </table>