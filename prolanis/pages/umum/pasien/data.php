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
        <form method="post">
            <div class="box-header with-border">
            
							<h3 class="box-title">Data</h3>
						</div>
            <div class="box-body">
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
                 $res=pg_query($dbconn,"SELECT mp.* from pasien_tindak_lanjut tl
                                        JOIN master_pasien mp on (mp.id=tl.id_pasien) 
                                        WHERE tl.id_unit='$_SESSION[id_branch]' AND tl.id_tindak_lanjut='3' ");


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
          </form>

        </div>
        <button class="btn btn-primary btn-sm blastNotification">Blast Notification</button>
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
  

