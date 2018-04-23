<?php
$id_kec = $_GET['id_kec'];

$result=pg_query($dbconn,"Select master_kelurahan.nama,master_kecamatan.id, master_kecamatan.nama, master_kabupaten.nama, master_kabupaten.id, master_provinsi.nama, master_provinsi.id from 
                    master_kelurahan 
                    INNER JOIN master_kecamatan on master_kecamatan.id=master_kelurahan.id_kecamatan AND master_kelurahan.id_kecamatan='".$id_kec."' 
                    INNER JOIN master_kabupaten on master_kabupaten.id=master_kecamatan.id_kabupaten
                    INNER JOIN master_provinsi on master_kabupaten.id_provinsi = master_provinsi.id
                    ");
$data=pg_fetch_array($result);

if(isset($_POST['hapus-contengan'])){
    $imp = "('".implode("','",array_values($_POST['checkbox']))."')";
    $sql =pg_query($dbconn, "DELETE FROM kelurahan WHERE id in $imp");
    if($result){
            ?>
            <script type="text/javascript">
            window.onload=function(){
                showSuccessToast();
                setTimeout(function(){
                    window.location.reload(1);
                    history.go(0)
                    location.href = location.href
                }, 5000);
            };
            </script>
            <?php
    } else{
            ?>
            <script type="text/javascript">
            window.onload=function(){
                showErrorToast();
                setTimeout(function(){
                    window.location.reload(1);
                    history.go(0)
                    location.href = location.href
                }, 5000);
            };
            </script>
            <?php
    }
}
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h4>
      <?php echo $data[2];?>
      </h4>
     
	 <ol class="breadcrumb">
			<li><a href="media.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="media.php?umum=provinsi">Provinsi</a></li>
			<li><a href="media.php?umum=kabupaten&id_prov=<?php echo $data[6] ?>"></i> Kabupaten/Kota</a></li>
			<li><a href="media.php?umum=kecamatan&id_kab=<?php echo $data[4] ?>"></i> Kecamatan</a></li>
			<li class="active">Kelurahan</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
        <form method="post">
            <div class="box-header">
              
               <div class="col-md-6 text-left">
                   
                </div>
                <div class="col-md-6 text-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th width="10px"><input type="checkbox" name="select-all" id="select-all" /></th>
                  <th width="">Kelurahan</th>
                  <th width="">Kode Pos</th>
                   <th width="60px"></th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"Select * from master_kelurahan WHERE id_kecamatan='".$id_kec."'");

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id'] ?>" name="checkbox[]" /></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row["kodepos"] ?></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?umum=kelurahan&modul=data&update&id_kec=<?php echo $id_kec ?>&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs btn-flat"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a href="index.php?umum=kelurahan&modul=hapus&id_kec=<?php echo $id_kec ?>&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>


              </table>
              <button type="submit" name="hapus-contengan" class="btn btn-danger btn-flat"><span class="fa fa-close"></span> Hapus Checklist</button>
            </div>
            <!-- /.box-body -->
          <!-- /.box -->

          </form>

        </div>
        <!-- /.col -->
      </div>

      <div class="col-md-6">


        <?php
        if(isset($_GET["update"])){
            include "update.php";

        }
        else{
         include "tambah.php"; 
        }
         ?>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
