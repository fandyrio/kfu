<?php
include "../../config/conn.php";
include "../../config/function.php";

$nama=strtoupper($_POST['nama']);
$no_rm=strtoupper($_POST['no_rekam_medik']);
$no_hp=$_POST['no_handphone'];
$tgl_lahir=$_POST['tanggal_lahir'];
if($tgl_lahir!="")
{
	//$tgl_lahir=date('Y-m-d',strtotime($_POST['tanggal_lahir']));
	$tgl=date('d', strtotime($_POST['tanggal_lahir']));
	$tgl_lahir=DatetoDatabase($_POST['tanggal_lahir']);
}
else
{
	$tgl_lahir="";
}

if($nama=="")
{
	$getDataPasien=pg_query("SELECT * from master_pasien where no_rm='$no_rm' or no_handphone='$no_hp' or tanggal_lahir='$tgl_lahir'");
}
else
{
	$getDataPasien=pg_query("SELECT * from master_pasien where nama like '%$nama%' or no_rm='$no_rm' or no_handphone='$no_hp' or tanggal_lahir='$tgl_lahir'");
}
$jumlah=pg_num_rows($getDataPasien);
if($jumlah==0)
{
	echo "Data tidak ditemukan";
}
else
{

	?>
	<div class="col-sm-12 col-lg-12">
				<div class="card ">
					<div class="card-header bg-secondaryd">
						<i class="icon-layers"></i> Hasil Pencarian
					</div>
					<div class="card-block">
						<table class="table  table-striped" id="myTable">
							<thead>
								<tr class="text-center">
									<th width="50px">No.</th>
									<th>No. Rekam Medis</th>
									<th>No. HP</th>
									<th>Nama</th>
									<th>Tanggal Lahir</th>
									<th>ID Lainnya</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no=1;
									while($r=pg_fetch_array($getDataPasien)){
										$tanggal_lahir=date('d-m-Y', strtotime($r['tanggal_lahir']));
										echo"
										<tr>
											<td>$no</td>
											<td>$r[no_rm]</td>
											<td>$r[no_handphone]</td>
											<td>$r[nama]</td>
											<td>$tanggal_lahir</td>
											<td>$r[id_lainnya]</td>
											<td>";
												if($r['status_kunjungan']!='Y'){
													echo"<a href='antrian?no_rm=$r[no_rm]'><button type='button' class='btn btn-xs btn-success'><i class='icon-login'></i></button></a>";
												}
											echo"</td>
										</tr>
										";
										$no++;
									}
								
								
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
	<?php
}
?>