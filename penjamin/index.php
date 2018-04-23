<?php
error_reporting(0);
session_start();
include_once "../config/conn.php";
$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));

if(!empty($_SESSION['login_user'])){
	header("location:home");
}
else{
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="MITCare">
    <meta name="author" content="MITCare">
    <meta name="keyword" content="sistem, sistem informasi rumah sakit">
    <link rel="shortcut icon" href="../images/<?php echo $setting['logo'];?>">

    <title>Partner Penjamin ::: <?php echo $setting['title'];?></title>

    <!-- Icons -->
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/simple-line-icons.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="../assets/css/style.css" rel="stylesheet">
	<script src="../assets/js/jquery.min.js"></script>
	
</head>

<body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-4 col-12">
                <div class="card-group mb-0">
                    <div class="card p-4">
                        
						<form id="loginform" action="#" method="POST">
                        <div class="card-body">
							<center><img src="../images/<?php echo $setting['logo'];?>" class="img-fluid"></center>
                            <p class="text-muted text-center"><b>PARTNER PENJAMIN</b></p>

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
    
    <script src="../assets/js/tether.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../assets/js/login.js"></script>

	
</body>

</html>
<?php
}
?>