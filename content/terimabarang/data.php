<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">Terima Barang</li>

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
                        <button type="button" onclick="location.href='media.php?inventori=terimabarang&modul=new'" class="btn btn-primary btn-xs"> <i class="fa fa-dot-circle-o"></i> Tambah Data</button>   
                  </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="card-block">
            	<div class=" form-horizontal" >
        
                <form method="post">
                <div class="form-group row">
                  <label class="col-sm-1 form-control-label">Unit  </label>

                  <div class="col-sm-4">
                   <?php 
                          session_start();
                          $result =pg_query($dbconn, "SELECT * FROM master_unit where id='$_SESSION[id_units]'");
                          $row =pg_fetch_array($result)
                      ?>
                      <input type="text" value="<?php echo $row['nama'] ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                


                </div>
                <div class="form-group row">
                  <label class="col-sm-1 form-control-label">Department</label>

                  <div class="col-sm-4">
                       <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                     
                      ?>
                      <select name='id_departemen' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                          if(isset($_POST["cari"]))
                          {
                             
                              $id_dept=$_POST["id_departemen"];
                             if($id_dept== $row['id']){
                                            echo "<option value='".$id_dept."' selected>".$row['nama']."</option>";
                                          }
                                          else{
                                          echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                                      }                 

                          }

                       else{
                              echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                              }
                      }
                      ?>
                      </select>
                  </div>
                  <div class="col-sm-3">
                  <button type="submit" class="btn btn-primary btn-sm" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Cari</button>
                  <a href="inventori-grn"><button type="button" class="btn btn-sm btn-danger" ><i class="fa fa-ban"></i> Tampilkan Semua</button>
                    </a>
                  </div>
                  </div>

 
                </form>  
                </div>
              <table id="myTable" class="table">
                <thead class="table-dark">
                <tr>               
                   <th>Departemen</th>
                   <th >Supplier</th>
				          <th>Tgl Dok.</th>
                   <th >Nama Brand</th>
                   <th >Qty</th>
                   <th >Satuan</th>
                   <th >Harga Unit</th>
                   <th >Nett Total</th>
                    <th></th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
             session_start();
                $sql= "Select g.*, inv_info_supplier.nama as \"nama_supplier\",
                inv_departemen.nama as \"nama_departemen\" from grn_hdr g 
                INNER JOIN inv_info_supplier on inv_info_supplier.id= g.id_supplier
                INNER JOIN inv_departemen on inv_departemen.id= g.id_departemen
                ";
                if(isset($_POST['cari'])){
                  $deptid = $_POST["id_departemen"];
                  $sql.=" WHERE g.id_departemen='$deptid' and g.id_unit='$_SESSION[id_units]' order by g.id desc";
                }
                else{
                   $sql.=" where g.id_unit='$_SESSION[id_units]' order by g.id desc";
                }
               
                 $res=pg_query($dbconn,$sql);

                 while ($data=pg_fetch_assoc($res)) {?>
                  <tr class="table-secondary">
                  <td colspan="9"><b><?php echo $data['doc_no'] ?></b></td>
                  </tr>
                  
                    <?php 
                     $qry= "Select l.*, s.nama as \"satuan_nama\" from grn_ln l
                     LEFT OUTER JOIN inv_satuan s ON s.id=l.id_satuan
                      WHERE l.id_hdr='".$data['id']."' order by l.id asc";
                     
                     $r=pg_query($dbconn,$qry);
                    
                    while ($row=pg_fetch_assoc($r)) {
                     ?>
                       <tr>                       
                        <td style="vertical-align:middle;"><?php echo $data['nama_departemen'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $data['nama_supplier'] ?></td>
                        <td style="vertical-align:middle;"><?php echo DatetoIndo($data['doc_date']); ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['qty']; ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['satuan_nama'] ?></td>
                        <td style="text-align:right;"><?php echo number_format($row['harga_unit'],0, '.', '.');?></td>
                        <td style="text-align:right;"><?php echo number_format($row['nett_total'],0, '.', '.'); ?></td>
                        <td class="text-center" style="vertical-align:middle;">

                        <?php 
                        	$q= "select sum(qty_out) as jum from inv_fifo where id_hdr='$data[id]' and doc_type='GRN' ";
                         $ceker=pg_fetch_assoc(pg_query($dbconn,$q));

                         if($ceker['jum'] ==0){
                         	?>
                         	 <a href="media.php?inventori=terimabarang&modul=update&id=<?php echo $data['id'] ?>" class="btn btn-warning btn-xs"><span class="icon-note" aria-hidden="true"></span></a>
                            <a href="media.php?inventori=terimabarang&modul=hapus&id=<?php echo $data['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><i class="icon-trash" aria-hidden="true"></i></a> 

                         <?php
                         }
                         else {
                        ?>
                        <a  class="btn btn-primary btn-xs disabled"><span class="icon-note" aria-hidden="true"></span></a>
                            <a  class="btn btn-primary btn-xs disabled"><i class="icon-trash" aria-hidden="true"></i></a> 
                         <?php 
                     }
                     ?>
                     <a href="media.php?inventori=terimabarang&modul=view&id=<?php echo $data['id'] ?>" class="btn btn-info btn-xs"><span class="icon-eye" aria-hidden="true"></span></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php 
               }
               }?> 
                </tbody>
              

              </table>
             
            </div>
            <!-- /.box-body -->
          <!-- /.box -->

         </div>
       </div>
     </div>
   </div>
 </div>


