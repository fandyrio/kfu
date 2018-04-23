<?php
error_reporting(0);
include "../../../config/conn.php";
$no_rm=$_GET['no_rm'];
$id_pasien=$_GET['id_pasien'];
$idKunjungan=$_GET['id_kunjungan'];

$getDataFisik=pg_query("SELECT * from pasien_fisik where id_kunjungan='$idKunjungan'");
$jumlahDataFisik=pg_num_rows($getDataFisik);

$getDataMata=pg_query("SELECT * from pasien_mata where id_kunjungan='$idKunjungan'");
$jumlahDataMata=pg_num_rows($getDataMata);

$getDataTHT=pg_query("SELECT * from pasien_tht where id_kunjungan='$idKunjungan'");
$jumlahDataTHT=pg_num_rows($getDataTHT);

$getDataMulut=pg_query("SELECT * from pasien_mulut where id_kunjungan='$idKunjungan'");
$jumlahDataMulut=pg_num_rows($getDataMulut);

$getDataLeher=pg_query("SELECT * from pasien_leher where id_kunjungan='$idKunjungan'");
$jumlahDataLeher=pg_num_rows($getDataLeher);

$getDataThorax=pg_query("SELECT * from pasien_thorax where id_kunjungan='$idKunjungan'");
$jumlahDataThorax=pg_num_rows($getDataThorax);

$getDataAbdomen=pg_query("SELECT * from pasien_abdomen where id_kunjungan='$idKunjungan'");
$jumlahDataAbdomen=pg_num_rows($getDataAbdomen);

$getDataRektal=pg_query("SELECT * from pasien_rektal where id_kunjungan='$idKunjungan'");
$jumlahDataRektal=pg_num_rows($getDataRektal);

$getDataExtremitas=pg_query("SELECT * from pasien_extremitas where id_kunjungan='$idKunjungan'");
$jumlahDataExtremitas=pg_num_rows($getDataExtremitas);

$getDataNeurologis=pg_query("SELECT * from pasien_neurologis where id_kunjungan='$idKunjungan'");
$jumlahDataNeurologis=pg_num_rows($getDataNeurologis);

$getDataKulit=pg_query("SELECT * from pasien_kulit where id_kunjungan='$idKunjungan'");
$jumlahDataKulit=pg_num_rows($getDataKulit);

?>
<p><button class="btn btn-sm btn-primary">Pemeriksaan Fisik</button></p> <!-- Judul -->
<?php
if($jumlahDataFisik==0)
{
	echo "Data tidak ada";
	echo "<hr />";
}
else
{
	include "dataPemeriksaanFisik.php";
}

?>
<p><button class="btn btn-sm btn-primary">Pemeriksaan Mata</button></p> <!-- Judul -->
<?php
if($jumlahDataMata==0)
{
	echo "Data tidak ada";
	echo "<hr />";
}
else
{
	include "dataPemeriksaanMata.php";
}
?>

<p><button class="btn btn-sm btn-primary">Pemeriksaan THT</button></p> <!-- Judul -->
<?php
if($jumlahDataTHT==0)
{
	echo "Data tidak ada";
	echo "<hr />";
}
else
{
	include "dataPemeriksaanTHT.php";
}
?>

<p><button class="btn btn-sm btn-primary">Pemeriksaan Mulut</button></p> <!-- Judul -->
<?php
if($jumlahDataMulut==0)
{
	echo "Data tidak ada";
	echo "<hr />";
}
else
{
	include "dataPemeriksaanMulut.php";
}

?>

<p><button class="btn btn-sm btn-primary">Pemeriksaan Leher</button></p> <!-- Judul -->
<?php
if($jumlahDataLeher==0)
{
	echo "Data tidak ada";
	echo "<hr />";
}
else
{
	include "dataPemeriksaanLeher.php";
}
?>

<p><button class="btn btn-sm btn-primary">Pemeriksaan Thorax</button></p> <!-- Judul -->
<?php
if($jumlahDataThorax==0)
{
	echo "Data tidak ada";
	echo "<hr />";
}
else
{
	include "dataPemeriksaanThorax.php";
}
?>


<p><button class="btn btn-sm btn-primary">Pemeriksaan Abdomen</button></p> <!-- Judul -->
<?php
if($jumlahDataAbdomen==0)
{
	echo "Data tidak ada";
	echo "<hr />";
}
else
{
	include "dataPemeriksaanAbdomen.php";
}
?>

<p><button class="btn btn-sm btn-primary">Pemeriksaan Rektal</button></p> <!-- Judul -->
<?php
if($jumlahDataRektal==0)
{
	echo "Data tidak ada";
	echo "<hr />";
}
else
{
	include "dataPemeriksaanRektal.php";
}
?>

<p><button class="btn btn-sm btn-primary">Pemeriksaan Extremitas</button></p> <!-- Judul -->
<?php
if($jumlahDataExtremitas==0)
{
	echo "Data tidak ada";
	echo "<hr />";
}
else
{
	include "dataPemeriksaanExtremitas.php";
}
?>

<p><button class="btn btn-sm btn-primary">Pemeriksaan Neurologis</button></p> <!-- Judul -->
<?php
if($jumlahDataNeurologis==0)
{
	echo "Data tidak ada";
	echo "<hr />";
}
else
{
	include "dataPemeriksaanNeurolis.php";
}
?>

<p><button class="btn btn-sm btn-primary">Pemeriksaan Kulit</button></p> <!-- Judul -->
<?php
if($jumlahDataKulit==0)
{
	echo "Data tidak ada";
	echo "<hr />";
}
else
{
	include "dataPemeriksaanKulit.php";
}
?>