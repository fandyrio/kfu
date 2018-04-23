<?php
include "../config/conn.php";
$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $setting['title'];?></title>
		<link rel="shortcut icon" href="../images/<?php echo $setting['logo'];?>">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="assets/gijgo.css" rel="stylesheet" type="text/css" />
		
		<link rel="stylesheet" href="assets/style.css">
		<link rel="stylesheet" href="assets/bootstrap.min.css">
		
	</head>
<body>
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-12">
				<h2 class="title2">
					Dashboard Sistem Informasi Laboratorium Klinik PT. Kimia Farma Diagnostika
					<span class="pull-right">
						<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
							Filter
						</a>
					</span>
				</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<fieldset>
					<legend>Jumlah Kunjungan</legend>
					<div class="row">
						<div class="col-6 col-md-3">
							<div class="card card-inverse card-primary mb-3 text-center card-120">
								<div class="card-block">
									<h4 class="font-30">20</h4>
									<blockquote class="card-blockquote">
										Atas Permintaan Sendiri
									</blockquote>
								</div>
							</div>
						</div>
						
						<div class="col-6 col-md-3">
							<div class="card card-inverse card-success mb-3 text-center card-120">
								<div class="card-block">
									<h4 class="font-30">20</h4>
									<blockquote class="card-blockquote">
										Atas Permintaan Dokter
									</blockquote>
								</div>
							</div>
						</div>
						
						<div class="col-6 col-md-3">
							<div class="card card-inverse card-warning mb-3 text-center card-120">
								<div class="card-block">
									<h4 class="font-30">20</h4>
									<blockquote class="card-blockquote">
										Rutin Rujukan
									</blockquote>
								</div>
							</div>
						</div>
						
						<div class="col-6 col-md-3">
							<div class="card card-inverse card-info mb-3 text-center card-120">
								<div class="card-block">
									<h4 class="font-30">20</h4>
									<blockquote class="card-blockquote">
										Medical Check-up
									</blockquote>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</div>
			
			<div class="col-md-6">
				<fieldset>
					<legend>Rata-rata Nilai Transaksi per Pengunjung</legend>
					<div class="row">
						<div class="col-6 col-md-3">
							<div class="card card-inverse card-primary mb-3 text-center card-120">
								<div class="card-block">
									<h4 class="font-30">20</h4>
									<blockquote class="card-blockquote">
										Atas Permintaan Sendiri
									</blockquote>
								</div>
							</div>
						</div>
						
						<div class="col-6 col-md-3">
							<div class="card card-inverse card-success mb-3 text-center card-120">
								<div class="card-block">
									<h4 class="font-30">20</h4>
									<blockquote class="card-blockquote">
										Atas Permintaan Dokter
									</blockquote>
								</div>
							</div>
						</div>
						
						<div class="col-6 col-md-3">
							<div class="card card-inverse card-warning mb-3 text-center card-120">
								<div class="card-block">
									<h4 class="font-30">20</h4>
									<blockquote class="card-blockquote">
										Rutin Rujukan
									</blockquote>
								</div>
							</div>
						</div>
						
						<div class="col-6 col-md-3">
							<div class="card card-inverse card-info mb-3 text-center card-120">
								<div class="card-block">
									<h4 class="font-30">20</h4>
									<blockquote class="card-blockquote">
										Medical Check-up
									</blockquote>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-3">
				<div class="card card-primary mb-3 card-khusus">
					<div class="card-block">
						<strong>10 Pemeriksaan Tertinggi - Atas Permintaan Sendiri</strong><br><br>
						<table class="table table-sm">
							<thead>
								<tr>
									<th>No.</th>
									<th>Pemeriksaan</th>
									<th>Kat</th>
									<th>Jlh</th>
								</tr>
							</thead>
							<tbody>
								<?php
								for($no=1;$no<=10;$no++){
								?>
								<tr>
									<th><?php echo $no;?></th>
									<th>Test1</th>
									<th>Single</th>
									<th>10</th>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="card card-success mb-3 card-khusus">
					<div class="card-block">
						<strong>10 Pemeriksaan Tertinggi - Atas Permintaan Dokter</strong><br><br>
						<table class="table table-sm">
							<thead>
								<tr>
									<th>No.</th>
									<th>Pemeriksaan</th>
									<th>Kat</th>
									<th>Jlh</th>
								</tr>
							</thead>
							<tbody>
								<?php
								for($no=1;$no<=10;$no++){
								?>
								<tr>
									<th><?php echo $no;?></th>
									<th>Test1</th>
									<th>Single</th>
									<th>10</th>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="card card-warning mb-3 card-khusus">
					<div class="card-block">
						<strong>10 Pemeriksaan Tertinggi - Rutin Rujukan</strong><br><br>
						<table class="table table-sm">
							<thead>
								<tr>
									<th>No.</th>
									<th>Pemeriksaan</th>
									<th>Kat</th>
									<th>Jlh</th>
								</tr>
							</thead>
							<tbody>
								<?php
								for($no=1;$no<=10;$no++){
								?>
								<tr>
									<th><?php echo $no;?></th>
									<th>Test1</th>
									<th>Single</th>
									<th>10</th>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="card card-info mb-3 card-khusus">
					<div class="card-block">
						<strong>10 Pemeriksaan Tertinggi - Medical Check-up</strong><br><br>
						<table class="table table-sm">
							<thead>
								<tr>
									<th>No.</th>
									<th>Pemeriksaan</th>
									<th>Kat</th>
									<th>Jlh</th>
								</tr>
							</thead>
							<tbody>
								<?php
								for($no=1;$no<=10;$no++){
								?>
								<tr>
									<th><?php echo $no;?></th>
									<th>Test1</th>
									<th>Single</th>
									<th>10</th>
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
		
		<div class="row">
			<div class="col-md-6">
				<fieldset>
					<legend>Jumlah Pasien</legend>
					<div class="card">
						<div class="card-block">
							<canvas id="canvas-1"></canvas>
						</div>
					</div>
				</fieldset>
			</div>
			
			<div class="col-md-6">
				<fieldset>
					<legend>Jumlah Pegawai</legend>
					<div class="card">
						<div class="card-block">
							<canvas id="canvas-2"></canvas>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<fieldset>
					<legend>Jumlah Transaksi</legend>
					<div class="row">
						<div class="col-6 col-md-3">
							<div class="card card-inverse card-primary mb-3 text-center card-120">
								<div class="card-block">
									<h4 class="font-30">20</h4>
									<blockquote class="card-blockquote">
										Atas Permintaan Sendiri
									</blockquote>
								</div>
							</div>
						</div>
						
						<div class="col-6 col-md-3">
							<div class="card card-inverse card-success mb-3 text-center card-120">
								<div class="card-block">
									<h4 class="font-30">20</h4>
									<blockquote class="card-blockquote">
										Atas Permintaan Dokter
									</blockquote>
								</div>
							</div>
						</div>
						
						<div class="col-6 col-md-3">
							<div class="card card-inverse card-warning mb-3 text-center card-120">
								<div class="card-block">
									<h4 class="font-30">20</h4>
									<blockquote class="card-blockquote">
										Rutin Rujukan
									</blockquote>
								</div>
							</div>
						</div>
						
						<div class="col-6 col-md-3">
							<div class="card card-inverse card-info mb-3 text-center card-120">
								<div class="card-block">
									<h4 class="font-30">20</h4>
									<blockquote class="card-blockquote">
										Medical Check-up
									</blockquote>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
		
	</div>
	
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Range Tanggal</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input id="datepicker" class="form-control datepicker"/>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<?php
	//GRAFIK 1
	$pasien_pria="";
	$pasien_wanita="";
	$pegawai="";
	$data_unit="";
	$tampil=pg_query($dbconn,"SELECT id, nama FROM master_unit ORDER BY id");
	while($r=pg_fetch_array($tampil)){
		$data_unit.="'$r[nama]',";
		$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM master_pasien WHERE id_unit='$r[id]' AND jenkel='1'"));
		$pasien_pria.="$c[tot],";
		
		$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM master_pasien WHERE id_unit='$r[id]' AND jenkel='2'"));
		$pasien_wanita.="$c[tot],";
		
		$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(b.id) AS tot FROM master_karyawan a, master_karyawan_unit b  WHERE a.id=b.id_karyawan AND b.id_unit='$r[id]'"));
		$pegawai.="$c[tot],";
	}
	?>
	<script src="assets/jquery.min.js"></script>
	<script src="assets/gijgo.js" type="text/javascript"></script>
	<script src="assets/popper.min.js"></script>
	<script src="assets/bootstrap.min.js"></script>
	<script src="assets/Chart.min.js"></script>
	<script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
			format: 'dd/mm/yyyy'
        });
    </script>
	
	<script type="text/javascript">
		$(function (){
			'use strict';
			var barChartData = {
				labels : [<?php echo $data_unit;?>],
				datasets : [
					{
						label: 'Pria',
						backgroundColor : 'rgba(0,0,255,0.7)',
						borderColor : 'rgba(0,0,255,0.75)',
						highlightFill: 'rgba(0,0,255,0.75)',
						highlightStroke: 'rgba(0,0,255,0.9)',
						data : [<?php echo $pasien_pria;?>]
					},
					{
						label: 'Wanita',
						backgroundColor : 'rgba(255,0,255,0.5)',
						borderColor : 'rgba(255,0,255,0.8)',
						highlightFill : 'rgba(255,0,255,0.75)',
						highlightStroke : 'rgba(255,0,255,1)',
						data : [<?php echo $pasien_wanita;?>]
					}
				]
			}
		  
			var ctx = document.getElementById('canvas-1');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true
				}
			});
			
			var barChartData = {
				labels : [<?php echo $data_unit;?>],
				datasets : [
					{
						label: 'Pegawai',
						backgroundColor : 'rgba(0,255,0,0.7)',
						borderColor : 'rgba(0,255,0,0.75)',
						highlightFill: 'rgba(0,255,0,0.75)',
						highlightStroke: 'rgba(0,255,0,0.9)',
						data : [<?php echo $pegawai;?>]
					}
				]
			}
		  
			var ctx = document.getElementById('canvas-2');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true
				}
			});
		});
	</script>
</body>
</html>
