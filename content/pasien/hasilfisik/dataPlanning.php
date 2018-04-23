<?php
include "../../../config/conn.php";
$no_rm=$_GET['no_rm'];
$id_pasien=$_GET['id_pasien'];
$id_kunjungan=$_GET['id_kunjungan'];

$getKesimpulan=pg_query("SELECT * from pasien_tindak_lanjut ptl left join master_tindak_lanjut mtl on mtl.id=ptl.id_tindak_lanjut where ptl.id_kunjungan='$id_kunjungan'");
$fetchTindakLanjut=pg_fetch_array($getKesimpulan);
$jumlahTindakLanjut=pg_num_rows($getKesimpulan);


if($jumlahTindakLanjut==0)
{
	echo "Tidak ada data";
}
else
{
	echo "<ol>";
	if($fetchTindakLanjut['status_terkontrol']=="Y")
	{
		echo "<li>Terkontrol </li>";
	}

	if($fetchTindakLanjut['status_dirujuk']=="Y")
	{
		$getRS=pg_query("SELECT * from master_cabang_rujukan where id='$fetchTindakLanjut[id_rs]'");
														$fetchRS=pg_fetch_assoc($getRS);
														$rs=$fetchRS['nama'];
		echo "<li>Dirujuk Ke ".$rs."</li>";
	}

	if($fetchTindakLanjut['meninggal_dunia']=="Y")
	{
		echo "<li>Meninggal Dunia </li>";
	}

	if($fetchTindakLanjut['id_tindak_lanjut']!=0)
	{
		echo "<li>Penanganan tingkat lanjut = ".$fetchTindakLanjut['nama']."</li>";
	}	
	echo"</ol>";
}


?>

