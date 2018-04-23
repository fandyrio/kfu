<?php
include "../../../config/conn.php";

$getDataPemeriksaan=pg_query("SELECT * from pasien_neurologis pn
	where pn.id_kunjungan='$idKunjungan'");
$fetchPemeriksaan=pg_fetch_assoc($getDataPemeriksaan);
if($fetchPemeriksaan['neurologis1_hasil']==1)
{
	$hasilNeurologis1="Normal";
}
else
{
	$hasilNeurologis1="Tidak Normal";
}

if($fetchPemeriksaan['neurologis2_hasil']==1)
{
	$hasilNeurologis2="Normal";
}
else
{
	$hasilNeurologis2="Tidak Normal";
}

if($fetchPemeriksaan['neurologis3_hasil']==1)
{
	$hasilNeurologis3="Normal";
}
else
{
	$hasilNeurologis3="Tidak Normal";
}

if($fetchPemeriksaan['neurologis4_hasil']==1)
{
	$hasilNeurologis4="Normal";
}
else
{
	$hasilNeurologis4="Tidak Normal";
}

if($fetchPemeriksaan['neurologis5_hasil']==1)
{
	$hasilNeurologis5="Normal";
}
else
{
	$hasilNeurologis5="Tidak Normal";
}

if($fetchPemeriksaan['neurologis6_hasil']==1)
{
	$hasilNeurologis6="Normal";
}
else
{
	$hasilNeurologis6="Tidak Normal";
}

?>

<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Reflex Fisiologis
			</div>
			<div class="col-md-3">
				<?php echo $hasilNeurologis1 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['neurologis1_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				Otot-otot/Tonus
			</div>
			<div class="col-md-3">
				<?php echo $hasilNeurologis2 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['neurologis2_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				Jari-jari/Kuku
			</div>
			<div class="col-md-3">
				<?php echo $hasilNeurologis3 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['neurologis3_keterangan'] ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				Tangan
			</div>
			<div class="col-md-3">
				<?php echo $hasilNeurologis4 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['neurologis4_keterangan'] ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				Kaki
			</div>
			<div class="col-md-3">
				<?php echo $hasilNeurologis5 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['neurologis5_keterangan'] ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				Kaki
			</div>
			<div class="col-md-3">
				<?php echo $hasilNeurologis6 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['neurologis6_keterangan'] ?>
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