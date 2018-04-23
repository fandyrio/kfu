<?php
session_start();
include_once('../../../config/conn.php');
include "../../../config/library.php";
include "../../../config/fungsi_tanggal.php";

	$id_pasien=$_POST[id_pasien];
	$id_kunjungan=$_POST[id_kunjungan];
	$id=$_POST[id];


?>

<input type="hidden" id="no_rm" value="<?php echo $_POST[no_rm] ?>">
<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-6 col-lg-6">
				<div id="data_jadwal">

			<div class="card">
				<div class="card-header">
					<div class="col-md-6 text-left">
						<strong>View Hasil Diagnosis </strong>
					</div>
				</div>
				<div class="card-block">
					<div class="row">
						<?php
						$id_pasien=$_POST['id_pasien'];
						$id_kunjungan=$_POST['id_kunjungan'];

						$qry="SELECT p.*, d.* FROM pasien_diagnosa_icpc p 
						LEFT OUTER JOIN  pasien_diagnosa_detail_icpc d ON d.id_pasien_diagnosa=p.id
						WHERE  p.status_hapus='N' AND d.id_pasien='".$id_pasien."' AND d.id_kunjungan='".$id_kunjungan."' AND p.id='".$_POST['id']."'
						ORDER BY d.status ASC";
						$tampil=pg_query($dbconn,$qry);
						//$row = pg_fetch_array($tampil);


		
						?>
							<table class="table" id="myTable">
								
								<tr>
									<td>Diagnosa</td><td>:</td>
									<td>
								<?php
								
									while($r=pg_fetch_array($tampil)){
										$a=pg_fetch_array(pg_query($dbconn,"SELECT kode, nama FROM master_icpc WHERE id='$r[id_diagnosa]'"));
										
								
											if($r['status']==1)
												{
													$status="Primer";
												}
												else
												{
													$status="Sekunder";
												}

											?>
											<li><?php echo $status."--".$a[nama];?></li>
									
								

								<?php }
							
								?>
								</td>
								</tr>
								<tr>
									<td>List</td><td>:</td>
									
									<td><?php echo "ICPC";?></td>
									
								</tr>
								
							</table>
					</div>
				</div>
				<div class="card-footer">
					<button type="button" class="btn btn-default btn-sm" id="btnbatalviewDiagnosa">Kembali</button>
						
				</div>
			</div>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
$(function () {
	
	$('#btnbatalviewDiagnosa').click(function()
	{
		var no_rm=$("#no_rm").val();
		$("#data_diagnosa").load("content/pasien/diagnosa_icpc/pasien_diagnosa.php?id="+no_rm);
		
	});
	
	
});
</script>