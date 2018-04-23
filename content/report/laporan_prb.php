<?php
session_start();
$_SESSION['tgl_awal']=date('Y-m-d');
$_SESSION['tgl_akhir']=date('Y-m-d');

switch($_GET['act']){
	
default:
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Laporan</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i> Laporan Data Pasien PRB
							
						</div>
						<div class="card-block">
						<div class="form-horizontal">
						  <form method="post">
							<div class="form-group row">
								
								<label class="col-sm-1 form-control-label" >Tanggal</label>
									<div class="col-sm-2">										
										<input name='tgl_awal' class='form-control datelap' value="<?php echo $_SESSION['tgl_awal'] ; ?>" required/>									
										
									</div>									
									s/d
									<div class="col-sm-2">
										<input name='tgl_akhir' class='form-control datelap' required value="<?php echo $_SESSION['tgl_akhir']; ?>"/>									
										
									</div>
				          
									<button type="submit" class="btn btn-sm btn-primary" style="margin-right:10px; " name="cari" ><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
									
									<button type="reset" class="btn btn-sm btn-danger" id="lapkunjungan"><i class="fa fa-ban"></i> Reset</button></div>
								
				            </form>

							</div>
							<div id="printlap">
							<table class="table" id="myTable22">
								<thead>
									<tr>
										<th>No</th>
										<th>Tanggal Masuk </th>
										<th>Nama Pasien/ RM</th>
										
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($_POST['cari'])){
										$tgl_awal=$_POST["tgl_awal"];
										$tgl_akhir=$_POST["tgl_akhir"];
										$_SESSION['tgl_awal'] = $tgl_awal;
										$_SESSION['tgl_akhir'] = $tgl_akhir;

										$tampil=pg_query($dbconn,"SELECT * FROM kunjungan  where id_unit='$_SESSION[id_units]' AND waktu_input::date >='$tgl_awal'  and waktu_input::date <='$tgl_akhir'");

						
									}
									else{
										echo "here";
										$getPasienPrb=pg_query("SELECT * from kunjungan k join master_pasien mp on mp.id=k.id_pasien where k.id_unit='$_SESSION[id_units]' and prb='Y'");
									}


									$no=1;
									$amount = 0;
									while($fetchPasienPrb=pg_fetch_array($getPasienPrb )){

										$tanggal=DateToIndo2($fetchPasienPrb['waktu_input']);

										//$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$r[id_pasien]' "));									
										?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $tanggal ?></td>
											<td><?php echo $fetchPasienPrb["nama"]." / ".$fetchPasienPrb["no_rm"]; ?></td>
										</tr>
										<?php
										$no++;
									}
									?>
								</tbody>
	
								
							</table>
							
							</div>





							<div id="printlap1" style="display:none;">
							<table class="table" id="">
								<thead>
									<tr>
										<th>No</th>
										<th>Tanggal Masuk </th>
										<th>Nama Pasien/ RM</th>
										
									</tr>
								</thead>
								<tbody>
									<?php
								/*	if(isset($_POST['cari'])){
										$tgl_awal=$_POST["tgl_awal"];
										$tgl_akhir=$_POST["tgl_akhir"];
										$_SESSION['tgl_awal'] = $tgl_awal;
										$_SESSION['tgl_akhir'] = $tgl_akhir;

										$tampil=pg_query($dbconn,"SELECT * FROM kunjungan  where id_unit='$_SESSION[id_units]' AND waktu_input::date >='$tgl_awal'  and waktu_input::date <='$tgl_akhir'");

						
									}
									else{
												$tampil=pg_query($dbconn,"SELECT pl.* FROM kunjungan as pl WHERE pl.id_unit='$_SESSION[id_units]'");

										
									}*/
									$getPasienPrb=pg_query("SELECT * from kunjungan k join master_pasien mp on mp.id=k.id_pasien where k.id_unit='$_SESSION[id_units]' and prb='Y'");

									$no=1;
									$amount = 0;
									while($fetchPasienPrb=pg_fetch_array($getPasienPrb )){

										$tanggal=DateToIndo2($fetchPasienPrb['waktu_input']);

										//$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$r[id_pasien]' "));									
										?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $tanggal ?></td>
											<td><?php echo $fetchPasienPrb["nama"]." / ".$fetchPasienPrb["no_rm"]; ?></td>
										</tr>
										<?php
										$no++;
									}
									?>
								</tbody>
	
								
							</table>
							
							</div>










							<div class="pull-right">
								<button class="btn btn-sm btn-success" onclick='printDiv();' >
												PRINT
											</button>
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
	$p=pg_query($dbconn,"Update pasien_laborder set status_hapus='Y' WHERE id='$_GET[id]'");



?>
	<script >
		alert("berhasil dihapus");
		document.location.href = "lab-order";
	</script>



<?php

break;


case "cari":

	$id_rujuk=$_POST["id_rujuk"];
	$id_rujuk_ke=$_POST["id_rujuk_ke"];

?>




<?php
break;

}
?>



	<script>

		$('#lapkunjungan').click(function()
		{
			document.location.href = "laporan-rawat-jalan";

		});

		$(document).ready(function(){
			$(".datelap").mask("9999/99/99",{placeholder:"yyyy-mm-dd"});
			
			 $('.js-example-basic-single').select2();
		});

	function myFunction() {
		    window.print();
		}

	function printDiv() 
		{

		  var divToPrint=document.getElementById('printlap1');

		  var newWin=window.open('','Print-Window');

		  newWin.document.open();

		  newWin.document.write('<html><head><title>Laporan Pemeriksaan</title>');
		  newWin.document.write('<link href="assets/css/style.css" rel="stylesheet"></head><body onload="window.print()">');
		  newWin.document.write('<div style="text-align:center"><h1>Laporan Pemeriksaan</h1></div><div class="table-border table-stripped	">');
		  newWin.document.write(divToPrint.innerHTML);
		  newWin.document.write('</div></body></html>');
		  newWin.document.close();
  
		  var res = window.location;
		  //alert(res);     
		}
		
		</script>
