<?php
 	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$kode = $_POST['kode'];
	$harga_material = $_POST['harga_material'];
	$harga_jasa = $_POST['harga_jasa'];
	$id_jenis = $_POST['id_jenis'];

	$result=pg_query($dbconn,"UPDATE tindakan SET 
	nama='".$nama."',
	kode='$kode',
	harga_material='$harga_material',
	harga_jasa='$harga_jasa',
	id_jenis = '$id_jenis'
	WHERE id = $id");

		

?>