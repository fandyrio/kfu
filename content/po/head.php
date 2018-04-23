        <div class="card-header">
            <i class="icon-grid"></i> Tambah
          </div>
         <div class="box-header">
         
                          <div class="col-md-12 text-right">
                            <button class="btn btn-xs btn-danger" id="cancel_po_hdr">Cancel</button>
                                 <button class="btn btn-xs btn-success" id="simpan_po_hdr">Simpan</button>
                                
                          </div>
              </div>


            <!-- /.box-header -->
            <!-- form start -->
           <form method="POST" class="form-horizontal" enctype="multipart/form-data" id="po_hdr">
              <div class="card-block" >
              <div class="row">
              <div class="col-md-6">

                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">No. PO  </label>

                  <div class="col-sm-8">
                      <input type="text" value="<?php echo random_doc("po");?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                </div>
				         <div class="form-group row">
                  <label  class="col-sm-3 form-control-label">Supplier <span class="ingatan">*</span></label>

                  <div class="col-sm-8">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_info_supplier");
                     
                      ?>
                      <select name='id_supplier' class='form-control' required id="supplier_po">
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label  class="col-sm-3 form-control-label">Departemen <span class="ingatan">*</span></label>

                  <div class="col-sm-8">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                     
                      ?>
                      <select name='id_departemen' id="deptid" class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label  class="col-sm-3 form-control-label">Ditujukan</label>

                  <div class="col-sm-8">                     
                      <input name='ditujukan' class='form-control' required>
                      
                  </div>
                  </div>
                  <div class="form-group row">
                  <label  class="col-sm-3 form-control-label">No Referensi</label>

                  <div class="col-sm-8">                     
                      <input name='refno' class='form-control' required>
                      
                  </div>
                  </div>
				  
      				  <span class="btn btn-info" id="alamat_po">Alamat Pengirim dan Penerima</span><br>
      				 <div class="form-group row alamat_po_hidden">
      					  <label class="col-sm-3 form-control-label">Alamat Pengirim</label>

      					  <div class="col-sm-8">
      						  <input type="text"  autocomplete="off" class="form-control"  name="shipping_address">
      					  </div>
      				</div>
      				
      				<div class="form-group row alamat_po_hidden">
      					  <label class="col-sm-3 form-control-label">Alamat Penerima</label>

      					  <div class="col-sm-8">
      						  <input type="text"  autocomplete="off" class="form-control"  name="delivery_address">
      					  </div>
      				</div>

      				     
            </div>

                <div class="col-sm-6">
			        
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">Status <span class="ingatan">*</span></label>

                  <div class="col-sm-8">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='E'>Expired</option>
                      <option value='B'>Batal</option>
                      
                      </select>
                  </div>
                </div>
          				 <div class="form-group row" >
                  <label for="jm" class="col-sm-3 form-control-label">Tgl. Dokumen <span class="ingatan">*</span></label>

                  <div class="col-sm-8">
                      <input type="text" name="doc_date" value="<?php echo date('d-m-Y') ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>
                <div class="form-group row" >
                  <label for="jm" class="col-sm-3 form-control-label">Tgl. Expected <span class="ingatan">*</span></label>

                  <div class="col-sm-8">
                      <input type="text" name="expected_date" value="<?php echo date('d-m-Y') ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>
                  <div class="form-group row" >
                    <label for="jm" class="col-sm-3 form-control-label">Tgl. Expired <span class="ingatan">*</span></label>

                    <div class="col-sm-8">
                        <input type="text" name="tanggal_expire" value="<?php echo date('d-m-Y') ?>" id="datepicker" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group row">
                  <label  class="col-sm-3 form-control-label">Komentar</label>

                  <div class="col-sm-8">                     
                      <input name='komentar' class='form-control' required>
                      
                  </div>
                  </div>
                </div>
                
                </div>
                </div>          

             </form>

              <!-- /.box-body -->
              
         

          
        
          
        