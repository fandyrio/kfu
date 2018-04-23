
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Buka Stok
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
                          <button type="submit" name="hapus-contengan" class="btn btn-danger btn-xs"><span class="fa fa-close"></span> Hapus Ceklis</button>
                          <button type="button" onclick="location.href='media.php?inventori=stok_buka&modul=new'" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Tambah Data</button>   
                  </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                
                   <th>Departemen</th>
                   <th>No Buka</th>
				            <th>Tanggal</th>
                   <th >Nama Brand</th>
                   <th >Qty</th>
                   <th >Owned By</th>                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"select h.doc_no,h.createddate,l.qty, d.nama as \"nama_departemen\" , 
              u.username as \"username\", l.nama_brand as \"nama_brand\" 
                from stok_buka_hdr as h
                LEFT OUTER JOIN stok_buka_qty as l on l.id_buka_stok_hdr = h.id
                LEFT OUTER JOIN stok_buka_batch as b on b.id_stok_buka_hdr = h.id
                LEFT OUTER JOIN inv_departemen as d on d.id = h.id_departemen
               
                LEFT OUTER JOIN auth_users as u on u.id_users = h.id_users");

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                       
                        <td style="vertical-align:middle;"><?php echo $row['nama_departemen'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['createddate'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['qty'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['username'] ?></td>
                       
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
