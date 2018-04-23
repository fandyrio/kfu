 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Jakarta");
	$id_unit=$_SESSION['id_units'];
	include "../config/conn.php";

	$getRuangPoly=pg_query("SELECT * from ruang_unit ru 
		join master_poly mp on mp.id=ru.poly
		where ru.id_unit='$id_unit'");

	$getData=pg_query("SELECT nama from master_unit where id='$id_unit'");
	$fetchDataUnit=pg_fetch_assoc($getData);
	$namaUnit=$fetchDataUnit['nama'];


?>
<div class="container-fluid">
	<div class="col-sm-12">

		<div class="row justify-content-center">
			<div class="col-sm-12">
				<center><img src="../images/logo_klinik.jpg" width="200px"></center><br />
				<center><p><b><h1>Selamat Datang Di Klinik <?php echo $namaUnit; ?> </h1></b></p></center>
			</div>
<?php
	while($fetchRuangPoly=pg_fetch_assoc($getRuangPoly))
	{
		$jumlah=$fetchRuangPoly['jumlah'];
		for($x=1;$x<=$jumlah;$x++)
		{
			
			?>
		
			<div class="col-sm-3" style="">
					<div class="card">
   					 <div class="card-header"> 
   					 	<center>
   					 		<b> <span id="<?php echo $fetchRuangPoly['name']."-".$x ?>" style="font-size:220px;">0</span></b>
   					 	</center>
   					 </div>
   					 <div class="card-footer"> 
   					 	<center>
   					 		<button class="btn btn-lg btn-primary">
   					 			<span class="glyphicon glyphicon-credit-card" style="font-size:20px;"> <?php echo $fetchRuangPoly['name']."-".$x ?>
   					 		</button>
   					 	</center>
   					 </div>
					</div>				 
			</div>
				<?php
		}
	}
?>
		
	</div>
	<div id="test_berjalan" style="height:40px;background-color:blue;color:white;margin-top:20%;;font-size:20px;">
		<marquee><b>TERIMA KASIH TELAH BERKUNJUNG KE <?php echo $namaUnit ?>, SEMOGA LEKAS SEMBUH</b></marquee>
	</div>
	<span style="background-color:white;color:black;"><center><p><b>copyright &copy; <?php echo date("Y");?></b></p></center></span>
</div>
</div>