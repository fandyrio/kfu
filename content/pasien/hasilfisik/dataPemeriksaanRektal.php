<?php
include "../../../config/conn.php";

$getDataPemeriksaan=pg_query("SELECT * from pasien_rektal pr
	where pr.id_kunjungan='$idKunjungan'");
$fetchPemeriksaan=pg_fetch_assoc($getDataPemeriksaan);
if($fetchPemeriksaan['rektal1_hasil']==1)
{
	$hasilRektal1="Normal";
}
else
{
	$hasilRektal1="Tidak Normal";
}

if($fetchPemeriksaan['rektal2_hasil']==1)
{
	$hasilRektal2="Normal";
}
else
{
	$hasilRektal2="Tidak Normal";
}

?>

<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Haemorrhoid
			</div>
			<div class="col-md-3">
				<?php echo $hasilRektal1 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['rektal1_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Anus/Rectum/Parianal
			</div>
			<div class="col-md-3">
				<?php echo $hasilRektal2 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['rektal2_keterangan'] ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				 Keterangan
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['keterangan'] ?>
			</div>
		</div>
	</li>
</ol>
<hr />