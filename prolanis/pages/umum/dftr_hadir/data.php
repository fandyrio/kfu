  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Daftar Hadir
      </h1>
      <ol class="breadcrumb">
        <li><a href="media.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Daftar hadir</li>
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
                          <th>Kegiatan</th>
                          <th>Nama Instruktur</th>
                          <th>Tanggal</th>
                          <th width="80px"></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       $res=pg_query($dbconn,"SELECT p.*, n.nama as \"nm_keg\", i.nama as \"nm_inst\" from pro_dftr_hadir p 
                                              join pro_jadwal j on j.id=p.id_jadwal
                                              join pro_instruktur i on i.id=p.id_instruktur
                                              JOIN pro_nama n on n.id=j.id_pro where p.id_unit='$_SESSION[id_branch]' order by p.id");
                       while ($row=pg_fetch_assoc($res)) {
                           ?>
                            <tr>
                              <td class="text-left" style="vertical-align:middle;"><?php echo $row["nm_keg"] ?></td>
                              <td class="text-left" style="vertical-align:middle;"><?php echo $row["nm_inst"] ?></td>
                              <td class="text-left" style="vertical-align:middle;"><?php echo $row["tgl_keg"] ?></td>
                              <td class="text-center" style="vertical-align:middle;">
                                <a href="media.php?umum=dftr_hadir&modul=data&update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs btn-flat"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                <a href="media.php?umum=dftr_hadir&modul=data&view&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs btn-flat"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                <a href="media.php?umum=dftr_hadir&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
        elseif(isset($_GET["view"])){
            include "view.php";

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
