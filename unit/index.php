<?php
error_reporting(0);
session_start();
include_once "../config/conn.php";
$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));

if(!empty($_SESSION['login_users'])){
	header("location:home");
}
else{
?>
<!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo $setting['title'];?></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="all,follow">
		<!-- Bootstrap CSS-->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<!-- Fontastic Custom icon font-->
		<link rel="stylesheet" href="css/fontastic.css">
		<!-- Font Awesome CSS-->
		<link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
		<!-- Google fonts - Poppins -->
		<link rel="stylesheet" href="fonts/font.css">
		<!-- theme stylesheet-->
		<link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
		<!-- Custom stylesheet - for your changes-->
		<link rel="stylesheet" href="css/custom.css">
		<!-- Favicon-->
		<link rel="shortcut icon" type="image/x-icon" href="../images/<?php echo $setting['logo'];?>"> 
		<!-- Tweaks for older IEs--><!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
	</head>
  
	<body>
		<div class="page login-page">
			<div class="container d-flex align-items-center">
				<div class="form-holder has-shadow">
					<div class="row">
					<!-- Logo & Information Panel-->
						<div class="col-lg-6">
							<div class="info d-flex align-items-center">
								<div class="content">
									<div class="logo">
										<center><img src="../images/<?php echo $setting['logo'];?>" class="img-fluid img-logo"></center>
									</div>
									<p class="text-center"><?php echo $setting['nama'];?></p>
								</div>
							</div>
						</div>
						
						<!-- Form Panel    -->
						<div class="col-lg-6 bg-white">
							<div class="form d-flex align-items-center">
								<div class="content">
									<form id="login-form" method="post">
										<div class="form-group">
											<label class="form-control-label">Unit</label>
											<select name="id_unit" id="id_unit" class="form-control">
												<?php
												$tampil=pg_query($dbconn,"SELECT id, nama FROM master_unit ORDER BY nama");
												while($r=pg_fetch_array($tampil)){
													echo"<option value='$r[id]'>$r[nama]</option>";
												}
												?>
											</select>
										</div>
										<div class="form-group">
											<label class="form-control-label">User Name</label>
											<input id="username" type="text" name="loginUsername" required="" class="form-control" autofocus>
										</div>
										<div class="form-group">
											<label class="form-control-label">Password</label>
											<input id="password" type="password" name="loginPassword" required="" class="form-control">
										</div>
										<div id="error"></div>
										<button type="submit" class="btn btn-primary" id="btnLogin">Login</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="copyrights text-center">
				<p>Copyright &copy; 2017 <a href="" class="external"><?php echo $setting['footer'];?></a></p>
			</div>
		</div>
		<!-- Javascript files-->
		<script src="js/jquery-3.2.1.min.js"></script>
		<script src="js/login.js"> </script>
		<script src="vendor/popper.js/umd/popper.min.js"> </script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
		<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
		<script src="js/front.js"></script>
	</body>
</html>
<?php
}
?>