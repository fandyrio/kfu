 <?php

  $id=$_GET['id'];
  $sql = pg_query($dbconn,"Select grn_ln_temp.*, inv_satuan.nama as \"nama_satuan\" from grn_ln_temp
                       INNER JOIN inv_satuan on inv_satuan.id=grn_ln_temp.id_satuan WHERE grn_ln_temp.id= $id");
  $data = pg_fetch_array($sql);


?>     
		  <div class="box-footer text-right">
                <button type="submit" class="btn-xs btn-info" id="cancel_grn_ln">Cancel</button>
                <button type="submit" class="btn-xs btn-primary" id="simpan_edit_grn_ln">Simpan</button>
              </div>
			 <div class="box-body form-horizontal"> 
			 <div class="col-sm-8"> 
			<form id="edit_grn_ln" method="POST" enctype="multipart/form-data" action="">
			<input type="hidden" name="id" value="<?php echo $id ?>">
			<input type="hidden" name="id_inv" value="<?php echo $data['id_inv'] ?>" id="inv">
             <input type="hidden" name='id_satuan' value="<?php echo $data['id_satuan'] ?>"  id="id_satuan">
             <input type="hidden" name='brand_nama' value="<?php echo $data['nama_brand'] ?>" id="brand_nama">
			<div class="form-group">
                  <label class="col-sm-2">Nama Brand </label>

                  <div class="col-sm-7">
                      <select name='nama_brand' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                     <?php
                                 $res =pg_query($dbconn, "select inv_inventori.* , inv_nama_brand.nama as \"nama_brand\" , inv_satuan.nama as \"nama_satuan\" FROM inv_inventori 
                                    INNER JOIN inv_nama_brand on inv_nama_brand.id=inv_inventori.id_brand
                                    INNER JOIN inv_satuan on inv_satuan.id=inv_inventori.id_satuan"); 

                                while ($row =pg_fetch_assoc($res)){

                                   if($data['nama_brand']== $row['nama_brand']){
                                        echo "<option value='".$data['id']."_".$data['nama_brand']."_".$data['nama_satuan']."_".$data['id_satuan']."' selected>".$row['nama_brand']."</option>";
                                      }else{
                                  echo "<option value='".$row['id']."_".$row['nama_brand']."_".$row['nama_satuan']."_".$row['id_satuan']."'>".$row['nama_brand']."</option>";
                                }
                                }
                                ?>
                      </select>
                     
                  </div>
            </div>
			<div class="form-group">
                  <label  class="col-sm-2">Jumlah</label>

                  <div class="col-sm-3">                     
                      <input name='qty' id="jumlah_grn" class='text-right  form-control'  value="<?php echo $data['qty'] ?>" onchange="count_on_jumlah_grn()">
                      
                  </div>
				  <div class="col-sm-4">                     
                      <input text="text" id="nama_satuan" name="nama_satuan" class='text-right  form-control' readonly value="<?php echo $data['nama_satuan'] ?>">
                  </div>
                </div>
                 <div class="form-group">
                            <label  class="col-sm-2">Harga Unit</label>
                             <div class="col-sm-3">                     
                                <input id="harga_unit" name='harga_unit'  value="<?php echo $data['harga_unit'] ?>" class='form-control' onchange="count_on_jumlah_grn()">
                                
                            </div>
                            
                                                 
                                <label  class="col-sm-1">Gross</label>
								 <div class="col-sm-3">                     
									<input id="gross_po" name='gross_total'  value="<?php echo $data['gross_total'] ?>" class='form-control' readonly>
									
								</div>
                            
                  </div>
						   <div class="form-group">
                            <label  class="col-sm-2">Diskon</label>
							<div class="col-xs-1">
							<input id="check_diskon"  type="checkbox" checked name='check_diskon'>%
							</div>
							
                             <div class="col-sm-2">                     
                                
                                <input id="persen_diskon" type="text" name='diskon_persen'  value="<?php echo $data['diskon_persen'] ?>" class='form-control' onchange="count_on_jumlah_grn()">
                                
                            </div>
                            
                                                 
                                <label  class="col-sm-1">Diskon Amt</label>
								 <div class="col-sm-3">                     
									<input value="<?php echo $data['diskon_amount'] ?>" id="diskon_amount" name='diskon_amount'  disabled class='form-control' onchange="count_on_jumlah_grn()">
									
								</div>
                            
                          </div>
						  <div class="form-group">
                            <label  class="col-sm-2">Pajak</label>
							<div class="col-xs-1">
							<input id="check_pajak"  type="checkbox" checked name='check_pajak'>%
							</div>
							
                             <div class="col-sm-2">                     
                                
                                <input id="persen_pajak" type="text" name='pajak_persen'  value="<?php echo $data['pajak_persen'] ?>" class='form-control' onchange="count_on_jumlah_grn()">
                                
                            </div>
                            
                                                 
                                <label  class="col-sm-1">Pajak Amt</label>
								 <div class="col-sm-3">                     
									<input value="<?php echo $data['pajak_amount'] ?>" id="pajak_amount" name='pajak_amount'  class='form-control' disabled  onchange="count_on_jumlah_grn()">
									
								</div>
                            
                          </div>
						  <div class="form-group">
                            <label  class="col-sm-2">Net Total</label>
                             <div class="col-sm-3">                     
                                <input id="net_grn" name='nett_total'  readonly class='form-control' value="<?php echo $data['nett_total'] ?>">
                                
                            </div>                            
                          </div>
			 </form>
            </div>
            </div>
			