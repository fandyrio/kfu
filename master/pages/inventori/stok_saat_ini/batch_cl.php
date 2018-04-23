              
                  <table  class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Batch No</th>
                        <th>Document Date</th>
                        <th>Manufacture</th>
                        <th>Expiry Date</th>
                        <th>Base UOM</th>
                        <th>Balance Quantity</th>
                        <th>Balance Cost</th
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $res=pg_query($dbconn,"Select rq_ln_temp.*, inv_satuan.nama as \"nama_satuan\" from rq_ln_temp
                       INNER JOIN inv_satuan on inv_satuan.id=rq_ln_temp.id_satuan WHERE rq_ln_temp.id_users='".$_SESSION['id_users']."'");

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;

                           ?>
                             <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>  
                              </tr>
         
                       <?php } ?> 
                      </tbody>
                    </table>