<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
    <li class="breadcrumb-item active">Akses</li>
</ol>

      
  <div class="container-fluid">
      <div class="row" style="padding-top:5px ">
        <div class="col-lg-6">
         <div class="card">
         
            <div class="card-header">
            <i class="icon-grid"></i> Data
          </div>

           <div class="card-body">
              <table id="myTable" class="table ">
                <thead>
                  <th width="">User</th>
                   <th width="100px"></th>
                  
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"Select * from auth_users a
                    INNER JOIN master_karyawan_unit u on u.id_karyawan = a.id_karyawan
                    where u.id_unit='$_SESSION[id_units]'
                  ");
                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        <td style="vertical-align:middle;"><?php echo $row["username"] ?></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?content=users&modul=data&update&id=<?php echo $row['id_users'] ?>" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-edit"></i></a>
                            <a href="media.php?content=users&modul=hapus&id=<?php echo $row['id_users'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>
                

              </table>

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
      </div>

      </div>
