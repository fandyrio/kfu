<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id_unit=$_SESSION['id_units'];
$_SESSION['tgl_awal']=date('Y-m-d');
$_SESSION['tgl_akhir']=date('Y-m-d');

$getSetting=pg_query("SELECT * from ruang_unit where id_unit='$id_unit'");
$fetchSetting=pg_fetch_assoc($getSetting);
$alert="";
if(pg_num_rows($getSetting)==0)
{
	$alert="<i class='fa fa-exclamation-triangle' style='font-size:20px;color:red'></i>";
}
?>	
<style type="text/css">
.headtab
{
	cursor:pointer;
	padding:0.5%;
}
.headtab:hover
{
	background-color:white;
}
</style>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Settings</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-settings"></i> Pengaturan Klinik
							
						</div>
						<div class="card-block">
							<div class="card">
							<div class="form-group card-title headtab">
								<div class="col-md-12">
									Ruangan Dokter <span class='pull-right'><?php echo $alert ?></span>
								</div>
							</div>
						</div>
							<div class="card-block" id="room_setting">
								
									<!-- Here room_setting.php -->
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(".headtab").click(function()
	{
		$("#room_setting").html("<img src='images/load.gif' style='width:100px;'>");
		$("#room_setting").load("content/settings/room_setting.php");
	});
</script>
