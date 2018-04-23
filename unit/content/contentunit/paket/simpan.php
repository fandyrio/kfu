<?php
switch($_GET['act'])
{
	case "baru":
	
	$id_unit= $_SESSION['id_unit'];
	$id_billing_paket = $_POST['id_billing_paket'];
	$id_kategori_harga = $_POST['id_kategori_harga'];

	if (!isset($_POST['harga']) || empty($_POST['harga'])) {
				  
		} 
			else{

	$harga = 'ARRAY['. implode(',', $_POST['harga']). ']';
    $id_layanan = 'ARRAY['. implode(',', $_POST['id_layanan']). ']';
		

		$sql =pg_query($dbconn, "INSERT INTO billing_paket_kategori_harga_unit (id_billing_paket, id_kategori_harga , id_unit, harga, id_lab_analysis) 
                         select $id_billing_paket , id_kategori_harga, $id_unit, *
					from unnest($harga, $id_lab)");


	}		
	   
	

		if($sql){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			document.location.href = "paket";
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
	$id_billing_paket = $_POST['id_billing_paket'];
	$unit = $_SESSION['id_unit'];
	$harga = 'ARRAY['. implode(',', $_POST['harga']). ']';
    $id_layanan = 'ARRAY['. implode(',', $_POST['id_layanan']). ']';

	$result=pg_query($dbconn,"DELETE FROM billing_paket_kategori_harga_unit WHERE id_billing_paket = $id_billing_paket and id_unit='$unit'");

	if($result){
		$sql =pg_query($dbconn, "INSERT INTO billing_paket_kategori_harga_unit (id_billing_paket, id_unit, harga, id_kategori_harga ) 
                         select $id_billing_paket , $unit, *
					from unnest($harga, $id_layanan)");

	}
		

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "paket";
			</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "paket";
			</script>
		<?php
	}

	

	break;
}

?>