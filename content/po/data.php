  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">Purchase Order</li>

</ol>

  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <i class="icon-grid"></i> Data
            </div>



            <div class="box-header">
                <div class="row">
                  <div class="col-md-6 text-left">
                    
                  </div>
                  <div class="col-md-6 text-right">
                        
                          <button type="button" onclick="location.href='media.php?inventori=po&modul=new'" class="btn btn-primary btn-xs"><i class="fa fa-dot-circle-o"></i>  Tambah Data</button>   
                  </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="card-block">
              <table id="myTable" class="table ">
                <thead class="table-dark">
                <tr>
                <th width="10px">No</th>
                   <th >Doc No</th>
                   <th >Supplier</th>
                  <th >Persediaan Stok</th>
                   <th >Kuantiti</th>
                   <th >Terima</th>
                   <th >User</th>
                  
                   <th>#</th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
             session_start();
                 $res=pg_query($dbconn,"Select po_hdr.*, auth_users.username \"nama_admin\", po_ln.nama_brand, po_ln.jumlah, inv_satuan.nama as \"nama_satuan\" from po_hdr                
                   INNER JOIN auth_users on auth_users.id_users= po_hdr.createdby
                   INNER JOIN po_ln on po_ln.id_hdr= po_hdr.id
                   INNER JOIN inv_satuan on inv_satuan.id = po_ln.id_satuan and id_unit='$_SESSION[id_units]'");
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
                        
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?inventori=po&modul=update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs"><i class="icon-note"></i></a>
                            <a href="media.php?inventori=po&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>
              

              </table>
             
                   </div>
                 </div>
               </div>
             </div>
            </div>
           </div>
      

      
    <script src="assets/js/action/purchase_order.js"></script>