                
                <button  id="add_retur_ln" class="btn btn-xs btn-primary">Tambah</button><br><br>
                  <table  id="retur_ln_loader" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                      <th width="10px">No</th>
                        <th width="">Nama Brand</th>
                        <th width="60px">QTY</th>
                        <th width="100px">Satuan</th>                        
                         <th width="60px"></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $jum = 0;
                       if($_SESSION['id_hdr_retur']){
                        $res=pg_query($dbconn,"Select retur_ln.*, inv_satuan.nama  as  \"nama_satuan\" from retur_ln
                       INNER JOIN inv_satuan on inv_satuan.id=retur_ln.id_satuan WHERE retur_ln.id_hdr='".$_SESSION['id_hdr_retur']."'");

                       }
                       else{                        

                       $res=pg_query($dbconn,"Select retur_ln.*, inv_satuan.nama  as  \"nama_satuan\" from retur_ln
                       INNER JOIN inv_satuan on inv_satuan.id=retur_ln.id_satuan WHERE retur_ln.id_users='".$_SESSION['id_users']."'");
                       }
                      
                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						 //$jum +=;

                           ?>
                             <tr id="<?php echo $row['id']; ?>" data="<?php echo $row['id_satuan']."_".$row['nama_satuan']; ?>" nama="<?php echo $row['nama_inventori']; ?>">
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_inventori"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                        
                             <td class="text-center" style="vertical-align:middle;">
                            <!-- <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_retur_ln"><span class="icon icon-pencil" aria-hidden="true"></span></a> -->
                            <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_retur_ln"><span class="icon icon-trash" aria-hidden="true"></span></a>
                               </td>
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
					  
                    </table>
			
