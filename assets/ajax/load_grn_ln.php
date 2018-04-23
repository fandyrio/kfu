  <?php
    session_start();
  ?>

            <form action="" method="post">
               <table id="po_batch_load" class="table table-bordered table-striped">
                <thead>
                <tr>
                 <th >Po Date</th>
                   <th >Po No</th>              
                   <th >Nama Brand</th>
                   <th >Satuan</th>
                    <th >Jumlah</th>      
                     <th >Harga Unit</th>
                     <th></th>
                  
                  
                </tr>
                </thead>
                <tbody>
                  <?php
                 $res=pg_query($dbconn,"Select po_hdr.*,
                    po_ln.jumlah,po_ln.nama_brand,po_ln.total_harga, inv_satuan.nama as \"nama_satuan\" from po_hdr
                  
                  
                   INNER JOIN po_ln on po_ln.id_hdr= po_hdr.id
                   INNER JOIN inv_satuan on inv_satuan.id = po_ln.id_satuan

                   WHERE po_hdr.id_supplier='".$_SESSION['id_po']."' and po_hdr.id_unit='$_SESSION[id_units]'");

                 
                 while ($row=pg_fetch_assoc($res)) {
                     ?>

                       <tr id="<?php echo $row['id'] ?>">
                        <td style="vertical-align:middle;"><?php echo $row['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['doc_date'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_satuan'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['jumlah'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['total_harga'] ?></td> 
                        <td style="vertical-align:middle;" >Tambah Batch</td>      
                        </tr>

                        <tr id="batch_">
                        <td style="vertical-align:middle;"><?php echo $row['doc_no'] ?></td>
                        </tr>
    

                        <?php } 

                        ?>
                    
            
                </tbody>
              

              </table>
              </form>