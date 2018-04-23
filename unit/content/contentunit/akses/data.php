 <?php
if(isset($_POST['hapus-contengan'])){
    $imp = "('".implode("','",array_values($_POST['checkbox']))."')";
    $sql =pg_query($dbconn, "DELETE FROM auth_modul WHERE id in $imp");
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
        <header class="page-header">
        <div class="container-fluid">
          <h2 class="no-margin-bottom">Akses </h2>
        </div>
        </header>

        <section class="dashboard-counts no-padding-bottom">
 
      <div class="row" style="padding-top:5px ">
        <div class="col-lg-6">
         <div class="card">
          <div class="card-body">
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
                
                  <th width="">Level</th>
                   <th width="100px"></th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"SELECT
                                     T1.id_level, T2.id, T2.nama
                                  FROM
                                     (SELECT DISTINCT id_level FROM auth_akses_menu) T1
                                     INNER JOIN
                                     (SELECT id, nama FROM auth_level where id <4) T2
                                                ON T1.id_level = T2.id");

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                       
                        <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?content=akses&modul=data&update&id=<?php echo $row['id_level'] ?>" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-edit"></i></a>
                            <a href="media.php?content=akses&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>
                

              </table>
              <button type="submit" name="hapus-contengan" class="btn btn-danger btn-flat"><span class="fa fa-close"></span> Hapus Checklist</button>
            </div>

          </form>

        </div>
        </div>
      </div>

      <div class="col-lg-6">
      <div class="card">


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
    </section>
