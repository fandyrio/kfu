			  <table  class="table table-bordered table-striped">
                <thead>
                <tr>
                <th width="10px">No</th>
                  <th width="">Nama Brand</th>
                  <th width="">Jumlah</th>
                  <th width="">Satuan</th>
                  <th width="">Harga Unit</th>
                  <th width="">Disx. Amount</th>
                  <th width="">Gross</th>
                  <th width="">Nett</th>
                   <th></th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $no = 0;
                 $res=pg_query($dbconn,"Select * from inv_satuan ");

                 while ($row=pg_fetch_assoc($res)) {
                  $no++;

                     ?>
                       <tr>
                        <td style="vertical-align:middle;"><?php echo $no ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["deskripsi"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["short_deskripsi"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["short_deskripsi"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["short_deskripsi"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["short_deskripsi"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["short_deskripsi"] ?></td>
                  
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>
              </table>
              