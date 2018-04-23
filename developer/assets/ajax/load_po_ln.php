 <?php
    $id_supplier=$_GET['id'];
    //var_dump($id_supplier);

 ?>
    <button type="submit" class="btn-xs btn-info" id="cancel_po">Cancel</button>
    <button type="submit" class="btn-xs btn-primary" id="simpan_load_po">Insert</button>
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                <th></th>
                   <th >Doc No</th>
                  <th >Doc Date</th>
                 <th >Nama Inventori</th>
                  <th >Jumlah</th>
                  <th >Satuan</th>
                   <th >Harga Unit</th>
                   <th >Diskon Persen</th>
                   <th >Diskon Amount</th>
                  
                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"Select q_hdr.*, auth_users.username \"nama_admin\", 
				 q_ln.jumlah,q_ln.nama_brand, q_ln.harga_unit,q_ln.disc_perc,q_ln.disc_amount, inv_satuan.nama as \"nama_satuan\" from q_hdr
                   
                   INNER JOIN auth_users on auth_users.id_users= q_hdr.createdby
                   INNER JOIN q_ln on q_ln.id_hdr= q_hdr.id
                   INNER JOIN inv_satuan on inv_satuan.id = q_ln.id_satuan

                   WHERE q_hdr.id_supplier='".$id_supplier."'");

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                       <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id'] ?>" name="po_checkbox[]" /></td>
                        <td style="vertical-align:middle;"><?php echo $row['no_dok'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['tgl_dok'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['jumlah'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_satuan'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['harga_unit'] ?></td>                  
                        <td style="vertical-align:middle;"><?php echo $row['disc_perc'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['disc_amount'] ?></td>


                        
                       
                        </tr>
                    
                 
                 <?php } 

                 ?> 
                </tbody>
              

              </table>