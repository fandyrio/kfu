
       <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah</h3>
            </div>
            
            <form role="form" action="media.php?inventori=satuan&modul=simpan&act=baru" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control"  required autofocus>
                </div>
				<div class="form-group">
                  <label>Deskripsi</label>
                  <input type="text" name="deskripsi" class="form-control"  required>
                </div>
				<div class="form-group">
                  <label>Short Deskripsi</label>
                  <input type="text" name="short_deskripsi" class="form-control"  required>
                </div>
				<div class="form-group">
                  <label>Parent Satuan</label>
                  <input type="text" name="parent_satuan" class="form-control"  required>
                </div>
				<div class="form-group">
                  <label>Qty</label>
                  <input type="text" name="qty" class="form-control"  required>
                </div>
				<div class="form-group">
				<input type="checkbox" name="active"  required>
                  <label>Active</label>
                  
                
				<input type="checkbox" name="base_satuan"   required>
                 <label>Base Satuan</label>
                  
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
    
