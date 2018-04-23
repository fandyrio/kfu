    <div class="card-header">
            <i class="icon-user"></i> Stok Adjustment
          </div>

                <div class="box-header">

                     
                      <div class="col-md-12 text-right">
                         <button type="submit" name="hapus-contengan" id="cancel_adj_hdr" class="btn btn-danger btn-xs">Cancel</button>
                            <button type="button" class="btn btn-success btn-xs" id="save_adj_hdr">Simpan</button> 
                    
                      </div>
                     
                    </div>
            <form id="adjustment_hdr">
              
              <div class="form-horizontal" >
                <div class="card-block">
                <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-2 form-control-label">No Dokumen</label>
                  <div class="col-sm-8">
                      <input type="hidden"  value="<?php echo random_doc("ad"); ?>" autocomplete="off" class="form-control" readonly name="doc_no">

                      <?php echo ": ".random_doc("ad"); ?>
                  </div>
                  </div>
                 <div class="form-group row">
                  <label class="col-sm-2 form-control-label">Unit  </label>

                  <div class="col-sm-8">
                     <?php 
                      $row =pg_fetch_array(pg_query($dbconn, "SELECT * FROM master_unit where id='$_SESSION[id_units]'"));
                     
                      ?>

                      <input type="hidden" name="id_unit" class="form-control" value="<?php echo $row['id']  ?>">
                      <?php echo ": ".$row['nama']  ?>
        
                  </div>

                </div>


                 <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Departemen</label>

                  <div class="col-sm-8">
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
                </div>

                <div class="col-md-6">
                           <div class="form-group row">
                          <label class="col-sm-3 form-control-label">Tanggal Dokumen  </label>

                          <div class="col-sm-8">
                              <input type="text" name="tgl_dok" id="datepicker" value="<?php echo date('d-m-Y') ?>" autocomplete="off" class="form-control" >
                          </div>

                         </div>

                </div>
                </div>
                </div> 
              </div>
                </form> 