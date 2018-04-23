
       <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah</h3>
            </div>
            
            <form role="form" action="media.php?umum=jadwal&modul=simpan&act=baru" method="post">
              <div class="box-body">
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Jenis Kegiatan</label>
                   <div class="col-sm-8">
                    <select class="form-control" name="id_pro">
                      <?php 
                        $tampil = pg_query($dbconn,"SELECT * from pro_nama");
                        while($row=pg_fetch_array($tampil)){
                          echo "<option value='$row[id]'>$row[nama]</option>";

                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Tanggal Awal</label>
                   <div class="col-sm-8">
                    <input type="text" name="tgl_awal" id="datepicker2" class="form-control"  required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Frekuensi</label>
                   <div class="col-sm-8">
                    <select class="form-control" name="freq" id="FreqRefeat">
                      <option value="1">Perbulan</option>
                      <option value="2">Perminggu</option>
                    </select>
                  </div>
                </div>

                <div id="ListMinggu">
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Iterasi</label>
                   <div class="col-sm-8">
                    <select class="form-control" name="id_literasi">
                      <option value="1">1 X Seminggu</option>
                      <option value="2">2 X Seminggu</option>
                      <option value="3">3 X Seminggu</option>
                      <option value="3">1 X Dua minggu</option>
                      
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Hari</label>
                   <div class="col-sm-8">
                    <select class='form-control select2' name='id_hari[]' multiple="multiple"  >
                      <option>Pilih</option>
                        <?php
                          $data = array("Sunday","Monday", "Tuesday", "Wednesday","Thursday", "Friday", "Saturday");
                          for($x=0; $x<count($data); $x++){

                            $id = $x-1;
                            if($id == '-1'){$id=6;}
                              echo "<option value=$data[$id] ";
                               
                              echo ">$data[$x]</option>";
                          }
                        ?>
                        </select>
                  </div>
                </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-3 text-label">Tanggal Akhir</label>
                   <div class="col-sm-8">
                    <input type="text" name="tgl_akhir" id="datepicker3" class="form-control"  required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Jam</label>
                   <div class="col-sm-8">
                    <input type="time" name="jam" class="form-control"  required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label  class="col-sm-3 text-label">Keterangan</label>
                   <div class="col-sm-8">
                    <textarea name="ket" class="form-control" style="width: 100%"></textarea>
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

<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>
  $('#ListMinggu').hide();

  $('#FreqRefeat').change(function(){
    var id=$('#FreqRefeat').val();
    if(id == '1'){
      $('#ListMinggu').hide();
    }else{
      $('#ListMinggu').show();
    }

  });
  $('#Listhari').change(function(){
    var id=$('#Listhari').val();
  });
</script>
    
