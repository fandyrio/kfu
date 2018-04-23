              <div class="box-footer text-left">
                <button type="submit" class="btn btn-xs btn-primary" id="add_adj_ln">Tambah</button>
                <!-- <button type="submit" class="btn-xs btn-primary" id="">View</button>
                 <button type="submit" class="btn-xs btn-primary" id="">Delete</button> -->
              </div>
               <table id="stok_adj" class="table ">
                <thead class="table-secondary">
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
              if($_SESSION["id_adj_hdr"]!=NULL){

                $res=pg_query($dbconn,"Select stok_adj_ln.*, inv_satuan.nama  as  \"nama_satuan\" from stok_adj_ln
                       INNER JOIN inv_satuan on inv_satuan.id=stok_adj_ln.id_satuan WHERE stok_adj_ln.id_hdr = '".$_SESSION["id_adj_hdr"]."'");
                }else{

                   $res=pg_query($dbconn,"Select stok_adj_ln.*, inv_satuan.nama  as  \"nama_satuan\" from stok_adj_ln
                       INNER JOIN inv_satuan on inv_satuan.id=stok_adj_ln.id_satuan WHERE stok_adj_ln.id_users='".$_SESSION['id_users']."'");


                }

              
                  $no=1;

                   $jlh = pg_num_rows($res);

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr id="<?php echo $row['id']; ?>" data="<?php echo $row['id_satuan']."_".$row['nama_satuan']; ?>" nama="<?php echo $row['nama_brand']; ?>" style="td {color: blue; background: white !important; }">
                       <td><?php echo $no++ ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["total_harga"] ?></td>
                        <td class="text-center" style="vertical-align:middle;">
                                          <!-- <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_trf_ln"><i class="icon-note" aria-hidden="true"></i></a> -->

                                          <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_stok_adj_ln"><i class="icon-trash" aria-hidden="true"></i></a>
                            </td>
                        
                       </tr>
                    
                 
                 <?php } ?> 
                </tbody>

                 <input type="hidden" id="jlh_ln" value="<?php echo $jlh ?>">
              
                </table>