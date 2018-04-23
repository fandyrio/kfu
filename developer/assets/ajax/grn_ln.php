                <!-- <button  id="grn_load" class="btn-xs btn-warning">Load</button> -->
                <button name="btn" class=" btn-warning btn-xs" id="grn_load" data-backdrop="static" data-toggle="modal" data-target="#confirm-submit">Load</button>
                <button  id="add_grn" class="btn-xs btn-primary">Tambah</button>
                  <table id="grn_ln_loader" class="table table-bordered table-striped">
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
                       $res=pg_query($dbconn,"Select grn_ln_temp.*, inv_satuan.nama  as  \"nama_satuan\" from grn_ln_temp
                       INNER JOIN inv_satuan on inv_satuan.id=grn_ln_temp.id_satuan WHERE grn_ln_temp.id_users='".$_SESSION['id_users']."'");

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						 //$jum +=;
						$totalgross += $row["gross_total"];
                           ?>
                             <tr id="<?php echo $row['id']; ?>" data="<?php echo $row['id_satuan']."_".$row['nama_satuan']; ?>" nama="<?php echo $row['nama_brand']; ?>" style="td {color: blue; background: white !important; }">
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
                                          <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_grn_ln"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                          <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_grn_ln"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
              							</td>
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
					  
                    </table>

                <div class="row">
                  <div class="col-md-6 text-left">                   
                  </div>
                    <div class="col-md-6 text-right">

                    
              	
                        <div class="box-body form-horizontal "> 

                           	<div class="form-group " >
                              <label for="jm" class="col-sm-2 text-left">Gross Total</label>
                               <div class="col-sm-7 text-right">
                                  <input id="gross_total"  type="text" name="gross_total" value="<?php echo $totalgross; ?>" placeholder="0" class="form-control text-right" readonly>
                              </div>
                            </div>
                            <div class="form-group " >
                              <label for="jm" class="col-sm-2 text-left">Diskon %</label>
                               <div class="col-sm-10">
                                  	<input id="check_diskon" class="col-md-1" type="checkbox" checked name='check_diskon' >
                                  	<div class="col-sm-5">
									<input id="persen_diskon"  class=" form-control"  type="text" name='disc_persen' onchange="hitung_net_cost()" >
									</div>
									   <div class="col-sm-5">
		                              <input id="diskon_amount" name='disc_amount'  disabled  onchange="hitung_net_cost()" class="form-control">
		                            </div>
											
                              </div>
                           
                            </div>

                             <div class="form-group " >
                              <label for="jm" class="col-sm-2 text-left">Pajak %</label>
                               <div class="col-sm-10">
                                  	<input id="check_pajak" class="col-md-1" type="checkbox" checked name='check_pajak'>
                                  	<div class="col-sm-5">
									<input id="persen_pajak" type="text" name='persen_pajak' class=" form-control"   onchange="hitung_net_cost()">
									</div>
									   <div class="col-sm-5">
		                               <input id="pajak_amount" name='pajak_amount'   disabled  onchange="hitung_net_cost()" class="form-control"> 
		                            </div>
											
                              </div>
                           
                            </div>

                             <div class="form-group " >
                              <label for="jm" class="col-sm-2 text-left">Net Cost</label>
                                <div class="col-sm-7 text-right">
                                  	<input type="text" id="net_total" name="net_total"  class="form-control text-right" readonly value="<?php echo $totalgross; ?>">	
                              </div>
                           
                            </div>

 


                            </div>
					 
					   </div>
					   </div>


          <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              

              <div class="modal-dialog" role="document" >
                  <div class="modal-content">

                   <div class="modal-body" style="text-align:left">

              </div>
                    <div class="modal-footer">                    

                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">BATAL</button>
                    </div>
                  </div>
              </div>
          </div>

			
			