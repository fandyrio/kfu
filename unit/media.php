<?php
error_reporting(0);
session_start();
$sid=session_id();
include "timeout.php";
date_default_timezone_set("Asia/Jakarta");
if($_SESSION['logins']==1){
	if(!cek_login()){
		$_SESSION['login'] = 0;
	}
}
if($_SESSION['logins']==0){
	header('location:keluar');
}
elseif(isset($_GET['ajax'])) {
	include_once('../config/conn.php');
    include_once('../config/function.php');

    include "content/contentunit/perusahaan/".$_GET['ajax'].".php";
    ?>
    	
        <script>
      			$(".example2 td [type=checkbox]").click(function() {
                          
      			 var next = $(this).closest('tr').find('td input[type=text]:first');
      			 next.attr("disabled", !this.checked);
      			});

      			$(".input2 td [type=checkbox]").click(function() {
                          
      			// first find 
      			//var next = $(this).closest('tr').find('td input[type=text]:first');
      			//next.attr("disabled", !this.checked);
      			 //var intes =  $(this).closest('tr').find('td input[type=text]:eq(0)');
      			 /**/
      			 var isSelected =  $(this).closest('tr').find('td input[type=text]');
      			 
      			  isSelected.attr("disabled", !this.checked);
      			  isSelected.val(0);
      					
      				  
      	});

        </script>


    <?php
    	pg_close($dbconn);
}
else{
include "../config/conn.php";
$users=pg_fetch_array(pg_query($dbconn,"Select * from auth_users where id_users = '$_SESSION[login_users]'"));
$karyawan = pg_fetch_array(pg_query($dbconn,"SELECT *  FROM master_karyawan WHERE id='$users[id_karyawan]'"));
$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo $setting['nama'];?></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="all,follow">
		<link rel="stylesheet" href="css/select2.css">
		<!-- Bootstrap CSS-->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<!-- Fontastic Custom icon font-->
		<link rel="stylesheet" href="css/fontastic.css">
		<!-- Font Awesome CSS-->
		<link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
		<!-- Google fonts - Poppins -->
		<link rel="stylesheet" href="fonts/font.css">
		<!-- theme stylesheet-->
		<link rel="stylesheet" href="css/style.blue.css" id="theme-stylesheet">
		<!-- Custom stylesheet - for your changes-->
		<link rel="stylesheet" href="css/custom.css">
		<link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">

		<link href="css/jquery.dataTables.css" rel="stylesheet">


		<!-- Favicon-->
		<link rel="shortcut icon" type="image/x-icon" href="../images/<?php echo $setting['logo'];?>"> 

  		
		<!-- Tweaks for older IEs--><!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
			
		<script src="js/jquery-3.2.1.min.js"></script>
	</head>
	<body>
		<div class="page home-page">
			<!-- Main Navbar-->
			<header class="header">
				<nav class="navbar">
					<!-- Search Box
					<div class="search-box">
						<button class="dismiss"><i class="icon-close"></i></button>
						<form id="searchForm" action="#" role="search">
							<input type="search" placeholder="What are you looking for..." class="form-control">
						</form>
					</div>-->
					
					<div class="container-fluid">
						<div class="navbar-holder d-flex align-items-center justify-content-between">
						<!-- Navbar Header-->
							<div class="navbar-header">
								<!-- Navbar Brand --><a href="home" class="navbar-brand">
								<div class="brand-text brand-big"><span>Laboratium </span><strong>Klinik</strong></div>
								<div class="brand-text brand-small"><strong>KF</strong></div></a>
								<!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
							</div>
							<!-- Navbar Menu -->
							<ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
			
								<!-- Logout    -->
								<li class="nav-item"><a href="keluar" class="nav-link logout">Logout<i class="fa fa-sign-out"></i></a></li>
							</ul>
						</div>
					</div>
				</nav>
			</header>
			
			<div class="page-content d-flex align-items-stretch">
				<!-- Side Navbar -->
				<nav class="side-navbar">
					<!-- Sidebar Header-->
					<div class="sidebar-header d-flex align-items-center">
						<div class="avatar"><img src="../images/pegawai/<?php echo $karyawan['foto'];?>"  class="img-fluid rounded-circle"></div>
						<div class="title">
							<h1 class="h4"><?php echo $karyawan['nama'];?></h1>
							<p><?php echo "Administartor Unit"?></p>
						</div>
					</div>
					
					<!-- Sidebar Navidation Menus-->
					<?php include "menu.php";?>
				</nav>
			
				<div class="content-inner">
					<?php include "content.php";?>
					<!-- Page Footer-->
				  <footer class="main-footer">
					<div class="container-fluid">
					  <div class="row">
						<div class="col-sm-12">
						  <p><?php echo $setting['nama'];?> &copy; 2017 <?php echo $setting['footer'];?></p>
						</div>
					  </div>
					</div>
				  </footer>
				</div>
			</div>
		</div>
		<!-- Javascript files-->
		<script src="vendor/popper.js/umd/popper.min.js"> </script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
		<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script> -->
		<script src="js/charts-home.js"></script>
		<script src="js/front.js"></script>		
		
        <script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap4.min.js"></script>
        <script src="js/datatable_code.js"></script>

		<script src="js/select2/select2.full.min.js"></script>

		<script>

		

		                      /*disable checkbox harga inventori*/
      			$(".example2 td [type=checkbox]").click(function() {
                          
      			 var next = $(this).closest('tr').find('td input[type=text]:first');
      			 next.attr("disabled", !this.checked);
      					//next.val("00");
      				 /* alert("noob");*/
      			});
      			

			    $(function () {
			    //Initialize Select2 Elements
			    $(".select2").select2();

			    });


		          $('#select-all').click(function(event) {   
				        if(this.checked) {
				            // Iterate each checkbox
				            $(':checkbox').each(function() {
				                this.checked = true;                        
				            });
				        } else{
				            $(':checkbox').each(function() {
				                this.checked = false;                        
				            });
				        }
				    });
		            $('#select-tambah').click(function(event) {   
			        if(this.checked) {
			            // Iterate each checkbox
			            $('.tambah').each(function() {
			                this.checked = true;                        
			            });
			        } else{
			            $('.tambah').each(function() {
			                this.checked = false;                        
			            });
			        }
			    });

		</script>
           
	</body>
</html>
<?php
}
?>