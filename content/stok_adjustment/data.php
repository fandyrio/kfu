<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">Stok Adjustment</li>

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
                      <div class="col-md-12 text-right">
                        <button type="button" onclick="location.href='inventori-add-adjustment'" class="btn btn-primary btn-xs"> <i class="fa fa-dot-circle-o"></i> Tambah Data</button> 
                        <!--  <button type="button" onclick="location.href=''" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> View</button>
                           <button type="button" onclick="location.href=''" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Delete</button>   -->
                            <!--button type="button" onclick="location.href=''" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Setting</button-->  
                      </div>
                     
                    </div>
                  </div>
          
              <div class="card-block" >
              <div class=" form-horizontal" >
                <form method="post">

                <div class="form-group row">
                  <label class="col-sm-1 form-control-label">Unit  </label>

                  <div class="col-sm-3">
                   <?php 
                      $row =pg_fetch_array(pg_query($dbconn, "SELECT * FROM master_unit where id='$_SESSION[id_units]'"));
                     
                      ?>

                      <input type="hidden" name="id_unit" class="form-control" value="<?php echo $row['id']  ?>">
                      <?php echo ": ".$row['nama']  ?>
                  </div>
                  <label class="col-sm-1 form-control-label">Department</label>

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
                  <a href="inventori-stok-adjustment"><button type="button" class="btn btn-sm btn-danger" ><i class="fa fa-ban"></i> Tampilkan Semua</button>
                    </a>
                  </div>


                </div>


                 <div class="form-group row">
                  <label  class="col-sm-1 form-control-label">Inventory</label>

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
                
           <br>
              <!-- /.box-body --> 
               <table id="myTable" class="table">
                <thead class="table-dark">
                <tr>
                  <th>Departemen</th>
                   <th >Tanggal</th>
                    <th >No Document </th>
                   <th >Nama Brand</th>
                   <th >Qty</th>
                   <th >Satuan</th>
                   <th></th>
                   
                </tr>
                </thead>
                <tbody>
             <?php
             if(isset($_POST["cari"]))
                  {

                     $res=pg_query($dbconn,"select h.id, h.doc_no,h.createddate,l.qty,l.id as \"id_ln\", d.nama as \"nama_departemen\" , s.nama as \"nama_satuan\", l.nama_brand as \"nama_brand\" 
                  from stok_adj_hdr as h
                  LEFT OUTER JOIN stok_adj_ln as l on l.id_hdr = h.id
                  LEFT OUTER JOIN inv_departemen as d on d.id = h.id_departemen
                  LEFT OUTER JOIN inv_satuan as s on s.id = l.id_satuan where h.id_departemen='".$_POST['id_departemen']."' and l.nama_brand='".$_POST['id_brand']."'");



                  }else{
                 $res=pg_query($dbconn,"select h.id, h.doc_no,h.createddate,l.qty,l.id as \"id_ln\", d.nama as \"nama_departemen\" , s.nama as \"nama_satuan\", l.nama_brand as \"nama_brand\" 
                  from stok_adj_hdr as h
                  LEFT OUTER JOIN stok_adj_ln as l on l.id_hdr = h.id
                  LEFT OUTER JOIN inv_departemen as d on d.id = h.id_departemen
                  LEFT OUTER JOIN inv_satuan as s on s.id = l.id_satuan");
               }

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        <td style="vertical-align:middle;"><?php echo $row['nama_departemen'] ?></td>
                        <td style="vertical-align:middle;"><?php echo tgl_indo($row['createddate']) ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['qty'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_satuan'] ?></td>
                        <td>
                         <a  href="view-stok-adj-<?php echo $row['id'];?>"  class="btn btn-primary btn-xs"><i class="icon-eye" title="view"></i></a>
                         <a  href="proses-hapus-stok-adj-<?php echo $row['id'];?>"  onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs"><i class="icon-trash" title="hapus"></i></a>
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
