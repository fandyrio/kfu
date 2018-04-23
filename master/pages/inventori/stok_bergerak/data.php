
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Stok Bergerak
      </h1>
    
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">

                <div class="box-header">
                    <div class="row">

                      <div class="col-md-6 text-left">
                                   
                           <button type="button" onclick="location.href=''" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Setting</button>  

                  
                      </div>
                      <div class="col-md-6 text-right">

                      <div class="form-group" style="padding-left: 0px">
                        <label class="col-sm-4">Departemen</label>

                        <div class="col-sm-6 text-right" style="padding-left: 0px">  
                                           
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
                     
                    </div>


                </div>
                <div class="box-body ">
                    <div class="col-md-2 col-sm-4" style="background-color: #FFFBFF; padding:0px;">
                     <h5><b> Stok Bergerak</b> </h5>
                    

                      <table id="bergerak" class="table table-bordered table-striped">
                      persedian Stok
                        <thead>

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
                    <div id="stok_gerak" style="padding:0px;"></div>
                    </div>
                </div>
             
              

        </div>
        <!-- /.col -->
      </div>

  
      <!-- /.row -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
