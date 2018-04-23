<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">Stok Saat Ini</li>

</ol>

  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <i class="icon-grid"></i> Stok Saat Ini
            </div>
            <div class="box-header">
                <div class="box-header">
                    <div class="row">
                      <!-- <div class="col-md-6 text-left">
                         <button type="submit" name="hapus-contengan" class="btn btn-danger btn-xs"><span class="fa fa-close"></span>close</button>
                          <button type="button" id="save_closing_stok" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Closing</button>  
                           
                      </div> -->
                     
                    </div>
                </div>
                <div class="card-block">
                <div class="form-horizontal " >
                  <form method="post">

                <div class="form-group row">
                 
                  <label class="col-sm-1 form-control-label">Departemen</label>

                  <div class="col-sm-4">
                       <?php 
                          $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                         
                          ?>
                          <select name='id_departemen' class='form-control' required>
                          
                          <?php 
                          while ($row =pg_fetch_assoc($result)){
                            if(isset($_POST["cari"])){
                              if($_POST['id_departemen']== $row['id']){
                                echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";

                              }
                              else{
                                echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                              }
                              

                            }else   { echo "<option value='".$row['id']."'>".$row['nama']."</option>";}
                          }
                          ?>
                          </select>
                  </div>

                    <div class="col-sm-4">
                  <button type="submit" class="btn btn-primary btn-sm" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Cari</button>
                  
                    </a>
                  </div>
                </div> 
                 </form>      
                </div>
              </div>
                <div class="col-md-12 angel">
                  <?php include "current_balance.php" ?>
                 </div>
        </div>
        <!-- /.col -->
      </div>
    </div>
  </div>
</div>
</div>
<script src="assets/js/action/stok_saat_ini.js"></script>


  
    
