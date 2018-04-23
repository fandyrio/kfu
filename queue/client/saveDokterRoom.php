<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../config/conn.php";

$namaRuang=$_POST['nama_ruangan'];
$idKaryawan=$_POST['idKaryawan'];
$idUnit=$_POST['id_unit'];

$getJabatan=pg_query("SELECT * from master_karyawan where id='$idKaryawan'");
$fetchJabatan=pg_fetch_assoc($getJabatan);
$jabatan=$fetchJabatan['id_jabatan'];

$insert=pg_query("INSERT INTO ruang_dokter (nama_ruangan,id_karyawan,tanggal,status,id_unit, id_jabatan) values ('$namaRuang', '$idKaryawan', now(), 'online', $idUnit, $jabatan)");

?>