 <?php

  $id=$_GET['id'];
  $sql = pg_query($dbconn,"Select q_ln_temp.*, inv_satuan.nama as \"nama_satuan\" from q_ln_temp
                       INNER JOIN inv_satuan on inv_satuan.id=q_ln_temp.id_satuan WHERE q_ln_temp.id= $id");
  $data = pg_fetch_array($sql);


?>     
		  <div class="box-footer text-right">
                <button type="submit" class="btn-xs btn-info" id="cancel_q">Cancel</button>
                <button type="submit" class="btn-xs btn-primary" id="simpan_edit_q_ln">Simpan</button>
              </div>
			 <div class="box-body form-horizontal">


           
      			<form id="edit_quo" class="form-horizontal" method="POST" enctype="multipart/form-data" action="">
      			<input type="hidden" name="id" value="<?php echo $id ?>">
      			<input type="hidden" name="id_inv" value="<?php echo $data['id_inv'] ?>" id="inv">
                   <input type="hidden" name='id_satuan' value="<?php echo $data['id_satuan'] ?>"  id="id_satuan">
                   <input type="hidden" name='brand_nama' value="<?php echo $data['nama_brand'] ?>" id="brand_nama">

                   <div class="card-block">
                     <div class="col-sm-8"> 
              			<div class="form-group row">
                                <label class="col-sm-3">Nama Brand </label>

                        <div class="col-sm-5">
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
            			<div class="form-group row">
                              <label  class="col-sm-3">Jumlah</label>

                              <div class="col-sm-3">                     
                                  <input name='jumlah' id="jumlah_brand" value="<?php echo $data['jumlah'] ?>" class='form-control text-right'  required >
            				</div>
            				<div class="col-sm-2 row"> 
                                  <input id="nama_satuan" type="text" name='nama_satuan' value="<?php echo $data["nama_satuan"] ?>"  readonly class='form-control'>                     
                                  
                   </div>
                      </div>
      			       <div class="form-group row row">
                        <label  class="col-sm-3">Harga Unit</label>

                        <div class="col-sm-3">                     
                            <input name="harga" id="harga_unit" onchange="hargaFunction()" value="<?php echo $data['harga_unit'] ?>" class='form-control text-right' placeholder="0" >
                            
                            
                        </div>
                   </div>
                        <div class="form-group row">
                        <label  class="col-sm-3">Diskon</label>

                        <div class="col-sm-3">                     
                            <input name="diskon" id="diskon_unit" onchange="discFunction()" value="<?php echo $data['disc_amount'] ?>" class='form-control text-right' placeholder="0"  >
                            
                            
                        </div>
                         </div>
            			 <div class="form-group row">
                              <label  class="col-sm-3">Gross Unit</label>

                              <div class="col-sm-3">                     
                                  <input name='gross' id="gross_unit" class='form-control text-right' value="<?php echo $data['gross_total'] ?>"  readonly placeholder="0" >
                                  
                                  
                              </div>
                         </div>
            			 <div class="form-group row">
                        <label  class="col-sm-3">Nett Unit</label>

                        <div class="col-sm-3">                     
                            <input name='net' id="net_unit" class='form-control text-right' value="<?php echo $data['net_total'] ?>"   readonly placeholder="0">

                            <input type="hidden" name='net_price' id="net_price" class='form-control text-right'   readonly placeholder="0">
                            
                            
                        </div>
                   </div>
                   </div>
                   </div>

			     </form>
            </div>
            </div>
			