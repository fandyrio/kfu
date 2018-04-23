<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item active">Dashboard</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-6 col-lg-3">
				<div class="card text-white bg-primary">
					<div class="card-body pb-0">
						<h4 class="mb-0">
							<?php 
							$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM antrian WHERE status_aktif='Y' AND id_unit='$_SESSION[id_units]'"));
							echo $c['tot'];
							?>
						</h4>
						<p>Total Antrian</p>
					</div>
					<div class="chart-wrapper px-3" style="height:70px;">
						<canvas id="card-chart1" class="chart" height="70"></canvas>
					</div>
				</div>
			</div>
			
			<div class="col-sm-6 col-lg-3">
				<div class="card text-white bg-info">
					<div class="card-body pb-0">
						<h4 class="mb-0">
						<?php 
							$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM master_pasien WHERE id_unit='$_SESSION[id_units]'"));
							echo $c['tot'];
						?>
						</h4>
						<p>Total Pasien</p>
					</div>
					<div class="chart-wrapper px-3" style="height:70px;">
						<canvas id="card-chart2" class="chart" height="70"></canvas>
					</div>
				</div>
			</div>
			
			<div class="col-sm-6 col-lg-3">
				<div class="card text-white bg-warning">
					<div class="card-body pb-0">
						<h4 class="mb-0">
						<?php 
							$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_laborder WHERE waktu_input BETWEEN '$tgl_sekarang 00:00:00' AND '$tgl_sekarang 23:59:59' AND status_hapus='N'"));
							echo $c['tot'];
						?>
						</h4>
						<p>Lab Order Hari Ini</p>
					</div>
					<div class="chart-wrapper px-3" style="height:70px;">
						<canvas id="card-chart3" class="chart" height="70"></canvas>
					</div>
				</div>
			</div>
			
			<div class="col-sm-6 col-lg-3">
				<div class="card text-white bg-success">
					<div class="card-body pb-0">
						<h4 class="mb-0">
						<?php 
							$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_hasillab WHERE waktu_input BETWEEN '$tgl_sekarang 00:00:00' AND '$tgl_sekarang 23:59:59' AND status_hapus='N'"));
							echo $c['tot'];
						?>
						</h4>
						<p>Lab Hasil Hari Ini</p>
					</div>
					<div class="chart-wrapper px-3" style="height:70px;">
						<canvas id="card-chart4" class="chart" height="70"></canvas>
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
					</div>
				</div>
			</div>
			
			
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						Jumlah Pasien
					</div>
					<div class="card-body">
						<canvas id="canvas-2"></canvas>
					</div>
				</div>
			</div>
			
		</div>
		<!--
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						Jumlah Order Group Tindakan
					</div>
					<div class="card-body">
						<canvas id="canvas-4"></canvas>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						Jumlah Order Lab
					</div>
					<div class="card-body">
						<canvas id="canvas-6"></canvas>
					</div>
				</div>
			</div>
		</div>
		-->
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						10 Tindakan Terbanyak Bulan Ini (Order)
					</div>
					<div class="card-body">
						<div id="barchart_values" style="max-width: 100%; height: 265px;"></div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						10 Paket Terbanyak Bulan Ini (Order)
					</div>
					<div class="card-body">
						<canvas id="canvas-6"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
//GRAFIK 1
$no=6;
$kunjungan_label="";
$kunjungan_pria="";
$kunjungan_wanita="";
while($no>=0){
	$tanggal = date("Y-m-d", strtotime("-$no days", strtotime($tgl_sekarang)));
	$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(a.id) AS tot FROM kunjungan a, master_pasien b WHERE CAST(a.id_pasien AS bigint)=b.id AND b.jenkel='1' AND a.waktu_input BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'"));
	$kunjungan_pria.="$c[tot],";
	
	$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(a.id) AS tot FROM kunjungan a, master_pasien b WHERE CAST(a.id_pasien AS bigint)=b.id AND b.jenkel='2' AND a.waktu_input BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'"));
	$kunjungan_wanita.="$c[tot],";
	
	$tanggal = DateToIndo2($tanggal);
	$kunjungan_label.="'$tanggal',";
	$no--;
	
}

//GRAFIK 2
$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM master_pasien WHERE jenkel='1'"));
$jumlah_pria=$c['tot'];
$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM master_pasien WHERE jenkel='2'"));
$jumlah_wanita=$c['tot'];

//GRAFIK 3
$tampil=pg_query($dbconn,"SELECT COUNT(id) AS tot, id_tindakan FROM pasien_tindakan WHERE waktu_input BETWEEN '$thn_sekarang-$bln_sekarang-01 00:00:00' AND '$tgl_sekarang 23:59:59' GROUP BY id_tindakan ORDER BY tot DESC LIMIT 10");
$warna = array("#424242","#DF013A","#08088A","#088A85","#0B610B","#FFFF00","#DF0101","#2E9AFE","#58FA58","#1B0A2A");
$no=0;
$data_tindakan="['Element', 'Density', { role: 'style' } ],";
while($r=pg_fetch_array($tampil)){
	$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM tindakan WHERE id='$r[id_tindakan]'"));
	$data_tindakan.="['$d[nama]', $r[tot], '$warna[$no]'],";
	$no++;
}

//GRAFIK 4
$tampil=pg_query($dbconn,"SELECT COUNT(id) AS tot, id_billing_paket FROM pasien_billing_paket WHERE waktu_input BETWEEN '$thn_sekarang-$bln_sekarang-01 00:00:00' AND '$tgl_sekarang 23:59:59' GROUP BY id_billing_paket ORDER BY tot DESC LIMIT 10");
$warna = array("#1B0A2A","#DF013A","#08088A","#088A85","#0B610B","#FFFF00","#DF0101","#424242","#2E9AFE","#58FA58");
$no=0;
$nama_billing_paket="";
$jumlah_billing_paket="";
while($r=pg_fetch_array($tampil)){
	$d=pg_fetch_array(pg_query($dbconn,"SELECT nama_paket FROM billing_paket WHERE id='$r[id_billing_paket]'"));
	$data_billing_paket.="'$d[nama_paket]',";
	$jumlah_billing_paket.="$r[tot],";
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
			width: 550,
			height: 270,
			bar: {groupWidth: "95%"},
			legend: { position: "none" },
		};
		var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
		chart.draw(view, options);
	}
	
	var polarData = {
    datasets: [{
      data: [
        <?php echo $jumlah_billing_paket;?>
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
      label: 'My dataset' // for legend
    }],
    labels: [
      <?php echo $data_billing_paket;?>
    ]
  };
  var ctx = document.getElementById('canvas-6');
  var chart = new Chart(ctx, {
    type: 'polarArea',
    data: polarData,
    options: {
      responsive: true
    }
  });
});

</script>