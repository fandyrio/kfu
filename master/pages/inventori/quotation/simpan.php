<?php
switch($_GET['act'])
{
	case "baru":
		//head.php
	    $id_generik = $_POST['id_generik'];
	    $id_brand = $_POST['id_brand'];
	    $form = $_POST['form'];
	    $kode = $_POST['kode'];
	    $strength = $_POST['strength'];
	    $register = $_POST['register'];
	    $isactive = $_POST['isactive'];

	    //details.pp
	    $id_kategori = $_POST['id_kategori'];
	    $id_pengobatan = $_POST['id_pengobatan'];
	    $route = $_POST['route'];
	    $id_tracking = $_POST['id_tracking'];
	    $id_kategori_kehamilan = $_POST['id_kategori_kehamilan'];
	    $obat_pengganti = $_POST['obat_pengganti'];
	    $id_atccode = $_POST['id_atccode'];
	    $id_mims = $_POST['id_mims'];
	    $id_satuan = $_POST['id_satuan'];
	    $print_label = $_POST['print_label'];
	    $edc = $_POST['edc'];
	    $otc = $_POST['otc'];






		$res=pg_query($dbinventory,"INSERT INTO obat (nama, id_kategori) VALUES('".$nama."', '".$kategori."')");

		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=obat";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo pg_last_error();
			?>
			<script>
			document.location.href = "media.php?inventori=obat";
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$kategori = $_POST['kategori'];
	$result=pg_query($dbinventory,"UPDATE obat SET
	nama='".$nama."',
	id_kategori='".$kategori."',
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=obat";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=obat";
			
		</script>
		<?php
	}

	

	break;
}

?>