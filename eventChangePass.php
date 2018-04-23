<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "config/conn.php";

$idUser=$_POST['idUser'];
$password=$_POST['password'];
$enkrip=md5($password);

echo $enkrip;

$change=pg_query("UPDATE auth_users set password='$enkrip' where id_users='$idUser'");


?>