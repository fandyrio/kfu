              
                  <table   class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Batch No</th>
                        <th>Document Date</th>
                        <th>Manufacture</th>
                        <th>Expiry Date</th>
                        <th>Base UOM</th>
                        <th>Balance Quantity</th>
                        <th>Balance Cost</th>
                        <th >Unit Cost</th>
                        <th>Supplier name</th>
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                      // $sql= "select  distinct grn_ln.nama_brand  from grn_ln 
                         //     join grn_hdr on grn_hdr.id =grn_ln.id_grn_hdr 
                          //      where grn_hdr.id_departemen=5";
                        $sql= "select  distinct grn_ln.nama_brand  from grn_ln";
                       $res=pg_query($dbconn,$sql);

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;

                           ?>
                             <tr>
                              <td><?php echo  $no++; ?></td>
                              <td><?php echo  $no++; ?></td>
                              <td><?php echo  $no++; ?></td>
                              <td><?php echo  $no++; ?></td>
                              <td><?php echo  $no++; ?></td>
                              <td><?php echo  $no++; ?></td>
                              <td><?php echo  $no++; ?></td>
                              <td><?php echo  $no++; ?></td>
                              <td><?php echo  $no++; ?></td>    
                              </tr>
         
                       <?php } ?> 
                      </tbody>
                    </table>