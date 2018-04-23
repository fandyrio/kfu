
          <!-- Horizontal Form -->
        <div class="box-header">
                        
                          <div class="col-md-12 text-right">
                                 <button class="btn-xs btn-danger" id="cancel_po_hdr">Cancel</button>
                                 <button class="btn-xs btn-success" id="simpan_po_hdr">Simpan</button>
                          </div>
              </div>

            <!-- /.box-header -->
            <!-- form start -->
           <form method="POST" enctype="multipart/form-data" id="po_hdr">
              <div class="box-body form-horizontal" >
              <div class="col-md-6">

                <div class="form-group">
                  <label class="col-sm-3">No. PO  </label>

                  <div class="col-sm-8">
                      <input type="text" value="<?php echo Random("PO") ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                </div>
				         <div class="form-group">
                  <label  class="col-sm-3">Supplier</label>

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
                <div class="form-group">
                  <label  class="col-sm-3">Departemen</label>

                  <div class="col-sm-8">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                     
                      ?>
                      <select name='id_departemen' class='form-control' required>
                      
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
                  <label  class="col-sm-3">Ditujukan</label>

                  <div class="col-sm-8">                     
                      <input name='ditujukan' class='form-control' required>
                      
                  </div>
                  </div>
                  <div class="form-group">
                  <label  class="col-sm-3">No Referensi</label>

                  <div class="col-sm-8">                     
                      <input name='refno' class='form-control' required>
                      
                  </div>
                  </div>
				  
				  <span class="btn btn-info" id="alamat_po">Alamat Pengirim dan Penerima</span><br>
				 <div class="form-group alamat_po_hidden">
					  <label class="col-sm-3">Alamat Pengirim</label>

					  <div class="col-sm-8">
						  <input type="text"  autocomplete="off" class="form-control"  name="shipping_address">
					  </div>
				</div>
				
				<div class="form-group alamat_po_hidden">
					  <label class="col-sm-3">Alamat Penerima</label>

					  <div class="col-sm-8">
						  <input type="text"  autocomplete="off" class="form-control"  name="delivery_address">
					  </div>
				</div>

				     
              </div>



                <div class="col-sm-6">
			        
                <div class="form-group">
                  <label class="col-sm-3">Status</label>

                  <div class="col-sm-8">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='E'>Expired</option>
                      <option value='B'>Batal</option>
                      
                      </select>
                  </div>
                </div>
          				 <div class="form-group" >
                  <label for="jm" class="col-sm-3">Tgl. Dokumen</label>

                  <div class="col-sm-8">
                      <input type="text" name="doc_date" value="<?php echo date('Y-m-d') ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>
                <div class="form-group" >
                  <label for="jm" class="col-sm-3">Tgl. Expected</label>

                  <div class="col-sm-8">
                      <input type="text" name="expected_date" value="<?php echo date('Y-m-d') ?>" id="datepicker" class="form-control" required>
                  </div>
                </div>
                  <div class="form-group" >
                    <label for="jm" class="col-sm-3">Tgl. Expired</label>

                    <div class="col-sm-8">
                        <input type="text" name="tanggal_expire" value="<?php echo date('Y-m-d') ?>" id="datepicker" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                  <label  class="col-sm-3">Komentar</label>

                  <div class="col-sm-8">                     
                      <input name='komentar' class='form-control' required>
                      
                  </div>
                  </div>
                </div>
                
                </div>
                

             </form>

              <!-- /.box-body -->
              
         

          
        
          
        