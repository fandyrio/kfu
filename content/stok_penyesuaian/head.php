
          <!-- Horizontal Form -->
        <div class="box-header">
                        
                          <div class="col-md-12 text-right">
                                 <button class="btn-xs btn-danger" id="cancel_grn_hdr">Cancel</button>
                                 <button class="btn-xs btn-success" id="simpan_grn_hdr">Simpan</button>
                          </div>
              </div>

            <!-- /.box-header -->
            <!-- form start -->
           <form method="POST" enctype="multipart/form-data" id="stt_hdr">
		   
              <div class="form-horizontal">
                 <div class="card-block">
                <div class="row">


              <div class="col-md-6">

                <div class="form-group row">
                  <label class="col-sm-2">No Dok </label>

                  <div class="col-sm-6">
                      <input type="text" value="<?php echo Random("SP") ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
				  
                </div>
				
				<div class="form-group row">
                  <label  class="col-sm-2">Departemen</label>

                  <div class="col-sm-10">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                     
                      ?>
                      <select name='id_departemen' class='form-control' required>                      
                      
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>
				 
                

                <div class="form-group row">
                  <label  class="col-sm-2">Komentar</label>

                  <div class="col-sm-5">                     
                      <input name='komentar' class='form-control' required> hari
                      
                  </div>
                  </div>                  
				  
				  

				     
              </div>



                <div class="col-sm-6">       
                
          		
                <div class="form-group row" >
                  <label for="jm" class="col-sm-3">Tgl</label>

                  <div class="col-sm-6">
                      <input type="text" name="tgl" value="<?php echo date('Y-m-d') ?>" id="datepicker3" class="form-control" required>
                  </div>
                </div>
                  
                  <div class="form-group row">
                  <label class="col-sm-3">Status</label>

                  <div class="col-sm-6">
                 
                      <select name='status' class='form-control' required>
                      
                      <option value='A'>Aktif</option>
                      <option value='H'>Hapus</option>
                      
                      </select>
                            </div>
                  </div>
                </div>
                
                </div>
              </div>
            </div>
                

              <!-- /.box-body -->
              
         

          
        
          
        