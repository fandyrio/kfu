<?php
switch($_GET['act'])
{
	case "baru":
	    $code = $_POST['code'];
	    $nama = $_POST['nama'];

		$res=pg_query($dbconn,"INSERT INTO inv_departemen (nama,code) 
		VALUES(
		'".$nama."',
		'".$code."'
		
		)");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=departemen";
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
	$id = $_POST['id'];
	
	 $code = $_POST['code'];
	 $nama = $_POST['nama'];
	 
	$result=pg_query($dbconn,"UPDATE inv_departemen 
	SET 
	code='".$code."',
	nama='".$nama."'
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=departemen";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?unit=departemen";
			
		</script>
		<?php
	}

	

	break;
}

?>