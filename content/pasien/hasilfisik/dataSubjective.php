<?php
include "../../../config/conn.php";
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
$no_rm=$_GET['no_rm'];
$id_pasien=$_GET['id_pasien'];
$id_kunjungan=$_GET['id_kunjungan'];

$getKeluhan=pg_query($dbconn, "SELECT pk.*, b.nama_body as nama_body, lb.nama_lokasi as nama_lokasi, ms.nama_sympton as nama_sympton 
					from pasien_keluhan pk 
					join pasien_keluhan_detail pkd on pkd.id_pasien_keluhan=pk.id
					join master_sympton_indo ms on ms.id=pkd.id_symptom
					join master_unit mu on mu.id=pk.id_unit
					join master_body b on b.id=pk.id_body
					join master_lokasi_body lb on lb.id=pk.id_lokasi
					where pk.id_pasien='$id_pasien' and id_kunjungan='$id_kunjungan'
					");

$jlh=pg_query($dbconn, "SELECT count(*) as jumlah from pasien_keluhan where id_pasien='$id_pasien'");
$jlhRow=pg_fetch_assoc($jlh);
?>

<p><button class="btn btn-sm btn-primary">Anamnesa Pasien</button></p> <!-- Judul -->
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
				<th>Bagian Tubuh</th>
				<th>Lokasi</th>
				<th>Sympton</th>
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
						<td>$data[tanggal]</td>
						<td>$data[nama_body]</td>
						<td>$data[nama_lokasi]</td>
						<td>$data[nama_sympton]</td>
						<td>$data[catatan]</td>
					</tr>
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
<p><button class="btn btn-sm btn-primary">Perhatian Pasien</button></p> <!-- Judul -->
<?php
$queryJumlahPerhatian=pg_query("SELECT count(*) as jumlah from pasien_perhatian where id_pasien='$id_pasien'");
$getJumlah=pg_fetch_assoc($queryJumlahPerhatian);
$jumlahPerhatian=$getJumlah['jumlah'];

if($jumlahPerhatian==0)
{
	echo"<div class='' style='height:30px;'><i class='icon-warning-sign'></i>Data tidak ada</div>";
}
else
{


?>

<table class="table">
	<thead>
		<tr>
			<th width="90px">Tanggal</th>
			<th width="150px">Kunjungan</th>
			<th width="100px">Kategori</th>
			<th width="120px">Teks</th>
			<!--<th width="80px">ATC Code</th>-->
			<th>Catatan</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$dataPerhatian=pg_query("SELECT * from pasien_perhatian pp 
								 join master_perhatian_kategori pk on pk.id=pp.id_kategori_perhatian
								 where pp.id_pasien='$id_pasien'
							   ");
		while($getDataPerhatian=pg_fetch_assoc($dataPerhatian))
		{
			echo"
				<tr>
					<td>".date('d-m-Y', strtotime($getDataPerhatian['waktu_input']))."</td>
					<td></td>
					<td>$getDataPerhatian[nama]</td>
					<td>$getDataPerhatian[judul]</td>
					<td>$getDataPerhatian[catatan]</td>
			";
		}
		?>
	</tbody>
</table>
<?php
}
?>

