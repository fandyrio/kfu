<?php 

$id_inv = $_POST['id_inv'];
$nama_brand = $_POST['brand_nama'];
$jumlah = $_POST['jumlah'];

$id_satuan = $_POST['id_satuan'];



$result=pg_query($dbconn,"INSERT INTO retur_ln (id_users, id_inv,nama_inventori, qty, id_satuan)
                        VALUES ('".$_SESSION['id_users']."', 
                            '".$id_inv."', 
                            '".$nama_brand."', 
                            '".$jumlah."',
                            '".$id_satuan."') RETURNING id");

 $row = pg_fetch_row($result);

 $_SESSION['id_retur_ln'] = $row[0];
 if($result){
    echo "success";

 }
 else{
    var_dump("INSERT INTO retur_ln (id_users, id_inv,nama_brand, qty, id_satuan)
                        VALUES ('".$_SESSION['id_users']."', 
                            '".$id_inv."', 
                            '".$nama_brand."', 
                            '".$jumlah."',
                            '".$id_satuan."') RETURNING id");
                            
 }


  					
					 
?>