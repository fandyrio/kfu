<?php
if(isset($_POST['hapus-contengan'])){
    $imp = "('".implode("','",array_values($_POST['checkbox']))."')";
    $sql =pg_query($dbconn, "DELETE FROM grn_hdr WHERE id in $imp");
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
       Stok Penyesuaian
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
                          <button type="submit" name="hapus-contengan" class="btn btn-danger btn-xs"><span class="fa fa-close"></span> Hapus Ceklis</button>
                          <button type="button" onclick="location.href='media.php?inventori=stok_penyesuaian&modul=new'" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Tambah Data</button>   
                  </div>
                </div>
            </div>
            <div class="box-body form-horizontal" >
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
