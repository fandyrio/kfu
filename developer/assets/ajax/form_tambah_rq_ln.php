<?php 
      $result =pg_query($dbconn, "select inv_inventori.* , inv_nama_brand.nama as \"nama_brand\" , inv_satuan.nama as \"nama_satuan\" FROM inv_inventori 
        INNER JOIN inv_nama_brand on inv_nama_brand.id=inv_inventori.id_brand
        INNER JOIN inv_satuan on inv_satuan.id=inv_inventori.id_satuan");                             
 ?>

<button class="btn-xs btn-danger" id="cancel_form_rq">Cancel</button>
<button class="btn-xs btn-success" id="simpan_form_rq_ln">Simpan</button>
 
            <form method="POST" enctype="multipart/form-data" id="form_rquo">
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
                          <label  class="col-sm-2">Jumlah</label>

                          <div class="col-sm-6">                     
                              <input name='jumlah'  required>
                              <input id="nama_satuan" width="10px" placeholder="satuan" readonly>             
                          </div>
                          </div>
                          
              
               
                        </div>
                  </div>

                  </div>
</form>
             

             

           



               
                
          
   
          
              