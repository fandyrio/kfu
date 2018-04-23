<?php
session_start();
include_once('../../../config/conn.php');
include "../../../config/library.php";
include "../../../config/fungsi_tanggal.php";

$id_pasien=$_GET['id_pasien'];
$id_kunjungan=$_GET['id_kunjungan'];
?>   

   <div class="form-group data-lab2" id="data_diagnosa_kanan">
	<table class="table">
		<thead>
			<th>Nama</th>
			<th>Status</th>
			<th width="50px">#</th>
		</thead>
		<tbody>
			<?php
			$tampil=pg_query($dbconn,"SELECT * FROM pasien_diagnosa_detail_icpc WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_temp='Y'");
			
			while($r=pg_fetch_array($tampil)){
				if($r['status']==1)
				{
					$status="Primer";
				}
				else
				{
				$status="Sekunder";
				}
				if($r['id_diagnosa']!=NULL){
					$a=pg_fetch_array(pg_query($dbconn,"SELECT  nama FROM master_icpc WHERE id='$r[id_diagnosa]'"));
					
					?>
					<tr>
						<td><?php echo $a['nama'];?></td>
						<td ><?php echo $status;?></td>
						<td>
							<button class="btn btn-danger btn-xs btnHapusDiagnosaPilih" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
						</td>
					</tr>
				<?php		
				}
													
				}
				?>
				</tbody>
			</table>
		</div>