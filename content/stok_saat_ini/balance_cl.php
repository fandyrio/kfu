       
                  <table   class="table table-bordered table-striped">
                      <thead>
                      <tr>
                      <th>Nama Brand</th>
                       <th>Base UOM</th>
                        <th>Balance Quality</th>
                        <th>Balance Cost </th>
                         <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $sql= "select  distinct grn_ln.nama_brand  from grn_ln";
                       $res=pg_query($dbconn,$sql);

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;

                           ?>
                             <tr>
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                               <td class="text-center" style="vertical-align:middle;">
                                  <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_rq"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                  <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_rq"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                              </td>
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
                    </table>