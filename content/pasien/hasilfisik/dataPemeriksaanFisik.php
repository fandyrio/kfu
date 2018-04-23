<?php
include "../../../config/conn.php";

$getDataPemeriksaanFisik=pg_query("SELECT * from pasien_fisik pf 
	JOIN pasien_fisik_detail pfd on pf.id=pfd.id_pasien_fisik
	JOIN fisik f on f.id=pfd.id_fisik
	where pf.id_kunjungan='$idKunjungan'");



?>

<table class="table table-bordered table-striped">
<?php
while($fetchPemeriksaanFisik=pg_fetch_assoc($getDataPemeriksaanFisik))
{
	?>
		<tr>
			<td><?php echo $fetchPemeriksaanFisik['nama'] ?></td>
			<td><?php echo $fetchPemeriksaanFisik['nilai'] .' '. $fetchPemeriksaanFisik['satuan'] ?></td>
		</tr>
	<?php
	
}
?>

</table>
<hr />