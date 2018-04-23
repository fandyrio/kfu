
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                            
                  <th >Jenis Kelammin</th>
                  <th >Dari Usia</th>
                  <th >Ke Usia</th>
                  <th >Low Range</th>
                  <th >High Range</th>
                                 
                </tr>
                </thead>
                <tbody>
             <?php
             //error_reporting(0);
                    $id = $_SESSION['id_lab'];
                    $res=pg_query($dbconn,"Select * from  lab_analisis_referal_range where id_lab_analisis='".$id."'");
               

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        
                        <td><?php echo $row["id_jenkel"] ?></td>
                        <td><?php echo $row["usia_awal"] ?></td>
                        <td><?php echo $row["usia_akhir"] ?></td>
                        <td><?php echo $row["nilai_rendah"] ?></td>
                        <td><?php echo $row["nilai_tinggi"] ?></td>
                       <td>
                                          <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_range"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                          <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_range"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                            </td>
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>
              </table>