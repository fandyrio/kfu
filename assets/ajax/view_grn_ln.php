<style type="text/css" media="screen">

tr:hover { color:#888; text-decoration: none; }
tr:active { color:red; text-decoration: underline; background: #333;}
</style>
<table id="grn_ln_view" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                      <th width="10px">No</th>
                        <th width="">Nama Brand</th>
                        <th width="">QTY</th>
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
                       INNER JOIN inv_satuan on inv_satuan.id=grn_ln.id_satuan WHERE grn_ln.id_grn_hdr='".$_SESSION['id_grn_hdr']."'");

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						 //$jum +=;
						$totalgross += $row["gross_total"];
                           ?>
                             <tr id="<?php echo $row['id_grn_ln']; ?>" data="<?php echo $row['id_satuan']."_".$row['nama_satuan']; ?>" nama="<?php echo $row['nama_brand']; ?>" style="cursor: pointer;">
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
                              
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
					  
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
							<input id="persen_diskon" type="text" name='disc_persen' disabled style="width:50px;">
                            
					</td>
					  <td>            
						<input id="diskon_amount" name='disc_amount'  disabled   class="form-control">
								
                          
					  </td>
					  </tr>
					  <tr>
					  <td colspan="5"></td>
					  <td>Pajak</td>
					  <td style="width:100px;">
					   	<input id="check_pajak"  type="checkbox" checked name='check_pajak'>%						                   
                                
                         <input id="persen_pajak" type="text" name='persen_pajak' style="width:50px;"  disabled> 		
					  </td>
					   <td> 
					   <input id="pajak_amount" name='pajak_amount'   disabled   class="form-control">
					   </td> 
					  </tr>
					  <tr>
					  <td colspan="5"></td>
					  <td>Net Cost</td>
					  <td></td>
					  <td><input type="text" id="net_total" name="net_total"  class="form-control text-right" disabled value="<?php echo $totalgross; ?>"></td>
					  </tr>
					  
                    </table>