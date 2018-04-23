 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Stok Saat Ini
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
                         <button type="submit" name="hapus-contengan" class="btn btn-danger btn-xs"><span class="fa fa-close"></span>close</button>
                          <button type="button" id="save_closing_stok" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Closing</button>  
                           <!--button type="button"  class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Setting</button-->  
                      </div>
                     
                    </div>
                </div>
                <div class="box-body form-horizontal " >
     

                <div class="form-group text-right">
                 
                  <label class="col-sm-1">Department</label>

                  <div class="col-sm-4">
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


            <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">Current Balance</a></li>
                  <li><a href="#tab2" data-toggle="tab">Closing Balance</a></li>
                    <!--li><a href="#tab_3" data-toggle="tab">Costing</a></li-->
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">  
                <?php include "current_balance.php" ?>
        
              </div>
            <div class="tab-pane" id="tab2">  
                <?php include "closing_balance.php" ?>
            
            </div>
              <!-- /.tab-pane -->
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
            <!-- /.box-header -->
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
