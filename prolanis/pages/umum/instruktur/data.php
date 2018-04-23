  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Instruktur
      </h1>
      <ol class="breadcrumb">
        <li><a href="media.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Instruktur</li>
      </ol>
    </section>

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
                    <table id="example1" class="table table-bordered table-striped tablefont">
                      <thead>
                        <tr>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>Telepon</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       $res=pg_query($dbconn,"Select * from pro_instruktur");

                       while ($row=pg_fetch_assoc($res)) {
                           ?>
                            <tr>
                              <td class="text-left" style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                              <td class="text-left" style="vertical-align:middle;"><?php echo $row["alamat"] ?></td>
                              <td class="text-left" style="vertical-align:middle;"><?php echo $row["no_telp"] ?></td>
                              <td class="text-center" style="vertical-align:middle;">
                                  <a href="media.php?umum=instruktur&modul=data&update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs btn-flat"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                  <a href="media.php?umum=instruktur&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                              </td>
                             
                            </tr>
                          
                       
                       <?php } ?> 
                      </tbody>
                    </table>
                  </div>

                </form>

        </div>
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
