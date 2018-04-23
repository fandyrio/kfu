<?php
session_start();
//var_dump($_GET['id']);
	$_SESSION["id_dokter"] = $_GET['id'];

    $id_unit= $_SESSION['id_units'];
    $res=pg_query($dbconn,"SELECT *  from master_karyawan where id='$_SESSION[id_dokter]'");

    $data = pg_fetch_array($res);

   
	
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Dokter  <?php echo $data["nama"]  ?></li>
	<li class="breadcrumb-menu d-md-down-none">
		
	</li>
</ol>  

       

<div class="container-fluid">
 <div class="card">
 <div class="card-header">
              <i class="icon-grid"></i> Tambah
      </div>
 <div class="card-block">

<ul class="nav nav-tabs" role="tablist">
	
	<li class="nav-item">
		<a class="nav-link active" data-toggle="tab" href="#nonlab" role="tab" >Tindakan</a>
	</li>
	
</ul>
	
<div class="card-body">
	<div class="tab-content">
        
        <div class="tab-pane active" id="nonlab" role="tabpanel">
        	<?php include "data_tindakan.php"; ?>
        </div>
       
	</div>

</div>

<div class="card-footer">
	 <button type="button" value="batal" class="btn btn-sm btn-primary " onClick="window.location='media.php?content=dokter';" >Kembali</button>
</div>

</div>
</div>
</div>

 