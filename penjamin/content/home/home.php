<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item active">Dashboard</li>
	<li class="breadcrumb-menu d-md-down-none">
		<div class="btn-group" role="group" aria-label="Button group">
			<button type="button" class="btn" id="btnTampilkan">Filter</button>
		</div>
	</li>
</ol>

<?php
if(isset($_GET['tanggal_awal'])){
	$tanggal_awal=$_GET['tanggal_awal'];
	$tanggal_akhir=$_GET['tanggal_akhir'];
}
else{
	$tanggal_awal=date('d-m-Y', strtotime('-7 days'));
	$tanggal_akhir=date('d-m-Y');
}

$tanggal_awal2=DateToEng($tanggal_awal);
$tanggal_akhir2=DateToEng($tanggal_akhir);

//GRAFIK 1
$no=7;
$kunjungan_label="";
$kunjungan_pria="";
$kunjungan_wanita="";
$total_kunjungan_pria=0;
$total_kunjungan_wanita=0;
while($no>=0){
	$tanggal = date("Y-m-d", strtotime("-$no days", strtotime($tgl_sekarang)));
	$sqlKunjungP = "SELECT COUNT(a.id) AS tot FROM kunjungan a, master_pasien b WHERE CAST(a.id_pasien AS bigint)=b.id AND b.jenkel='1' AND a.waktu_input BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59' AND a.id_kategori_harga='$_SESSION[login_user]'";
	$c1=pg_fetch_array(pg_query($dbconn, $sqlKunjungP));
	$kunjungan_pria.="$c1[tot],";
	$total_kunjungan_pria+=$c1['tot'];
	
	$sqlKunjungW = "SELECT COUNT(a.id) AS tot FROM kunjungan a, master_pasien b WHERE CAST(a.id_pasien AS bigint)=b.id AND b.jenkel='2' AND a.waktu_input BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59' AND a.id_kategori_harga='$_SESSION[login_user]' ";
	$c2=pg_fetch_array(pg_query($dbconn,$sqlKunjungW));
	$kunjungan_wanita.="$c2[tot],";
	$total_kunjungan_wanita+=$c2['tot'];
	
	$tanggal = DateToIndo2($tanggal);
	$kunjungan_label.="'$tanggal',";
	$no--;
	
}

//GRAFIK 2
$JumlahP = "SELECT COUNT(id) AS tot FROM master_pasien WHERE jenkel='1' AND id_perusahaan='$_SESSION[login_user]'";
$cp=pg_fetch_array(pg_query($dbconn,$JumlahP));
$jumlah_pria=$cp['tot'];

$JumlahW = "SELECT COUNT(id) AS tot FROM master_pasien WHERE jenkel='2' AND id_perusahaan='$_SESSION[login_user]'";
$cw=pg_fetch_array(pg_query($dbconn,$JumlahW));
$jumlah_wanita=$cw['tot'];


