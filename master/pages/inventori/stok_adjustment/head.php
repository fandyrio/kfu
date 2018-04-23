                <div class="box-header">

                      <div class="col-md-6 text-left">
                      </div>

                      <div class="col-md-6 text-right">
                         <button type="submit" name="hapus-contengan" class="btn btn-danger btn-xs"><span class="fa fa-close"></span>close</button>
                            <button type="button" class="btn btn-success btn-xs" id="save_adj_hdr"><span class="fa fa-clone"></span> Save</button> 
                    
                      </div>
                     
                    </div>
            <form id="adjustment_hdr">
              <div class="box-body form-horizontal" >
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-sm-2">No Dokumen</label>
                  <div class="col-sm-8">
                      <input type="text" value="<?php echo createRandomPassword() ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                  </div>
                 <div class="form-group">
                  <label class="col-sm-2">Unit  </label>

                  <div class="col-sm-8">
                      <input type="text" value="1" autocomplete="off" class="form-control" readonly name="id_unit" readonly>
                  </div>

                </div>


                 <div class="form-group">
                  <label  class="col-sm-2">Departemen</label>

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
                           <div class="form-group">
                          <label class="col-sm-3">Tanggal Dokumen  </label>

                          <div class="col-sm-8">
                              <input type="text" name="tgl_dok" id="datepicker" autocomplete="off" class="form-control" >
                          </div>

                         </div>

                </div>
                </div> 
                </form> 