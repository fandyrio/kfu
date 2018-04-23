<?php
session_start();
switch($_GET['act'])
{
	case "baru":
		$res=pg_query($dbconn,"INSERT INTO pro_instruktur (nama, alamat, tgl_lahir, no_telp, kode, id_unit) VALUES('$_POST[nama]','$_POST[alamat]', '$_POST[tgl_lahir]', '$_POST[no_telp]', '$_POST[kode]', '$_SESSION[id_branch]')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?umum=instruktur";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			 echo mysql_error();
			?>
			<script>		
			</script>
			<?php
	    }
	break;

	case "edit":
	
	$result=pg_query($dbconn,"UPDATE pro_instruktur SET nama='$_POST[nama]', alamat='$_POST[alamat]', kode='$_POST[kode]', no_telp='$_POST[no_telp]', tgl_lahir='$_POST[tgl_lahir]' WHERE id = '$_POST[id]'");

	var_dump("UPDATE pro_instruktur SET nama='$_POST[nama]', alamat='$_POST[alamat]', kode='$_POST[kode]', no_telp='$_POST[no_telp]', tgl_lahir='$_POST[tgl_lahir]' WHERE id = '$_POST[id]'");
	

	if($result)
	{
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=instruktur";
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?umum=instruktur";
		</script>
		<?php
	}

	

	break;
}

?>