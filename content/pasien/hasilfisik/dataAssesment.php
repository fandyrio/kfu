<?php
include "../../../config/conn.php";
$no_rm=$_GET['no_rm'];
$id_pasien=$_GET['id_pasien'];
$idKunjungan=$_GET['id_kunjungan'];


$getKeluhan=pg_query($dbconn, "SELECT * from pasien_diagnosa pd join pasien_diagnosa_detail pdd on pdd.id_pasien_diagnosa=pd.id
		join master_icd10 icd on icd.id=pdd.id_diagnosa
					where pd.id_pasien='$id_pasien' and pd.id_kunjungan='$idKunjungan'
					");

$jlh=pg_query($dbconn, "SELECT count(*) as jumlah from pasien_diagnosa where id_pasien='$id_pasien' and id_kunjungan='$idKunjungan'");
$jlhRow=pg_fetch_assoc($jlh);
?>

<p><button class="btn btn-sm btn-primary">Diagnosa</button></p> <!-- Judul -->
<?php
if($jlhRow['jumlah']==0)
{
	echo"<div class='' style='height:30px;'><i class='icon-warning-sign'></i>Data tidak ada</div>";
}
else
{
?>
	<table id="example1" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No.</th>
				<th>Tanggal</th>
				<th>Diagnosa</th>
				<th>Catatan</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no=1;
			while($data=pg_fetch_assoc($getKeluhan))
			{
				echo"
					<tr>
						<td>$no</td>
						<td>$data[tgl_diagnosa]</td>
						<td>$data[nama]</td>
						<td>$data[catatan]</td>
				";
				$no++;
			}
			?>
		</tbody>

	</table>
<?php
}
?>

<hr />

<?php
//Peringatan Pasien

?>
<p><button class="btn btn-sm btn-primary">Tindakan Medis</button></p> <!-- Judul -->
<?php
$queryJumlahPerhatian=pg_query("SELECT * from transaksi_invoice_detail tid join tindakan t on t.id=tid.id_detail where id_kunjungan='$idKunjungan'");
$getJumlah=pg_num_rows($queryJumlahPerhatian);

if($getJumlah==0)
{
	echo"<div class='' style='height:30px;'><i class='icon-warning-sign'></i>Data tidak ada</div>";
}
else
{


?>

<table class="table">
	<tbody>
	<?php
		$dataPerhatian=pg_query("SELECT * from transaksi_invoice_detail tid join tindakan t on t.id=tid.id_detail where id_kunjungan='$idKunjungan'
							   ");
		while($getDataPerhatian=pg_fetch_assoc($dataPerhatian))
		{
			echo"
				<tr>
					<td>$getDataPerhatian[nama]</td>


			";
		}
		?>
	</tbody>
</table>
<?php
}
?>

