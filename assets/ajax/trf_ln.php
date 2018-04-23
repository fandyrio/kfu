                  <button  id="add_trf_ln" class="btn btn-xs btn-primary">Tambah</button>
                  <table id="trf_batch_ln"  class=" table ">
                      <thead class="table-secondary">
                      <tr>
                      <th width="10px">No</th>
                        <th width="">Nama Brand</th>
                        <th width="">QTY</th>
                        <th width="">Satuan</th>
                        <th width="">Jumlah</th>  
                        <th>With Batch</th>
                         <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $totalgross = 0;
                      

                       if($_SESSION["id_trf_hdr"]!=NULL){

                        //var_dump("www");

                         $res=pg_query($dbconn,"Select stok_trf_ln.*, inv_satuan.nama  as  \"nama_satuan\" from stok_trf_ln
                            INNER JOIN inv_satuan on inv_satuan.id=stok_trf_ln.id_satuan WHERE id_hdr = '".$_SESSION["id_trf_hdr"]."'");

                       }else{

                         $res=pg_query($dbconn,"Select stok_trf_ln.*, inv_satuan.nama  as  \"nama_satuan\" from stok_trf_ln
                            INNER JOIN inv_satuan on inv_satuan.id=stok_trf_ln.id_satuan WHERE stok_trf_ln.id_users='".$_SESSION['id_users']."'");

                       }

                       $jlh = pg_num_rows($res);

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						            //$jum +=;
						            //$totalgross += $row["gross_total"];
                           ?>
                              <tr id="<?php echo $row['id']; ?>" data="<?php echo $row['id_satuan']."_".$row['nama_satuan']; ?>" nama="<?php echo $row['nama_brand']; ?>" style="td {color: blue; background: white !important; }">
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                              <td style="vertical-align:middle;">
                                 <?php
                                  if($row['with_batch'] ==1)
                                      echo "<input type='checkbox' checked disabled>";
                                    
                                  else
                                          echo "<input type='checkbox' disabled>";
                                    ?>

                              </td>
              							<td class="text-center" style="vertical-align:middle;">
                                          <!-- <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_trf_ln"><i class="icon-note"></i></a> -->
                                          <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_trf_ln"><i class="icon-trash"></i></a>
              							</td>
                             
                              </tr>
                          
                       
                       <?php } ?> 

                       <input type="hidden" id="jlh_ln" value="<?php echo $jlh ?>">
                      </tbody>
					  
                    </table>



			
			