<?php
session_start();
include_once "config/conn.php";
if(!empty($_SESSION['login_user']))
{
	pg_query($dbconn,"UPDATE auth_users SET status_login='N' WHERE id_users='$_SESSION[login_user]'");
	session_unset(); 
	session_destroy();
	
}
header("Location:../index.php");
?>