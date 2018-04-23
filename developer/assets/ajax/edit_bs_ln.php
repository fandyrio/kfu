 <?php

  $id=$_GET['id'];
  $sql = pg_query($dbconn,"Select stok_buka_qty_temp.*, inv_satuan.nama as \"nama_satuan\" from stok_buka_qty_temp
                       INNER JOIN inv_satuan on inv_satuan.id=stok_buka_qty_temp.id_satuan WHERE stok_buka_qty_temp.id= $id");
  $data = pg_fetch_array($sql);


?>     
		  <div class="box-footer text-right">
                <button type="submit" class="btn-xs btn-info" id="cancel_bs_ln">Cancel</button>
                <button type="submit" class="btn-xs btn-primary" id="simpan_edit_bs_ln">Simpan</button>
              </div>
			 <div class="box-body form-horizontal"> 
			 <div class="col-sm-8"> 
			<form id="edit_bs_ln" method="POST" enctype="multipart/form-data" action="">
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
                      <input name='qty' id="jumlah_grn" class='text-right  form-control'  value="<?php echo $data['qty']; ?>" onchange="count_on_jumlah_grn()">
                      
                  </div>
          <div class="col-sm-3">                     
                      <input text="text" id="nama_satuan" name="nama_satuan" class='text-right  form-control' readonly value="<?php echo $data['nama_satuan']; ?>">
                  </div>
                </div>
                 <div class="form-group">
                            <label  class="col-sm-2">Harga Unit</label>
                             <div class="col-sm-3">                     
                                <input id="harga_unit" name='harga_unit'  value="<?php echo $data['harga_unit']; ?>" class='form-control' onchange="count_on_jumlah_grn()">
                                
                            </div>
                            
                  </div>
           <div class="form-group">
                            <label  class="col-sm-2">Total Cost</label>
                             <div class="col-sm-3">                     
                                <input id="net_grn" name='total_cost'  readonly class='form-control' value="<?php echo $data['totalcost']; ?>">
                                
                            </div>
                            
                  </div>
               
              <div class="form-group">
                            <label  class="col-sm-2">Komen</label>
                             <div class="col-sm-3">                     
                                <input name='komentar'   class='form-control' value="<?php echo $data['komentar']; ?>">
                                
                            </div>                            
                          </div>
              
                          
              
               
                        </div>
			 </form>
            </div>
            </div>
			