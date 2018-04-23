<?php
  session_start();
	$id=$_GET['id'];
	$result=pg_query($dbconn,"SELECT * FROM pro_dftr_hadir WHERE id='$id' ");
	$data = pg_fetch_array($result);
?>	  
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">View</h3>
            </div>
            
            <form role="form" action="media.php?umum=dftr_hadir&modul=simpan&act=edit" method="post">
            <input type="hidden" name="id_pasien[]" id="ValuePasien">
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                <div class="box-body">

                    <div class="form-group row">
                      <label class="col-sm-3 text-label">Jenis Kegiatan</label>
                       <div class="col-sm-8">: 
                          <?php 
                            $tampil = pg_query($dbconn,"SELECT p.nama, j.id from pro_nama p JOIN pro_jadwal j on j.id_pro=p.id 
                                                        where j.id_unit='$_SESSION[id_branch]' and j.id='$data[id_jadwal]'");
                            $row=pg_fetch_array($tampil);
                              echo $row[nama];

                          ?>
                      </div>
                    </div>

                     <div class="form-group row">
                      <label class="col-sm-3 text-label">Nama Instruktur</label>
                       <div class="col-sm-8">: 
                          <?php 
                            $tampil = pg_query($dbconn,"SELECT * from pro_instruktur where id='$data[id_instruktur]' ");
                            $row=pg_fetch_array($tampil);

                            echo $row[nama];
                          ?>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-3 text-label">Tanggal Pelaksanaan</label>
                       <div class="col-sm-8">: <?php echo $data[tgl_keg] ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-3 text-label">Jumlah Hadir</label>
                       <div class="col-sm-8">: <?php echo $data[qty]; ?>
                        
                      </div>
                    </div> 
                    <div class="form-group row">
                      <label  class="col-sm-3 text-label">Keterangan</label>
                       <div class="col-sm-8">: <?php echo $data[ket] ?>
                       
                      </div>
                    </div>
                      <table  class="table  table-bordered tablefont"  id="example4">
                        <thead>
                          <tr>
                            <th>Pasien</th>
                            <th>Alamat</th>
                          </tr>
                        </thead>
                        <tbody>
                         <?php
                             $res=pg_query($dbconn,"SELECT mp.* from pasien_tindak_lanjut tl
                                                  JOIN master_pasien mp on (mp.id=tl.id_pasien)
                                                  JOIN pro_dftr_hadir_dtl d on (d.id_pasien=mp.id)
                                                  JOIN pro_dftr_hadir dh on (dh.id=d.id_dftr_hdr)
                                                  WHERE tl.id_unit='$_SESSION[id_branch]' and dh.id='$data[id]' AND tl.id_tindak_lanjut='3'");

                            while ($row=pg_fetch_assoc($res)) {
                              $q=pg_query($dbconn,"SELECT id_pasien from pro_dftr_hadir_dtl where id_dftr_hdr='$data[id]' 
                                                   AND id_pasien='$row[id]' ");
                              $cek_unit=pg_fetch_assoc($q);
                              ?>
                                <tr>
                                  <td class="text-left" style="margin-left:5px;vertical-align:left;"><?php echo $row["nama"] ?></td>
                                  <td class="text-left" style="margin-left:5px;vertical-align:left;"><?php echo $row["alamat"] ?></td>
                                </tr>                         
                             <?php } ?> 
                          </tbody>

                          </table>
                                              
                    </div>
              <!-- /.box-body -->
              <div class="box-footer">
                   <button type="button" value="batal" class="btn btn-warning btn-flat" onClick="window.location='media.php?umum=dftr_hadir';" >BATAL</button>
                </div>  

            </form>
          </div>

          </div>
      </div>
      <script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
      <script type="text/javascript">
      var checkbox1=[];
      $(".tambah:checked").each(function(){
         var nilai = $(this).val();
         checkbox1.push(nilai);
          $('#ValuePasien').val(checkbox1); 
      });
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
    

