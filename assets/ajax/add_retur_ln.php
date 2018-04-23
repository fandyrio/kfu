<?php 

      $query="SELECT distinct brand.nama as \"nama_brand\", ln.id_satuan, ln.id_inv, s.nama from inv_nama_brand brand
              INner join grn_ln ln on ln.nama_brand=brand.nama
              INNER JOIN grn_hdr h on h.id = ln.id_hdr
               INNER JOIN inv_satuan s on s.id = ln.id_satuan
              WHERE id_departemen='$_GET[departemen]' and id_supplier='$_GET[supp]' ";
      $result =pg_query($dbconn, $query); 

 ?> 

<button class="btn btn-xs btn-danger" id="cancel_retur_add_ln">Cancel</button>
<button class="btn btn-xs btn-success" id="simpan_retur_ln" >Simpan</button>
            <form method="POST" class="form-horizontal" enctype="multipart/form-data" id="retur_ln">
              <input type="hidden" name="id_inv" id="inv">
             <input type="hidden" name='id_satuan' id="id_satuan">
             <input type="hidden" name='brand_nama' id="brand_nama">
             
              <div class="card-block">
              
              <div class="col-md-8">
                    <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Nama brand</label>

                            <div class="col-sm-6">
                               
                                <select name="nama_brand" class='form-control' required>
                                
                                <option value=''>Pilih</option>
                                <?php 
                                while ($row =pg_fetch_assoc($result)){
                                  echo "<option value='".$row['id_inv']."_".$row['nama_brand']."_".$row['nama']."_".$row['id_satuan']."'>".$row['nama_brand']."</option>";
                                }
                                ?>
                                </select>
                            </div>
                          </div>
                   
             

                        <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Qty</label>
  						          <div class="col-sm-3">                     
                                <input id="jumlah_po" name='jumlah'  required class='form-control' onchange="count_on_jumlah_po()">
                                
                            </div>
                            
                            <div class="col-sm-3">                     
                            <input text="text" id="nama_satuan" name="nama_satuan" class='text-right  form-control' readonly>
                          </div>
                          </div>

                          <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Cost</label>
                             <div class="col-sm-3">                     
                                <input  name='cost'  readonly class='form-control' >
                                
                            </div>
                            
                          </div>
						  
						  
						             <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Tgl Expired</label>
                             <div class="col-sm-3">                     
                                <input  name='tgl_expired' id="datepicker2"  value="<?php echo date('Y-m-d') ?>" class='form-control'>
                                
                            </div>                            
                          </div>
						            <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Tgl Manufactureds</label>
                             <div class="col-sm-3">                     
                                <input  name='tgl_manufactured'  id="datepicker" value="<?php echo date('Y-m-d') ?>" class='form-control'>
                                
                            </div>                            
                          </div>
						  
                          
              
               
                        </div>

                  </div>
</form>


 <div id="mit_pop_up" class="melayang" >
            <div class="melayang-content">
              <span class="close">&times;</span>
               <div class="form-horizontal" >
                <div class="card-block">
              <div class="row resultload">   </div>          
            </div>
            </div>
            <div class="modal-footer">  
              <button type="button" class="btn btn-sm btn-warning" id="save_batch_retur" >Simpan</button>
              </div>
              </div>
            </div>


  

             

           



               
                
          
   
          
              