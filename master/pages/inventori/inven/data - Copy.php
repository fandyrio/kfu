<?php
if(isset($_POST['hapus-contengan'])){
    $imp = "('".implode("','",array_values($_POST['checkbox']))."')";
    $sql =pg_query($dbconn, "DELETE FROM inv_obat WHERE id in $imp");
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
       Inventory <img src="images/inventori.png" style="width:32px;"> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Obat</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    
      <div class="row">
        
<form method="POST" enctype="multipart/form-data" action="media.php?inventori=inven&modul=simpan&act=baru">
      <div class="col-xs-12">
		<?php include"head.php"; ?>
</div>

       <div class="row">
        <div class="col-xs-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Detail</a></li>
              <li><a href="#tab_2" data-toggle="tab">Harga</a></li>
              <li><a href="#tab_3" data-toggle="tab">Costing</a></li>
              <li><a href="#tab_4" data-toggle="tab">Gambar</a></li>
              <li><a href="#tab_5" data-toggle="tab">Opsi Resep</a></li>
              <li><a href="#tab_6" data-toggle="tab">Opsi Billing</a></li>
              <li><a href="#tab_7" data-toggle="tab">Info Supplier</a></li>
              
              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1"><?php include "details.php" ?> </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2"><?php include "pricing.php" ?> </div>
              
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3"><?php include "costing.php" ?>
              
              </div>
               <div class="tab-pane" id="tab_4"><?php include "gambar_obat.php" ?> </div>
               <div class="tab-pane" id="tab_5"><?php include "opsi_resep.php" ?> </div>
               <div class="tab-pane" id="tab_6"><?php include "opsi_billing.php" ?> </div>
               <div class="tab-pane" id="tab_7"><?php include "info_supplier.php" ?> </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->

        
        <!-- /.col -->
      </div>
      <!-- /.row -->
       <div class="box-footer text-right">
                <button type="submit" class="btn btn-success">SIMPAN</button>
              </div>


      
      </form>


      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
