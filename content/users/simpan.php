<?php
switch($_GET['act'])
{
	case "baru":
	    $username = $_POST['username'];
	    $password = md5(pg_escape_string($_POST['password']));

	    $id_level = $_POST['id_level'];
	    $id_karyawan = $_POST['id_karyawan'];

	    $user=pg_query($dbconn,"SELECT * from auth_users where username='$username'");

	    if(pg_num_rows($user)==0){

		$res=pg_query($dbconn,"INSERT INTO auth_users (username, password, id_level, id_karyawan) VALUES('".$username."','".$password."','".$id_level."','".$id_karyawan."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?content=users";
			</script>

		<?php
	    } 
		}else{
			?>
			<script>
			 window.alert("username sudah digunakan");
			 window.history.go(-1);
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$username = pg_escape_string($_POST['username']);
	
	$id_level = $_POST['id_level'];
	$id_karyawan = $_POST['id_karyawan'];


	if($_POST['password'] != ""){
		$password = md5(pg_escape_string($_POST['password']));
		
		$result=pg_query($dbconn,"UPDATE auth_users SET username='".$username."', password='".$password."',id_level='".$id_level."',id_karyawan='".$id_karyawan."', tanggal_edit = '".date("Y-m-d")."',jam_edit = '".date("H:i:s")."' WHERE id_users = $id");
	}
	else{

		$result=pg_query($dbconn,"UPDATE auth_users SET username='".$username."',id_level='".$id_level."', tanggal_edit = '".date("Y-m-d")."',id_karyawan='".$id_karyawan."',jam_edit = '".date("H:i:s")."' WHERE id_users = $id");
	}

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?content=users";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "";
			
		</script>
		<?php
	}

	

	break;
}

?>