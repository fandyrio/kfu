<?php
$id = $_GET['id'];
?>

            <form method="post" id="form_edit_tindakan"> 
            <input type="hidden" name="id" value="<?php echo $id ?>">
              <div class="card-header d-flex align-items-center">
               Edit
              </div>
              <?php
              $data = pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan_kategori_harga_unit WHERE id = '$id'"));
         

              ?>    
                <div class="card-body">
                  <div class="form-group col-xs-8">
                      <label for="exampleInputEmail1">Nama Analysis</label>

                      <input type="text" class="form-control" value="<?php
                       $row = pg_fetch_assoc(pg_query($dbconn,"SELECT * FROM tindakan WHERE id = '$data[id_tindakan]'"));
                       echo $row['nama']?>" readonly>


                  </div>

                  <div class="form-group col-xs-8">
                      <label for="exampleInputEmail1">Harga</label>
                      <input type="text" name="harga" class="form-control" value="<?php echo $data['harga']?>"  >
                  </div>
                <!-- /.box-header -->
               
                  
                </div>

                <div class="card-footer">
                 <button type="button" class="btn btn-primary btn-flat" id="btnSimpanEditTindakan">SIMPAN</button>                   
                    <button type="button" value="batal" class="btn btn-warning btn-flat" id="kembali_tindakan" >BATAL</button>

                </div>

              </form>