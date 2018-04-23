  <?php 
  $id=$_GET['id'];
  $sql = pg_query($dbconn,"Select po_ln_temp.*, inv_satuan.nama as \"nama_satuan\" from po_ln_temp
                       INNER JOIN inv_satuan on inv_satuan.id=po_ln_temp.id_satuan WHERE po_ln_temp.id= $id");
  $data = pg_fetch_array($sql);
                          
 ?> 

<button class="btn-xs btn-danger" id="cancel_po">Cancel</button>
<button class="btn-xs btn-success" id="simpan_edit_po_ln">Simpan</button>
            <form method="POST" enctype="multipart/form-data" id="edit_po_ln">
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
            <input type="hidden" name="id_inv" value="<?php echo $data['id_inv'] ?>" id="inv_po">
            <input type="hidden" name='id_satuan' value="<?php echo $data['id_satuan'] ?>" id="id_satuan_po">
            <input type="hidden" name='brand_nama' value="<?php echo $data['nama_brand'] ?>" id="brand_nama_po">
              <div class="box-body form-horizontal">
              
              <div class="col-md-8">

                    <div class="row">
                     <div class="form-group">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-7">
                               <select name="brandnama_po" class='form-control' required>
                                
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
                                  <input name='jumlah' id="jumlah_po" value="<?php echo $data['jumlah'] ?>" class='form-control text-right'  required >
                                
                            </div>
                            
                            <div class="col-sm-4">                     
                                
                                 <input id="nama_satuan_po" type="text" name='nama_satuan' value="<?php echo $data['nama_satuan'] ?>" readonly class='form-control'>
                                
                            </div>
                          </div>
                          <div class="form-group">
                            <label  class="col-sm-2">Harga Unit</label>
                             <div class="col-sm-3">                     
                                <input id="harga_unit" name='harga_unit' value="<?php echo $data['harga_unit'] ?>"  required class='form-control' onchange="count_on_jumlah_po()">
                                
                            </div>
                            
                                                 
                                <label  class="col-sm-1">Gross</label>
            								 <div class="col-sm-3">                     
            									<input id="gross_po" name='total_harga' value="<?php echo $data['total_harga'] ?>"  required class='form-control' readonly>
            									
            								</div>
                                        
                                      </div>
            						   <div class="form-group">
                                        <label  class="col-sm-2">Diskon</label>
            							<div class="col-xs-1">
            							<input id="check_diskon"  type="checkbox" " checked name='check_diskon'>%
            							</div>
							
                             <div class="col-sm-2">                     
                                
                                <input id="persen_diskon" type="text" value="<?php echo $data['diskon_persen'] ?>" name='diskon_persen'  required class='form-control' onchange="count_on_jumlah_po()">
                                
                            </div>
                            
                                                 
                                <label  class="col-sm-1">Diskon Amt</label>
              								 <div class="col-sm-3">                     
              									<input id="diskon_amount" name='diskon_amt' value="<?php echo $data['diskon_amt'] ?>" disabled class='form-control' onchange="count_on_jumlah_po()">
    									
              								</div>
                                      
                                    </div>
                						  <div class="form-group">
                                            <label  class="col-sm-2">Pajak</label>
                							<div class="col-xs-1">
                							<input id="check_pajak"  type="checkbox" checked name='check_pajak'>%
                							</div>
          							
                                       <div class="col-sm-2">                     
                                          
                                          <input id="persen_pajak" type="text" name='pajak_persen' value="<?php echo $data['pajak_persen'] ?>"  required class='form-control' onchange="count_on_jumlah_po()">
                                          
                                      </div>
                                      
                                                           
                                          <label  class="col-sm-1">Pajak Amt</label>
          								 <div class="col-sm-3">                     
          									<input id="pajak_amount" name='pajak_amt' value="<?php echo $data['pajak_amt'] ?>" class='form-control' disabled  onchange="count_on_jumlah_po()">
          									
          								</div>
                                      
                                    </div>
          						  <div class="form-group">
                                      <label  class="col-sm-2">Net Total</label>
                                       <div class="col-sm-3">                     
                                          <input id="net_po" name='nett_total' value="<?php echo $data['nett_total'] ?>"  readonly class='form-control'>
                                          
                                      </div>                            
                                    </div>
          						  <div class="form-group">
                                      <label  class="col-sm-2">Komentar</label>
                                       <div class="col-sm-7">                     
                                          <input name='komen' value="<?php echo $data['komen'] ?>"  required class='form-control'>
                                          
                                      </div>                            
                                    </div>
                                    
                        
                         
                                  </div>
                            </div>

                            </div>
</form>
             

             

           



               
                
          
   
          
              