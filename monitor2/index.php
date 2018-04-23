<?php
include "../config/conn.php";
$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));
$unit=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_unit WHERE id='1'"));
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Monitoring Antrian ::: <?php echo $setting['title'];?></title>
		<link rel="shortcut icon" href="../images/<?php echo $setting['logo'];?>">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="assets/gijgo.css" rel="stylesheet" type="text/css" />
		
		<link rel="stylesheet" href="assets/style.css">
		<link rel="stylesheet" href="assets/bootstrap.min.css">
		
		<link href="../assets/css/simple-line-icons.css" rel="stylesheet">
	</head>
<body>
	<header>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="pull-left">
					<img src="../images/<?php echo $setting['logo'];?>" class="img-fluid img-logo">
					</div>
					<div class="pull-left">
					<h3 class="title"><?php echo $unit['nama'];?></h3>
					<h4 class="title"><?php echo "$unit[alamat]. Telp. $unit[telepon]";?></h4>
					</div>
					<div class="pull-right">
						<span class="waktu block font-2">21:40:10</span>
					</div>
				</div>
			</div>
		</div>
	</header>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 middle">
				<div class="loket-antrian card2">
					LOKET <span class="yellow">A</span>
				</div>
				<div class="loket-nomor-antrian card2">
					<span class="nomor">NOMOR ANTRIAN</span>
					<span class="block nomor-antrian">
						001
					</span>
				</div>
			</div>
			<div class="col-md-8 middle">
				<div class="video card2">
				<video width="100%" height="320" autoplay>
					<source src="../video/1.mp4" type="video/mp4">
					Your browser does not support the video tag.
				</video>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="footer card2">
					<div class="row">
						<div class="col-md-4">
							<div class="head-antrian">
								LOKET <span class="yellow">A</span>
							</div>
							<div class="body-antrian">
								001
							</div>
						</div>
						<div class="col-md-4">
							<div class="head-antrian">
								LOKET <span class="yellow">B</span>
							</div>
							<div class="body-antrian">
								002
							</div>
						</div>
						<div class="col-md-4">
							<div class="head-antrian">
								LOKET <span class="yellow">C</span>
							</div>
							<div class="body-antrian">
								003
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer>
		Running Text .......... Running Text ..........
	</footer>
	<script src="assets/jquery.min.js"></script>
	<script src="assets/gijgo.js" type="text/javascript"></script>
	<script src="assets/popper.min.js"></script>
	<script src="assets/bootstrap.min.js"></script>
</body>
</html>
