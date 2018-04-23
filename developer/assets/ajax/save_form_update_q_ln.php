 <?php         
            //$id = $_SESSION['id_users'];
 			$id = $_POST['id'];
            $brand_nama = $_POST['brand_nama'];
            $id_satuan = $_POST['id_satuan'];
            $jumlah = $_POST['jumlah'];
            $harga_unit = $_POST['harga'];
           	//$disc_amount = $_POST['diskon'];
            $gross_unit = $_POST['gross'];
           	$net_total = $_POST['net'];
            $net_price = $_POST['net_price'];
            $id_inv = $_POST['id_inv'];

             if (!isset($_POST['diskon']) || empty($_POST['diskon'])) {
				    $disc_amount = 'NULL';
				} else {
				    $disc_amount = "'" .pg_escape_string($_POST['diskon']) . "'";
				}

            $res=pg_query($dbconn,"UPDATE q_ln set id_inv='".$id_inv."', nama_brand='".$brand_nama."', id_satuan='".$id_satuan."', jumlah='".$jumlah."', harga_unit='".$harga_unit."',gross_total='".$gross_unit."',net_total='".$net_total."', net_price='".$net_price."' WHERE id = $id");
    
		   var_dump("UPDATE q_ln set id_inv='".$id_inv."', nama_brand='".$brand_nama."', id_satuan='".$id_satuan."', jumlah='".$jumlah."', harga_unit='".$harga_unit."',gross_total='".$gross_unit."',net_total='".$net_total."', net_price='".$net_price."' WHERE id = $id");
?>  