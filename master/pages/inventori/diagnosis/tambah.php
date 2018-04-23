
       <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah</h3>
            </div>
            
            <form role="form" action="media.php?inventori=diagnosis&modul=simpan&act=baru" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label>Kode</label>
                  <input type="text" name="code" class="form-control"  required autofocus>
                </div>
				        <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control"  required>
                </div>
                <div class="form-group">
                  <label>Parent Diafolder</label>
                  <input type="text" name="parent_diafolder" class="form-control"  >
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
    
