  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Request Quotation
      </h1>
    
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="col-xs-12">
          <div class="box box-primary">
        <form method="post">
            <div class="box-header">
                <div class="row">
                  <div class="col-md-6 text-left">
                    
                  </div>
                  <div class="col-md-6 text-right">
                          <button type="button" onclick="location.href='media.php?inventori=rq&modul=new'" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Tambah Data</button>   
                  </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                   <th >Doc No </th>
                  <th >Doc Date</th>
                  <th >Supplier</th>
                  <th >Nama Brand</th>
                   <th >Kuantiti</th>
                   <th >Satuan</th>
                   <th ></th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
             unset($_SESSION['id_rq_hdr']);
                 $res=pg_query($dbconn,"Select rq_hdr.*, inv_info_supplier.nama as \"nama_supplier\", auth_users.username \"nama_admin\", rq_ln.nama_brand, rq_ln.jumlah, inv_satuan.nama as \"nama_satuan\" from rq_hdr
                   INNER JOIN inv_info_supplier on inv_info_supplier.id= rq_hdr.id_supplier
                   INNER JOIN auth_users on auth_users.id_users= rq_hdr.createdby
                   INNER JOIN rq_ln on rq_ln.id_rq= rq_hdr.id
                   INNER JOIN inv_satuan on inv_satuan.id = rq_ln.id_satuan");

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        <td style="vertical-align:middle;"><?php echo $row['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['doc_date'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_supplier'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['jumlah'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_satuan'] ?></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?inventori=rq&modul=update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a href="media.php?inventori=rq&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>
                       
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
