<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_users'])){
  header('location:keluar');
}
else{
	include "../../../config/conn.php";
	include "../../../config/library.php";
	$module=$_GET['module'];
	$act=$_GET['act'];

	// Input user
	if ($module=='profile' AND $act=='update'){
		$id=$_SESSION['login_users'];
		$username=$_POST['username'];
		
		$res=pg_query($dbconn,"Select username from auth_users where id_users='$id' ");
		
		
		if(pg_num_rows($res) > 0 ){
			$res1=pg_query($dbconn,"Select id_users from auth_users where username='$username' ");
			if(pg_num_rows($res1) < 1 )
			{
				if($_POST['password']!=''){
					$password=md5($_POST['password']);
				}
				else{
					$password=$_POST['password2'];
				}
				$result=pg_query($dbconn,"UPDATE auth_users SET username='$username', password='$password', tanggal_edit='$tgl_sekarang', jam_edit='$jam_sekarang' WHERE id_users = $id");
			}
			else{
				$PESAN="USERNAME SUDAH DIGUNAKAN ";

			}
		}
		else{
			$PESAN="PASSWORD SALAH Select username from auth_users where id_users='$id' ";
		}
		
		if($result){		
			?>
			<script>
				alert('Pembaharuan profile berhasil');
				document.location.href = "media.php";
				
			</script>
			<?php
		}
		else
		{
			?>
			<script>
				alert('<?php echo $PESAN; ?>');
				document.location.href = "profile";
			</script>
			<?php
		}
	}

}
?>
