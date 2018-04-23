<?php
	$id=$_GET['id'];
	$result=pg_query($dbconn,"SELECT * FROM pro_jadwal WHERE id='$id' ");
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
            
            <form role="form" action="media.php?umum=jadwal&modul=simpan&act=edit" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                <div class="box-body">
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Jenis Kegiatan</label>
                   <div class="col-sm-8">
                    <select class="form-control" name="id_pro">
                      <?php 
                        $tampil = pg_query($dbconn,"SELECT * from pro_nama");
                        while($row=pg_fetch_array($tampil)){
                          echo "<option value='$row[id]'";
                          if($data['id_pro']==$row['id']){
                            echo "selected";
                          }
                          echo ">$row[nama]</option>";

                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Tanggal Awal</label>
                   <div class="col-sm-8">
                    <input type="text" name="tgl_awal" id="datepicker3" class="form-control" value="<?php echo $data[tgl_awal] ?>"  required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Frekuensi</label>
                   <div class="col-sm-8">
                    <select class="form-control" name="freq" id="FreqRefeat">
                      <option value="1" <?php if($data['freq']==1){echo "selected";} ?> >Perbulan</option>
                      <option value="2"<?php if($data['freq']==2){echo "selected";} ?> >Perminggu</option>
                    </select>
                  </div>
                </div>

                <div id="ListMinggu">
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Iterasi</label>
                   <div class="col-sm-8">
                    <select class="form-control" name="id_literasi">
                      <option value="1" <?php if($data['id_literasi']==1){echo "selected";} ?>>1 X Seminggu</option>
                      <option value="2" <?php if($data['id_literasi']==2){echo "selected";} ?>>2 X Seminggu</option>
                      <option value="3" <?php if($data['id_literasi']==3){echo "selected";} ?>>3 X Seminggu</option>
                      <option value="3" <?php if($data['id_literasi']==4){echo "selected";} ?>>1 X Dua minggu</option>
                      
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Hari</label>
                   <div class="col-sm-8">
                    <select class='form-control select2' name='id_hari[]' multiple="multiple"  >
                      <option>Pilih</option>
                        <?php
                          $DayArray = array("Sunday","Monday", "Tuesday", "Wednesday","Thursday", "Friday", "Saturday");
                          for($x=0; $x<count($DayArray); $x++){
                            $id = $x-1;
                            if($id == '-1'){$id=6;}
                            $row = pg_fetch_array(pg_query($dbconn, "SELECT * from pro_jadwal_dtl where id_jadwal ='$_GET[id]'
                                                            AND day_notif='$DayArray[$id]'"));

                            $day=="";
                            if($row[day_notif]=='Sunday'){$day="Monday";}
                            if($row[day_notif]=='Monday'){$day="Tuesday";}
                            if($row[day_notif]=='Tuesday'){$day="Wednesday";}
                            if($row[day_notif]=='Wednesday'){$day="Thursday";}
                            if($row[day_notif]=='Thursday'){$day="Friday";}
                            if($row[day_notif]=='Friday'){$day="Saturday";}
                            if($row[day_notif]=='Saturday'){$day="Sunday";}

                            
                            
                              echo "<option value=$DayArray[$id] ";
                                if($day==$DayArray[$x]){
                                  echo "selected";
                                }
                              echo ">$DayArray[$x]</option>";
                          }
                        ?>
                        </select>
                  </div>
                </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-3 text-label">Tanggal Akhir</label>
                   <div class="col-sm-8">
                    <input type="text" name="tgl_akhir" id="datepicker2" value="<?php echo $data[tgl_akhir] ?>" class="form-control"  required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Jam</label>
                   <div class="col-sm-8">
                    <input type="time" name="jam" class="form-control" value="<?php echo $data[jam] ?>"  required autofocus>
                  </div>
                </div>
                <div class="form-group row">
                  <label  class="col-sm-3 text-label">Keterangan</label>
                   <div class="col-sm-8">
                    <textarea name="ket" class="form-control" style="width:100%"><?php echo $data[ket] ?></textarea>
                  </div>
                </div>                          
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                
                   <button type="button" value="batal" class="btn btn-warning btn-flat" onClick="window.location='media.php?umum=jadwal';" >BATAL</button>
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
  var id=$('#FreqRefeat').val();
  if(id != '2'){
    $('#ListMinggu').hide();
  }
  

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
    

