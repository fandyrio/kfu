<?php
include "config/conn.php";
$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $setting['title'];?></title>
		<link rel="shortcut icon" href="images/<?php echo $setting['logo'];?>">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="bootstrap/style.css">
		
		<link href="bootstrap/css/font-awesome.min.css" rel="stylesheet">
		<link href="bootstrap/css/simple-line-icons.css" rel="stylesheet">
	
	</head>
<body>
	<div class="page-home">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-md-6">
					<h2 class="title">Sistem Informasi Seven 7 Solution<br>PT. Kimia Farma Apotek</h2>
					<br>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-6  col-sm-6 col-md-2">
					<a href="master">
					<div class="menu">
						<img src="images/master.png" class="img-fluid">
						<span class="menu-title">Master</span>
					</div>
					</a>
				</div>
				
				<div class="col-6 col-sm-6 col-md-2">
					<a href="client">
					<div class="menu">
						<img src="images/adminunit.png" class="img-fluid">
						<span class="menu-title">Pendaftaran</span>
					</div>
					</a>
				</div>
				
				
				<div class="col-6  col-sm-6 col-md-2">
					<a href="dashboard">
					<div class="menu">
						<img src="images/dashboard.png" class="img-fluid">
						<span class="menu-title">Dashboard</span>
					</div>
					</a>
				</div>
				
				<div class="col-6  col-sm-6 col-md-2">
					<a href="cetak_queue">
					<div class="menu">
						<img src="images/client.png" class="img-fluid">
						<span class="menu-title">Antrian</span>
					</div>
					</a>
				</div>
				
				<div class="col-6  col-sm-6 col-md-2">
					<a href="monitor">
					<div class="menu">
						<img src="images/monitor.png" class="img-fluid">
						<span class="menu-title">Monitor Antrian</span>
					</div>
					</a>
				</div>
				
				<!-- <div class="col-6  col-sm-6 col-md-2">
					<a href="maintenance">
					<div class="menu">
						<img src="images/sdm.png" class="img-fluid">
						<span class="menu-title">SDM</span>
					</div>
					</a>
				</div>
				
				
				<div class="col-6  col-sm-6 col-md-2">
					<a href="maintenance">
					<div class="menu">
						<img src="images/keuangan.png" class="img-fluid">
						<span class="menu-title">Keuangan</span>
					</div>
					</a>
				</div>
				-->
				
				<!-- <div class="col-6  col-sm-6 col-md-2">
					<a href="marketing">
					<div class="menu">
						<img src="images/marketing.png" class="img-fluid">
						<span class="menu-title">Marketing</span>
					</div>
					</a>
				</div> -->
			
				<div class="col-6  col-sm-6 col-md-2">
					<a href="penjamin">
					<div class="menu">
						<img src="images/partner.png" class="img-fluid">
						<span class="menu-title">Portal Perusahaan</span>
					</div>
					</a>
				</div>
				
				<div class="col-6  col-sm-6 col-md-2">
					<a href="maintenance">
					<div class="menu">
						<img src="images/eksternal.png" class="img-fluid">
						<span class="menu-title">Portal R. Eksternal</span>
					</div>
					</a>
				</div> 

				<div class="col-6  col-sm-6 col-md-2">
					<a href="prolanis">
					<div class="menu">
						<img src="images/prolanis.png" class="img-fluid">
						<span class="menu-title">Program Prolanis</span>
					</div>
					</a>
				</div> 

			</div>
		</div>
	</div>
	
	
	<script src="bootstrap/jquery.min.js"></script>
	<script src="bootstrap/popper.min.js"></script>
	<script src="bootstrap/bootstrap.min.js"></script>
</body>
</html>
