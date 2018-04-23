<?php
include "../../../config/conn.php";

$getDataPemeriksaanMulut=pg_query("SELECT * from pasien_mulut pm 
	where pm.id_kunjungan='$idKunjungan'");
$fetchPemeriksaanMulut=pg_fetch_assoc($getDataPemeriksaanMulut);

if($fetchPemeriksaanMulut['oral_hasil']==1)
{
	$hasilOral="Baik";
}
else if($fetchPemeriksaanMulut['oral_hasil']==2)
{
	$hasilOral="Cukup";
}
else
{
	$hasilOral="Kurang";
}


if($fetchPemeriksaanMulut['lidah_hasil']==1)
{
	$hasilLidah="Normal";
}
else
{
	$hasilLidah="Tidak Normal";
}

if($fetchPemeriksaanMulut['gusi_hasil']==1)
{
	$hasilGusi="Normal";
}
else
{
	$hasilGusi="Tidak Normal";
}
?>

<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Oral Hygiene
			</div>
			<div class="col-md-3">
				<?php echo $hasilOral ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanMulut['oral_keterangan'] ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				Lidah
			</div>
			<div class="col-md-3">
				<?php echo $hasilLidah ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanMulut['lidah_keterangan']  ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				Gusi
			</div>
			<div class="col-md-3">
				<?php echo $hasilGusi ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanMulut['gusi_keterangan']  ?>
			</div>
		</div>
	</li>
</ol>