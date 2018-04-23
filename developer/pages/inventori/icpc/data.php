<?php
if(isset($_POST['hapus-contengan'])){
    $imp = "('".implode("','",array_values($_POST['checkbox']))."')";
    $sql =pg_query($dbconn, "DELETE FROM master_icpc WHERE id in $imp");
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
       ICD 10
      </h1>
      <ol class="breadcrumb">
        <li><a href="media.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">ICD 10</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
        <form method="post">
           <div class="box-header with-border">
							<h3 class="box-title">Data</h3>
						</div>
            <!-- /.box-header -->
            <div class="box-body">

                                    <table id="icpc_grid" class="table table-bordered table-striped">  
                                     <thead align="center">
                                        <tr>
    
                                       
                                      <th>Kode </th>
                                        <th>Nama </th>
                                      <th class="text-center"> Action </th> 
    
                                       </tr>
                                      </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
             
            </div>
            <!-- /.box-body -->
          <!-- /.box -->

          </form>

        </div>
        <!-- /.col -->
      </div>

      <div class="col-md-6">


        <?php
        if(isset($_GET["update"])){
            include "update.php";

        }
        else{
         include "tambah.php"; 
        }
         ?>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>

    <script>
    //datatable diagnosis folder
              $(document).ready(function() {
                var dataTable = $('#icpc_grid').DataTable( {
                   "language": {
                    "search": "Cari:",
                    "sLengthMenu": "Tampilkan _MENU_ records",
                     "info": ""

                        },
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                        url :"assets/ajax/ajax-grid-data-icpc.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                            $(".diagnosis-error").html("");
                            $("#diagnosis").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            $("#diagnosis_processing").css("display","none");
                            
                        }
                    }
                } );
            } );

    </script>