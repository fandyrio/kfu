                <Button class="btn btn-xs btn-warning"  id="load_q" >Load</Button>
                <Button  class="btn btn-xs btn-primary"  id="add_q">Tambah</Button>
              
			 			   <table  class="table table-bordered table-striped">
                <thead>
                <tr>
                <th width="10px">No</th>
                  <th width="">Nama Brand</th>
                  <th width="">Jumlah</th>
                  <th width="">Satuan</th>
                  <th width="">Harga Unit</th>
                  <th width="">Disc. Amount</th>
                  <th width="">Gross</th>
                  <th width="">Nett</th>
                   <th></th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $no = 0;
                 $res=pg_query($dbconn,"Select q_ln_temp.*, inv_satuan.nama  as  \"nama_satuan\" from q_ln_temp  								
								INNER JOIN inv_satuan on inv_satuan.id=q_ln_temp.id_satuan 
								WHERE q_ln_temp.id_user='".$_SESSION['id_users']."'");

                 $totalgross = 0;
                 $totalnet = 0;

                 while ($row=pg_fetch_assoc($res)) {

                  $totalgross += $row["gross_total"];
                  $totalnet += $row["net_total"];
                  $no++;

                     ?>
                       <tr>
                        <td style="vertical-align:middle;"><?php echo $no ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                        <td style="vertical-align:middle;"><?php echo number_format($row["jumlah"] ,0,",","."); ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                        <td style="vertical-align:middle;"><?php echo number_format($row["harga_unit"] ,0,",","."); ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["disc_amount"] ?></td>
                        <td style="vertical-align:middle;"><?php echo number_format($row["gross_total"],0,',','.') ?></td>
                        <td style="vertical-align:middle;"><?php echo number_format($row["net_total"],0,',','.') ?></td>
						     <td class="text-center" style="vertical-align:middle;">
                            <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_quotation"><i class="icon-note"></i></a>
                            <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_quotation"><i class="icon-trash"></i></a>
                        </td>
                       
                        </tr>             
                 <?php } ?> 
                </tbody>
              </table>

                    <div class="col-md-12 text-right">
                        <div class="form-horizontal ">  
                            <div class="form-group row" >
                              <label for="jm" class="col-sm-8 ">Gross Total</label>
                               <div class="col-sm-4">
                                  <input type="text" name="tanggal_lahir" value="<?php echo  number_format($totalgross,0,',','.') ?>" placeholder="0" class="form-control text-right" readonly>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label  class="col-sm-8">Net Total</label>
                              <div class="col-sm-4">                     
                                  <input name="kode" class="form-control text-right" value="<?php echo  number_format($totalnet,0,',','.') ?>" placeholder="0" readonly>                    
                              </div>
                              </div>
                         </div>  
                  </div>
              