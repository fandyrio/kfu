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
                         <button type="button" onclick="location.href='media.php?content=mcu&modul=tambah'" class="btn btn-primary btn-xs pull-right">Tambah Data</button>    
                            </div>
            <br>
            <div class="card-body">
              <table id="myTable" class="table ">
                <thead class="table-success">
                <tr>
                <th width="10px">No.</th>
                  <th width="">Tanggal</th>
                  <th width="">Paket</th>
                  <th width="">Unit</th>
                  
                   <th width="60px"></th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
            if($_SESSION['id_units']>1){
                  $q= "Select p.*, u.harga, unit.nama  from billing_paket p 
                      INNER JOIN billing_paket_kategori_harga_unit u ON u.id_billing_paket = p.id
                      LEFT OUTER JOIN master_unit unit ON  unit.id=u.id_unit
                      where unit.id= '$_SESSION[id_units]' ORDER BY p.nama_paket ASC";
               
            }
            else{
                $q= "Select p.*, u.harga, unit.nama  from billing_paket p 
                      INNER JOIN billing_paket_kategori_harga_unit u ON u.id_billing_paket = p.id
                      LEFT OUTER JOIN master_unit unit ON  unit.id=u.id_unit
                  ORDER BY p.nama_paket ASC";
               }
                 $res=pg_query($dbconn,$q);
                 $no=1;

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>     
                       <td class="text-left" style="vertical-align:middle;"><?php echo $no++;?></td>                   
                        <td class="text-left" style="vertical-align:middle;"><?php echo DatetoIndo($row["waktu_input"]);?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["nama_paket"];?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["nama"];?></td>
                       
                        <td class="text-center" style="vertical-align:middle;">
                            <a href="media.php?content=mcu&modul=update&id=<?php echo $row['id']?>" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-edit"></i></a>
                            <a href="media.php?content=mcu&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
                        </td>
                       
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
  
