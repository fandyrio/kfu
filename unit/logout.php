<?php
	error_reporting(0);
	session_start();
	include "../config/conn.php";
	pg_query($dbconn,"UPDATE auth_users SET status_login='N' WHERE id_users='$_SESSION[login_users]'");
	session_destroy();
	echo "<script>window.location = '../index.php'</script>";
  
?>
