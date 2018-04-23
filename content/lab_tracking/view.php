

<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"<a href="lab-hasil">Lab Tracking</a></li>
	<li class="breadcrumb-item active">Detail</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-6 col-lg-6">
				<div id="data_jadwal">

			<div class="card">
				<div class="card-header">
					<div class="col-md-6 text-left">
						<strong>View Lab Tracking </strong>
					</div>
				</div>
				<div class="card-block">
					<div class="row">
						<?php
						
						$a=pg_fetch_array(pg_query($dbconn,"SELECT id_detail, jenis, id_lab_group, id_pasien FROM lab_order WHERE id='$_GET[id]'")); 

						//var_dump("SELECT id_detail, jenis, id_lab_group, id_pasien FROM lab_order WHERE id='$_GET[id]'");
						?>
							<table class="table" id="myTable">
								
								
								<tr>
									<td>Spesimen</td><td>:</td>
									<?php
									 $lab_analysis=pg_fetch_array(pg_query($dbconn,"Select id_lab_specimen from lab_analysis WHERE id='".$a["id_detail"]."'")); 

									 $spesimen=pg_fetch_array(pg_query($dbconn,"Select nama from lab_specimen WHERE id='".$lab_analysis["id_lab_specimen"]."'")); ?>
									<td><?php echo $spesimen["nama"];?></td>
									
								</tr>
								
								<tr>
									<td>Pemeriksaan</td><td>:</td>
									
										<?php 
										if($a['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$a[id_detail]'"));
											
											echo '<td>';
												echo "Single Test ".$a[nama];
											echo '</td>';	
											
										}
										elseif($a['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$a[id_detail]'"));
											echo '<td>';
												echo $jenis="Multiple Test";
											echo '</td>';
											echo '<td>';
												echo "Multiple Test ".$a[nama];
											echo '</td>';
										}
										elseif($a['jenis']=='N'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$a[id_detail]'"));
											echo '<td>';
												echo "Non Laboratorium ". $a[nama];
											echo '</td>';
										}
										?>
								</tr>
								
							</table>
					</div>
				</div>
				<div class="card-footer">
					<button type="button" class="btn btn-default btn-sm" id="btnbatalviewLab">Kembali</button>
						<!-- <a href="content/lab_tracking/print_hasil_lab.php?id=<?php echo "$_GET[id]";?>" target="_blank" class="btn btn-danger btn-sm pull-right"  data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i> Print</a> -->
				</div>
			</div>
</div>
</div>
</div>
</div>
</div>
