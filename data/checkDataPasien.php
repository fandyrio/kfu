<?php
include "../config/conn.php";

$idPasien=$_POST['idPasien'];

$get=pg_query("SELECT * from master_pasien where public_id='$idPasien'");
$fetch=pg_fetch_assoc($get);
$jumlah=pg_num_rows($get);
echo $jumlah.'-'.$fetch['no_rm'];
?>