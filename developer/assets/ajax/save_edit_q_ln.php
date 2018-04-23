 <?php
			$id = $_POST['id'];
            $brand_nama = $_POST['brand_nama'];
            $id_satuan = $_POST['id_satuan'];
            $jumlah = $_POST['jumlah'];
            $harga_unit = $_POST['harga'];
           	if (!isset($_POST['diskon']) || empty($_POST['diskon'])) {
                    $disc_amount = 'NULL';
                } else {
                    $disc_amount = "'" .pg_escape_string($_POST['diskon']) . "'";
                }
            $gross_unit = $_POST['gross'];
           	$net_total = $_POST['net'];
            $net_price = $_POST['net_price'];
            $id_inv = $_POST['id_inv'];


            $res=pg_query($dbconn,"UPDATE q_ln_temp set 
			nama_brand='".$brand_nama."',
			id_satuan='".$id_satuan."', 
			jumlah='".$jumlah."'
            , harga_unit='".$harga_unit."'
            , disc_amount=$disc_amount
            , gross_total='".$gross_unit."'
            , net_total='".$net_total."'
            , net_price='".$net_price."'
            , id_inv='".$id_inv."'
			WHERE id = '".$id."'");

            /*var_dump("UPDATE q_ln_temp set 
            nama_brand='".$brand_nama."',
            id_satuan='".$id_satuan."', 
            jumlah='".$jumlah."'
            , harga_unit='".$harga_unit."'
            , disc_amount=$disc_amount
            , gross_total='".$gross_unit."'
            , net_total='".$net_total."'
            , net_price='".$net_price."'
            , id_inv='".$id_inv."'
            WHERE id = '".$id."'");*/
            		 
?>  