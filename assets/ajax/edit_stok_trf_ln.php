   <?php 
  $id=$_GET['id'];
  $sql = pg_query($dbconn,"Select stok_trf_ln.*, inv_satuan.nama as \"nama_satuan\" from stok_trf_ln
                       INNER JOIN inv_satuan on inv_satuan.id=stok_trf_ln.id_satuan WHERE stok_trf_ln.id= $id");
  $data = pg_fetch_array($sql);
                          
 ?> 

  <div class="col-md-12 mb-4 angel">
       <ul class="nav nav-tabs" role="tablist">
         <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Add Quantity</a>
          </li>
       </ul>

  <div class="tab-content">
  <div class="tab-pane active" id="home" role="tabpanel">


<button class="btn-xs btn-danger" id="cancel_trf_batch">Cancel</button>
<button name="btn" class=" btn-warning btn-xs" id="edit_trf_load_batch" >Simpan</button>
            <form method="POST" class="form-horizontal" enctype="multipart/form-data" id="edit_trf_ln">
            <input type="hidden" name="id" id="id_ln" value="<?php echo $data['id'] ?>">
            <input type="hidden" name="id_inv" value="<?php echo $data['id_inv'] ?>" id="inv_trf">
            <input type="hidden" value="<?php echo $data['qty'] ?>" id="jumlah_awal">
            <input type="hidden" name='jumlah_nilai' value="<?php echo $data['nama_brand'] ?>" id="brand_nama_trf">
            <input type="hidden" name='total_cost' value="<?php echo $data['total_cost'] ?>" id="total_cost">
             
              <div class="card-block">
              <div class="row">
              
              <div class="col-md-8">

                     <div class="form-group row">
                            <label  class="col-sm-2">Nama brand</label>

                            <div class="col-sm-6">
                               
                              <input type="text" value="<?php echo $data['nama_brand'] ?>" class="form-control text-right" readonly>
                                
                            </div>
                          </div>
                   
             

                  <div class="form-group row">
                  <label  class="col-sm-2">Jumlah</label>

                  <div class="col-sm-3">                     
                      <input name='jumlah' class='text-right  form-control' id="jumlah_edit" value="<?php echo $data['qty'] ?>"  required>
                      
                  </div>
                    <div class="col-sm-3">                     
                      <input text="text" id="nama_satuan_trf"  value="<?php echo $data['nama_satuan'] ?>"  name="nama_satuan" class='text-right  form-control' readonly>
                            </div>
                    </div>


                    <div class="form-group row">
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



      <!--  <div class="modal fade" id="confirm-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              
              <div class="modal-dialog modal-lg" role="document" >
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
 -->


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