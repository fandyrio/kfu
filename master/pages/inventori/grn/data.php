<?php
if(isset($_POST['hapus-contengan'])){
    $imp = "('".implode("','",array_values($_POST['checkbox']))."')";
    $sql =pg_query($dbconn, "DELETE FROM grn_hdr WHERE id in $imp");
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Terima Barang
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
                          <button type="button" onclick="location.href='media.php?inventori=grn&modul=new'" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Tambah Data</button>   
                  </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                <th width="10px"></th>
                   <th>Departemen</th>
                   <th >Supplier</th>
				          <th>Tgl Dok.</th>
                   <th >No Dok.</th>
                   <th >Qty</th>
                   <th >Satuan</th>
                   <th >Harga Unit</th>
                   <th >Nett Total</th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
                $sql= "Select g.*, inv_info_supplier.nama as \"nama_supplier\",
                inv_departemen.nama as \"nama_departemen\" from grn_hdr g 
                INNER JOIN inv_info_supplier on inv_info_supplier.id= g.id_supplier
                INNER JOIN inv_departemen on inv_departemen.id= g.id_departemen
                ";
                //var_dump($sql);
                 $res=pg_query($dbconn,$sql);

                 while ($data=pg_fetch_assoc($res)) {?>
                  <tr>
                  <td><?php echo $data['doc_no'] ?></td>
                  </tr>
                  
                    <?php 
                     $qry= "Select l.* from grn_ln l ";
                     $res=pg_query($dbconn,$sql);
                     while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id'] ?>" name="checkbox[]" /></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_departemen'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_supplier'] ?></td>
                        <td style="vertical-align:middle;"></td>
                        <td style="vertical-align:middle;"></td>
                        <td style="vertical-align:middle;"></td>
                        <td style="vertical-align:middle;"></td>
                        <td style="vertical-align:middle;"></td>
                        <td style="vertical-align:middle;"></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?inventori=grn&modul=update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a href="index.php?inventori=grn&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } 
               }?> 
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
