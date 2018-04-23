<?php
if(isset($_POST['hapus-contengan'])){
    $imp = "('".implode("','",array_values($_POST['checkbox']))."')";
    $sql =pg_query($dbconn, "DELETE FROM retur_hdr WHERE id in $imp");
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
       Retur Barang
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
                          
                          <button type="button" onclick="location.href='media.php?inventori=retur&modul=new'" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Tambah Data</button>   
                  </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                
                  <th >No Dok.</th>
				  <th >Tgl Dok.</th> 
				  <th >Supplier</th>   
				  <th >Nama Inventori</th>				  
                   <th >Qty</th>
                   <th >Satuan</th>
                  
                  
                </tr>
                </thead>
                <tbody>
             <?php
                $sql= "Select g.*, inv_info_supplier.nama as \"nama_supplier\",
                inv_departemen.nama as \"nama_departemen\" from retur_hdr g 
                INNER JOIN inv_info_supplier on inv_info_supplier.id= g.id_supplier
                INNER JOIN inv_departemen on inv_departemen.id= g.id_departemen";
                 $res=pg_query($dbconn,$sql);

                  while ($data=pg_fetch_assoc($res)) {?>
                  <tr>
                  <td colspan="7"><b><?php echo $data['doc_no'] ?></b></td>
                  </tr>
                  
                    <?php 
                     $qry= "Select l.*, s.nama from retur_ln l 
                     LEFT OUTER JOIN inv_satuan s on s.id=l.id_satuan ";
                     $res1=pg_query($dbconn,$qry);
                     while ($row=pg_fetch_assoc($res1)) {
                     ?>
                       <tr>
                        
                        <td style="vertical-align:middle;"><?php echo $data['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $data['doc_date'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $data['nama_supplier'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_inventori'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['qty'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama'] ?></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?inventori=retur&modul=update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a href="index.php?inventori=retur&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } }?> 
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
