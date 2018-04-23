<?php
switch($_GET['act'])
{
	case "baru":
	    $nama = $_POST['nama'];

		$res=pg_query($dbconn,"INSERT INTO inv_form (nama) VALUES('".$nama."') RETURNING id");
		// get last_id
		$row = pg_fetch_row($res);

		//write array to variable $user_id
		$user_id = $row[0];

		if($res){
           	$_SESSION["id_terakhir"] = $user_id;
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			document.location.href = "media.php?inventori=form";
			// alert('lappet <?php echo $user_id;?>');
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo mysql_error();
			?>
			<script>
			document.location.href = "media.php?inventori=form";
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$result=pg_query($dbconn,"UPDATE inv_form SET 
	nama='".$nama."' 
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=form";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=form";
			
		</script>
		<?php
	}

	

	break;
}

?>