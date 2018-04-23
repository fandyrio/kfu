 <div class="col-md-12 mb-4 angel">
       <ul class="nav nav-tabs" role="tablist">
         <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Add Quantity</a>
          </li>
       </ul>

  <div class="tab-content">
  <div class="tab-pane active" id="home" role="tabpanel">
                   

<?php 
      $result =pg_query($dbconn, "select inv_inventori.* , inv_nama_brand.nama as \"nama_brand\" , inv_satuan.nama as \"nama_satuan\" FROM inv_inventori 
        INNER JOIN inv_nama_brand on inv_nama_brand.id=inv_inventori.id_brand
        INNER JOIN inv_satuan on inv_satuan.id=inv_inventori.id_satuan");                             
 ?>  

<button class="btn btn-xs btn-danger" id="cancel_trf_batch">Cancel</button>
<button name="btn" class="btn btn-warning btn-xs" id="trf_load_batch" >Simpan</button>
            <form method="POST" class="form-horizontal" enctype="multipart/form-data" id="trf_ln">
            <input type="hidden" name="id_inv" id="inv_trf">
             <input type="hidden" name='id_satuan' id="id_satuan_trf">
             <input type="hidden" name='brand_nama' id="brand_nama_trf">
             
             <div class="card-block">
              
              <div class="col-md-8">

                     <div class="form-group row">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-6">
                               
                                <select name="nama_brand_batch" class='form-control' required>
                                
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
                      <input name='jumlah' class='text-right  form-control' onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);count_adj();"  >
                      
                  </div>
                    <div class="col-sm-3">                     
                      <input text="text" id="nama_satuan_trf" name="nama_satuan" class='text-right  form-control' readonly>
                            </div>
                    </div>


                    <div class="form-group row">
                         <label  class="col-sm-2">Remark</label>
                           <div class="col-sm-3">                     
                          <input name='remark' class='form-control text-right'>
                           </div>                            
                     </div>


                    </div>

                  </div>
                  </form>
			  
              </div>
			  
      				</div>			  
      				</div>



           <div id="mit_pop_up" class="melayang" >
            <div class="melayang-content">
              <span class="close">&times;</span>
               <div class="form-horizontal" >
                <div class="card-block">
              <div class="row resultload">   </div>          
            </div>
            </div>
            <div class="modal-footer">  
              <button type="button" class="btn btn-sm btn-warning" id="save_batch_trf" >oke</button>
              </div>
              </div>
            </div>