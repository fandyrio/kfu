  <?php 
      $result =pg_query($dbconn, "select inv_inventori.* , inv_nama_brand.nama as \"nama_brand\" , inv_satuan.nama as \"nama_satuan\" FROM inv_inventori 
        INNER JOIN inv_nama_brand on inv_nama_brand.id=inv_inventori.id_brand
        INNER JOIN inv_satuan on inv_satuan.id=inv_inventori.id_satuan");                             
 ?> 

<button class="btn-xs btn-danger" id="cancel_update_po">Cancel</button>
<button class="btn-xs btn-success" id="simpan_update_po_ln">Simpan</button>
            <form method="POST" enctype="multipart/form-data" id="update_po_ln">
              <input type="hidden" name="id_inv" id="inv_po">
             <input type="hidden" name='id_satuan' id="id_satuan_po">
             <input type="hidden" name='brand_nama' id="brand_nama_po">
              <div class="box-body form-horizontal">
              
              <div class="col-md-8">

                    <div class="row">
                     <div class="form-group">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-7">
                               <select name="brandnama_po" class='form-control' required>
                                
                                <option value=''>Pilih</option>
                                <?php 
                                while ($row =pg_fetch_assoc($result)){
                                  echo "<option value='".$row['id']."_".$row['nama_brand']."_".$row['nama_satuan']."_".$row['id_satuan']."'>".$row['nama_brand']."</option>";
                                }
                                ?>
                                </select>
                            </div>
                          </div>
                   
             

                        <div class="form-group">
                            <label  class="col-sm-2">Jumlah</label>
  						          <div class="col-sm-3">                     
                                 <input name='jumlah' id="jumlah_po" class='text-right  form-control'  required onkeyup="javascript:tandaPemisahTitik(this);">
                                
                            </div>
                            
                            <div class="col-sm-4">                     
                                
                                <input text="text" id="nama_satuan_po" name="nama_satuan" class='text-right  form-control' readonly>
                                
                            </div>
                          </div>
                          <div class="form-group">
                            <label  class="col-sm-2">Harga Unit</label>
                             <div class="col-sm-3">                     
                                <input id="harga_unit" name='harga_unit'  required class='form-control' onchange="count_on_jumlah_po()">
                                
                            </div>
                            
                                                 
                                <label  class="col-sm-1">Gross</label>
                								 <div class="col-sm-3">                     
                									<input id="gross_po" name='total_harga'  required class='form-control' readonly>
                									
                								</div>
                                            
                                          </div>
                						   <div class="form-group">
                                            <label  class="col-sm-2">Diskon</label>
                							<div class="col-xs-1">
                							<input id="check_diskon"  type="checkbox" checked name='check_diskon'>%
                							</div>
							
                             <div class="col-sm-2">                     
                                
                                <input id="persen_diskon" type="text" name='diskon_persen'  required class='form-control' onchange="count_on_jumlah_po()">
                                
                            </div>
                            
                                                 
                                <label  class="col-sm-1">Diskon Amt</label>
								 <div class="col-sm-3">                     
									<input id="diskon_amount" name='diskon_amt'  disabled class='form-control' onchange="count_on_jumlah_po()">
									
								</div>
                            
                          </div>
						  <div class="form-group">
                            <label  class="col-sm-2">Pajak</label>
							<div class="col-xs-1">
							<input id="check_pajak"  type="checkbox" checked name='check_pajak'>%
							</div>
							
                             <div class="col-sm-2">                     
                                
                                <input id="persen_pajak" type="text" name='pajak_persen'  required class='form-control' onchange="count_on_jumlah_po()">
                                
                            </div>
                            
                                                 
                                <label  class="col-sm-1">Pajak Amt</label>
								 <div class="col-sm-3">                     
									<input id="pajak_amount" name='pajak_amt'  class='form-control' disabled  onchange="count_on_jumlah_po()">
									
								</div>
                            
                          </div>
						  <div class="form-group">
                            <label  class="col-sm-2">Net Total</label>
                             <div class="col-sm-3">                     
                                <input id="net_po" name='nett_total'  readonly class='form-control'>
                                
                            </div>                            
                          </div>
						  <div class="form-group">
                            <label  class="col-sm-2">Komentar</label>
                             <div class="col-sm-7">                     
                                <input name='komen'  required class='form-control'>
                                
                            </div>                            
                          </div>
                          
              
               
                        </div>
                  </div>

                  </div>
</form>
             

             

           



               
                
          
   
          
              