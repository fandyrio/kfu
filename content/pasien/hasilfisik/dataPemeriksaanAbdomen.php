<?php
include "../../../config/conn.php";

$getDataPemeriksaan=pg_query("SELECT * from pasien_abdomen pa
	where pa.id_kunjungan='$idKunjungan'");
$fetchPemeriksaan=pg_fetch_assoc($getDataPemeriksaan);
if($fetchPemeriksaan['abdomen1_hasil']==1)
{
	$hasilAbdomen1="Normal";
}
else
{
	$hasilAbdomen1="Tidak Normal";
}
if($fetchPemeriksaan['abdomen2_hasil']==1)
{
	$hasilAbdomen2="Normal";
}
else
{
	$hasilAbdomen2="Tidak Normal";
}
if($fetchPemeriksaan['abdomen3_hasil']==1)
{
	$hasilAbdomen3="Normal";
}
else
{
	$hasilAbdomen3="Tidak Normal";
}


if($fetchPemeriksaan['abdomen4_hasil']==1)
{
	$hasilAbdomen4="Normal";
}
else
{
	$hasilAbdomen4="Tidak Normal";
}

if($fetchPemeriksaan['abdomen5_hasil']==1)
{
	$hasilAbdomen5="Normal";
}
else
{
	$hasilAbdomen5="Tidak Normal";
}

if($fetchPemeriksaan['abdomen6_hasil']==1)
{
	$hasilAbdomen6="Normal";
}
else
{
	$hasilAbdomen6="Tidak Normal";
}

if($fetchPemeriksaan['abdomen7_hasil']==1)
{
	$hasilAbdomen7="Normal";
}
else
{
	$hasilAbdomen7="Tidak Normal";
}

if($fetchPemeriksaan['abdomen8_hasil']==1)
{
	$hasilAbdomen8="Normal";
}
else
{
	$hasilAbdomen8="Tidak Normal";
}

?>

<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Bentuk
			</div>
			<div class="col-md-3">
				<?php echo $hasilAbdomen1 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['abdomen1_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Palpasi/Perkusi
			</div>
			<div class="col-md-3">
				<?php echo $hasilAbdomen2 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['abdomen2_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Auskultasi
			</div>
			<div class="col-md-3">
				<?php echo $hasilAbdomen3 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['abdomen3_keterangan'] ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				Hati
			</div>
			<div class="col-md-3">
				<?php echo $hasilAbdomen4 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['abdomen4_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Limpa
			</div>
			<div class="col-md-3">
				<?php echo $hasilAbdomen5 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['abdomen4_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Ginjal
			</div>
			<div class="col-md-3">
				<?php echo $hasilAbdomen6 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['abdomen6_keterangan'] ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				Test Ketok
			</div>
			<div class="col-md-3">
				<?php echo $hasilAbdomen7 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['abdomen7_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Ballotemen
			</div>
			<div class="col-md-3">
				<?php echo $hasilAbdomen8 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['abdomen8_keterangan'] ?>
			</div>
		</div>
	</li>
</ol>
<hr />