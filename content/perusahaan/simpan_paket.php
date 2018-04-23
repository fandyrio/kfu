<?php

switch($_GET['act'])
{
	case "baru":	
	$id_unit= $_SESSION['id_units'];
	$id_billing_paket = $_POST['id_billing_paket'];
	$id_kategori_harga = $_POST['id_perusahaan'];

	$diskon_paket_persen=$_POST['dis_unit_persen'];
	$diskon_paket_amt=$_POST['dis_unit_amt'];

	$nama_paket_baru=$_POST['nama_paket_baru'];
	$tahun=$_POST['tahun'];
	$nasional=$_POST['nasional'];

			  

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
	/*JIKA ADA PENAMBAHAN PAKET BARU Yang dilakukan unit terkait*/
	if($add_new_even){
		$res=pg_query($dbconn,"INSERT INTO billing_paket (nama_paket, tahun, nasional, created_unit) 	
			VALUES(	'".$nama."', '$tahun', '$nasional', '$id_unit') RETURNING id");
		$row = pg_fetch_row($res); 

		$list_harga_tindakan = 'ARRAY['. implode(',', $_POST['total_tindakan']). ']';
		$list_id_tindakan 	 = 'ARRAY['. implode(',', $_POST['check_tindakan']). ']';
		$list_harga_lab 	 = 'ARRAY['. implode(',', $_POST['total_lab']). ']';
        $list_id_lab 		 = 'ARRAY['. implode(',', $_POST['check_lab']). ']';

        $disc_persen_tindakan = 'ARRAY['. implode(',', $_POST['dis_persen_tindakan']). ']';
   		$disc_amt_tindakan = 'ARRAY['. implode(',', $_POST['dis_amt_tindakan']). ']';

   		 $dis_persen_lab = 'ARRAY['. implode(',', $_POST['dis_persen_lab']). ']';
   		 $dis_amt_lab = 'ARRAY['. implode(',', $_POST['dis_amt_lab']). ']';

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
		$harga_total_paket = 0;
		$harga_total_paket =  $total_nett1 +  $total_nett;
   		 pg_query($dbconn, "UPDATE billing_paket SET harga_net='$harga_total_paket' WHERE id='$row[0]' ");

		///////////////////////////////////////////////////////////////////////////////////////////////
		$sql =pg_query($dbconn, "INSERT INTO billing_paket_detail (id_billing_paket, jenis, id_detail ) 
                         select $row[0], 'T',*	from unnest($list_id_tindakan)");
		$sql =pg_query($dbconn, "INSERT INTO billing_paket_detail (id_billing_paket, jenis, id_detail ) 
                         select $row[0] ,'L',* 	from unnest($list_id_lab)");
		///////////////////////////////////////////////////////////////////////////////////////////////

		$res = pg_query($dbconn, 
			"INSERT INTO billing_paket_kategori_harga_unit (id_billing_paket, id_kategori_harga , id_unit, disc_persen, disc_amount) VALUES ('$row[0]', '$id_kategori_harga', '$id_unit', $diskon_paket_persen, $diskon_paket_amt ) RETURNING id "); 	

		$id_billing_paket_kategori_harga_unit = pg_fetch_row($res);


		pg_query($dbconn, "INSERT INTO billing_paket_kategori_harga_unit_detail (id_paket_k_unit,jenis, harga_net, id_detail, disc_persen, disc_amount) 
                    SELECT $id_billing_paket_kategori_harga_unit[0],'T', *
					from unnest($list_harga_tindakan, $list_id_tindakan, $disc_persen_tindakan, $disc_amt_tindakan )");

		pg_query($dbconn, "INSERT INTO billing_paket_kategori_harga_unit_detail (id_paket_k_unit,jenis,  harga_net, id_detail, disc_persen, disc_amount) 
                    SELECT $id_billing_paket_kategori_harga_unit[0],'L',  *
					from unnest($list_harga_lab, $list_id_lab, $dis_persen_lab, $dis_amt_lab )");

		pg_query($dbconn,"UPDATE billing_paket_kategori_harga_unit SET harga='$harga_total_paket' WHERE id='$row[0]' ");
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
		

	break;

	case "delete":
	$id = $_POST["id"];
	$unit = $_SESSION['id_unit'];
	$res=pg_query($dbconn,"DELETE FROM billing_paket_kategori_harga_unit WHERE id_billing_paket = '$id' and id_unit='$unit' ");
	$res=pg_query($dbconn,"DELETE FROM billing_paket_kategori_harga_unit_detail WHERE id_paket_k_unit = '$id' ");

	break;
}

?>