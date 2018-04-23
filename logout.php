<?php
session_start();
include_once "config/conn.php";
include_once "queue/client/function_panggil.php";
if(!empty($_SESSION['login_user']))
{
	$id_users=$_SESSION['login_user'];
	$id_karyawan=getKaryawan($id_users);
	pg_query($dbconn, "UPDATE ruang_dokter set status='offline' where id_karyawan='$id_karyawan'");
	pg_query($dbconn,"UPDATE auth_users SET status_login='N' WHERE id_users='$_SESSION[login_user]'");
	session_unset(); 
	session_destroy();
	
}
header("Location:index.php");
?>