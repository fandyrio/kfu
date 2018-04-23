  <script>
      function DateToIndo($date) { // fungsi atau method untuk mengubah tanggal ke format indonesia
     // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
      $BulanIndo = array("Januari", "Februari", "Maret",
                 "April", "Mei", "Juni",
                 "Juli", "Agustus", "September",
                 "Oktober", "November", "Desember");
    
      $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
      $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
      $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
      
      $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
      return($result);
    }
  </script>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
       Pasien
      </h1>
      <ol class="breadcrumb">
        <li><a href="media.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pasien</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">

            <div class="box-header with-border">          
                <h3 class="box-title">Laporan Prolanis</h3>
              </div>

            <div class="box-body">

            <form method="POST">             
              <div class="form-group row">
                  <label class="col-sm-2 text-label">Jenis Kegiatan</label>
                   <div class="col-sm-3">
                    <select class="form-control" name="id_jadwal" required>
                        <option value="">Pilih</option>
                      <?php 
                        $tampil = pg_query($dbconn,"SELECT p.nama, j.id from pro_nama p JOIN pro_jadwal j on j.id_pro=p.id 
                                                    where j.id_unit='$_SESSION[id_branch]'");
                       
                        while($row=pg_fetch_array($tampil)){
                          echo "<option value='$row[id]'";
                            if($_POST[id_jadwal]==$row[id]){
                              echo "selected";
                            }
                          echo ">$row[nama]</option>";

                        }
                      ?>
                    </select>
                  </div>
                  <label class="col-sm-1 text-label">Bulan</label>
                  <div class="col-sm-2" >
                  <select class='form-control' name='id_bulan' required>
                    <option>Pilih</option>
                      <?php
                        $data = array("Januari","Februari", "Maret", "April","Mei", "Juni", "Juli","Agustus","September"
                                       ,"Oktober", "November", "Desember" );
                        $no=1;
                        foreach ($data as $key) {
                          echo "<option value=$no ";
                            if($_POST[id_bulan]==$no){
                              echo "selected";
                            }
                          echo ">$key</option>";
                          $no++;
                        }
                        
                      ?>
                      </select>
                  </div>
                  <div class="col-sm-2" >
                    <input type="submit" name="cari" class="btn btn-success btn-flat" value="Cari">
                    <input type="button" class="btn btn-primary btn-flat" value="Reset" onClick="window.location='media.php?umum=report';" >
                  </div>  
                  
              </div>
            </form>

              <table id="example1" class="table table-bordered table-striped tablefont" >
                <thead>
                <tr>
                  <th>Nama</th>
                  <th>Tanggal Lahir</th>
                  <th>Alamat</th>
                  <th>No Telepon</th>
                  <th>Nik</th>                  
                </tr>
                </thead>
                <tbody>
                <?php
                $arr=array();
                  $DataProlanis = "SELECT mp.* from pro_dftr_hadir pt
                                    JOIN pro_dftr_hadir_dtl pd on pd.id_dftr_hdr = pt.id
                                    JOIN master_pasien mp on (mp.id=pd.id_pasien) 
                                        WHERE pt.id_unit='$_SESSION[id_branch]'";

                  if($_POST['cari']){
                     $DataProlanis .=" and id_jadwal='$_POST[id_bulan]' and EXTRACT(MONTH FROM pt.tgl_keg)='$_POST[id_bulan]'" ;
                  }

                 $res=pg_query($dbconn,$DataProlanis);

                 while ($row=pg_fetch_assoc($res)) {
                  $id= $row[tanggal_lahir];
                  array_push($arr, $row['no_handphone']);
                     ?>
                      <tr>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo DateToIndo($id) ?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["alamat"] ?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["no_handphone"] ?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["nik"] ?></td>
                      </tr>
                    
                 
                 <?php } ?> 
                </tbody>
          

              </table>
            </div>

        </div>
       
      </div>
    </section>

    <!-- /.content -->

  </div>
<script type="text/javascript">
$(document).ready(function()
{
  $(".blastNotification").click(function()
  {
      var arr=<?php echo json_encode($arr) ?>;
      var idKlinik=<?php echo $_SESSION['id_branch'] ?>;

      $.ajax(
      {
        url:'pages/umum/pasien/sendNotif.php',
        data:{arr:arr, idKlinik:idKlinik},
        type:'POST',
        success:function(result)
        {
          if(result=="")
          {
            alert(result);
            //alert("Notif Blasted");
          }
          else
          {
            alert(result);
          }
        },
        error:function()
        {
          alert("E");
        }
      });
  });
});

</script>
  

