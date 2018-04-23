<?php
include "../../../config/conn.php";

$getDataPemeriksaanThorax=pg_query("SELECT * from pasien_thorax pt 
	where pt.id_kunjungan='$idKunjungan'");
$fetchPemeriksaanThorax=pg_fetch_assoc($getDataPemeriksaanThorax);
if($getDataPemeriksaanThorax['cor1_hasil']==1)
{
	$hasilCor1="Normal";
}
else
{
	$hasilCor1="Tidak Normal";
}
if($getDataPemeriksaanThorax['cor2_hasil']==1)
{
	$hasilCor2="Normal";
}
else
{
	$hasilCor2="Tidak Normal";
}

if($getDataPemeriksaanThorax['cor3_hasil']==1)
{
	$hasilCor3="Normal";
}
else
{
	$hasilCor3="Tidak Normal";
}

if($getDataPemeriksaanThorax['cor4_hasil']==1)
{
	$hasilCor4="Normal";
}
else
{
	$hasilCor4="Tidak Normal";
}

if($getDataPemeriksaanThorax['pulmo1_hasil']==1)
{
	$hasilPulmo1="Normal";
}
else
{
	$hasilPulmo1="Tidak Normal";
}

if($getDataPemeriksaanThorax['pulmo2_hasil']==1)
{
	$hasilPulmo2="Normal";
}
else
{
	$hasilPulmo2="Tidak Normal";
}

if($getDataPemeriksaanThorax['pulmo3_hasil']==1)
{
	$hasilPulmo3="Normal";
}
else
{
	$hasilPulmo3="Tidak Normal";
}

if($getDataPemeriksaanThorax['pulmo4_hasil']==1)
{
	$hasilPulmo4="Normal";
}
else
{
	$hasilPulmo4="Tidak Normal";
}


?>

<b>COR</b>
<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Inspeksi
			</div>
			<div class="col-md-3">
				<?php echo $hasilCor1 ?>
			</div>
			<div class="col-md-3">
				<?php echo $getDataPemeriksaanThorax['car1_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Perkusi
			</div>
			<div class="col-md-3">
				<?php echo $hasilCor2 ?>
			</div>
			<div class="col-md-3">
				<?php echo $getDataPemeriksaanThorax['car2_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				Palpasi
			</div>
			<div class="col-md-3">
				<?php echo $hasilCor3 ?>
			</div>
			<div class="col-md-3">
				<?php echo $getDataPemeriksaanThorax['car3_keterangan'] ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				Auskultasi
			</div>
			<div class="col-md-3">
				<?php echo $hasilCor4 ?>
			</div>
			<div class="col-md-3">
				<?php echo $getDataPemeriksaanThorax['car4_keterangan'] ?>
			</div>
		</div>
	</li>
</ol>
<b>Pulmo</b>
<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Inspeksi
			</div>
			<div class="col-md-3">
				<?php echo $hasilPulmo1 ?>
			</div>
			<div class="col-md-3">
				<?php echo $getDataPemeriksaanThorax['pulmo1_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Perkusi
			</div>
			<div class="col-md-3">
				<?php echo $hasilPulmo2 ?>
			</div>
			<div class="col-md-3">
				<?php echo $getDataPemeriksaanThorax['pulmo2_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Palpasi
			</div>
			<div class="col-md-3">
				<?php echo $hasilPulmo3 ?>
			</div>
			<div class="col-md-3">
				<?php echo $getDataPemeriksaanThorax['pulmo3_keterangan'] ?>
			</div>
		</div>
	</li>


	<li>
		<div class="row">
			<div class="col-md-3">
				 Auskultasi
			</div>
			<div class="col-md-3">
				<?php echo $hasilPulmo4 ?>
			</div>
			<div class="col-md-3">
				<?php echo $getDataPemeriksaanThorax['pulmo4_keterangan'] ?>
			</div>
		</div>
	</li>
</ol>


<hr />