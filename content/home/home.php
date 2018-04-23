<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include "config/conn.php";
//session_start();

//=======================================================
//GET UNIT ID
//=======================================================
$idUnit=$_SESSION['id_units'];
$getOutlet=pg_query("SELECT * from master_unit where id='$idUnit'");
$fetchOutlet=pg_fetch_assoc($getOutlet);
$outletId=$fetchOutlet['id_outlet'];
//======================================================
//sync obat
//======================================================
$getCek=pg_query("SELECT * from list_sync ls join master_unit mu on mu.id_outlet=ls.outlet_id where ls.nama_sync='sync_obat' and mu.id='$idUnit'");
$jumlah=pg_num_rows($getCek);
if($jumlah==0)
{
	$insertData=pg_query("INSERT into list_sync (nama_sync,last_update,outlet_id) values ('sync_obat', '2018-01-01','$outletId')");
	echo"<meta http-equiv='refresh' content='3'>";
}
else
{
	$fetchCek=pg_fetch_assoc($getCek);
	$today=date("Y-m-d");
	$lastDateSync=$fetchCek['last_update'];
}
//======================================================
//send notifikasi
//======================================================
$getCekNotif=pg_query("SELECT * from list_sync ls join master_unit mu on mu.id_outlet=ls.outlet_id where ls.nama_sync='notif_prolanis' and mu.id='$idUnit'");
$jumlahNotif=pg_num_rows($getCekNotif);
if($jumlahNotif==0)
{
	$insertData=pg_query("INSERT into list_sync (nama_sync,last_update,outlet_id) values ('notif_prolanis', '2018-01-01','$outletId')");
	echo"<meta http-equiv='refresh' content='3'>";
}
else
{
	$fetchCekNotif=pg_fetch_assoc($getCekNotif);
	$today=date("Y-m-d");
	$lastDateSyncNotif=$fetchCekNotif['last_update'];
}
//======================================================
//SYNC PENJAMIN
//======================================================
$getPenjaminSync=pg_query("SELECT * from list_sync ls join master_unit mu on mu.id_outlet=ls.outlet_id where ls.nama_sync='sync_penjamin' and mu.id='$idUnit'");
$jumlahDataSync=pg_num_rows($getPenjaminSync);
if($jumlahDataSync==0)
{
	$insertData=pg_query("INSERT into list_sync (nama_sync,last_update,outlet_id) values ('sync_penjamin', '2018-01-01','$outletId')");
	echo"<meta http-equiv='refresh' content='3'>";
}
else
{
	$fetchCekPenjamin=pg_fetch_assoc($getPenjaminSync);
	$today=date("Y-m-d");
	$lastDateSyncPenjamin=$fetchCekPenjamin['last_update'];
}
//======================================================

$status=0;

?>
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
?>

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
			<div class="col-sm-6 col-lg-3">
				<button class="btn btn-lg btn-primary btn-circle"><i class="fa fa-bell"></i>
						<span class="btn btn-sm btn-danger btn-circle" style="width:20px;height:20px;position:fixed;font-size:10px;padding-top:10%;">1</span>
					</button>
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
			
		<!-- 	<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						10 Paket Terbanyak Bulan Ini (Order)
					</div>
					<div class="card-body">
						<canvas id="canvas-6"></canvas>
					</div>
				</div>
			</div> -->
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
						<span aria-hidden="true">×</span>
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

	var today="<?php echo $today ?>";
	var lastUpdateObat="<?php echo $lastDateSync ?>";
	var lastDateSyncNotif="<?php echo $lastDateSyncNotif; ?>";
	var lastDateSyncPenjamin="<?php echo $lastDateSyncPenjamin ?>";
	var id_outlet="<?php echo $outletId; ?>";
	console.log(lastUpdateObat);
	/*setInterval(
			function()
			{
				$.ajax(
				{
					url:'content/home/syncReservasi.php',
					data:{id_outlet:id_outlet},
					success:function(result)
					{
						$(".jumlahReservasi").html("");
						$(".jumlahReservasi").html(result);
					},
					error:function()
					{
						alert("Error");
					}

				});
			},1000000000000);*/
	if(today > lastUpdateObat)
	{
		$("#isi").html(" <span class='result_obat'>Mohon Menunggu sedang <b>SINKRON DATA OBAT</b>, akan memakan beberapa waktu<span>");
		$.ajax({
			url:'data/syncObat.php',
			type:'POST',
			success:function(result)
			{
				if(result=="ERROR")
				{
					$(".result_obat").html("<b>SINKRON OBAT GAGAL</b>");
					return false;
				}
				var name='sync_obat';
				$.ajax(
				{
					url:'data/updateSyncDate.php',
					data:{name:name},
					type:'POST',
					success:function()
					{
						$(".result_obat").html("<b>SINKRON DATA OBAT BERHASIL</b>");
						if(today > lastDateSyncNotif)
						{
							$("#isi").append("<br /> <span class='result_notif'>Mohon Menunggu sedang mengirimkan <b>NOTIFIKASI </b>, akan memakan beberapa waktu <span>");
							$.ajax({
								url:'prolanis/pages/umum/pasien/sendNotif.php',
								type:'POST',
								success:function()
								{
									var name='notif_prolanis';
									$(".result_notif").html("<b>KIRIM NOTIFIKASI BERHASIL</b>");
									$.ajax(
									{
										url:'data/updateSyncDate.php',
										data:{name:name},
										type:'POST',
										success:function()
										{
											if(today > lastDateSyncPenjamin)
											{
												$("#isi").append("<br /><span class='result_penjamin'>Mohon Menunggu sedang <b>SINKRON DATA PENJAMIN</b>, akan memakan beberapa waktu <span>");
												$.ajax(
												{
													url:'data/syncPenjamin.php',
													type:'POST',
													success:function()
													{
														$(".result_penjamin").html("<b>SINKRON DATA PENJAMIN BERHASIL</b>");
														var name="sync_penjamin";
														$.ajax(
														{
															type:'POST',
															data:{name:name},
															url:'data/updateSyncDate.php',
															success:function()
															{
																$("#isi").append("<br /><a href='home'><button class='btn btn-primary btn-xs'>Lanjut</button></a>");
																//alert("Synkronisasi berhasil");
																//location.reload();
															},
															error:function()
															{
																$(".result_penjamin").html("<b>SINKRON DATA PENJAMIN GAGAL !</b>");
															}
														});
													}

												});
											}
											/*alert("Synkronisasi berhasil");
											location.reload();*/
										}
									});
									 
								},
								error:function()
								{
									//alert("ERROR PROLANIS");
									$(".result_notif").html("<b>KIRIM SMS PROLANIS GAGAL</b>");
								}
							});
						}
					}
				});
			},
			error:function()
			{
				$(".result_obat").html("<b>SINKRON OBAT GAGAL</b>");
			}
		});
	}
	

