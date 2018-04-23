<?php 

$id_inv = $_POST['id_inv'];
$nama_brand = $_POST['brand_nama'];
$jumlah = $_POST['jumlah'];
$alasan = $_POST['alasan'];
$id_satuan = $_POST['id_satuan'];
$harga_unit = $_POST['unit_cost'];
$total_cost = $_POST['total_cost'];


             if (!isset($_POST['unit_cost']) || empty($_POST['unit_cost'])) {
                    $harga_unit = 0;
            } 
            else{
                    $harga_unit = "'" .pg_escape_string($_POST['unit_cost']) . "'";
            }
            if (!isset($_POST['total_cost']) || empty($_POST['total_cost'])) {
                    $total_cost = 0;
            } 
            else{
                    $total_cost = "'" .pg_escape_string($_POST['total_cost']) . "'";
            }



$result=pg_query($dbconn,"INSERT INTO stok_adj_ln_temp (id_users, id_inv,nama_brand, qty, id_satuan, harga_unit, total_harga, alasan)
                        VALUES ('".$_SESSION['id_users']."', 
                            '".$id_inv."', 
                            '".$nama_brand."', 
                            '".$jumlah."',
                            '".$id_satuan."',
                            $harga_unit,
                            $total_cost,
                            '".$alasan."')
  											RETURNING id");

 $row = pg_fetch_row($result);

 $_SESSION['id_adj_ln'] = $row[0];
 $_SESSION['nama_brand']    = $nama_brand;
 $_SESSION['id_satuan']    = $id_satuan;
 $_SESSION['jumlah']    = $jumlah;
 $_SESSION['nama_satuan']    = $_POST['nama_satuan'];

var_dump($_POST);
  					
					 
?>