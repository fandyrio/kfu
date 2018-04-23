              <div id="result">

                   <button  id="add_rq" class="btn-xs btn-primary">Tambah</button>
                    <table  class="table table-bordered table-striped">
                      <thead>
                      <tr>
                      <th width="10px">No</th>
                        <th width="">Nama Brand</th>
                        <th width="">Jumlah</th>
                        <th width="">Satuan</th>
                         <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $res=pg_query($dbconn,"Select * from rq_ln ");

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;

                           ?>
                             <tr>
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["id_brand"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["jumlah"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["id_satuan"] ?></td>
                        
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
                    </table>
                  
                </div>