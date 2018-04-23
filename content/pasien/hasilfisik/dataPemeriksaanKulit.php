<?php
include "../../../config/conn.php";

$getDataPemeriksaan=pg_query("SELECT * from pasien_kulit pk
	where pk.id_kunjungan='$idKunjungan'");
$fetchPemeriksaan=pg_fetch_assoc($getDataPemeriksaan);
?>

<ol>
	<li>
		<div class="row">
			<div class="col-md-3">
				Warna Kulit
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['warna'] ?>
			</div>
		</div>
	</li>

	<li>
		<div class="row">
			<div class="col-md-3">
				Kelainan Kulit
			</div>
			<div class="col-md-3">
				<?php echo $fetchPemeriksaan['kelainan'] ?>
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
<hr />