  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">Pergerakan Stok</li>

</ol>

  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <i class="icon-grid"></i> Stok Bergerak
            </div>

                  <div class="col-md-12 text-left">
                
                </div>


              <div class="card-block">




                <div class="form-horizontal">
                <div class="row">
                    <div class="col-md-2 col-sm-4" style="background-color: #FFFBFF; padding:0px;">
                     <h5><b> Stok Bergerak</b> </h5>
                    

                      <table id="bergerak" class="table table-bordered ">
                      Persedian Stok
                        <thead class="table-dark">

                        <tr>
                      
                          <th width="">Nama Brand</th>
                         
                        </tr>
                        </thead>
                        <tbody>
                     <?php

                         $res=pg_query($dbconn,"Select DISTINCT nama from inv_nama_brand 
                                      INNER JOIN inv_inventori on inv_inventori.id_brand = inv_nama_brand.id ");

                         while ($row=pg_fetch_assoc($res)) {
                             ?>
                               <tr id="<?php echo $row['nama'] ?>">
                                <td style="vertical-align:middle;"><a><?php echo $row['nama'] ?></a></td>             
                                </tr>
                            
                         
                         <?php } ?> 
                        </tbody>
                      </table>        
                           

                    </div>
                    <div class="col-md-10 col-sm-4" style="padding:0px;">
                                    <div class="col-md-12 text-right">

                      <div class="form-group row" style="padding-left: 0px">
                        <label class="col-sm-9 form-control-label">Departemen</label>

                        <div class="col-sm-3 " style="padding-left: 0px">  
                                           
                           <?php 
                            $result =pg_query($dbconn, "SELECT * FROM inv_departemen");
                           
                            ?>
                            <select name='id_departemen' class='form-control' required>
                            
                            <?php 
                            while ($row =pg_fetch_assoc($result)){
                              echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                            }
                            ?>
                            </select>
                            
                        </div>

                      </div> 
                        

                      </div>
                     
                    <div id="stok_gerak" style="padding:0px;"></div>
                    </div>
                </div>
                </div>
                </div>
             
              

        </div>
        <!-- /.col -->
      </div>
</div>
</div>
</div>

<script src="assets/js/action/stok_bergerak.js"></script>
