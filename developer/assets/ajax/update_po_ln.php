                <button  id="load_po" class="btn-xs btn-warning">Load</button>
                <button  id="update_add_po" class="btn-xs btn-primary">Tambah</button>
                  <table  class="table table-bordered table-striped">
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
                       $res=pg_query($dbconn,"Select po_ln.*, inv_satuan.nama  as  \"nama_satuan\" from po_ln
                       INNER JOIN inv_satuan on inv_satuan.id=po_ln.id_satuan 
                        WHERE po_ln.id_hdr='".$_SESSION['id_po_hdr']."'");


                       $nett_total =0;
                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						 //$jum +=;
                          $nett_total += $row["nett_total"];
                           ?>
                             <tr>
                              <td style="vertical-align:middle;"><?php echo $no ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_brand"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["jumlah"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["harga_unit"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["total_harga"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["diskon_amt"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["pajak_amt"] ?></td>
                              <td style="vertical-align:middle;"><?php echo $row["nett_total"] ?></td>
                          <td class="text-center" style="vertical-align:middle;">
                            <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_po"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_update_po"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>
                             
                              </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
					 
                    </table>
              <div class="row">
                  <div class="col-md-6 text-left">                   
                  </div>
                    <div class="col-md-6 text-right">
                       <div class="box-body">
                        <div class="box-body form-horizontal ">  
                         <div class="col-md-6 text-left">                  
                              </div>
                           <div class="col-md-6 text-right">

                            <div class="form-group">
                              <label  class="col-sm-5">Net Cost</label>
                              <div class="col-sm-7">                     
                                  <input name="kode" class="form-control text-right" value="<?php echo  number_format($nett_total,0,',','.') ?>" placeholder="0" readonly>                    
                              </div>
                              </div>
                              </div>
                         </div>              
                      </div>
                  </div>
                  </div>
			
			