        <!-- Page Header-->
        <header class="page-header">
        <div class="container-fluid">
          <h2 class="no-margin-bottom">Commision Group</h2>
        </div>
        </header>
        <!-- Dashboard Counts Section-->
        <section class="forms"> 
            <div class="container-fluid">
              <div class="row">
        <div class="col-lg-6">
        <div class="card card-body">
        <form method="post">
              <table id="myTable" class="table ">
                <thead class="table-secondary">
                <tr>
                  <th>Nama</th>
                   <th ></th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $unit = $_SESSION['id_unit'];
                 $res=pg_query($dbconn,"Select distinct id_commision_group from commision_group_harga_unit where id_unit='$unit' order by id_commision_group asc");

                

                 while ($row=pg_fetch_assoc($res)) {
                   $data=pg_fetch_array(pg_query($dbconn,"Select * from commision_group where id='".$row["id_commision_group"]."' "));
                     ?>
                       <tr>
                        <td style="vertical-align:middle;"><?php echo $data["nama"] ?></td>                      
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?content=commision_group&modul=data&update&id=<?php echo $row['id_commision_group'] ?>" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-edit"></i></a>
                            <a href="media.php?content=commision_group&modul=hapus&id=<?php echo $row['id_commision_group'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>

              </table>

          </form>
          </div>

        </div>


      <div class="col-lg-6">
      <div class="card ">


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
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
