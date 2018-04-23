<?php
session_start();
//var_dump($_GET['id']);
	$_SESSION["id_perusahaan"] = $_GET['id'];

    $id_unit= $_SESSION['id_units'];
    $res=pg_query($dbconn,"SELECT k.*  from master_kategori_harga k 
    	inner join master_unit_perusahaan p ON p.id_perusahaan = k.id WHERE p.id_unit = '$id_unit' and p.id_perusahaan='$_SESSION[id_perusahaan]' ");

    $data = pg_fetch_array($res);
	
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Perusahaan  <?php echo $data["nama"]  ?></li>
	<li class="breadcrumb-menu d-md-down-none">
		
	</li>
</ol>  

       

<div class="container-fluid">
 <div class="card">
 <div class="card-block">
<ul class="nav nav-tabs" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" data-toggle="tab" href="#single" role="tab" >Single Test</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#multiple" role="tab">Multiple Test</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#nonlab" role="tab" >Non Laboratorium</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#paket" role="tab" >Event / MCU</a>
	</li>	
</ul>
	
<div class="card-body">
	<div class="tab-content">
        <div class="tab-pane active" id="single" role="tabpanel">
           <?php include "data_lab.php"; ?>
        </div>
        <div class="tab-pane" id="multiple" role="tabpanel">
        	 <?php include "data_multitest.php"; ?> 
        	
        </div>
        <div class="tab-pane" id="nonlab" role="tabpanel">
        	<?php include "data_tindakan.php"; ?>
        </div>
        <div class="tab-pane" id="paket" role="tabpanel">
        	<?php include "data_paket.php"; ?>
        </div> 
        
	</div>

</div>




	<div class="card-footer">
	 <button type="button" value="batal" class="btn btn-sm btn-primary " onClick="window.location='media.php?content=perusahaan';" >Kembali</button>
</div>

</div>
</div>
</div>

 