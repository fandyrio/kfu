                  
                  <button  id="add_buka_stok_ln" class="btn btn-xs btn-primary">Tambah</button>
                  <table id="tabelstok"  class="table ">
                      <thead>
                      <tr>
                      <th width="10px">No</th>
                        <th width="">Nama Brand</th>
                        <th width="">QTY</th>
                        <th width="">Satuan</th>
                        <th width="">Harga Unit</th>
                        <th width="">Total</th>
                         <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $totalcost = 0;
                       $res=pg_query($dbconn,"Select stok_buka_qty_temp.*, inv_satuan.nama  as  \"nama_satuan\" from stok_buka_qty_temp
                       INNER JOIN inv_satuan on inv_satuan.id=stok_buka_qty_temp.id_satuan WHERE stok_buka_qty_temp.id_users='".$_SESSION['id_users']."'");

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						 //$jum +=;
						            $totalcost += $row["totalcost"];
                           ?>
                             <tr id="<?php echo $row['id']; ?>" data="<?php echo $row['id_satuan']."_".$row['nama_satuan']; ?>" nama="<?php echo $row['nama_brand']; ?>">
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["harga_unit"] ?></td>
                              
                              <td style="vertical-align:middle;"><?php echo $row["totalcost"] ?></td>
							                 <td class="text-center" style="vertical-align:middle;">
                                <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_bs_ln"><i class="icon-note"> </i></a>
                                <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_bs_ln"> <i class="icon-trash"></i></a>
							                 </td>
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
					  
                    </table>

             <div class="col-md-12 text-right">
               <div class="form-group  row">
                  <label  class="col-sm-9">Net Cost</label>
                  <div class="col-sm-3">                     
                      <input name='net_cost' value="<?php echo $totalcost; ?>" class='form-control' readonly>                    
                  </div>
                  </div>
             </div>
              

			
			