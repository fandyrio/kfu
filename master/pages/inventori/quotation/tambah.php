
       <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Obat</h3>
            </div>
            
            <form role="form" action="media.php?inventori=obat&modul=simpan&act=baru" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control"  required>
                </div>
				<div class="form-group">
                    <label for="jm">Kategori</label>
                        <?php 
                      $result =pg_query($dbinventory, "SELECT * FROM obat_kategori");
                     
                      ?>
                      <select name='id_kategori' class='form-control' required>
                      
                      <option value=''>Pilih Kategori Obat</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">SIMPAN</button>
              </div>

            </form>
          </div>
          <!-- /.box -->

             
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      <!-- /.row -->
    
