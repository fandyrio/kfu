<?php
session_start();
switch($_GET['act'])
{
	case "baru":
		$res=pg_query($dbconn,"INSERT INTO pro_dftr_hadir (id_jadwal, tgl_keg, id_instruktur, ket ,qty, id_unit) 
							VALUES('$_POST[id_jadwal]', '$_POST[tgl_keg]', '$_POST[id_instruktur]', '$_POST[ket]', '$_POST[qty]' ,'$_SESSION[id_branch]') RETURNING id");

		$row = pg_fetch_row($res);

		if (!isset($_POST['id_pasien']) || empty($_POST['id_pasien'])) {
				  
		} 
		else{
			$id_pasien = 'ARRAY['. implode(',', $_POST['id_pasien']). ']';  
			$sql =pg_query($dbconn, "INSERT INTO pro_dftr_hadir_dtl (id_dftr_hdr, id_pasien ) 
                         select $row[0], *	from unnest($id_pasien)");
		}

		
		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
				document.location.href = "media.php?umum=dftr_hadir";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			 //echo mysql_error();
			?>
			<script>		
			</script>
			<?php
	    }
	break;

	case "edit":
	$id= $_POST[id];	
	$result=pg_query($dbconn,"UPDATE pro_dftr_hadir SET id_jadwal='$_POST[id_jadwal]', tgl_keg='$_POST[tgl_keg]', id_instruktur='$_POST[id_instruktur]', ket='$_POST[ket]', qty='$_POST[qty]' WHERE id = '$id'");

	if (!isset($_POST['id_pasien']) || empty($_POST['id_pasien'])) {
				  
	} 
	else{
		$h =pg_query($dbconn, "DELETE FROM pro_dftr_hadir_dtl where id_dftr_hdr='".$id."'");
		$id_pasien = 'ARRAY['. implode(',', $_POST['id_pasien']). ']';  

		$sql =pg_query($dbconn, "INSERT INTO pro_dftr_hadir_dtl (id_dftr_hdr, id_pasien ) 
                         select $id, *	from unnest($id_pasien)");	
	}	   
	if($result)
	{
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?umum=dftr_hadir";
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?umum=dftr_hadir";
		</script>
		<?php
	}
	break;
}

?>