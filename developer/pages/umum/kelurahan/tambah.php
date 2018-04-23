
       <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah</h3>
            </div>
            
            <form role="form" action="media.php?umum=kelurahan&modul=simpan&act=baru" method="post">
            <input type="hidden" name="id_kec" value ="<?php echo $id_kec ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Kelurahan</label>
                  <input type="text" name="kelurahan" class="form-control"  required autofocus>
                </div>               
              
                <div class="form-group">
                  <label for="exampleInputEmail1">Kode Pos</label>
                  <input type="text" name="kodepos" class="form-control" required>
                             
              </div>
              <!-- /.box-body -->
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
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
    
