<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<?php
session_start();
error_reporting(1);
date_default_timezone_set('Asia/Jakarta');
if(!isset($_SESSION['user_login']))
{
	header("location:index.php");
}else
{ 

	include_once('../config/conn.php');
	include_once('../config/fungsi_master.php');

	if(isset($_GET['ajax'])){

		/*include_once('../config/conn.php');
		include_once('../config/function.php');*/
		
		include "assets/ajax/".$_GET['ajax'].".php";
		//include_once ('template/datatable_ajax.php');

	}

	else{	/*
				include_once('../config/conn.php');
				include_once('../config/function.php');*/
				include "template/head.php";
				include "template/panel.php";
				include "template/sidebar.php";
				if(isset($_GET['umum']))
				{
					$modul = "data.php";
					if(isset($_GET["modul"]))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/umum/".$_GET['umum']."/".$modul;
			
					
				}
				else if(isset($_GET['inventori']))
				{
					$modul = "data.php";
					if(isset($_GET["modul"]))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/inventori/".$_GET['inventori']."/".$modul;
					
				}
				else if(isset($_GET['unit']) && isset($_GET['dokter']))
				{
					$modul = "data.php";
					if(isset($_GET["modul"]))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/unit/".$_GET['unit']."/".$modul;
					
				}
				else if(isset($_GET['unit']))
				{
					$modul = "data.php";
					if(isset($_GET["modul"]))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/unit/".$_GET['unit']."/".$modul;
					
				}
				else if(isset($_GET['tindakan']))
				{
					$modul = "data.php";
					if(isset($_GET["modul"]))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/tindakan/".$_GET['tindakan']."/".$modul;
					
				}

				else if(isset($_GET['auth']))
				{
					$modul = "data.php";
					if(isset($_GET["modul"]))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/auth/".$_GET['auth']."/".$modul;
					
				}

				else if(isset($_GET['billing']))
				{
					$modul = "data.php";
					if(isset($_GET["modul"]))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/billing/".$_GET['billing']."/".$modul;
					
				}

				else if(isset($_GET['lab']))
				{
					$modul = "data.php";
					if(isset($_GET["modul"]))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/lab/".$_GET['lab']."/".$modul;
					
				}

				elseif(isset($_GET['module']))
				{
					$modul="unit.php";
					
					if(isset($_GET["modul"]))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/module/".$_GET['module']."/".$modul;
					
				}

				elseif(isset($_GET['fisik']))
				{
					//$modul="unit.php";
					
					if(isset($_GET["modul"]))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/module/".$_GET['module']."/".$modul;
					
				}
				elseif(isset($_GET['rujukan']))
				{
					$modul = "data.php";
					
					if(isset($_GET["modul"]))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/rujukan/".$_GET['rujukan']."/".$modul;
					
				}
				elseif(isset($_GET['body']))
				{
					$modul="data.php";
					if(isset($_GET['modul']))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/".$_GET['body']."/".$modul;
				}	
				elseif(isset($_GET['lokasi_body']))
				{
					$modul="data.php";
					if(isset($_GET['modul']))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/".$_GET['lokasi_body']."/".$modul;
				}
				elseif(isset($_GET['sympton']))
				{
					$modul="data.php";
					if(isset($_GET['modul']))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/".$_GET['sympton']."/".$modul;
				}
				elseif(isset($_GET['edc']))
				{
					$modul="data.php";
					if(isset($_GET['modul']))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/".$_GET['edc']."/".$modul;
				}
				elseif(isset($_GET['master_ruangan']))
				{
					$modul="data.php";
					if(isset($_GET['modul']))
					{
						$modul = $_GET["modul"].".php";
					}
					include "pages/".$_GET['master_ruangan']."/".$modul;
				}									
				else
				{
					include "body.php";
				}
				
				include_once 'template/footer.php';
			}

	pg_close($dbconn);
	
}

?>


