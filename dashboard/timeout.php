<?php
//session_start();
function timer(){
	$time=10000;
	$_SESSION['timeout']=time()+$time;
}
function cek_login(){
	$timeout=$_SESSION['timeout'];
	if(time()<$timeout){
		timer();
		return true;
	}else{
		include "../config/conn.php";
		pg_query($dbconn,"UPDATE auth_users SET status_login='N' WHERE id_users='$_SESSION[login_user]'");
		unset($_SESSION['timeout']);
		return false;
	}
}
?>
