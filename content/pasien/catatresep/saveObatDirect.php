<?php
include"../../../config/conn.php";

$idPasien=$_POST['idPasien'];
$idObat=$_POST['idObat'];
$idKunjungan=$_POST['idKunjungan'];
$namaObat=$_POST['namaObat'];
$dosis=$_POST['dosis'];
$waktu=date("Y-m-d");
$ket=$_POST['keterangan'];
$satuan=$_POST['satuan'];
$idResep=$_POST['idResep'];


$insertData=pg_query("INSERT INTO pasien_resep_order (id_pasien, status_proses, id_inv, id_kunjungan,nama_brand, dosis, waktu_input,ket, satuan,id_resep)
values ('$idPasien', 'N', '$idObat','$idKunjungan', '$namaObat','$dosis','$waktu','$ket','$satuan','$idResep')"); 

?>