/*	setInterval(function() {
			$.ajax(
			{
				url:'percentage.php',
				success:function(result)
				{
					var data=JSON.parse(result);
					console.log(data);
					var token=data.token;
					var noAntrian=data.no_cetak_antrian;
					var getRoom=data.getRoom;
					var idunit=data.idUnit;
					console.log(idunit);
					if(id_unit==idunit)
					{
						if(token=="XXI")
						{
							$("#"+getRoom).html(noAntrian);
							play(noAntrian,getRoom);
						}
					}
					
				}
			});

		}, 1000);*/
	

	$("#btnTampilkan").click(function(){
		$("#form-modal").modal('show'); 
	});
</script>
<?php
//GRAFIK 1
$no=6;
$kunjungan_label="";
$kunjungan_pria="";
$kunjungan_wanita="";
while($no>=0){
	$tanggal = date("Y-m-d", strtotime("-$no days", strtotime($tgl_sekarang)));
	$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(a.id) AS tot FROM kunjungan a, master_pasien b WHERE CAST(a.id_pasien AS bigint)=b.id AND b.jenkel='1' AND a.waktu_input AND id_unit='$_SESSION[id_units]' BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'"));
	$kunjungan_pria.="$c[tot],";
	
	$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(a.id) AS tot FROM kunjungan a, master_pasien b WHERE CAST(a.id_pasien AS bigint)=b.id AND b.jenkel='2' AND a.waktu_input AND id_unit='$_SESSION[id_units]' BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'"));
	$kunjungan_wanita.="$c[tot],";
	
	$tanggal = DateToIndo2($tanggal);
	$kunjungan_label.="'$tanggal',";
	$no--;
	
}

//GRAFIK 2
$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM master_pasien WHERE jenkel='1' AND id_unit='$_SESSION[id_units]'"));
$jumlah_pria=$c['tot'];
$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM master_pasien WHERE jenkel='2' AND id_unit='$_SESSION[id_units]'"));
$jumlah_wanita=$c['tot'];

//GRAFIK 3
$NonLab = "SELECT COUNT(id_detail) AS tot, id_detail FROM transaksi_invoice_detail WHERE waktu_input BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' AND jenis='N' AND id_unit='$_SESSION[id_units]' GROUP BY id_detail ORDER BY tot DESC LIMIT 10";

$tampil=pg_query($dbconn,$NonLab);
$warna = array("#424242","#DF013A","#08088A","#088A85","#0B610B","#FFFF00","#DF0101","#2E9AFE","#58FA58","#1B0A2A");
$no=0;
$data_tindakan="['Element', 'Density', { role: 'style' } ],";
while($r=pg_fetch_array($tampil)){
	$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM tindakan WHERE id='$r[id_detail]'"));
	$data_tindakan.="['$d[nama]', $r[tot], '$warna[$no]'],";
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