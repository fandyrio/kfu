<?php
include "../../../config/conn.php";

$getDataPemeriksaanLeher=pg_query("SELECT * from pasien_leher pm 
	where pm.id_kunjungan='$idKunjungan'");
$fetchPemeriksaanLeher=pg_fetch_assoc($getDataPemeriksaanLeher);

if($fetchPemeriksaanLeher['leher1_hasil']==1)
{
	$hasilLeher1="Normal";
}
else
{
	$hasilLeher1="Tidak";
}

if($fetchPemeriksaanLeher['leher2_hasil']==1)
{
	$hasilLeher2="Normal";
}
else
{
	$hasilLeher2="Tidak Normal";
}
?>
<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Bentuk
			</div>
			<div class="col-md-3">
				<?php echo $hasilLeher1 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanLeher['leher1_keterangan'] ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				Thyroid
			</div>
			<div class="col-md-3">
				<?php echo $hasilLeher2 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanLeher['leher2_keterangan'] ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				Keterangan
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanLeher['keterangan'] ?>
			</div>
		</div>
	</li>
</ol>
