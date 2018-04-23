
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Inventori Obat <img src="images/indication.png">
      </h1>
      <ol class="breadcrumb">
        <li><a href="media.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Inventori Obat</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
        <form method="post">
            <div class="box-header with-border">
                   <h3 class="box-title">Data</h3>
                  <a href="media.php?inventori=inven&modul=new"  class="btn btn-info btn-flat pull-right">Tambah</a>
                
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
               
                  <th width="">Nama Brand</th>
                  <th width="">Nama Generik</th>
                  <th width="">Kategori</th>
                  <th width="">Charge Group</th>
                  <th width="">Satuan</th>
                   
        
                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"Select * from inv_inventori");

                 while ($row=pg_fetch_assoc($res)) {
     $nama_brand=pg_fetch_assoc(pg_query($dbconn,"Select nama from inv_nama_brand WHERE id='".$row['id_brand']."' "));
     $nama_generik=pg_fetch_assoc(pg_query($dbconn,"Select nama from inv_nama_generik WHERE id='".$row['id_generik']."' "));
     $charge_group=pg_fetch_assoc(pg_query($dbconn,"Select nama from inv_opsi_billing WHERE id='".$row['id_opsi_billing']."' "));
     $kategori_obat=pg_fetch_assoc(pg_query($dbconn,"Select nama from inv_obat_kategori WHERE id='".$row['id_kategori_obat']."' "));
     $satuan=pg_fetch_assoc(pg_query($dbconn,"Select nama from inv_satuan WHERE id='".$row['id_satuan']."' "));
                     ?>
                       <tr>
                        
                       
                        <td style="vertical-align:middle;"><?php echo $nama_brand["nama"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $nama_generik["nama"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $kategori_obat["nama"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $charge_group["nama"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $satuan["nama"] ?></td>
                       <!--  <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?inventori=indikasi&modul=data&update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a href="media.php?inventori=indikasi&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td> -->
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>
                

              </table>
             
            </div>
            <!-- /.box-body -->
          <!-- /.box -->

          </form>

        </div>
        <!-- /.col -->
      </div>

      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
