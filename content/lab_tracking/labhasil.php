<?php
switch($_GET['act']){
	
default:
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Lab Hasil</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i>Data Hasil Lab
						</div>
						<div class="card-block">
							<form method="post" class="form-horizontal">
								<div class="form-group row">
									<label class="col-sm-1 form-control-label" >Dari Tanggal</label>
									<div class="col-sm-2">										
										<input name='tgl_awal' class='form-control datedatabase' value="<?php echo date('Y-m-d'); ?>" required>		
									</div>									
									<label class="col-sm-2 form-control-label" >Sampai Tanggal</label>
									<div class="col-sm-2">
										<input name='tgl_akhir' class='form-control datedatabase' required value="<?php echo date('Y-m-d'); ?>">
									</div>
									<button type="submit" class="btn btn-primary btn-xs" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
								</div>
							</form>
						
							<div class="row">
								<div class="col-md-12">
									<table class="table" id="myTable">
										<thead>
											<tr>
												<th width="60px">Tanggal</th>
												<th width="150px">Lab</th>
												<th>Pasien</th>
												<th>Status</th>
												<th width="100px">#</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if($_POST['cari']){
												$tgl_awal=$_POST["tgl_awal"];
												$tgl_akhir=$_POST["tgl_akhir"];
												$tampil=pg_query($dbconn,"SELECT * FROM lab_order  where id_unit='$_SESSION[id_units]' AND status='3' ORDER BY id DESC");
											}
											else{
												$tampil=pg_query($dbconn,"SELECT * FROM  lab_order  where status='3'  ORDER BY id DESC");
											}
										
												while($r=pg_fetch_array($tampil)){
													$a=explode(" ",$r['waktu_input']);
													$tanggal_input=DateToIndo2($a[0]);
													$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_unit_lab WHERE id='$r[id_unit_lab]'"));
													$nama_lab=$a['nama'];


													$a=pg_fetch_array(pg_query($dbconn,"SELECT distinct id_pasien FROM pasien_hasillab_detail WHERE id_hasillab='$r[id]'"));
													$id_pasien=$a['id_pasien'];
													

													$b=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_pasien WHERE id='$id_pasien'"));
													$nama_pasien=$b['nama'];

													$b=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM hasillab_status WHERE id='$r[id_status_hasillab]'"));
													$nama_status=$b['nama'];
													//var_dump($b);
													
													
													
													if($r['status_jawab']=='N'){
														$status="<button class='btn btn-xs btn-warning'>-</button>";
													}
													else{
														$status="<button class='btn btn-xs btn-success'><i class='icon-check'></i></button>";
													}
													?>
													<tr>
														<td><?php echo $tanggal_input;?></td>
														<td><?php echo $nama_lab;?></td>
														<td><?php echo $nama_pasien;?></td>
														<td><?php echo $nama_status;?></td>
														<td>
															
															<a href="view-lab-hasil-<?php echo "$r[id]";?>" class="btn btn-primary btn-xs" title="View Hasil" data-toggle="tooltip" data-placement="top" title="View"><i class="icon-eye"></i></a>
															<a href="hapus-track-lab-hasil-<?php echo "$r[id]";?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>
														</td>
													</tr>
													<?php
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
break;



case "hapus":
	$p=pg_query($dbconn,"Update pasien_hasillab set status_hapus='Y' WHERE id='$_GET[id]'");

?>
<script>
			document.location.href = "lab-hasil";
				
			</script>


<?php

break;
case "view":
 $v=pg_fetch_array(pg_query($dbconn,"Select id_invoice from transaksi_invoice_detail WHERE id='$_GET[id]'"));
 
?>

<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"<a href="lab-hasil">Hasil Lab</a></li>
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
						<strong>View Hasil Lab </strong>
					</div>
				</div>
				<div class="card-block">
					<div class="row">
						<?php
						
						$a=pg_query($dbconn,"SELECT id,  id_lab_group, id_pasien, id_kunjungan FROM transaksi_invoice_detail WHERE id_invoice='$v[id_invoice]'"); 
						//var_dump($a);
						?>
							<table class="table" id="myTable">
								<tr>

									<td width="150px">Dari</td>
									<td width="10px">:</td>
									<?php $ul=pg_fetch_array(pg_query($dbconn,"Select * from master_unit_lab WHERE id='".$v["id_unit"]."'")); ?>
									<td><?php echo $ul["nama"];?></td>
								</tr>
								
								<tr>
									<td>Spesimen</td><td>:</td>
									<?php
									 $lab_analysis=pg_fetch_array(pg_query($dbconn,"Select id_lab_specimen from lab_analysis WHERE id='".$a["id_detail"]."'")); 

									 $spesimen=pg_fetch_array(pg_query($dbconn,"Select nama from lab_specimen WHERE id='".$lab_analysis["id_lab_specimen"]."'")); ?>
									<td><?php echo $spesimen["nama"];?></td>
									
								</tr>
								
								<tr>
									<td>Analisa</td><td>:</td>
									<td>
										<?php 
										$no=1;
										while($invoice=pg_fetch_array($a)){
										$q=pg_query("select * from pasien_hasillab_detail where id_transaksi_invoice_detail=$invoice[id]");
										$pld=pg_fetch_assoc($q);
									
										
										$qp=pg_query("select distinct id_lab_group from pasien_hasillab_detail where id_transaksi_invoice_detail=$invoice[id]");	
										

										
											
										while($q1=pg_fetch_array($qp)){
											
											$la=pg_query("select * from lab_analysis_group_detail where  id_lab_analysis_group='".$q1["id_lab_group"]."'");
											$group=pg_fetch_array(pg_query($dbconn,"SELECT id, nama FROM lab_analysis_group WHERE id='$q1[id_lab_group]'"));
											//var_dump($group);

											?>
										<tr>
											
											<td colspan="4" align="center"><b><?php echo $group['nama'];?></b></td>
										</tr>
										<?php

											while($lag=pg_fetch_assoc($la)){

												$lagd=pg_fetch_array(pg_query("select * from lab_analysis where id='".$lag["id_lab_analysis"]."'"));

												?>
							
											<tr>
												<td width="20px"><?php echo $no++;?></td>
												<td colspan="2"><?php echo $lagd['nama'];?></td>
											</tr>
											<?php


											}
										}
										
										$q=pg_query("select * from pasien_hasillab_detail where id_transaksi_invoice_detail=$invoice[id]");
								
									while($pld=pg_fetch_assoc ($q)){
										 if($pld['id_lab_group']==NULL){
										 	$lagd=pg_fetch_array(pg_query("select * from lab_analysis where id='".$pld['id_detail']."'"));
												

												?>
							
											<tr>
												<td width="20px"><?php echo $no++;?></td>
												<td colspan="2"><?php echo $lagd['nama'];?></td>
											</tr>
											<?php
											
											
										}
									}
									}
									

										
										?>
										
									</td>
								</tr>
								
							</table>
					</div>
				</div>
				<div class="card-footer">
					<button type="button" class="btn btn-default btn-sm" id="btnbatalviewLab">Kembali</button>
						<a href="content/lab_tracking/print_hasil_lab.php?id=<?php echo "$_GET[id]";?>" target="_blank" class="btn btn-danger btn-sm pull-right"  data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i> Print</a>
				</div>
			</div>
</div>
</div>
</div>
</div>
</div>






<?php
break;

}
?>



	<script>
		$('#btnbatalviewLab').click(function()
		{
			document.location.href = "lab-hasil";

		});
		</script>
		<script type="text/javascript">
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
		});
		
		$(document).ready(function(){
			$(".datedatabase").mask("9999/99/99",{placeholder:"yyyy-mm-dd"});
			
			 $('.js-example-basic-single').select2();
		});
		
	</script>