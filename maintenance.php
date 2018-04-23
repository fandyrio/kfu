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
					<img src="images/404.png" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
	
	
	<script src="bootstrap/jquery.min.js"></script>
	<script src="bootstrap/popper.min.js"></script>
	<script src="bootstrap/bootstrap.min.js"></script>
</body>
</html>