?>
<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-6 col-lg-3">
				<div class="card text-white bg-primary">
					<div class="card-body pb-0">
						<div class="row">
							<div class="col-xs-4 text-center pv-lg">
								<em class="icon-user fa-3x"></em>
							</div>
							<div class="col-xs-8 pv-lg">
								<h2 class="mb-0">
									<?php 
										$sqlKunjungK = "SELECT COUNT(a.id) AS tot FROM kunjungan a INNER JOIN master_pasien b on b.id=a.id_pasien WHERE  a.waktu_input BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' AND a.id_kategori_harga='$_SESSION[login_user]'";

										$c=pg_fetch_array(pg_query($dbconn, $sqlKunjungK));
										
									echo $c['tot'];
									?>
								</h2>
								<p>Jumlah Kunjungan</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-sm-6 col-lg-3">
				<div class="card text-white bg-success">
					<div class="card-body pb-0">
						<div class="row">
							<div class="col-xs-4 text-center pv-lg">
								<em class="icon-user-following fa-3x"></em>
							</div>
							<div class="col-xs-8 pv-lg">
								<h2 class="mb-0">
								<?php 
									$apd = "SELECT COUNT(k.id) AS tot FROM pasien_keluhan k 
											INNER JOIN kunjungan a on a.id_pasien=k.id_pasien and a.id=k.id_kunjungan  
											INNER JOIN master_pasien b on b.id=k.id_pasien WHERE a.id_kategori_harga='2' and k.merokok = 'Y' AND a.waktu_input BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' ";
									$c=pg_fetch_array(pg_query($dbconn,$apd));
									echo $c['tot'];
									?>
								</h2>
								<p>Pasien Merokok</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-sm-6 col-lg-3">
				<div class="card text-white bg-warning">
					<div class="card-body pb-0">
						<div class="row">
							<div class="col-xs-4 text-center pv-lg">
								<em class="icon-refresh fa-3x"></em>
							</div>
							<div class="col-xs-8 pv-lg">
								<h2 class="mb-0">
								<?php 
									$apd = "SELECT COUNT(k.id) AS tot FROM pasien_keluhan k 
											INNER JOIN kunjungan a on a.id_pasien=k.id_pasien and a.id=k.id_kunjungan  
											INNER JOIN master_pasien b on b.id=k.id_pasien WHERE a.id_kategori_harga='2' and k.merokok = 'N' AND a.waktu_input BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' ";
									$c=pg_fetch_array(pg_query($dbconn,$apd));
									echo $c['tot'];
									?>
								</h2>
								<p>Pasien Tidak Merokok</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-sm-6 col-lg-3">
				<div class="card text-white bg-info">
					<div class="card-body pb-0">
						<div class="row">
							<div class="col-xs-4 text-center pv-lg">
								<em class="icon-doc fa-3x"></em>
							</div>
							<div class="col-xs-8 pv-lg">
								<h2 class="mb-0">
								<?php 
								$mcu = "SELECT COUNT(id) AS tot FROM antrian WHERE id_segmen='4' AND waktu_masuk BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' ";

								if($_SESSION[id_units]=='1'){
									$mcu .= "AND id_unit <> '$_SESSION[id_units]'";
									}
								if($_SESSION[id_units]!='1'){
									$mcu .= "AND id_unit='$_SESSION[id_units]'";
								}

								$c=pg_fetch_array(pg_query($dbconn,$mcu));
									echo $c['tot'];
								?>
								</h2>
								<p>Medical Check-up</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						Jumlah Kunjungan Pasien
					</div>
					<div class="card-body">
						<canvas id="canvas-1"></canvas>
						<h4>
							Jumlah Kunjungan Pria : <?php echo $total_kunjungan_pria;?>,
							Jumlah Kunjungan Wanita : <?php echo $total_kunjungan_wanita;?>
						</h4>
					</div>
				</div>
			</div>
			
			
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						Total Pasien
					</div>
					<div class="card-body">
						<canvas id="canvas-2"></canvas>
						<h4>Pria : <?php echo $jumlah_pria;?>,
						Wanita : <?php echo $jumlah_wanita;?></h4>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						10 Order Single Test Terbanyak
					</div>
					<div class="card-body">
						<canvas id="canvas-4"></canvas>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						10 Order Multi Test Terbanyak
					</div>
					<div class="card-body">
						<canvas id="canvas-5"></canvas>
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						10 Order Non Lab Terbanyak
					</div>
					<div class="card-body">
						<div id="barchart_values" style="max-width: 100%; height: 265px;"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						10 Order Paket Lab Terbanyak
					</div>
					<div class="card-body">
						<div id="pakettest" style="max-width: 100%; height: 265px;"></div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<div id="form-modal" class="modal fade melayang2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form method="GET" class="form-horizontal" action="home">
		<div class="modal-dialog modal-primary" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Filter</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">Ã—</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-3 form-control-label">Tgl. Awal</label>
						<div class="col-sm-6">
							<input id="datepicker" name="tanggal_awal" value="<?php echo $tanggal_awal;?>" class="form-control" required>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 form-control-label">Tgl. Akhir</label>
						<div class="col-sm-6">
							<input id="datepicker2" name="tanggal_akhir" value="<?php echo $tanggal_akhir;?>" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-search"></i> Tampilkan</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</form>
