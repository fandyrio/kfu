              <div class="box-footer text-left">
                <button type="submit" class="btn-xs btn-info" id="">Add</button>
                <button type="submit" class="btn-xs btn-primary" id="">View</button>
                 <button type="submit" class="btn-xs btn-primary" id="">Delete</button>
              </div>
               <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                   <th >Nama Brand </th>
                   <th >Qty</th>
                   <th >Satuan</th>
                   <th>amount</th>
                   <th></th>
                   
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"Select * from rq_hdr");

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        <td style="vertical-align:middle;"></td>
                        <td style="vertical-align:middle;"></td>
                        <td style="vertical-align:middle;"></td>
                        <td style="vertical-align:middle;"></td>
                        <td style="vertical-align:middle;"></td>
                        <td></td>
                        
                       </tr>
                    
                 
                 <?php } ?> 
                </tbody>
              
                </table>