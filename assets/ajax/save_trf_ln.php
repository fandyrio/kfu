<?php 

$id_inv = $_POST['id_inv'];
$nama_brand = $_POST['brand_nama'];
$jumlah = $_POST['jumlah'];
$remark = $_POST['remark'];
$id_satuan = $_POST['id_satuan'];

if($_SESSION["id_trf_hdr"]!=NULL){

    $result=pg_query($dbconn,"INSERT INTO stok_trf_ln (id_users, id_hdr, id_inv,nama_brand,  id_satuan, catatan)
                        VALUES ('".$_SESSION['id_users']."', 
                            '".$_SESSION['id_trf_hdr']."',
                            '".$id_inv."', 
                            '".$nama_brand."', 
                            '".$id_satuan."',
                            '$remark') RETURNING id");

    var_dump("INSERT INTO stok_trf_ln (id_users, id_hdr, id_inv,nama_brand,  id_satuan, catatan)
                        VALUES ('".$_SESSION['id_users']."', 
                            '".$_SESSION['id_trf_hdr']."',
                            '".$id_inv."', 
                            '".$nama_brand."', 
                            '".$id_satuan."',
                            '$remark') RETURNING id");

}else{
$result=pg_query($dbconn,"INSERT INTO stok_trf_ln (id_users, id_inv,nama_brand,  id_satuan, catatan)
                        VALUES ('".$_SESSION['id_users']."', 
                            '".$id_inv."', 
                            '".$nama_brand."', 
                            '".$id_satuan."',
                            '$remark') RETURNING id");

var_dump("INSERT INTO stok_trf_ln (id_users, id_inv,nama_brand,  id_satuan, catatan)
                        VALUES ('".$_SESSION['id_users']."', 
                            '".$id_inv."', 
                            '".$nama_brand."', 
                            '".$id_satuan."',
                            '$remark') RETURNING id");

}

$row = pg_fetch_row($result);

$_SESSION['id_trf_ln'] = $row[0];

var_dump($_SESSION['id_trf_ln']);
  					
					 
?>