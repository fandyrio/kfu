<?php
	$id=$_GET['id'];
	$result=pg_query($dbconn,"SELECT * FROM pro_instruktur WHERE id='$id' ");
	$data = pg_fetch_array($result);
?>	  

      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit</h3>
            </div>
            
            <form role="form" action="media.php?umum=instruktur&modul=simpan&act=edit" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                <div class="box-body">
                <div class="form-group row">
                  <label for="exampleInputEmail1"  class="col-sm-3 text-label">Nama</label>
                   <div class="col-sm-8">
                    <input type="text" name="nama" class="form-control" value="<?php echo $data['nama'] ?>" required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="exampleInputEmail1"  class="col-sm-3 text-label">Kode</label>
                   <div class="col-sm-8">
                    <input type="text" name="kode" class="form-control" value="<?php echo $data['kode'] ?>"  required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="exampleInputEmail1"  class="col-sm-3 text-label">Tanggal Lahir</label>
                   <div class="col-sm-8">
                    <input type="text" name="tgl_lahir" id="datepicker3" class="form-control" value="<?php echo $data['tgl_lahir'] ?>"  required autofocus>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="exampleInputEmail1"  class="col-sm-3 text-label">Alamat</label>
                   <div class="col-sm-8">
                    <input type="text" name="alamat" class="form-control" value="<?php echo $data['alamat'] ?>"  required autofocus>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="exampleInputEmail1"  class="col-sm-3 text-label">No Telepon</label>
                   <div class="col-sm-8">
                    <input type="text" name="no_telp" class="form-control" value="<?php echo $data['no_telp'] ?>"  required autofocus>
                  </div>
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                
                   <button type="button" value="batal" class="btn btn-warning btn-flat" onClick="window.location='media.php?umum=instruktur';" >BATAL</button>
                </div>                          
              </div>
              <!-- /.box-body -->

            </form>
          </div>
          <!-- /.box -->

             
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      <!-- /.row -->
    

