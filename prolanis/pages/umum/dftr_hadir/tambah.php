<?php
  session_start();
?>
       <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah</h3>
            </div>
            
            <form role="form" action="media.php?umum=dftr_hadir&modul=simpan&act=baru" method="post">
            <input type="hidden" name="id_pasien[]" id="ValuePasien">
              <div class="box-body">
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Jenis Kegiatan</label>
                   <div class="col-sm-8">
                    <select class="form-control" name="id_jadwal">
                      <?php 
                        $tampil = pg_query($dbconn,"SELECT p.nama, j.id from pro_nama p JOIN pro_jadwal j on j.id_pro=p.id 
                                                    where j.id_unit='$_SESSION[id_branch]'");
                        while($row=pg_fetch_array($tampil)){
                          echo "<option value='$row[id]'>$row[nama]</option>";

                        }
                      ?>
                    </select>
                  </div>
                </div>
                 <div class="form-group row">
                  <label class="col-sm-3 text-label">Nama Instruktur</label>
                   <div class="col-sm-8">
                    <select class="form-control" name="id_instruktur">
                      <?php 
                        $tampil = pg_query($dbconn,"SELECT * from pro_instruktur");
                        while($row=pg_fetch_array($tampil)){
                          echo "<option value='$row[id]'>$row[nama]</option>";

                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 text-label">Tanggal Pelaksanaan</label>
                   <div class="col-sm-8">
                    <input type="text" name="tgl_keg" id="datepicker2" class="form-control"  required autofocus>
                  </div>
                </div>

                <div class="form-group row">
                  <label  class="col-sm-3 text-label">Jumlah Hadir</label>
                   <div class="col-sm-4">
                    <input type="text" class="form-control" name="qty"> 
                  </div>
                </div> 

                <div class="form-group row">
                  <label  class="col-sm-3 text-label">Keterangan</label>
                   <div class="col-sm-8">
                    <textarea name="ket" class="form-control" style="width: 100%"></textarea>
                  </div>
                </div>

             
              <table  class="table  table-bordered tablefont"  id="example4">
                <thead class="table-success">    
                  <th width="10px"><input type="checkbox" name="select-tambah" id="select-tambah" /></th>           
                  <th >Nama Pasien</th>
                  <th >Alamat</th>  
                </thead>
                <tbody >
                <?php
                 $res=pg_query($dbconn,"SELECT mp.* from pasien_tindak_lanjut tl
                                        JOIN master_pasien mp on (mp.id=tl.id_pasien) 
                                        WHERE tl.id_unit='$_SESSION[id_branch]' AND tl.id_tindak_lanjut='3'");

                 while ($row=pg_fetch_assoc($res)) {

                     ?>
                       <tr>
                       <td style="vertical-align:middle;"><input type="checkbox" class="tambah" value="<?php echo $row['id'] ?>" name="id_unit[]" />
                       </td>
                        <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["Alamat"] ?></td>
                         
                                       
                        </tr>              
                 <?php }
                  ?>
                </tbody>
              </table>
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
      <script type="text/javascript">
        var checkbox1=[]
        $('#example4 td [type=checkbox]').click(function(){
          var nilai = $(this).val();
         
              if ($(this).is(':checked')) {
                checkbox1.push(nilai);
              }else{
                var index = checkbox1.indexOf(nilai);
                if (index > -1) {
                    checkbox1.splice(index, 1);
                }
              }
          $('#ValuePasien').val(checkbox1);    
        });

      </script>
    
