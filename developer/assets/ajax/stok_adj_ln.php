              <div class="box-footer text-left">
                <button type="submit" class="btn-xs btn-info" id="add_adj_ln">Add</button>
                <!-- <button type="submit" class="btn-xs btn-primary" id="">View</button>
                 <button type="submit" class="btn-xs btn-primary" id="">Delete</button> -->
              </div>
               <table id="stok_adj" class="table table-bordered table-striped">
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

                 $res=pg_query($dbconn,"Select stok_adj_ln_temp.*, inv_satuan.nama  as  \"nama_satuan\" from stok_adj_ln_temp
                       INNER JOIN inv_satuan on inv_satuan.id=stok_adj_ln_temp.id_satuan WHERE stok_adj_ln_temp.id_users='".$_SESSION['id_users']."'");
                  $no=1;
                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr id="<?php echo $row['id']; ?>" data="<?php echo $row['id_satuan']."_".$row['nama_satuan']; ?>" nama="<?php echo $row['nama_brand']; ?>" style="td {color: blue; background: white !important; }">
                       <td><?php echo $no++ ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["total_harga"] ?></td>
                        <td class="text-center" style="vertical-align:middle;">
                                          <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_trf_ln"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                          <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_stok_adj_ln"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                            </td>
                        
                       </tr>
                    
                 
                 <?php } ?> 
                </tbody>
              
                </table>