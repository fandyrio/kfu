<?php
include("../config/conn.php");
include("../config/library.php");
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
	// username and password sent from Form
	$username=pg_escape_string($dbconn,$_POST['username']); 
	//Here converting passsword into MD5 encryption. 
	$password=md5(pg_escape_string($dbconn,$_POST['password'])); 

	$result=pg_query($dbconn,"SELECT a.id_users, a.username, a.status_login FROM auth_users a, master_karyawan_unit b WHERE a.username='$username' and a.password='$password' AND a.id_level='5' AND a.id_karyawan=b.id_karyawan AND b.id_unit='$_POST[id_unit]'");
	
	$count=pg_num_rows($result);
	$row=pg_fetch_array($result);
	if($count==1)
	{	
		include "timeout.php";
		timer();
		
		$sid_lama = session_id();
		session_regenerate_id();
		$sid_baru = session_id();
		
		$_SESSION['login_users']    = $row['id_users'];
		$_SESSION['id_sessions']    = $sid_baru;
		$_SESSION['id_unit']       = $_POST['id_unit'];
		$_SESSION['logins'] = 1;
		if($row['status_login']=='Y'){
			echo"sudah_login";
		}
		else{
			pg_query($dbconn,"UPDATE auth_users SET tanggal_login='$tgl_sekarang', jam_login='$jam_sekarang', status_login='Y' WHERE id_users='$row[id_users]'");
			echo $row['username'];
		}
	}
}
?>