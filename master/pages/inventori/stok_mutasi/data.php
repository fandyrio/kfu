
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Stok Mutasi
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
                          <button type="button" onclick="location.href='media.php?inventori=stok_mutasi&modul=new'" class="btn btn-primary btn-xs"> Tambah Data</button>   
                  </div>
                  <div class="col-md-6 text-right">
                          
                  </div>
                </div>
            </div>

                       <!-- /.box-header -->
            <!-- form start -->
          
              <div class="box-body form-horizontal" >
     

                <div class="form-group">
                  <label class="col-sm-1">Unit  </label>

                  <div class="col-sm-4">
                      <input type="text" value="<?php echo createRandomPassword() ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                  <label class="col-sm-1">Department</label>

                  <div class="col-sm-4">
                       <?php 
                      $result =pg_query($dbconn, "SELECT DISTINCT id_brand FROM inv_inventori");
                     
                      ?>
                      <select name='id_supplier' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['id_brand']."</option>";
                      }
                      ?>
                      </select>
                  </div>


                </div>


                 <div class="form-group">
                  <label  class="col-sm-1">Inventory</label>

                  <div class="col-sm-4">
                     <?php 
                      $result =pg_query($dbconn, "SELECT * FROM inv_inventori");
                     
                      ?>
                      <select name='id_supplier' class='form-control' required>
                      
                      <option value=''>Pilih</option>
                      <?php 
                      while ($row =pg_fetch_assoc($result)){
                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                      }
                      ?>
                      </select>
                  </div>
                </div>    
                </div>
            <!-- /.box-header -->
            <div class="box-body">
            <?php

            /*mutasi masuk*/
          error_reporting(0);
          $response_in = array(); 
          $res=pg_query($dbconn,"Select stok_trf_hdr.*,stok_trf_ln.qty, stok_trf_ln.nama_brand, auth_users.username, master_unit.nama as \"nama_unit\", inv_departemen.nama as \"nama_departemen\" from stok_trf_hdr
                          INNER JOIN stok_trf_ln on stok_trf_ln.id_trf_hdr = stok_trf_hdr.id
                          INNER JOIN auth_users on auth_users.id_users= stok_trf_hdr.id_users
                          INNER JOIN master_unit on master_unit.id = stok_trf_hdr.dari_unit
                          INNER JOIN inv_departemen on inv_departemen.id = stok_trf_hdr.dari_departemen");
         

    
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


          /*mutasi keluar*/
          $response_out = array(); 
          $result=pg_query($dbconn,"Select stok_trf_hdr.*,stok_trf_ln.qty, stok_trf_ln.nama_brand, auth_users.username, master_unit.nama as \"nama_unit\", inv_departemen.nama as \"nama_departemen\" from stok_trf_hdr
                          INNER JOIN stok_trf_ln on stok_trf_ln.id_trf_hdr = stok_trf_hdr.id
                          INNER JOIN auth_users on auth_users.id_users= stok_trf_hdr.id_users
                          INNER JOIN master_unit on master_unit.id = stok_trf_hdr.dari_unit
                          INNER JOIN inv_departemen on inv_departemen.id = stok_trf_hdr.ke_departemen");

    
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

              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                   <th>Unit</th>
                   <th>Departemen</th>                   
				           <th>Tanggal</th>
				           <th>No Dok</th>
                   <th>Nama Brand</th>
                   <th >Qty</th>
                   <th >Pengguna</th>
                   <th >Diproses</th> 
                   <th></th>                 
                </tr>
                </thead>
                <tbody>
                <tr><td style="font-weight: bold">Mutasi Masuk</td>
   
                </tr>
                 <?php

               foreach($json_array as $json){
                ?>
                       <tr>
                        <td style="vertical-align:middle;"><?php echo $json['unit'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['departemen'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['doc_date'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['qty'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json['username'] ?></td>
                        <td style="vertical-align:middle;"></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a  class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a  onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } ?>
                      <tr><td style="font-weight: bold">Mutasi Keluar</td>
           
                      </tr>


            <?php

               foreach($json_array_out as $json_out){
                ?>
                       <tr>
                        <td style="vertical-align:middle;"><?php echo $json_out['unit'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json_out['departemen'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json_out['doc_date'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json_out['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json_out['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json_out['qty'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $json_out['username'] ?></td>
                        <td style="vertical-align:middle;"></td>
                        <td class="text-center" style="vertical-align:middle;">
                            <a  class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a  onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } ?> 

                </tbody>
              </table>
             
            </div>

          </form>

        </div>
      </div>
    </section>
  </div>>
