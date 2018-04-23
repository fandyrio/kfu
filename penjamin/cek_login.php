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

	$result=pg_query($dbconn,"SELECT * FROM master_kategori_harga WHERE username='$username' AND password='$password'");
	
	$count=pg_num_rows($result);
	$row=pg_fetch_array($result);
	if($count==1)
	{	
		include "../timeout.php";
		timer();
		
		session_regenerate_id();
		$sid=session_id();
		
		$_SESSION['login_user']    = $row['id'];
		$_SESSION['id_session']    = $sid;

		$_SESSION['login'] = 1;
		
		pg_query($dbconn,"UPDATE master_kategori_harga SET waktu_login='$tgl_sekarang $jam_sekarang' WHERE id='$row[id]'");
		echo $row['username'];
	}
	
	
}
?>