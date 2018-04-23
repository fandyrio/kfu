<?php
if(isset($_POST['hapus-contengan'])){
    $imp = "('".implode("','",array_values($_POST['checkbox']))."')";
    $sql =pg_query($dbconn, "DELETE FROM auth_level WHERE id in $imp");

   
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
      
        <header class="page-header">
        <div class="container-fluid">
          <h2 class="no-margin-bottom">Level </h2>
        </div>
        </header>
        <!-- Dashboard Counts Section-->
        <section class="dashboard-counts no-padding-bottom">
 
          <!-- Item -->

      <div class="row" style="padding-top:5px ">

        <div class="col-lg-6">

         <div class="card">
          <div class="card-body">
        <form enctype="multipart/form-data" method="post">
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
                <th width="10px"><input type="checkbox" name="select-all" id="select-all" class="text-label" /></th>
                  <th width="">level</th>
                   <th width="100px"></th>
                  
                </tr>
                </thead>
                <tbody>
             <?php

              //echo $imp;
                 $res=pg_query($dbconn,"Select * from auth_level where id <4 order by id asc");
                 
                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        <td ><input type="checkbox" value="<?php echo $row['id'] ?>" name="checkbox[]" /></td>
                        <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?content=level&modul=data&update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-edit"></i></a>
                            <a href="index.php?content=level&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-edit"></i></a>
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
      <!-- /.row -->
    </section>
