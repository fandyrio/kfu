
          <!-- Horizontal Form -->
        <div class="box-header">
                        <div class="col-md-6 text-left">
                            <h3 class="box-title"><b>Tambah Permintaan</b></h3>
                          </div>
                          <div class="col-md-6 text-right">
                                 <button class="btn-xs btn-danger" id="cancel_rq_hdr">Cancel</button>
                                 <button class="btn-xs btn-success" id="simpan_update_rq_hdr">Simpan</button>
                          </div>
              </div>

            <!-- /.box-header -->
            <!-- form start -->
           <form method="POST" enctype="multipart/form-data" id="update_rquohdr">
              <div class="box-body form-horizontal" >
              <div class="col-md-8">

                <div class="form-group">
                  <label class="col-sm-2">No. Dokumen  </label>

                  <div class="col-sm-6">
                      <input type="text" value="<?php echo createRandomPassword() ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                </div>

                <div class="form-group" >
                  <label for="jm" class="col-sm-2">Tgl. Dokumen</label>

                  <div class="col-sm-6">
                      <input type="text" name="doc_date" value="<?php echo date('Y-m-d') ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>

				         <div class="form-group">
                  <label  class="col-sm-2">Supplier</label>

                  <div class="col-sm-6">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier");
                     
                      ?>
                      <select name='id_supplier' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>

                <div class="form-group">
                  <label  class="col-sm-2">Catatan</label>

                  <div class="col-sm-6">                     
                      <input name='catatan' class='form-control' required>
                      
                  </div>
                  </div>
				     
              </div>



                <div class="col-sm-4">
			        
                <div class="form-group">
                  <label class="col-sm-3">Aktif</label>

                  <div class="col-sm-9">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='TL'>Tidak Dilanjutkan</option>
                      <option value='D'>Hapus</option>
                      
                      </select>
                  </div>
                </div>
          				 <div class="form-group">
          					 
          					 <label class="col-sm-3"> Kunci</label>

          						<div class="col-sm-9">

          						  <input type="checkbox" name="islock">
          						  
          					  </div>
                  </div>
                </div>
                
				  
                </div>

             </form>

              <!-- /.box-body -->
              
         

          
        
          
        