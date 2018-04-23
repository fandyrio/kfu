<?php

switch($_GET['act'])
{
	case "baru":	
	$id_unit= $_SESSION['id_unit'];
	$id_billing_paket = $_POST['id_billing_paket'];
	$id_kategori_harga = $_POST['id_perusahaan'];

	$diskon_paket_persen=$_POST['dis_unit_persen'];
	$diskon_paket_amt=$_POST['dis_unit_amt'];

			 if (!isset($_POST['dis_unit_persen']) || empty($_POST['dis_unit_persen'])) {
				    $diskon_paket_persen = 0;
				    
			} 
			else{
				    $diskon_paket_persen = "'".pg_escape_string($_POST['dis_unit_persen'])."'";				   
			}

			 if (!isset($_POST['dis_unit_amt']) || empty($_POST['dis_unit_amt'])) {
				    $diskon_paket_amt = 0;
				    
			} 
			else{
				    $diskon_paket_amt = "'".pg_escape_string($_POST['dis_unit_amt'])."'";				   
			}

	$res = pg_query($dbconn, 
			"INSERT INTO billing_paket_kategori_harga_unit (id_billing_paket, id_kategori_harga , id_unit, disc_persen, disc_amount) VALUES ('$id_billing_paket', '$id_kategori_harga', '$id_unit', $diskon_paket_persen, $diskon_paket_amt ) RETURNING id "); 
	

	$row = pg_fetch_row($res); 

	/*hitung total harga tindakan*/
	$total_tindakan =array_values($_POST['total_tindakan']);
    $arrlength = count($total_tindakan);
	$total_nett =0;

	for( $i=0; $i<$arrlength; $i++){			
			  $total_nett += $total_tindakan[$i];
	}
	/**************/
	/*hitung total harga lab*/
	$total_lab =array_values($_POST['total_lab']);
    $arrlength1 = count($total_lab);
	$total_nett_lab =0;

	for( $j=0; $j<$arrlength1; $j++){			
			  $total_nett_lab += $total_lab[$j];
	}
	/**************/
	$total_tindakan = 'ARRAY['. implode(',', $_POST['total_tindakan']). ']';
    $check_tindakan = 'ARRAY['. implode(',', $_POST['check_tindakan']). ']';
    $disc_persen_tindakan = 'ARRAY['. implode(',', $_POST['dis_persen_tindakan']). ']';
    $disc_amt_tindakan = 'ARRAY['. implode(',', $_POST['dis_amt_tindakan']). ']';

    $total_lab = 'ARRAY['. implode(',', $_POST['total_lab']). ']';
    $check_lab = 'ARRAY['. implode(',', $_POST['check_lab']). ']';
    $dis_persen_lab = 'ARRAY['. implode(',', $_POST['dis_persen_lab']). ']';
    $dis_amt_lab = 'ARRAY['. implode(',', $_POST['dis_amt_lab']). ']';
		

	pg_query($dbconn, "INSERT INTO billing_paket_kategori_harga_unit_detail (id_paket_k_unit,jenis, harga_net, id_detail, disc_persen, disc_amount) 
                    SELECT $row[0],'T', *
					from unnest($total_tindakan, $check_tindakan, $disc_persen_tindakan, $disc_amt_tindakan )");

	pg_query($dbconn, "INSERT INTO billing_paket_kategori_harga_unit_detail (id_paket_k_unit,jenis,  harga_net, id_detail, disc_persen, disc_amount) 
                    SELECT $row[0],'L',  *
					from unnest($total_lab, $check_lab, $dis_persen_lab, $dis_amt_lab )");

	$total_harga_paket =0;
	$total_harga_paket =$total_nett + $total_nett_lab;

	pg_query($dbconn,"UPDATE billing_paket_kategori_harga_unit SET harga='$total_harga_paket' WHERE id='$row[0]' ");
	var_dump("UPDATE billing_paket_kategori_harga_unit SET harga='$total_harga_paket' WHERE id='$row[0]' ");

		if($sql){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			alert("success");
			document.location.href = "paket";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo mysql_error();
			?>
			<script>
			alert("gagal");
				
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