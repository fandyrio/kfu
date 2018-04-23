<?php 

$id_inv      = $_POST['id_inv'];
$nama_brand  = $_POST['brand_nama'];
$jumlah      = $_POST['jumlah'];
$remark      = $_POST['remark'];
$id_satuan   = $_POST['id_satuan'];
$stno        = '1';
$beda_qty    = $_POST['beda_qty'];
$balance_qty = $_POST['balance_qty'];
$baru_qty    = $_POST['baru_qty'];

$result=pg_query($dbconn,"INSERT INTO stok_take_qty_temp (
                                id_users, 
                                id_inv,
                                stno,
                                nama_brand, 
                                beda_qty, 
                                balance_qty,
                                baru_qty,
                                id_satuan
                        )
                        VALUES ('".$_SESSION['id_users']."', 
                            '".$id_inv."', 
                            '".$stno."', 
                            '".$nama_brand."', 
                            '".$beda_qty."',
                            '".$balance_qty."',
                             '".$baru_qty."',
                            '".$id_satuan."') RETURNING id");

 $row = pg_fetch_row($result);

 $_SESSION['id_trf_ln'] = $row[0];

//var_dump($_SESSION['id_trf_ln']);

var_dump("INSERT INTO stok_take_qty_temp (id_users, id_inv,nama_brand, qty, id_satuan, catatan)
                        VALUES ('".$_SESSION['id_users']."', 
                            '".$id_inv."', 
                            '".$nama_brand."', 
                            '".$jumlah."',
                            '".$id_satuan."',
                            '".$remark."')
                        RETURNING id");
  					
					 
?>