<?php
include "../../../config/conn.php";

$getDataPemeriksaanMata=pg_query("SELECT * from pasien_mata pm join master_buta_warna mbw on mbw.id=pm.butawarna::integer where pm.id_kunjungan='$idKunjungan'");



?>

<table class="table table-bordered table-striped">
	<tr>
		<td rowspan="2">Buta warna</td>
		<td rowspan="2">Kacamata</td>
		<td colspan="3"><center>Visus Tanpa Kacamata</center></td>
		<td colspan="3"><center>Visus Dengan Kacamata</center></td>
		<td rowspan="2">Kelainan Mata Lain</td>
	</tr>
	<tr>
		<td>OD</td>
		<td>OS</td>
		<td>ODS</td>
		<td>OD</td>
		<td>OS</td>
		<td>ODS</td>
	</tr>
<?php
while($fetchPemeriksaanMata=pg_fetch_assoc($getDataPemeriksaanMata))
{
	?>
		<tr>
			<td><?php echo $fetchPemeriksaanMata['ket'] ?></td>
			<td><?php echo $fetchPemeriksaanMata['kacamata'] ?></td>
			<td><?php echo $fetchPemeriksaanMata['visus_a_1'] ?></td>
			<td><?php echo $fetchPemeriksaanMata['visus_a_2'] ?></td>
			<td><?php echo $fetchPemeriksaanMata['visus_a_3'] ?></td>
			<td><?php echo $fetchPemeriksaanMata['visus_b_1'] ?></td>
			<td><?php echo $fetchPemeriksaanMata['visus_b_2'] ?></td>
			<td><?php echo $fetchPemeriksaanMata['visus_b_3'] ?></td>
			<td><?php echo $fetchPemeriksaanMata['kelainan'] ?></td>
		</tr>
	<?php
	
}
?>

</table>
<hr />