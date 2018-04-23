<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";


if(isset($_SESSION["id_pasien"])){
	
	$id_pasien=$_SESSION["id_pasien"];
	$id_kunjungan=$_SESSION["id_kunjungan"];
}
elseif($_GET["id_pasien"]){
	$id_pasien=$_GET["id_pasien"];
	$id_kunjungan=$_GET["id_kunjungan"];

}
?>
<table id="example2" class="table resep_loader ">
							<thead>
								<th>Nama</th>
								<th style="text-align: right;">Charges</th>
								<th></th>
							</thead>
								<tbody>
								<?php
								$tampil=pg_query($dbconn,"select i.* from pasien_resep i where i.id_pasien='".$id_pasien."' AND i.id_kunjungan='".$id_kunjungan."' AND i.status_proses='N' AND i.id_unit='$_SESSION[id_units]' ");
								
								while($r=pg_fetch_array($tampil)){
													?>
									<tr id="<?php echo $r['id'];?>">
										<td><?php echo $r['nama_brand'];?></td>
										<td style="text-align: right;"><?php echo $r['total_cost']; ?></td>	
										<td style="text-align: right;">
										<button class="btn btn-danger btn-xs btnHapusItemResep" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
										</td>						
									</tr>
										<?php
											}
										?>
								</tbody>
						</table>