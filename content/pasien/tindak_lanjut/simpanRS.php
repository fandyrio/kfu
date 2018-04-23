<?php
include "../../../config/conn.php";

$nama=$_POST['nama_rs'];
$alamat=$_POST['alamat'];
$tlp=$_POST['no_tlp'];

$insertRS=pg_query("INSERT into master_cabang_rujukan (nama,alamat,telepon) values ('$nama', '$alamat', '$tlp') RETURNING id,nama");
$fetchRS=pg_fetch_array($insertRS);
$nama=$fetchRS[1];
$id=$fetchRS[0];

$return=array('nama'=>$nama,
			'id'=>$id);
$jsonReturn=json_encode($return);
echo $jsonReturn;
?>