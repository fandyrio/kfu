<?php 
      $result =pg_query($dbconn, "select inv_inventori.* , inv_nama_brand.nama as \"nama_brand\" , inv_satuan.nama as \"nama_satuan\" FROM inv_inventori 
        INNER JOIN inv_nama_brand on inv_nama_brand.id=inv_inventori.id_brand
        INNER JOIN inv_satuan on inv_satuan.id=inv_inventori.id_satuan");                             
 ?> 

<button class="btn-xs btn-danger" id="cancel_retur_add_ln">Cancel</button>
<button class="btn-xs btn-success" id="simpan_retur_ln" data-backdrop="static" data-toggle="modal" data-target="#confirm-submit">Simpan</button>
            <form method="POST" enctype="multipart/form-data" id="retur_ln">
              <input type="hidden" name="id_inv" id="inv">
             <input type="hidden" name='id_satuan' id="id_satuan">
             <input type="hidden" name='brand_nama' id="brand_nama">
             
              <div class="box-body form-horizontal">
              
              <div class="col-md-8">

                    <div class="row">
                    <div class="form-group">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-6">
                               
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
                   
             

                        <div class="form-group">
                            <label  class="col-sm-2">Qty</label>
  						          <div class="col-sm-3">                     
                                <input id="jumlah_po" name='jumlah'  required class='form-control' onchange="count_on_jumlah_po()">
                                
                            </div>
                            
                            <div class="col-sm-3">                     
                            <input text="text" id="nama_satuan" name="nama_satuan" class='text-right  form-control' readonly>
                          </div>
                          </div>
                          <div class="form-group">
                            <label  class="col-sm-2">Cost</label>
                             <div class="col-sm-3">                     
                                <input  name='cost'  readonly class='form-control' >
                                
                            </div>
                            
                          </div>
						  
						  
						  <div class="form-group">
                            <label  class="col-sm-2">Tgl Expired</label>
                             <div class="col-sm-3">                     
                                <input  name='tgl_expired' id="datepicker2"  value="<?php echo date('Y-m-d') ?>" class='form-control'>
                                
                            </div>                            
                          </div>
						   <div class="form-group">
                            <label  class="col-sm-2">Tgl Manufactureds</label>
                             <div class="col-sm-3">                     
                                <input  name='tgl_manufactured'  id="datepicker" value="<?php echo date('Y-m-d') ?>" class='form-control'>
                                
                            </div>                            
                          </div>
						  
                          
              
               
                        </div>
                  </div>

                  </div>
</form>
<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              
              <div class="modal-dialog" role="document" style="width: 700px">
                  <div class="modal-content">

                   <div class="modal-body" style="text-align:left">

                    </div>
                    <div class="modal-footer">                    
                    <button type="button" class="btn btn-sm btn-warning" id="save_batch_retur">oke</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">BATAL</button>
                    </div>
                  </div>
              </div>
          </div>
             

             

           



               
                
          
   
          
              