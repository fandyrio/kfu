
       <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Departemen Obat</h3>
            </div>
            
            <form role="form" action="media.php?inventori=departemen&modul=simpan&act=baru" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Kode</label>
                  <input type="text" name="code" class="form-control sm"  required autofocus>
                </div>  
				<div class="form-group">
                  <label for="exampleInputEmail1">Nama Departemen Obat</label>
                  <input type="text" name="nama" class="form-control"  required>
                </div>				
              </div>
              <!-- /.box-body -->

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
    
