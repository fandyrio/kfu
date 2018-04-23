  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">Pengembalian</li>

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
                          
                          <button type="button" onclick="location.href='media.php?inventori=retur&modul=new'" class="btn btn-primary btn-xs"><i class="icon-plus"></i> Tambah Data</button>   
                  </div>
                </div>
            </div>

            <div class="card-block">
               <div class=" form-horizontal" >
                <form method="post">

                <div class="form-group row">
                  <label class="col-sm-1">Unit  </label>

                  <div class="col-sm-3">
                   <?php 
                          session_start();
                          $result =pg_query($dbconn, "SELECT * FROM master_unit where id='$_SESSION[id_units]'");
                          $row =pg_fetch_array($result)
                      ?>
                      <input type="text" value="<?php echo $row['nama'] ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                  <label class="col-sm-1">Department</label>

                  <div class="col-sm-3">
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
                  <a href="inventori-kembali"><button type="button" class="btn btn-sm btn-danger" ><i class="fa fa-ban"></i> Tampilkan Semua</button>
                    </a>
                  </div>


                </div>


                 <div class="form-group row">
                  <label  class="col-sm-1">Inventory</label>

                  <div class="col-sm-3">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_nama_brand");
                     
                      ?>
                      <select name='id_brand' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        if(isset($_POST["cari"]))
                          {
                             
                              $id_b=$_POST["id_brand"];
                             if($id_b== $row['nama']){
                                          echo "<option value='".$id_b."' selected>".$row['nama']."</option>";
                                          }
                                          else{
                                          echo "<option value='".$row['nama']."'>".$row['nama']."</option>";
                                      }                 

                          }

                       else{
                              echo "<option value='".$row['nama']."'>".$row['nama']."</option>";
                              }

                      }
                      ?>
                      </select>
                  </div>
                </div>

                </form>    
                </div> 
              <table class="table " id="myTable">
                <thead class="table-dark">
                <tr>
                
                  <th >No Dok.</th>
        				  <th >Tgl Dok.</th> 
        				  <th >Supplier</th>   
        				  <th >Nama Inventori</th>				  
                   <th >Qty</th>
                   <th >Satuan</th>
                   <th>#</th>
                  
                  
                </tr>
                </thead>
                <tbody>
             <?php
              if(isset($_POST["cari"]))
                {
                    $sql= "Select g.*, inv_info_supplier.nama as \"nama_supplier\",
                    inv_departemen.nama as \"nama_departemen\" from retur_hdr g 
                    INNER JOIN inv_info_supplier on inv_info_supplier.id= g.id_supplier
                    INNER JOIN inv_departemen on inv_departemen.id= g.id_departemen
                    WHERE g.id_departemen=='".$_POST['id_departemen']."' ";
                 }
                 else{
                  $sql= "Select g.*, inv_info_supplier.nama as \"nama_supplier\",
                    inv_departemen.nama as \"nama_departemen\" from retur_hdr g 
                    INNER JOIN inv_info_supplier on inv_info_supplier.id= g.id_supplier
                    INNER JOIN inv_departemen on inv_departemen.id= g.id_departemen";
                 }
                 $res=pg_query($dbconn,$sql);

                  while ($data=pg_fetch_assoc($res)) {?>
                  <tr>
                  <td colspan="7"><b><?php echo $data['doc_no'] ?></b></td>
                  </tr>
                  
                    <?php 
                     $qry= "Select l.*, s.nama from retur_ln l 
                     LEFT OUTER JOIN inv_satuan s on s.id=l.id_satuan WHERE l.id_hdr='".$data['id']."' ";
                     if(isset($_POST["cari"]))
                     {
                       $qry.=" and l.nama_brand='".$_POST['id_brand']."' ";
                      }
                     $res1=pg_query($dbconn,$qry);
                     while ($row=pg_fetch_assoc($res1)) {
                     ?>
                       <tr>
                        
                        <td ><?php echo $data['doc_no'] ?></td>
                        <td ><?php echo $data['doc_date'] ?></td>
                        <td ><?php echo $data['nama_supplier'] ?></td>
                        <td ><?php echo $row['nama_inventori'] ?></td>
                        <td ><?php echo $row['qty'] ?></td>
                        <td ><?php echo $row['nama'] ?></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <!-- <a href="media.php?inventori=retur&modul=update&id=<?php echo $row['id'] ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> -->
                            <a href="media.php?inventori=retur&modul=hapus&id=<?php echo $data['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><span class="icon icon-trash" aria-hidden="true"></span></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } }?> 
                </tbody>
              

              </table>
              </div>
         </div>
      </div>
    </div>
  </div>
</div>

             
