                <button  id="load_po" class="btn btn-xs btn-warning">Load</button>
                <button  id="add_po" class="btn btn-xs btn-primary">Tambah</button>
                  <table  class="table ">
                      <thead>
                      <tr>
                      <th width="10px">No</th>
                        <th width="">Nama Brand</th>
                        <th width="">Jumlah</th>
                        <th width="">Satuan</th>
                        <th width="">Harga Unit</th>
                        <th width="">Gross</th>
                        <th width="">Discount</th>
                        <th width="">Tax</th>
                        <th width="">Nett</th>
                         <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $jum = 0;
                       $res=pg_query($dbconn,"Select po_ln_temp.*, inv_satuan.nama  as  \"nama_satuan\"from po_ln_temp
                       INNER JOIN inv_satuan on inv_satuan.id=po_ln_temp.id_satuan WHERE po_ln_temp.id_users='".$_SESSION['id_users']."'");

                        $jlh = pg_num_rows($res);
                       $nett_total =0;
                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						 //$jum +=;
                          $nett_total += $row["nett_total"];
                           ?>
                             <tr>
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                              <td style="vertical-align:middle;"><?php echo number_format($row["jumlah"] ,0,",",".");  ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo number_format($row["harga_unit"] ,0,",","."); ?></td>
                              <td style="vertical-align:middle;"><?php echo number_format($row["total_harga"] ,0,",","."); ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["diskon_amt"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["pajak_amt"] ?></td>
                              <td style="vertical-align:middle;"><?php echo number_format($row["nett_total"] ,0,",","."); ?></td>
                          <td class="text-center" style="vertical-align:middle;">
                            <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_po"><i class="icon-note"></i></a>
                            <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_po"><i class="icon-trash"></i></a>
                        </td>
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
                      <input type="hidden" id="jlh_ln" value="<?php echo $jlh ?>">
					 
                    </table>


                 <div class="col-md-12 text-right">
                        <div class="form-horizontal ">

                            <div class="form-group row">
                              <label  class="col-sm-8">Net Cost</label>
                              <div class="col-sm-4">                     
                                  <input name="kode" class="form-control text-right" value="<?php echo  number_format($nett_total,0,',','.') ?>" placeholder="0" readonly>                    
                              </div>
                              </div>
                              </div>
              </div>              
                  
			
			