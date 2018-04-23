  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">Stok Penyesuaian</li>

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
                          <button type="button" onclick="location.href='media.php?inventori=stok_penyesuaian&modul=new'" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Tambah Data</button>   
                  </div>
                </div>
            </div>
            <div class="form-horizontal" >
                <div class="form-group">
                  <label class="col-sm-1">Unit  </label>

                  <div class="col-sm-4">
                      <input type="text" value="<?php echo createRandomPassword() ?>" autocomplete="off" class="form-control" readonly name="doc_no">
                  </div>
                  <label class="col-sm-1">Aktif</label>

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
                  <label  class="col-sm-1">Inventori</label>

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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                   <th>Departemen</th>
                   <th>No Stok Penyesuaian</th>
				           <th>Tanggal</th>
                   <th >Nama Brand</th>
                   <th >Qty</th>
                   <th >Owned By</th>                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"select h.doc_no,h.createddate,l.beda_qty, d.nama as \"nama_departemen\" , 
      u.username as \"username\", l.nama_brand as \"nama_brand\" 
                from stok_take_hdr as h
                LEFT OUTER JOIN stok_take_qty as l on l.id_stok_take_hdr = h.id
                LEFT OUTER JOIN stok_take_batch as b on b.id_stok_take_hdr = h.id
                LEFT OUTER JOIN inv_departemen as d on d.id = h.id_departemen
               
                LEFT OUTER JOIN auth_users as u on u.id_users = h.id_users");

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                        
                        <td style="vertical-align:middle;"><?php echo $row['nama_departemen'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['doc_no'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['createddate'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['nama_brand'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['beda_qty'] ?></td>
                        <td style="vertical-align:middle;"><?php echo $row['username'] ?></td>
                       
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
  
            
