<div class="card-header">
            <i class="icon-user"></i> Tambah Permintaan Penawaran
          </div>
         <div class="box-header">
     
                          <div class="col-md-12 text-right">
                           <button class="btn btn-xs btn-danger" id="cancel_rq_hdr">Cancel</button>
                                 <button class="btn btn-xs btn-success" id="simpan_rq_hdr">Simpan</button>
                                
                          </div>
              </div>

            <!-- /.box-header -->
            <!-- form start -->
           <form class="form-horizontal"  method="POST" enctype="multipart/form-data" id="rquohdr">
             
          <div class="card-block">
          <div class="row">
          <div class="col-md-7">
                <div class="form-group row">
                  <label class="col-sm-2 form-control-label">No. Dokumen  </label>

                  <div class="col-md-8">

                      <input type="text" value="<?php echo random_doc("rq"); ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                </div>

                <div class="form-group row" >
                  <label for="jm" class="col-sm-2 form-control-label">Tgl. Dokumen <span class="ingatan">*</span></label>

                  <div class="col-sm-8">
                      <input type="text" name="doc_date" value="<?php echo date('d-m-Y') ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>

				         <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Supplier <span class="ingatan">*</span></label>

                  <div class="col-sm-8">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier");
                     
                      ?>
                      <select name='id_supplier' class='form-control' required>
                      
                     
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Catatan</label>

                  <div class="col-sm-8">                     
                      <input name='catatan' class='form-control' required>
                      
                  </div>
                  </div>
				     
              </div>



                <div class="col-sm-4">
			        
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">Aktif <span class="ingatan">*</span></label>

                  <div class="col-sm-9">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='TL'>Tidak Dilanjutkan</option>
                      <option value='D'>Hapus</option>
                      
                      </select>
                  </div>
                </div>
          				 <div class="form-group row">
          					 
          					 <label class="col-sm-3 form-control-label"> Kunci</label>

          						<div class="col-sm-9">

          						  <input type="checkbox" name="islock">
          						  
          					  </div>
                  </div>
                </div>
                </div>
                </div>
                
				  

             </form>

              <!-- /.box-body -->
              
         

          
        
          
        