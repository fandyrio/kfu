                <button  id="add_update_rq" class="btn btn-xs btn-primary">Tambah</button>
                  <table  class="table table-bordered ">
                      <thead class="table-secondary">
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
                       $res=pg_query($dbconn,"Select rq_ln.*, inv_satuan.nama as \"nama_satuan\" from rq_ln
                       INNER JOIN inv_satuan on inv_satuan.id=rq_ln.id_satuan 
                       WHERE rq_ln.id_rq='".$_SESSION['id_rq_hdr']."'");

                       $jlh = pg_num_rows($res);
                       while ($row=pg_fetch_assoc($res)) {
                        $no++;

                           ?>
                             <tr>
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["jumlah"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                               <td class="text-center" style="vertical-align:middle;">
                                  <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs update_rq"><i class="icon-note"></i></a>
                                  <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_update_rq"><i class="icon-trash"></i></a>
                              </td>
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
                      <input type="hidden" id="jlh_ln" value="<?php echo $jlh ?>">
                    </table>