<?php
include "../config/conn.php";
$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $setting['title'];?></title>
		<link rel="shortcut icon" href="../images/<?php echo $setting['logo'];?>">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="assets/bootstrap.min.css">
		<link rel="stylesheet" href="assets/style.css">
		
		<link href="../assets/css/simple-line-icons.css" rel="stylesheet">
	</head>
<body>
	<div class="page-home">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-md-8">
					<h2 class="title">Dashboard Sistem Informasi Laboratorium Klinik<br>PT. Kimia Farma Diagnostika</h2>
					<br>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-6  col-sm-6 col-md-4">
					<div class="menu">
						<div class="logo">
							<img src="../images/<?php echo $setting['logo'];?>" class="img-fluid">
						</div>
						<form id="loginform" action="#" method="POST">
							<div class="card-body">
								<div class="input-group mb-3">
									<span class="input-group-addon"><i class="icon-user"></i>
									</span>
									<input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
								</div>
								<div class="input-group mb-4">
									<span class="input-group-addon"><i class="icon-lock"></i>
									</span>
									<input type="password" id="password" name="password" class="form-control" placeholder="Password">
								</div>
								<div class="row">
									<div class="col-12 text-right">
										<button type="submit" class="btn btn-primary px-4" id="btnLogin">Masuk</button>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<br>
										<div id="error"></div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
		
	<script src="assets/jquery.min.js"></script>
	<script src="assets/popper.min.js"></script>
	<script src="assets/bootstrap.min.js"></script>
	<script src="assets/login.js"></script>
</body>
</html>
