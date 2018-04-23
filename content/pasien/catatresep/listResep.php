<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include "../../../config/conn.php";
$no_RM=$_REQUEST['id'];

$getDataPasien=pg_query("SELECT * from master_pasien where no_rm='$no_RM'");
$fetchDataPasien=pg_fetch_assoc($getDataPasien);
$idPasien=$fetchDataPasien['id'];


?>
<div class="card">
	<div class="card-header">
		<strong>Daftar Resep</strong>
		<button class="btn btn-xs btn-primary" id="addResep" style="float:right;">Tambah</button>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<thead>
						<tr>
							<th>No Resep</th>
							<th>Dokter Pembuat Resep</th>
							<th></th>
							<th colspan="2" width="30px"><center>Action</center></th>

						</tr>
					</thead>
					<tbody>
						<?php
							$getDataResep=pg_query("SELECT * from pasien_no_resep pnr 
								join kunjungan k on k.id=pnr.id_kunjungan 
								join antrian a on a.id_kunjungan=k.id 
								join master_karyawan mk on mk.id=a.id_dokter::integer
								where pnr.id_pasien='$idPasien'");
							while($fetchDataResep=pg_fetch_assoc($getDataResep))
							{
								if($fetchDataResep['cito']=='Y')
								{
									$status="<button class='btn btn-xs btn-danger'>C I T O !</button>";
								}
								else
								{
									$status="";
								}
								echo"
								<tr>
									<td>$fetchDataResep[no_resep]</td>
									<td>$fetchDataResep[nama]</td>
									<td>$status</td>
									<td width='15px'><button class='btn btn-xs btn-primary detail' id='$fetchDataResep[id_kunjungan]'>Detail</button></td>
									<td width='15px'><button class='btn btn-xs btn-danger delete' id='$fetchDataResep[id_kunjungan]'>Hapus</button></td>
								</tr>
								";
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function()
{
	$("#addResep").click(function()
	{
		$("#data_pasien").load("content/pasien/catatresep/catatResep.php?id=<?php echo $_REQUEST['id'] ?>");
	});

	$(".detail").click(function()
	{
		var id=this.id;
		$.ajax(
		{
			url:'content/pasien/catatresep/detailResep.php',
			type:'POST',
			data:{id_kunjungan:id, idPasien:<?php echo $idPasien ?>, status:"front"},
			success:function(result)
			{
				$("#data_pasien").html(result);
			}
		});
	});

	$(".delete").click(function()
	{
		var id=this.id;
		$.ajax(
		{
			url:'content/pasien/catatresep/deleteResep.php',
			type:'POST',
			data:{id_kunjungan:id},
			success:function(result)
			{
				$("#data_pasien").load("content/pasien/catatresep/listResep.php?id=<?php echo $no_RM ?>");
			}
		});
	});

});

</script>