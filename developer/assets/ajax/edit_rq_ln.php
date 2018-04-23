<?php 
       $id=$_GET['id'];
       $result =pg_query($dbconn, " Select rq_ln_temp.*, inv_satuan.nama as \"nama_satuan\" from rq_ln_temp
                       INNER JOIN inv_satuan on inv_satuan.id=rq_ln_temp.id_satuan WHERE rq_ln_temp.id= $id"); 
        
        $data = pg_fetch_array($result);                            
 ?>

<button class="btn-xs btn-danger" id="cancel_rq">Cancel</button>
<button class="btn-xs btn-success" id="simpan_edit_rq_ln">Simpan</button>
            <form method="POST" enctype="multipart/form-data" id="edit_rquo">
              <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
             <input type="hidden" name="id_inv" value="<?php echo $data['id_inv'] ?>" id="inv">
             <input type="hidden" name='id_satuan' value="<?php echo $data['id_satuan'] ?>"  id="id_satuan">
             <input type="hidden" name='brand_nama' value="<?php echo $data['nama_brand'] ?>" id="brand_nama">
              <div class="box-body form-horizontal">
              
              <div class="col-md-8">

                    <div class="row">
                     <div class="form-group">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-6">
                               
                                <select name="nama_brand" class='form-control' required>
                                
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
                          <label  class="col-sm-2" >Jumlah</label>

                          <div class="col-sm-6">                     
                              <input name='jumlah' value="<?php echo $data["jumlah"] ?>"  required>
                              <input id="nama_satuan" width="10px" value="<?php echo $data["nama_satuan"] ?>" placeholder="satuan" readonly>             
                          </div>
                          </div>
                          
              
               
                        </div>
                  </div>

                  </div>
</form>