</div>
<script type="text/javascript">
	$("#btnTampilkan").click(function(){
		$("#form-modal").modal('show'); 
	});
</script>

<?php


//GRAFIK 3
$NonLab = "SELECT COUNT(id_detail) AS tot, id_detail FROM transaksi_invoice_detail WHERE waktu_input BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' AND jenis='N' AND a.id_kategori_harga='$_SESSION[login_user]'  GROUP BY id_detail ORDER BY tot DESC LIMIT 10";

$tampil=pg_query($dbconn,$NonLab);
$warna = array("#424242","#DF013A","#08088A","#088A85","#0B610B","#FFFF00","#DF0101","#2E9AFE","#58FA58","#1B0A2A");
$no=0;
$data_tindakan="['Element', 'Density', { role: 'style' } ],";
while($r=pg_fetch_array($tampil)){
	$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM tindakan WHERE id='$r[id_detail]'"));
	$data_tindakan.="['$d[nama]', $r[tot], '$warna[$no]'],";
	$no++;

}
//GRAFIK 4
$Lab= "SELECT COUNT(id_detail) AS tot, id_detail FROM transaksi_invoice_detail WHERE waktu_input BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' AND jenis='S'";
if($_SESSION[id_units]=='1'){
	$Lab .= "AND id_unit <> '$_SESSION[id_units]'";
	}
if($_SESSION[id_units]!='1'){
	$Lab .= "AND id_unit='$_SESSION[id_units]'";
	}
$Lab .=	"GROUP BY id_detail ORDER BY tot DESC LIMIT 10";

$tampil=pg_query($dbconn,$Lab);

$warna = array("#1B0A2A","#DF013A","#08088A","#088A85","#0B610B","#FFFF00","#DF0101","#424242","#2E9AFE","#58FA58");
$no=0;
$data_singletest="";
$jumlah_singletest="";
while($r=pg_fetch_array($tampil)){
	$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_analysis WHERE id='$r[id_detail]'"));
	$data_singletest.="'$d[nama]',";
	$jumlah_singletest.="$r[tot],";
	$no++;
}


//GRAFIK 5
$multiLab = "SELECT COUNT(id_detail) AS tot, id_detail FROM transaksi_invoice_detail WHERE waktu_input BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' AND jenis='M' ";
if($_SESSION[id_units]=='1'){
	$multiLab .= "AND id_unit <> '$_SESSION[id_units]'";
	}
if($_SESSION[id_units]!='1'){
	$multiLab .= "AND id_unit='$_SESSION[id_units]'";
	}
$multiLab .= "GROUP BY id_detail ORDER BY tot DESC LIMIT 10";

$tampil=pg_query($dbconn, $multiLab);

$warna = array("#1B0A2A","#DF013A","#08088A","#088A85","#0B610B","#FFFF00","#DF0101","#424242","#2E9AFE","#58FA58");
$no=0;
$data_multitest="";
$jumlah_multitest="";
while($r=pg_fetch_array($tampil)){
	$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_analysis_group WHERE id='$r[id_detail]'"));
	$data_multitest.="'$d[nama]',";
	$jumlah_multitest.="$r[tot],";
	$no++;
}


//GRAFIK 6
$PaketLab = "SELECT COUNT(id_detail) AS tot, id_detail FROM transaksi_invoice_detail WHERE waktu_input BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' AND jenis='P'  ";
if($_SESSION[id_units]=='1'){
	$PaketLab .= "AND id_unit <> '$_SESSION[id_units]'";
	}
if($_SESSION[id_units]!='1'){
	$PaketLab .= "AND id_unit='$_SESSION[id_units]'";
	}
$PaketLab .=	"GROUP BY id_detail ORDER BY tot DESC LIMIT 10";

