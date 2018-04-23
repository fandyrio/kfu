<!-- <button  id="grn_load" class="btn btn-xs btn-warning">Load</button> -->
                <button  id="update_add_grn" class="btn btn-xs btn-primary">Tambah</button>
                  <table id="grn_ln_update" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                      <th width="10px">No</th>
                        <th width="">Nama Brand</th>
                        <th width="">Qty</th>
                        <th width="">Satuan</th>
                        <th width="">Gross</th>
                        <th width="">Diskon</th>
                        <th width="">Pajak</th>
                        <th width="">Nett</th>
                         <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $totalgross = 0;
                       $res=pg_query($dbconn,"Select grn_ln.*, inv_satuan.nama  as  \"nama_satuan\" from grn_ln
                       INNER JOIN inv_satuan on inv_satuan.id=grn_ln.id_satuan WHERE grn_ln.id_hdr='".$_SESSION['id_grn_hdr']."'");

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						 //$jum +=;
						$totalgross += $row["gross_total"];
                           ?>
                             <tr id="<?php echo $row['id']; ?>" data="<?php echo $row['id_satuan']."_".$row['nama_satuan']; ?>" nama="<?php echo $row['nama_brand']; ?>" >
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["qty"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["gross_total"] ?></td>
                              <td style="vertical-align:middle;">
							  <?php 
							  if($row["diskon_persen"] ){
								  echo $row["diskon_persen"];
							  }
							  else echo $row["diskon_amount"];
								  ?>
							  </td>
                              <td style="vertical-align:middle;">
							  <?php 
							  if($row["pajak_persen"] ){
								  echo $row["pajak_persen"];
							  }
							  else echo $row["pajak_amount"];
								  ?>
							  </td>
                              <td style="vertical-align:middle;"><?php echo $row["nett_total"] ?></td>
							<td class="text-center" style="vertical-align:middle;">
                            <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_grn_ln_update"><i class="icon-note" aria-hidden="true"></i></a>
                            <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_grn_ln_update"><i class="icon-trash" aria-hidden="true"></i></a>
							</td>
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
					   <form method="POST" enctype="multipart/form-data" id="grn_hdr_ex">
					  <tr>
					  <td colspan="5"></td>
					  <td>Gross Total</td>
					  <td></td>
					  <td class="col-sm-2"><input id="gross_total" type="text" name="gross_total" value="<?php echo $totalgross; ?>" class="form-control text-right" readonly></td>
					  </tr>
					  <tr>
					  <td colspan="5"></td>
					  <td>Diskon</td>
					  <td style="width:100px;">
							<input id="check_diskon"  type="checkbox" checked name='check_diskon' >%
							<input id="persen_diskon" type="text" name='disc_persen' onchange="hitung_net_cost()" style="width:50px;">
                            
					</td>
					  <td>            
						<input id="diskon_amount" name='disc_amount'  disabled  onchange="hitung_net_cost()" class="form-control">
								
                          
					  </td>
					  </tr>
					  <tr>
					  <td colspan="5"></td>
					  <td>Pajak</td>
					  <td style="width:100px;">
					   	<input id="check_pajak"  type="checkbox" checked name='check_pajak'>%						                   
                                
                         <input id="persen_pajak" type="text" name='persen_pajak' style="width:50px;"  onchange="hitung_net_cost()"> 		
					  </td>
					   <td> 
					   <input id="pajak_amount" name='pajak_amount'   disabled  onchange="hitung_net_cost()" class="form-control">
					   </td> 
					  </tr>
					  <tr>
					  <td colspan="5"></td>
					  <td>Net Cost</td>
					  <td></td>
					  <td><input type="text" id="net_total" name="net_total"  class="form-control text-right" readonly value="<?php echo $totalgross; ?>"></td>
					  </tr>
					   </form>
                    </table>