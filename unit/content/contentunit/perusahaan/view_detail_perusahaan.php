<?php
session_start();
//var_dump($_GET['id']);
	$_SESSION["id_perusahaan"] = $_GET['id'];

    $id_unit= $_SESSION['id_unit'];
    $res=pg_query($dbconn,"SELECT k.*  from master_kategori_harga k 
    	inner join master_unit_perusahaan p ON p.id_perusahaan = k.id WHERE p.id_unit = '$id_unit' and p.id_perusahaan='$_SESSION[id_perusahaan]' ");

    $data = pg_fetch_array($res);
	
?>  
<header class="page-header">
        <div class="container-fluid">
          <h2 class="no-margin-bottom">Perusahaan  <?php echo $data["nama"]  ?></h2>
		  <ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
			<li class="breadcrumb-item active">Perusahaan</li>
		</ul>
        </div>
        </header>
         <!-- Dashboard Counts Section-->
        <section class="dashboard-counts no-padding-bottom">
 <div class="container-fluid">
 <div class="card">
			<div class="card-header">
<ul class="nav nav-tabs" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" data-toggle="tab" href="#lab" role="tab" aria-controls="home">Laboratorium</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#nonlab" role="tab" aria-controls="bar">Non Laboratorium</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#paket" role="tab" aria-controls="bar">Paket</a>
	</li>	
</ul>
	
<div class="card-body">
	<div class="tab-content">
        <div class="tab-pane active" id="lab" role="tabpanel">
           <?php include "data_lab.php"; ?>
        </div>
        <div class="tab-pane" id="nonlab" role="tabpanel">
        	<?php include "data_tindakan.php"; ?>
        </div>
        <div class="tab-pane" id="paket" role="tabpanel">
        	<?php include "data_paket.php"; ?>
        </div> 
        
	</div>

</div>




</div>
	<div class="card-footer">
	 <button type="button" value="batal" class="btn btn-sm btn-primary " onClick="window.location='media.php?content=perusahaan';" >Kembali</button>
</div>

</div>
</div>


 </section>
 