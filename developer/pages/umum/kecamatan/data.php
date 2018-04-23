<?php
$id_kab = $_GET['id_kab'];

$result=pg_query($dbconn,"Select master_kecamatan.nama, master_kabupaten.nama, master_kabupaten.id, master_provinsi.nama, master_provinsi.id from master_kecamatan 
                    INNER JOIN master_kabupaten on master_kabupaten.id=master_kecamatan.id_kabupaten AND master_kecamatan.id_kabupaten='".$id_kab."'
                    INNER JOIN master_provinsi on master_kabupaten.id_provinsi = master_provinsi.id ");


$data=pg_fetch_array($result);

if(isset($_POST['hapus-contengan'])){
    $imp = "('".implode("','",array_values($_POST['checkbox']))."')";
    $sql =pg_query($dbconn, "DELETE FROM master_kecamatan WHERE id in $imp");
    if($sql){
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
     <?php  echo $data[1] ;?>
      </h4>
		<ol class="breadcrumb">
			<li><a href="media.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="media.php?umum=provinsi">Provinsi</a></li>
			<li><a href="media.php?umum=kabupaten&id_prov=<?php echo $data[4] ?>"></i> Kabupaten/Kota</a></li>
			<li class="active">Kecamatan</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
        <form method="post">
            <div class="box-header with-border">
				<div class="box-header with-border">
					<h3 class="box-title">Data Kecamatan</h3>
				</div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th width="10px"><input type="checkbox" name="select-all" id="select-all" /></th>
                  <th width="">Kecamatan</th>
                   <th width="60px"></th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"Select * from master_kecamatan WHERE id_kabupaten='".$id_kab."'");

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id'] ?>" name="checkbox[]" /></td>
                        <td class="text-left" style="vertical-align:middle;"><a href="media.php?umum=kelurahan&modul=data&id_kec=<?php echo $row['id'] ?>" ><?php echo $row["nama"] ?></a></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?umum=kecamatan&modul=data&update&id_kab=<?php echo $id_kab?>&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs btn-flat"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a href="index.php?umum=kecamatan&modul=hapus&id_kab=<?php echo $id_kab?>&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
	  </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
