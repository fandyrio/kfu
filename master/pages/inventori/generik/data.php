<?php
if(isset($_POST['hapus-contengan'])){
    $imp = "('".implode("','",array_values($_POST['checkbox']))."')";
    $sql =pg_query($dbconn, "DELETE FROM inv_nama_generik WHERE id in $imp");
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
      <h1>
       Generik
      </h1>
      <ol class="breadcrumb">
        <li><a href="media.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Generik</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
        <form method="post">
           <div class="box-header with-border">
							<h3 class="box-title">Data</h3>
						</div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th width="10px"><input type="checkbox" name="select-all" id="select-all" /></th>
                  <th width="">Nama</th>
				  <th>Last Modify</th>
                   <th width="60px" ></th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"Select * from inv_nama_generik");

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id'] ?>" name="checkbox[]" /></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo DateToIndo($row["modify_date"]); ?></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?inventori=generik&modul=data&update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs btn-flat"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a href="index.php?inventori=generik&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
