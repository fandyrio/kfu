
       <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah</h3>
            </div>
            
            <form role="form" action="media.php?umum=instruktur&modul=simpan&act=baru" method="post">
              <div class="box-body">
                <div class="form-group row">
                  <label for="exampleInputEmail1"  class="col-sm-3 text-label">Nama</label>
                   <div class="col-sm-8">
                    <input type="text" name="nama" class="form-control"  required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="exampleInputEmail1"  class="col-sm-3 text-label">Kode</label>
                   <div class="col-sm-8">
                    <input type="text" name="kode" class="form-control"  required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="exampleInputEmail1"  class="col-sm-3 text-label">Tanggal Lahir</label>
                   <div class="col-sm-8">
                    <input type="text" name="tgl_lahir" id="datepicker3" class="form-control"  required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="exampleInputEmail1"  class="col-sm-3 text-label">Alamat</label>
                   <div class="col-sm-8">
                    <input type="text" name="alamat" class="form-control"  required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="exampleInputEmail1"  class="col-sm-3 text-label">No Telepon</label>
                   <div class="col-sm-8">
                    <input type="text" name="no_telp" class="form-control"  required autofocus>
                  </div>
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
    
