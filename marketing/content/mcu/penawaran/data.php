<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">MCU</li>

</ol>


<div class="container-fluid">
  <div class="animated fadeIn">
      <div class="row">   
        <div class="col-md-12 " >
         <div class="card">

        <form method="post">
            
            <div class="card-header">
              <i class="icon-grid"></i> Data
			  <span class="pull-right">
                         <button type="button" onclick="location.href='media.php?content=mcu&modul=tambah'" class="btn btn-primary btn-xs">Tambah Data</button>    
				</span>
                            </div>
            <div class="card-body">
              <table id="myTable" class="table ">
                <thead>
                <tr>
                <th width="10px">No.</th>
                  <th width="">Waktu Input</th>
                  <th width="">Paket</th>
                  <th width="">Perusahaan</th>
                  <th width="">Harga</th>
				  <th>Keterangan/Catatan</th>
                  <th width="">Status</th>
                   <th width="90px">Aksi</th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
            if($_SESSION['id_units']>1){
                  $q= "Select p.* from billing_paket p 
                      where id= '$_SESSION[id_units]' ORDER BY p.nama_paket ASC";
               
            }
            else{
                $q= "Select p.* from billing_paket p  ORDER BY p.nama_paket ASC";
               }
              
                 $res=pg_query($dbconn,$q);
                 $no=1;

                 while ($row=pg_fetch_assoc($res)) {
                   $result =pg_fetch_array(pg_query($dbconn, "SELECT nama FROM master_kategori_harga  where id= '$row[id_perusahaan]' "));
				   $harga_net=formatRupiah3($row['harga_net']);
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_status_penawaran WHERE id='$row[status]'"));
									$status="<span class='badge badge-$a[warna]'>$a[nama]</span>";
                     ?>
                       <tr>     
                       <td class="text-left" style="vertical-align:middle;"><?php echo $no++;?></td>                   
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["waktu_input"];?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["nama_paket"];?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $result["nama"];?></td>
						<td><?php echo $harga_net;?></td>
						<td><?php echo $row['keterangan'];?></td>
						<td><?php echo $status;?></td>
                       
                        <td class="text-left" style="vertical-align:middle;">
                        <a href="media.php?content=mcu&modul=view&id=<?php echo $row['id']?>" class="btn btn-info btn-xs btn-flat"><i class="fa fa-eye"></i></a>
            <?php
            if($row['status']==8){
            ?>
              <a href="media.php?content=mcu&modul=revisi&id=<?php echo $row['id']?>" class="btn btn-warning btn-xs btn-flat" title="revisi"><i class="fa fa-pencil-square"></i></a>
            <?php
              } 
            ?>
						<?php
						if($row['status']<4){
						?>
                            <a href="media.php?content=mcu&modul=update&id=<?php echo $row['id']?>" class="btn btn-warning btn-xs btn-flat" title="edit"><i class="fa fa-edit"></i></a>
                            <a href="media.php?content=mcu&modul=hapus_all&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
                        </td>
						<?php
						}
						?>
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>
               

              </table>
              </div>

          </form>

        <!-- /.col -->
      </div>

     </div>
    </div>
    </div>
    </div>
  
