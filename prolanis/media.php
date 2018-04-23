<script src="../assets/js/jquery-3.1.1.min.js"></script>
<?php
session_start();
error_reporting(1);
date_default_timezone_set('Asia/Jakarta');
if(!isset($_SESSION['pro_user']))
{
	header("location:index.php");
}else
{ 
	include_once('../config/conn.php');
	include_once('../config/fungsi_master.php');
	include "template/head.php";
	include "template/panel.php";
	include "template/sidebar.php";
	include "../data/constanta.php";
	if(isset($_GET['umum']))
	{
		$modul = "data.php";
		if(isset($_GET["modul"]))
		{
			$modul = $_GET["modul"].".php";
		}
		include "pages/umum/".$_GET['umum']."/".$modul;
	}
	else
		{
			include "body.php";
		}
				
	include_once 'template/footer.php';
}

pg_close($dbconn);


?>



