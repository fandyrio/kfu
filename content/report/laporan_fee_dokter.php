<?php
session_start();
$_SESSION['tgl_awal']=date('Y-m-d');
$_SESSION['tgl_akhir']=date('Y-m-d');

if(isset($_POST['cari'])){
	$startDate= $_POST['startDate'];
	$endDate=  $_POST['endDate'];
}										
else{
	$startDate= date('Y-m-d');
	$endDate= date('Y-m-d');

}

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
							<i class="icon-grid"></i> Laporan Fee Dokter
							
						</div>
						<div class="card-block">
						<div class="form-horizontal">
						  <form method="post">
							<div class="form-group row">
								
								<label class="col-sm-1 form-control-label" >Tanggal</label>
									<div class="col-sm-2">										
										<input type="date" name='startDate' class='form-control' value="<?php echo $startDate ; ?>" required/>									
										
									</div>									
									s/d
									<div class="col-sm-2">
									<input type="date" name='endDate' class='form-control' required value="<?php echo $endDate; ?>"/>									
										
									</div>
				          
									<button type="submit" class="btn btn-sm btn-primary" style="margin-right:10px; " name="cari" value="cari" ><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
									
									<button type="reset" class="btn btn-sm btn-danger" id="lapkunjungan"><i class="fa fa-ban"></i> Reset</button></div>
								
				            </form>

							</div>
							<div id="printlap">
							<table class="table" >
								<thead>
									<tr>
										<th>No</th>
										<th>Nama Dokter </th>
										<th>Tindakan </th>
										<th>Total </th>
										
									</tr>
								</thead>
								<tbody>
									<?php
									$tampil=pg_query($dbconn,"SELECT DISTINCT id_dokter from antrian WHERE id_unit='$_SESSION[id_units]' AND waktu_masuk BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'");

		
									$no=1;
									$amount = 0;
									while($r=pg_fetch_array($tampil)){

										$tanggal=DateToIndo2($r['waktu_input']);

										$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_karyawan WHERE id='$r[id_dokter]' "));

										?>
										<tr>
											<td><?php echo $no++ ?></td>
											<td><?php echo $a[nama] ?></td>
											<td>
											<?php
											$total_fee ="0";
											$doc=pg_query($dbconn,"SELECT * from antrian WHERE id_dokter='$r[id_dokter]'");
											while($tr=pg_fetch_array($doc)){
												if($tr[id_pasien]){
												$data_tindakan=pg_query($dbconn,"SELECT i.* from transaksi_invoice_detail t LEFT OUTER JOIN tindakan i on i.id=t.id_detail WHERE t.id_pasien='$tr[id_pasien]' and t.jenis='N'");

												$tindakan=pg_fetch_array($data_tindakan);
												
												if(pg_num_rows($data_tindakan)>0){
												$dokter_unit=pg_query($dbconn,"SELECT * FROM tindakan_dokter_unit where id_karyawan='$r[id_dokter]' AND id_unit='$_SESSION[id_units]' AND id_tindakan='$tindakan[id]'");
												
													if(pg_num_rows($dokter_unit)>0){
													$dokter_data=pg_fetch_array($dokter_unit);
													$fee = ($dokter_data[persen_dokter] * $dokter_data[harga])/100;
													$total_fee	+= $fee;
													?>
													<li>
													<?php
													echo $tindakan[nama]." / ".number_format($fee,'0','','.')?>
													</li>
													<?php }//end cek apakah dokter sudah disetting 
													else {
														?>	
							
													<li><span style="color:red"><?php
													echo $tindakan[nama]; ?> (Belum Disetting)</span>
														
													</li>
											<?php
														}//end elses
														
													}//end check jika data  ditemukan
												}//END CHECK JIKA PASIEN !#NULL
											}

											?>

											</td>
											<td><?php echo number_format($total_fee,'0','','.') ?></td>


											
										</tr>
										<?php
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
			document.location.href = "laporan-fee-dokter";

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

		  var divToPrint=document.getElementById('printlap');

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
