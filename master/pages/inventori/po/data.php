
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Purchase Order
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
                        
                          <button type="button" onclick="location.href='media.php?inventori=po&modul=new'" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Tambah Data</button>   
                  </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th width="10px">No</th>
                   <th >Doc No</th>
                   <th >Supplier</th>
                  <th >Persediaan Stok</th>
                   <th >Kuantiti</th>
                   <th >Terima</th>
                   <th >User</th>
                   <th >Sys Gen</th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"Select po_hdr.*, auth_users.username \"nama_admin\", po_ln.nama_brand, po_ln.jumlah, inv_satuan.nama as \"nama_satuan\" from po_hdr                
                   INNER JOIN auth_users on auth_users.id_users= po_hdr.createdby
                   INNER JOIN po_ln on po_ln.id_hdr= po_hdr.id
                   INNER JOIN inv_satuan on inv_satuan.id = po_ln.id_satuan");
                 $no=1;
                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        <td style="vertical-align:middle;"><?php echo $no++ ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['doc_date'] ?></td>
                        <td style="vertical-align:middle;"></td>
                        <td style="vertical-align:middle;"><?php echo $row['jumlah'] ?></td>
                        <td style="vertical-align:middle;"></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_admin'] ?></td>
                        <td style="vertical-align:middle;"></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?inventori=po&modul=update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a href="index.php?inventori=brand&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