$tampil1=pg_query($dbconn,$PaketLab);
$warna = array("#424242","#DF013A","#08088A","#088A85","#0B610B","#FFFF00","#DF0101","#2E9AFE","#58FA58","#1B0A2A");
$no=0;
$data_lab_paket="['Element', 'Density', { role: 'style' } ],";
while($r=pg_fetch_array($tampil1)){
	$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_analysis_paket WHERE id='$r[id_detail]'"));

	$data_lab_paket.="['$d[nama]', $r[tot], '$warna[$no]'],";
	$no++;

}

?>
<!-- /.conainer-fluid -->
<script type="text/javascript">
$(function (){
	'use strict';
	var barChartData = {
		labels : [<?php echo $kunjungan_label;?>],
		datasets : [
			{
				label: 'Pria',
				backgroundColor : 'rgba(220,220,220,0.5)',
				borderColor : 'rgba(220,220,220,0.8)',
				highlightFill: 'rgba(220,220,220,0.75)',
				highlightStroke: 'rgba(220,220,220,1)',
				data : [<?php echo $kunjungan_pria;?>]
			},
			{
				label: 'Wanita',
				backgroundColor : 'rgba(151,187,205,0.5)',
				borderColor : 'rgba(151,187,205,0.8)',
				highlightFill : 'rgba(151,187,205,0.75)',
				highlightStroke : 'rgba(151,187,205,1)',
				data : [<?php echo $kunjungan_wanita;?>]
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



	var pieData = {
		labels: [
			'Pria',
			'Wanita'
		],
		datasets: [{
			data: [<?php echo "$jumlah_pria, $jumlah_wanita";?>],
			backgroundColor: [
				'#FF6384',
				'#36A2EB'
			],
			hoverBackgroundColor: [
				'#FF6384',
				'#36A2EB'
			]
		}]
	};
	var ctx = document.getElementById('canvas-2');
	var chart = new Chart(ctx, {
		type: 'pie',
		data: pieData,
		options: {
			responsive: true
		}
	});
  
	google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			<?php echo $data_tindakan;?>
		]);

		var view = new google.visualization.DataView(data);
		view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

		var options = {
			title: "10 Tindakan Terbanyak",
			width: 450,
			height: 270,
			bar: {groupWidth: "95%"},
			legend: { position: "none" },
		};
		var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
		chart.draw(view, options);
	}

	/**/
	google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart1);
	function drawChart1() {
		var data2 = google.visualization.arrayToDataTable([
			<?php echo $data_lab_paket;?>
		]);

		var view2 = new google.visualization.DataView(data2);
		view2.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

		var options2 = {
			title: "10 Paket Lab Terbanyak",
			width: 450,
			height: 270,
			bar: {groupWidth: "95%"},
			legend: { position: "none" },
		};
		var chart2 = new google.visualization.BarChart(document.getElementById("pakettest"));
		chart2.draw(view2, options2);
	}

	/**/

	
	var polarData = {
		datasets: [{
			data: [
				<?php echo $jumlah_singletest;?>
			],
			backgroundColor: [
				'#FF6384',
				'#4BC0C0',
				'#FFCE56',
				'#E7E9ED',
				'#36A2EB',
				'#1B0A2A',
				'#08088A',
				'#088A85',
				'#0B610B',
				'#FFFF00'
			],
			label: 'Single Test' // for legend
		}],
		labels: [
		  <?php echo $data_singletest;?>
		]
	};
	var ctx = document.getElementById('canvas-4');
	var chart = new Chart(ctx, {
		type: 'polarArea',
		data: polarData,
		options: {
			responsive: true
		}
	});
	
	var polarData2 = {
		datasets: [{
			data: [
				<?php echo $jumlah_multitest;?>
			],
			backgroundColor: [
				'#FF6384',
				'#4BC0C0',
				'#FFCE56',
				'#E7E9ED',
				'#36A2EB',
				'#1B0A2A',
				'#08088A',
				'#088A85',
				'#0B610B',
				'#FFFF00'
			],
			label: 'Multi Test' // for legend
		}],
		labels: [
		  <?php echo $data_multitest;?>
		]
	};
	var ctx = document.getElementById('canvas-5');
	var chart = new Chart(ctx, {
		type: 'polarArea',
		data: polarData2,
		options: {
			responsive: true
		}
	});
});
</script>