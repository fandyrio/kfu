 <?php 
      $result =pg_query($dbconn, "select inv_inventori.* , inv_nama_brand.nama as \"nama_brand\" , inv_satuan.nama as \"nama_satuan\" FROM inv_inventori 
        INNER JOIN inv_nama_brand on inv_nama_brand.id=inv_inventori.id_brand
        INNER JOIN inv_satuan on inv_satuan.id=inv_inventori.id_satuan");                             
 ?>  

<button class="btn btn-xs btn-danger" id="cancel_grn_ln">Cancel</button>
<button class="btn btn-xs btn-success" id="simpan_grn_ln">Simpan</button>
            <form method="POST" class="form-horizontal" enctype="multipart/form-data" id="grn_ln">
			       <input type="hidden" name="id_inv" id="inv">
             <input type="hidden" name='id_satuan' id="id_satuan">
             <input type="hidden" name='brand_nama' id="brand_nama">
             
              <div class="card-block">
              <div class="row">
              <div class="col-md-8">

                    
                     <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Nama Brand</label>

                            <div class="col-sm-7">
                               
                                <select name="nama_brand" class='form-control' required>                          
                               <option value=''>Pilih</option>
                                <?php 
                                while ($row =pg_fetch_assoc($result)){
                                  echo "<option value='".$row['id']."_".$row['nama_brand']."_".$row['nama_satuan']."_".$row['id_satuan']."'>".$row['nama_brand']."</option>";
                                }
                                ?>
                                </select>
                            </div>
                      </div>
                   
             

                  <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Jumlah <span class="ingatan">*</span></label>

                  <div class="col-sm-3 ">                     
                      <input name='qty' id="jumlah_grn" class='text-right  form-control'   onchange="count_grn()" required>
                      
                  </div>
				            <div class="col-sm-4">                     
                      <input text="text" id="nama_satuan" name="nama_satuan" class='text-right  form-control' readonly>
                  </div>
                </div>
                 <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Harga Unit <span class="ingatan">*</span></label>
                             <div class="col-sm-3"> 
                    <input id="harga_unit" name='harga_unit'  required class='form-control text-right' onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);count_grn();" >
                             <!-- <input id="harga_unit" name='harga_unit'  required class='form-control' onchange="count_grn()"> -->
                                
                            </div>
                            
                                                 
                  <label  class="col-sm-1 form-control-label">Gross</label>
								 <div class="col-sm-3">                     
									<input id="gross_po" name='gross_total'  type="hidden" class='form-control text-right' readonly>
                  <input id="gross_po_show" name='gross_po_show' readonly  class='form-control text-right'>
									
								</div>
                            
                  </div>
						   <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Diskon</label>
							<div class="col-sm-1">
							<input id="check_diskon"  type="checkbox" checked name='check_diskon'>%
							</div>
							
              <div class="col-sm-2">
              <input id="persen_diskon" type="text" name='diskon_persen'  required class='form-control text-right' onchange="count_grn()">
                                
              </div>
                            
                                                 
                  <label  class="col-sm-2 form-control-label">Diskon Amt</label>
								 <div class="col-sm-2">                     
									<input id="diskon_amount" name='diskon_amount'  disabled class='form-control text-right' onchange="count_grn()">
									
								</div>
                            
                          </div>
						  <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Pajak</label>
							<div class="col-sm-1">
							<input id="check_pajak"  type="checkbox" checked name='check_pajak'>%
							</div>
							
                             <div class="col-sm-2">                     
                                
                                <input id="persen_pajak" type="text" name='pajak_persen'  required class='form-control text-right' onchange="count_grn()">
                                
                            </div>
                            
                                                 
                  <label  class="col-sm-2 form-control-label">Pajak Amt</label>
								 <div class="col-sm-2">                     
									<input id="pajak_amount" name='pajak_amount'  class='form-control text-right' disabled  onchange="count_grn()">
									
								</div>
                            
                          </div>
						  <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Net Total</label>
                             <div class="col-sm-7">                     
                                <input id="net_grn" name='nett_total'  type="hidden" class='form-control'>
                                 <input id="net_grn_show" name='nett_total_show'  readonly class='form-control text-right'>

                                <input id="harga_bersih" name='harga_bersih'  type="hidden" class='form-control'>
                                
                            </div>                            
                          </div>
						  
                          
              
               
                        </div>
                  </div>

                  </div>
</form>
             

             

           



               
                
          
   
          
              