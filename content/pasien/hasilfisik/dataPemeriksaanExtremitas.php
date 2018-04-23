<?php
include "../../../config/conn.php";

$getDataPemeriksaan=pg_query("SELECT * from pasien_extremitas pe
	where pe.id_kunjungan='$idKunjungan'");
$fetchPemeriksaan=pg_fetch_assoc($getDataPemeriksaan);
if($fetchPemeriksaan['extremitas1_hasil']==1)
{
	$hasilExtremitas1="Normal";
}
else
{
	$hasilExtremitas1="Tidak Normal";
}

if($fetchPemeriksaan['extremitas2_hasil']==1)
{
	$hasilExtremitas2="Normal";
}
else
{
	$hasilExtremitas2="Tidak Normal";
}

if($fetchPemeriksaan['extremitas3_hasil']==1)
{
	$hasilExtremitas3="Normal";
}
else
{
	$hasilExtremitas3="Tidak Normal";
}

if($fetchPemeriksaan['extremitas4_hasil']==1)
{
	$hasilExtremitas4="Normal";
}
else
{
	$hasilExtremitas4="Tidak Normal";
}

if($fetchPemeriksaan['extremitas5_hasil']==1)
{
	$hasilExtremitas5="Normal";
}
else
{
	$hasilExtremitas5="Tidak Normal";
}

?>

<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Tulang/Sendi
			</div>
			<div class="col-md-3">
				<?php echo $hasilExtremitas1 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['extremitas1_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				Otot-otot/Tonus
			</div>
			<div class="col-md-3">
				<?php echo $hasilExtremitas2 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['extremitas2_keterangan'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				Jari-jari/Kuku
			</div>
			<div class="col-md-3">
				<?php echo $hasilExtremitas3 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['extremitas3_keterangan'] ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				Tangan
			</div>
			<div class="col-md-3">
				<?php echo $hasilExtremitas4 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['extremitas4_keterangan'] ?>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				Kaki
			</div>
			<div class="col-md-3">
				<?php echo $hasilExtremitas5 ?>
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['extremitas5_keterangan'] ?>
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