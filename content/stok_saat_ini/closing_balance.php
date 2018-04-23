SEDANG PENGEMBANGAN                    
                  <table   class="table table-bordered table-striped">
                      <thead>
                      <tr>
                      <th>Closing Date</th>
                        <th>Remark</th>
                        <th>User</th>
                       
                         <th></th>
                        
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
                              <td style="vertical-align:middle;"></td>
                              <td style="vertical-align:middle;"></td>
                              <td style="vertical-align:middle;"></td>
                     
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
                    </table>

    
            <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab6" data-toggle="tab">Balance</a></li>
                  <li><a href="#tab7" data-toggle="tab">Batch</a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab6">  

            <?php include "balance_cl.php"; ?>
               
        
              </div>
            <div class="tab-pane" id="tab7">  
          <?php include "batch_cl.php"; ?>
             
            </div>
              <!-- /.tab-pane -->
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>