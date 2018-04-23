<?php
switch($_GET['act'])
{
	case "baru": 
	    $unit = $_SESSION['id_unit'];
	    $id_tindakan = $_POST['id_tindakan'];
	    $id_commision = $_POST['id_commision'];
	    $id_karyawan = $_POST['id_karyawan'];
	    $harga = 'ARRAY['. implode(',', $_POST['harga']). ']';
    	$id_layanan = 'ARRAY['. implode(',', $_POST['id_layanan']). ']';

		$row = pg_fetch_row($res); 
		$sql =pg_query($dbconn, "INSERT INTO commision_group_harga_unit (id_commision_group, id_tindakan_unit, id_karyawan_unit, id_unit, harga, id_kategori_harga_unit )  select $id_commision,$id_tindakan, $id_karyawan, $unit, *
					from unnest($harga, $id_layanan)");
	

		if($sql){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			
			 document.location.href = "media.php?content=commision_group";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo mysql_error();
			?>
			<script>
				window.alert("data ada yang kosong");
				window.history.go(-1);
			</script>
			<?php
	    }
	break;

	case "edit":
	$id_tindakan = $_POST['id_tindakan'];
	$id_commision = $_POST['id_commision'];
	$id_karyawan = $_POST['id_karyawan'];
	$unit = $_SESSION['id_unit'];
	$harga = 'ARRAY['. implode(',', $_POST['harga']). ']';
    $id_layanan = 'ARRAY['. implode(',', $_POST['id_layanan']). ']';

	$delete =pg_query($dbconn, "DELETE FROM commision_group_harga_unit WHERE id_commision_group='$id_commision' and id_unit='$unit'");



	if($delete){
		$sql =pg_query($dbconn, "INSERT INTO commision_group_harga_unit (id_commision_group, id_tindakan_unit, id_karyawan_unit, id_unit, harga, id_kategori_harga_unit ) 
			select $id_commision,$id_tindakan, $id_karyawan, $unit, *
					from unnest($harga, $id_layanan)");


	}



	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?content=commision_group";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?content=commision_group";
			
		</script>
		<?php
	}

	

	break;
}

?>