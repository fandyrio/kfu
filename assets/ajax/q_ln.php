  <?php 
      $result =pg_query($dbconn, "select inv_inventori.* , inv_nama_brand.nama as \"nama_brand\" , inv_satuan.nama as \"nama_satuan\" FROM inv_inventori 
        INNER JOIN inv_nama_brand on inv_nama_brand.id=inv_inventori.id_brand
        INNER JOIN inv_satuan on inv_satuan.id=inv_inventori.id_satuan");                             
 ?>    
		  <div class="box-footer">
                <button type="submit" class="btn btn-xs btn-info" id="cancel_q">Cancel</button>
                <button type="submit" class="btn btn-xs btn-primary" id="simpan_q_ln">Simpan</button>
              </div>
			 <div class="box-body form-horizontal"> 
			 <div class="col-sm-8"> 
			<form id="quo" method="POST" enctype="multipart/form-data" action="">
			       <input type="hidden" name="id_inv" id="inv">
             <input type="hidden" name='id_satuan' id="id_satuan">
             <input type="hidden" name='brand_nama' id="brand_nama">
			<div class="form-group row">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-6">
                               
                                <select name="nama_brand" class='form-control' id="id_brand" required>
                                
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
                  <label  class="col-sm-2">Jumlah</label>

                  <div class="col-sm-3">                     
                      <input name='jumlah' id="jumlah_brand" class='text-right  form-control'  required onkeyup="javascript:tandaPemisahTitik(this);">
                      
                  </div>
				  <div class="col-sm-3">                     
                      <input text="text" id="nama_satuan" name="nama_satuan" class='text-right  form-control' readonly>
                  </div>
                </div>
			       <div class="form-group row">
                  <label  class="col-sm-2">Harga Unit</label>

                  <div class="col-sm-3">                     
                      <input name="harga" id="harga_unit" onchange="hargaFunction()" class='form-control text-right' placeholder="0" required>
                      
                      
                  </div>
             </div>
                  <div class="form-group row">
                  <label  class="col-sm-2">Diskon</label>

                  <div class="col-sm-2">                     
                      <input name="diskon" id="diskon_unit" onchange="discFunction()" class='form-control text-right' placeholder="0"  required>
                      
                      
                  </div>
             </div>
			 <div class="form-group row">
                  <label  class="col-sm-2">Gross Unit</label>

                  <div class="col-sm-2">                     
                      <input name='gross' id="gross_unit" class='form-control text-right'  readonly placeholder="0" required >
                      
                      
                  </div>
             </div>
			 <div class="form-group row">
                  <label  class="col-sm-2">Nett Unit</label>

                  <div class="col-sm-2">                     
                      <input name='net' id="net_unit" class='form-control text-right'   readonly placeholder="0">

                      <input type="hidden" name='net_price' id="net_price" class='form-control text-right'   readonly placeholder="0" required>
                      
                      
                  </div>
             </div>
			 </form>
            </div>
            </div>
			