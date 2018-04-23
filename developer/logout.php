<?php
session_start();

session_unset(); 
	session_destroy();
unset($_SESSION['id_users']);
unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['id_level']);

header("location:../index.php");
?>