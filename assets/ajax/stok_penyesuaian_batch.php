                  <button  id="add_buka_stok_batch" class="btn-xs btn-primary">Tambah</button>
                  <table  class="table table-bordered table-striped">
                      <thead>
                      <tr>
                      <th width="10px">No</th>
                        <th width="">No. Batch</th>
						<th width="">Tgl. Expired</th>
						 <th width="">Catatan</th>
                        <th width="">QTY</th>
                        <th width="">Satuan</th>
                        <th width="">Harga Unit</th>                        
                       
                         <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $jum = 0;
                       $res=pg_query($dbconn,"Select grn_batch_temp.*, inv_satuan.nama  as  \"nama_satuan\"from grn_batch_temp
                       INNER JOIN inv_satuan on inv_satuan.id=grn_batch_temp.id_satuan WHERE grn_batch_temp.id_users='".$_SESSION['id_users']."'");

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						 //$jum +=;

                           ?>
                             <tr>
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["no_batch"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["manufacdate"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["expired_date"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["catatan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                        
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
					  
                    </table>
			
			