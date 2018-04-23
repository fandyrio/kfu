<div class="card-header">
            <i class="icon-user"></i> Tambah Penawaran Harga
          </div>
         <div class="box-header">
                          <div class="col-md-12 text-right">
                                <button class="btn btn-xs btn-danger" id="cancel_quo">Cancel</button>
                                 <button class="btn btn-xs btn-success" id="penawaran_harga_save">Simpan</button>
                                
                          </div>
              </div>




          <!-- Horizontal Form -->
            <!-- /.box-header -->
            <!-- form start -->
			<form method="POST" class="form-horizontal" enctype="multipart/form-data" id="form_penawaran">

          <div class="card-block">
             <div class="row">
              <div class="col-md-7">


                <div class="form-group row">
                  <label class="col-sm-2 form-control-label"> No. Penawaran</label>

                  <div class="col-sm-6">
                      <input name="no_dok" class='form-control' value="<?php echo random_doc("q") ?>" readonly >
                     
                  </div>
                </div>

                <div class="form-group row" >
                  <label  class="col-sm-2 form-control-label">Supplier <span class="ingatan">*</span></label>

                  <div class="col-sm-6">
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

				 <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Tgl Valid <span class="ingatan">*</span></label>

                  <div class="col-sm-6">                     
                      <input name='validfrom' id="datepicker" value="<?php echo date('d-m-Y') ?>" required>to
                      <input name='validto' id="datepicker2" value="<?php echo date('d-m-Y') ?>"  required>
                      
                  </div>
                </div>

                <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Catatan</label>

                  <div class="col-sm-6">                     
                      <input name='catatan' class='form-control' required>
                      
                  </div>
                  </div>
				        
              </div>



                <div class="col-sm-5">
			      
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">Status <span class="ingatan">*</span></label>

                  <div class="col-sm-6">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='K'>Kadaluwarsa</option>
                      <option value='C'>Cancel</option>
                      
                      </select>
                            </div>
                          </div>
          				<div class="form-group row">
                            <label  class="col-sm-3 form-control-label">Tgl Doc <span class="ingatan">*</span></label>

                            <div class="col-sm-6">                     
                                <input name='tgl_dok' id="datepicker3" value="<?php echo date('d-m-Y') ?>" class='form-control' required>
                                
                            </div>
                          </div>
          				<div class="form-group row">
                            <label  class="col-sm-3 form-control-label">Kunci</label>

                            <div class="col-sm-6">                     
                                <input type="checkbox" name="islock"   >
                                
                            </div>
                    </div>
				 
                
				  
                </div>
                </div>
                </div>

              <!-- /.box-body -->
              </form>
         
       
          
        
          
        