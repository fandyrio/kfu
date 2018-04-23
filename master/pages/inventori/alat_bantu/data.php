
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Alat Bantu
      </h1>
      <ol class="breadcrumb">
        <li><a href="media.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Alat Bantu</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-7">
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
				  <th width="50px">No.</th>
                  <th width="">Nama</th>
                  <th width="">Jumlah</th>
                  <th width="">Satuan</th>				          
                  <th width="60px">Aksi</th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"Select * from inv_alat_bantu");
				 $no=1;
                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
					   <td><?php echo $no;?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["jumlah"] ?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["satuan"] ?></td>
                       
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?inventori=alat_bantu&modul=data&update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs btn-flat"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a href="media.php?inventori=alat_bantu&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data atk')" class="btn btn-danger btn-xs btn-flat"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php $no++;} ?> 
                </tbody>
                

              </table>
             
            </div>
            <!-- /.box-body -->
          <!-- /.box -->

          </form>

        </div>
        <!-- /.col -->
      </div>

      <div class="col-md-5">


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
