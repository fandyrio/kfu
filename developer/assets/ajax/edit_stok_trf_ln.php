   <?php 
  $id=$_GET['id'];
  $sql = pg_query($dbconn,"Select stok_trf_ln_temp.*, inv_satuan.nama as \"nama_satuan\" from stok_trf_ln_temp
                       INNER JOIN inv_satuan on inv_satuan.id=stok_trf_ln_temp.id_satuan WHERE stok_trf_ln_temp.id= $id");
  $data = pg_fetch_array($sql);
                          
 ?> 

          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Add Quantity</a></li>
			 
              <!--li><a href="#tab_3" data-toggle="tab">Costing</a></li-->
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">  
                <div class="box-footer text-left"> 

<button class="btn-xs btn-danger" id="cancel_trf_batch">Cancel</button>
<button name="btn" class=" btn-warning btn-xs" id="edit_trf_load_batch" data-backdrop="static" data-toggle="modal" data-target="#confirm-submit">Simpan</button>
            <form method="POST" enctype="multipart/form-data" id="edit_trf_ln">
            <input type="hidden" name="id" id="id_ln" value="<?php echo $data['id'] ?>">
            <input type="hidden" name="id_inv" value="<?php echo $data['id_inv'] ?>" id="inv_trf">
            <input type="hidden" value="<?php echo $data['qty'] ?>" id="jumlah_awal">
            <input type="hidden" name='jumlah_nilai' value="<?php echo $data['nama_brand'] ?>" id="brand_nama_trf">
            <input type="hidden" name='total_cost' value="<?php echo $data['total_cost'] ?>" id="total_cost">
             
              <div class="box-body form-horizontal">
              
              <div class="col-md-8">

                    <div class="row">
                     <div class="form-group">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-6">
                               
                              <input type="text" value="<?php echo $data['nama_brand'] ?>" class="form-control text-right" readonly>
                                
                            </div>
                          </div>
                   
             

                  <div class="form-group">
                  <label  class="col-sm-2">Jumlah</label>

                  <div class="col-sm-3">                     
                      <input name='jumlah' class='text-right  form-control' id="jumlah_edit" value="<?php echo $data['qty'] ?>"  required>
                      
                  </div>
                    <div class="col-sm-3">                     
                      <input text="text" id="nama_satuan_trf"  value="<?php echo $data['nama_satuan'] ?>"  name="nama_satuan" class='text-right  form-control' readonly>
                            </div>
                    </div>


                    <div class="form-group">
                         <label  class="col-sm-2">Remark</label>
                           <div class="col-sm-3">                     
                          <input name='remark' class='form-control text-right'  value="<?php echo $data['catatan'] ?>" >
                           </div>                            
                     </div>
                    </div>
                  </div>

                  </div>
                  </form>
			  
              </div>
			  
      				</div>			  
      				</div>
            </div>



          <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              
              <div class="modal-dialog" role="document" style="width: 700px">
                  <div class="modal-content">

                   <div class="modal-body" style="text-align:left">

                    </div>
                    <div class="modal-footer">                    
                    <button type="button" class="btn btn-sm btn-warning" id="save_edit_batch_trf">oke</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">BATAL</button>
                    </div>
                  </div>
              </div>
          </div>