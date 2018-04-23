<?php
include "../../../config/conn.php";
session_start();
$id_unit=$_SESSION['id_units'];
$status=$_POST['id'];

$getDataUnit=pg_query("SELECT * from master_unit where id='$id_unit'");
$fetchUnit=pg_fetch_array($getDataUnit);

$mode="dbKlinik";
if($mode=="APIPOC")
{
	$idOutlet=$fetchUnit['id_outlet'];
	$table="item_catalog";
}
else
{
	$idOutlet=0;
	$table="item_catalog_temp";
}

if($status=="doneNamaObat")
{
	$nama_obat=$_POST['nama_obat'];
	$id_obat=$_POST['id_obat'];
	$idPRO=$_POST['idPRO'];
	$getDataObat=pg_query("SELECT * from $table where  catalog_id='$id_obat' and outlet_id='$idOutlet'");
	$fetchDataObat=pg_fetch_array($getDataObat);
	$namaObat=$fetchDataObat['catalog_name'];

	$update=pg_query("update pasien_resep_order set id_inv='$id_obat', nama_brand='$namaObat' where id='$idPRO'");
}
else if($status=="doneDosisEdit")
{
	$dosis=$_POST['dosis'];
	$idPRO=$_POST['idPRO'];
	$satuan=$_POST['satuan'];
	
	$update=pg_query("update pasien_resep_order set dosis='$dosis', satuan='$satuan' where id='$idPRO'");
}
else if($status=="editJumlah")
{
	echo "editJumlah";
	$idPRO=$_POST['idPRO'];
	$jumlah=$_POST['jumlah'];
	$noResep=$_POST['noResep'];
	$idKunjungan=$_POST['idKunjungan'];
	
	$update=pg_query("update pasien_resep_keterangan set jml='$jumlah' where id_kunjungan='$idKunjungan' and id_resep='$noResep'");
}
else if($status=="editXperh")
{
	echo "editJumlah";
	$idPRK=$_POST['idPRK'];
	$xperh=$_POST['xperh'];
	$idKunjungan=$_POST['idKunjungan'];
	
	$update=pg_query("update pasien_resep_keterangan set xperh='$xperh' where id_kunjungan='$idKunjungan' and id='$idPRK'");
}
else if($status=="editOperh")
{
	echo "editJumlah";
	$idPRK=$_POST['idPRK'];
	$operh=$_POST['operh'];
	$idKunjungan=$_POST['idKunjungan'];
	
	$update=pg_query("update pasien_resep_keterangan set operh='$operh' where id_kunjungan='$idKunjungan' and id='$idPRK'");
}
else if($status=="editSediaan")
{
	echo "editJumlah";
	$idPRK=$_POST['idPRK'];
	$sediaan=$_POST['sediaan'];
	$idKunjungan=$_POST['idKunjungan'];
	
	$update=pg_query("update pasien_resep_keterangan set sediaan_detail='$sediaan' where id_kunjungan='$idKunjungan' and id='$idPRK'");
}
else if($status=="editIterasi")
{
	$idPRK=$_POST['idPRK'];
	$iterasi=$_POST['iterasi'];
	$idKunjungan=$_POST['idKunjungan'];

	$explodeIterasi=explode("prk", $idPRK);
	
	$update=pg_query("update pasien_resep_keterangan set iterasi='$iterasi' where id_kunjungan='$idKunjungan' and id='$explodeIterasi[1]'");
}
else if($status=="editCarapakai")
{
	$idPRK=$_POST['idPRK'];
	$carapakai=$_POST['carapakai'];
	$idKunjungan=$_POST['idKunjungan'];

	
	
	$update=pg_query("update pasien_resep_keterangan set cara_pakai='$carapakai' where id_kunjungan='$idKunjungan' and id='$idPRK'");
}
else if($status=="editKeteranganSigna")
{
	$idPRK=$_POST['idPRK'];
	$keteranganSigna=$_POST['keteranganSigna'];
	$idKunjungan=$_POST['idKunjungan'];

	
	
	$update=pg_query("update pasien_resep_keterangan set ket_signa='$keteranganSigna' where id_kunjungan='$idKunjungan' and id='$idPRK'");
}


?>