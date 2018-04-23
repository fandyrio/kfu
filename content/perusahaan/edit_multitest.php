<?php
$id = $_GET['id'];
?>

            <form method="post" id="form_edit_multi"> 
            <input type="hidden" name="id" value="<?php echo $id ?>">
              <div class="card-header d-flex align-items-center">
                Edit
              </div>
              <?php
              $data = pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group_unit WHERE id = '$id'"));
         

              ?>    
                <div class="card-body">
                  <div class="form-group col-xs-8">
                      <label for="exampleInputEmail1">Nama Analysis Group</label>

                      <input type="text" class="form-control" value="<?php
                       $row = pg_fetch_assoc(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id = '$data[id_lab_analysis_group]'"));
                       echo $row['nama']?>" readonly>


                  </div>

                  <div class="form-group col-xs-8">
                      <label for="exampleInputEmail1">Harga</label>
                      <input type="text" name="harga" class="form-control" value="<?php echo $data['harga_unit']?>"  >
                  </div>
                <!-- /.box-header -->
               
                  
                </div>

                <div class="card-footer">
                 <button type="button" class="btn btn-primary btn-flat" id="btnSimpanEditMulti">SIMPAN</button>                   
                    <button type="button" value="batal" class="btn btn-warning btn-flat" id="kembali_lab" >BATAL</button>

                </div>

              </form>