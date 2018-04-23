<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";


$t=pg_query($dbconn,"SELECT qty, no_batch from pasien_resep_batch  where id_pasien_resep='".$_GET['id']."' ");

?>

<div class="col-md-12" style="overflow-y:scroll;">
						<table class="table">
							<thead>
								<th>No Batch</th>
								<th style="text-align: right;">Qty</th>
								<th></th>
							</thead>
								<tbody>
								<?php
								
								while($r=pg_fetch_array($t)){
													?>
										<tr>
										<td><?php echo $r['no_batch'];?></td>
										<td style="text-align: right;"><?php echo $r['qty'];?></td>	
										
									</tr>
										<?php
											}
										?>
								</tbody>
						</table>
					</div>