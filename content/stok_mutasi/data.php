  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">Mutasi Stok</li>

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
                          <button type="button" onclick="location.href='inventori-add-mutasi'" class="btn btn-primary btn-xs"> <i class="fa fa-dot-circle-o"></i> Tambah Data</button>   
                  </div>
                </div>
            </div>

                       <!-- /.box-header -->
            <!-- form start -->
          
          <div class="card-block">
              <div class=" form-horizontal" >
        
                <form method="post">
                <div class="form-group row">
                  <label class="col-sm-1 form-control-label">Unit  </label>

                  <div class="col-sm-4">
                   <?php 
                      $row =pg_fetch_array(pg_query($dbconn, "SELECT * FROM master_unit where id='$_SESSION[id_units]'"));
                     
                      ?>

                      <input type="hidden" name="id_unit" class="form-control" value="<?php echo $row['id']  ?>">
                      <?php echo ": ".$row['nama']  ?>
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
                  <a href="inventori-stok-mutasi"><button type="button" class="btn btn-sm btn-danger" ><i class="fa fa-ban"></i> Tampilkan Semua</button>
                    </a>
                  </div>
                  </div>

<!-- 
                 <div class="form-group row">
                  <label  class="col-sm-1">Inventory</label>

                  <div class="col-sm-4">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_nama_brand");
                     
                      ?>
                      <select name='id_brand' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div> -->  
                </form>  
                </div>
            <!-- /.box-header -->
            <?php

            /*mutasi masuk*/
          error_reporting(0);
          $response_in = array(); 
          if(isset($_POST["cari"]))
                  {
                    $deptid = $_POST["id_departemen"];

          $res=pg_query($dbconn,"Select stok_trf_hdr.*,stok_trf_ln.qty, stok_trf_ln.nama_brand, auth_users.username, master_unit.nama as \"nama_unit\", inv_departemen.nama as \"nama_departemen\" from stok_trf_hdr
                          INNER JOIN stok_trf_ln on stok_trf_ln.id_hdr = stok_trf_hdr.id
                          INNER JOIN auth_users on auth_users.id_users= stok_trf_hdr.id_users
                          INNER JOIN master_unit on master_unit.id = stok_trf_hdr.dari_unit
                          INNER JOIN inv_departemen on inv_departemen.id = stok_trf_hdr.dari_departemen WHERE stok_trf_hdr.proses_by is NOT NULL and stok_trf_hdr.dari_departemen='".$deptid."'");

                  }
                else{
          $res=pg_query($dbconn,"Select stok_trf_hdr.*,stok_trf_ln.qty, stok_trf_ln.nama_brand, auth_users.username, master_unit.nama as \"nama_unit\", inv_departemen.nama as \"nama_departemen\" from stok_trf_hdr
                          INNER JOIN stok_trf_ln on stok_trf_ln.id_hdr = stok_trf_hdr.id
                          INNER JOIN auth_users on auth_users.id_users= stok_trf_hdr.id_users
                          INNER JOIN master_unit on master_unit.id = stok_trf_hdr.dari_unit
                          INNER JOIN inv_departemen on inv_departemen.id = stok_trf_hdr.dari_departemen WHERE stok_trf_hdr.proses_by is NOT NULL");
         
        }
    
          while ($row = pg_fetch_assoc($res)) {
              $mutasi_in = array();
              
              $mutasi_in["id"] = $row["id"];
              $mutasi_in["unit"] = $row["nama_unit"];            
              $mutasi_in["departemen"] = $row["nama_departemen"];
              $mutasi_in["doc_date"] = $row["doc_date"];
              $mutasi_in["doc_no"] = $row["doc_no"];
              $mutasi_in["nama_brand"] = $row["nama_brand"];
              $mutasi_in["qty"] = $row["qty"];
              $mutasi_in["username"] = $row["username"];
              //$mutasi_in["total_cost"] = $row["nett_total"];
             //$bergerak["pengalaman"] = $row["pengalaman"];    
              array_push($response_in, $mutasi_in);
          }

          // echo json_encode($response_in);
           $data = json_encode($response_in); 
           $json_array = json_decode($data, true);


          /*mutasi masuk dan keluar*/
          $response_out = array();
          if(isset($_POST["cari"]))
          {
          $deptid = $_POST["id_departemen"]; 
          $result=pg_query($dbconn,"Select stok_trf_hdr.*,stok_trf_ln.qty, stok_trf_ln.nama_brand, auth_users.username, master_unit.nama as \"nama_unit\", inv_departemen.nama as \"nama_departemen\" from stok_trf_hdr
                          INNER JOIN stok_trf_ln on stok_trf_ln.id_hdr = stok_trf_hdr.id
                          INNER JOIN auth_users on auth_users.id_users= stok_trf_hdr.id_users
                          INNER JOIN master_unit on master_unit.id = stok_trf_hdr.ke_unit
                          INNER JOIN inv_departemen on inv_departemen.id = stok_trf_hdr.ke_departemen WHERE stok_trf_hdr.proses_by is NOT NULL and stok_trf_hdr.ke_departemen='".$deptid."'");
            }else{
                $result=pg_query($dbconn,"Select stok_trf_hdr.*,stok_trf_ln.qty, stok_trf_ln.nama_brand, auth_users.username, master_unit.nama as \"nama_unit\", inv_departemen.nama as \"nama_departemen\" from stok_trf_hdr
                                      INNER JOIN stok_trf_ln on stok_trf_ln.id_hdr = stok_trf_hdr.id
                                      INNER JOIN auth_users on auth_users.id_users= stok_trf_hdr.id_users
                                      INNER JOIN master_unit on master_unit.id = stok_trf_hdr.ke_unit
                                      INNER JOIN inv_departemen on inv_departemen.id = stok_trf_hdr.ke_departemen WHERE stok_trf_hdr.proses_by is NOT NULL");

            }
     

    
          while ($data = pg_fetch_assoc($result)) {
              $mutasi_out = array();
              
              $mutasi_out["id"] = $data["id"];
              $mutasi_out["unit"] = $data["nama_unit"];            
              $mutasi_out["departemen"] = $data["nama_departemen"];
              $mutasi_out["doc_date"] = $data["doc_date"];
              $mutasi_out["doc_no"] = $data["doc_no"];
              $mutasi_out["nama_brand"] = $data["nama_brand"];
              $mutasi_out["qty"] = $data["qty"];
              $mutasi_out["username"] = $data["username"];   
              array_push($response_out, $mutasi_out);
          }

          // echo json_encode($response_out);
           $data_out = json_encode($response_out); 

           $json_array_out = json_decode($data_out, true);

          ?>


              <table class="table table-bordered ">
                <thead >
                <tr class="table-dark">
                   <th>Unit</th>
                   <th>Departemen</th>                   
				           <th>Tanggal</th>
				           <th>No Dok</th>
                   <th>Nama Brand</th>
                   <th >Qty</th>
                   <th >Pengguna</th>
                   <th >Status Proses</th> 
                   <th></th>                 
                </tr>
                </thead>
                <tbody>

                <?php
                if(isset($_POST["cari"]))
                    {
                    $deptid = $_POST["id_departemen"];
                     $res=pg_query($dbconn,"Select stok_trf_hdr.*,stok_trf_ln.qty, stok_trf_ln.nama_brand, auth_users.username, master_unit.nama as \"nama_unit\", inv_departemen.nama as \"nama_departemen\" from stok_trf_hdr
                          INNER JOIN stok_trf_ln on stok_trf_ln.id_hdr = stok_trf_hdr.id
                          INNER JOIN auth_users on auth_users.id_users= stok_trf_hdr.id_users
                          INNER JOIN master_unit on master_unit.id = stok_trf_hdr.dari_unit
                          INNER JOIN inv_departemen on inv_departemen.id = stok_trf_hdr.dari_departemen WHERE stok_trf_hdr.proses_by is NULL and stok_trf_hdr.ke_departemen='".$deptid."'");

                  }else{

                   $res=pg_query($dbconn,"Select stok_trf_hdr.*,stok_trf_ln.qty, stok_trf_ln.nama_brand, auth_users.username, master_unit.nama as \"nama_unit\", inv_departemen.nama as \"nama_departemen\" from stok_trf_hdr
                          INNER JOIN stok_trf_ln on stok_trf_ln.id_hdr = stok_trf_hdr.id
                          INNER JOIN auth_users on auth_users.id_users= stok_trf_hdr.id_users
                          INNER JOIN master_unit on master_unit.id = stok_trf_hdr.dari_unit
                          INNER JOIN inv_departemen on inv_departemen.id = stok_trf_hdr.dari_departemen WHERE stok_trf_hdr.proses_by is NULL");
                  } 
                ?>

                <tr class="table-secondary"><td colspan="9" >Mutasi Masuk Belum Diproses</td>
                

                  </tr>

                <?php

                    while ($data = pg_fetch_assoc($res)) {



               ?>
                <tr>
                        <td style="vertical-align:middle;"><?php echo $data['nama_unit'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $data['nama_departemen'] ?></td>
                        <td style="vertical-align:middle;"><?php echo tgl_indo($data['doc_date']) ?></td>
                        <td style="vertical-align:middle;"><?php echo $data['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $data['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $data['qty'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $data['username'] ?></td>
                        <td style="vertical-align:middle;">Belum diproses</td>
                       <td class="text-center" style="vertical-align:middle;">
                            <a  class="btn btn-warning btn-xs" href="proses-edit-trf-<?php echo $data['id'];?>" title="ubah"><i class="icon-note"></i></a>
                            <a  class="btn btn-primary btn-xs" href="proses-stok-trf-<?php echo $data['id'];?>" title="proses"><i class="icon-login"></i></a>
                            <a  href="proses-hapus-stok-trf-<?php echo $data['id'];?>"  onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><i class="icon-trash" title="hapus"></i></a>
                        </td> 
                       
                        </tr>
                  <?php }?>      

                <tr class="table-secondary"><td colspan="9" >Mutasi Masuk</td>
               
   
                </tr>
                 <?php

               foreach($json_array as $json){
                ?>
                       <tr>
                        <td style="vertical-align:middle;"><?php echo $json['unit'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['departemen'] ?></td>
                        <td style="vertical-align:middle;"><?php echo tgl_indo($json['doc_date']) ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['qty'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['username'] ?></td>
                        <td style="vertical-align:middle;">Proses</td>
                       <!--  <td class="text-center" style="vertical-align:middle;">
                            <a  class="btn btn-warning btn-xs"><i class="icon-note"></i></span></a>
                            <a  onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>
                        </td> -->
                        <td class="text-center" style="vertical-align:middle;"> 
                          <a  href="view-stok-trf-<?php echo $json['id'];?>"  class="btn btn-primary btn-xs"><i class="icon-eye" title="view"></i></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } ?>
                      <tr class="table-secondary">
                      <td colspan="9" >Mutasi Keluar</td>
           
                      </tr>


            <?php

               foreach($json_array_out as $json_out){
                ?>
                       <tr>
                        <td style="vertical-align:middle;"><?php echo $json_out['unit'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json_out['departemen'] ?></td>
                        <td style="vertical-align:middle;"><?php echo tgl_indo($json_out['doc_date']) ?></td>
                        <td style="vertical-align:middle;"><?php echo $json_out['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json_out['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json_out['qty'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json_out['username'] ?></td>
                        <td style="vertical-align:middle;">Proses</td>
                        <!-- <td class="text-center" style="vertical-align:middle;">
                            <a  class="btn btn-warning btn-xs"><i class="icon-note"></i></a>
                            <a  onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>
                        </td> -->
                        <td class="text-center" style="vertical-align:middle;">
                          <a  href="view-stok-trf-<?php echo $json_out['id'];?>"  class="btn btn-primary btn-xs"><i class="icon-eye" title="view"></i></a>
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


