

        <div class="box-header">
                        <div class="col-md-6 text-left">
                            <h3 class="box-title"><b>Tambah Penawaran Harga</b></h3>
                          </div>
                          <div class="col-md-6 text-right">
                                 <button class="btn-xs btn-danger" id="cancel_quo">Cancel</button>
                                 <button class="btn-xs btn-success" id="penawaran_harga_save">Simpan</button>
                          </div>
              </div>

          <!-- Horizontal Form -->
            <!-- /.box-header -->
            <!-- form start -->
			<form method="POST" enctype="multipart/form-data" id="form_penawaran">
              <div class="box-body form-horizontal">
              <div class="col-md-8">

                <div class="form-group">
                  <label class="col-sm-2"> No. Penawaran</label>

                  <div class="col-sm-5">
                      <input name="no_dok" class='form-control' value="<?php echo Random("Q"); ?>" readonly >
                     
                  </div>
                </div>

                <div class="form-group" >
                  <label for="jm" class="col-sm-2">Supplier</label>

                  <div class="col-sm-8">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier");
                     
                      ?>
                      <select name='id_supplier' id="id_suppli" class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."' >".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>

				 <div class="form-group">
                  <label  class="col-sm-2">Tgl Valid</label>

                  <div class="col-sm-8">                     
                      <input name='validfrom' id="datepicker"  required>to
                      <input name='validto' id="datepicker2"  required>
                      
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
                  <label class="col-sm-3">Status</label>

                  <div class="col-sm-6">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='K'>Kadaluwarsa</option>
                      <option value='C'>Cancel</option>
                      
                      </select>
                            </div>
                          </div>
          				<div class="form-group">
                            <label  class="col-sm-3">Tgl Doc</label>

                            <div class="col-sm-6">                     
                                <input name='tgl_dok' id="datepicker3"  class='form-control' required>
                                
                            </div>
                          </div>
          				<div class="form-group">
                            <label  class="col-sm-3">Kunci</label>

                            <div class="col-sm-6">                     
                                <input type="checkbox" name="islock"   >
                                
                            </div>
                    </div>
				 
                
				  
                </div>

             </div>

              <!-- /.box-body -->
              </form>
         
       
          
        
          
        