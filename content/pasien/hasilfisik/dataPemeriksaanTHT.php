<?php
include "../../../config/conn.php";

$getDataPemeriksaanTHT=pg_query("SELECT * from pasien_tht pt 
	where pt.id_kunjungan='$idKunjungan'");
$fetchPemeriksaanTHT=pg_fetch_assoc($getDataPemeriksaanTHT);
if($fetchPemeriksaanTHT['telinga1_hasil']==1)
{
	$hasilTelinga1="Normal";
}
else
{
	$hasilTelinga1="Tidak Normal";
}
if($fetchPemeriksaanTHT['telinga2_hasil']==1)
{
	$hasilTelinga2="Normal";
}
else
{
	$hasilTelinga2="Tidak Normal";
}
if($fetchPemeriksaanTHT['telinga3_hasil']==1)
{
	$hasilTelinga3="Normal";
}
else
{
	$hasilTelinga3="Tidak Normal";
}


if($fetchPemeriksaanTHT['hidung1_hasil']==1)
{
	$hasilHidung1="Normal";
}
else
{
	$hasilHidung1="Tidak Normal";
}

if($fetchPemeriksaanTHT['hidung2_hasil']==1)
{
	$hasilHidung2="Normal";
}
else
{
	$hasilHidung2="Tidak Normal";
}

if($fetchPemeriksaanTHT['hidung3_hasil']==1)
{
	$hasilHidung3="Normal";
}
else
{
	$hasilHidung3="Tidak Normal";
}

if($fetchPemeriksaanTHT['tenggorokan1_hasil']==1)
{
	$hasilTenggorokan1="Normal";
}
else
{
	$hasilTenggorokan1="Tidak Normal";
}

if($fetchPemeriksaanTHT['tenggorokan2_hasil']==1)
{
	$hasilTenggorokan2="Normal";
}
else
{
	$hasilTenggorokan2="Tidak Normal";
}

?>

<b>Telinga</b>
<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Bentuk
			</div>
			<div class="col-md-3">
				<?php echo $hasilTelinga1 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanTHT['telinga1_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Lubang Telinga
			</div>
			<div class="col-md-3">
				<?php echo $hasilTelinga2 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanTHT['telinga2_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Memberan Tympani
			</div>
			<div class="col-md-3">
				<?php echo $hasilTelinga3 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanTHT['telinga3_keterangan'] ?>
			</div>
		</div>
	</li>
</ol>
<b>Hidung</b>
<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Bentuk
			</div>
			<div class="col-md-3">
				<?php echo $hasilHidung1 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanTHT['hidung1_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Septum
			</div>
			<div class="col-md-3">
				<?php echo $hasilHidung2 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanTHT['hidung2_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Concha
			</div>
			<div class="col-md-3">
				<?php echo $hasilHidung3 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanTHT['hidung3_keterangan'] ?>
			</div>
		</div>
	</li>
</ol>

<b>Tenggorokan</b>
<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Faring
			</div>
			<div class="col-md-3">
				<?php echo $hasilTenggorokan1 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanTHT['tenggorokan1_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				 Tonsil
			</div>
			<div class="col-md-3">
				<?php echo $hasilTenggorokan2 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanTHT['tenggorokan2_keterangan'] ?>
			</div>
		</div>
	</li>
</ol>

<b>Lain-Lain</b>
<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Faring
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaanTHT['lainlain'] ?>
			</div>
			
		</div>
	</li>
</ol>
<hr />