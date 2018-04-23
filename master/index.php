<?php
session_start();
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
if(!isset($_SESSION['user_login']))
{
  include "login.php";
}else
{ 
 
  include "media.php";
}

?>


