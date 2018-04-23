<?php

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
							<i class="icon-grid"></i> Data
							
						</div>



						<div class="card-block">
						<div class="form-horizontal">
						  <form method="post">
							<div class="form-group row">
								<label class="col-md-2 form-control-label" >Jenis Pemeriksaan</label>
								<div class="col-sm-3">
				                     
				                      <select name='jenis' class='form-control' required>
				                      
				                       <option value='S' <?php if($_POST["jenis"]=='S') echo 'selected' ?>>Laboratorium</option>
				                       <!-- <option value='M' <?php if($_POST["jenis"]=='M') echo 'selected' ?>>Multi Test</option> -->
				                       <option value='N' <?php if($_POST["jenis"]=='N') echo 'selected' ?>>Tindakan</option>
				                       <!-- <option value='E' <?php if($_POST["jenis"]=='E') echo 'selected' ?>>MCU</option> -->
				                   
				                      </select>
				                  </div>
				              
				          
									<button type="submit" class="btn btn-sm btn-primary" style="margin-right:10px; " name="cari" ><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
									
									<button type="reset" class="btn btn-sm btn-danger" id="resetreport"><i class="fa fa-ban"></i> Reset</button></div>
								
							
								<!--<div class="col-md-6">
									<a href="pendaftaran?act=sidik" class="btn btn-success btn-sm pull-right"><i class="fa fa-500px"></i> Sidik Jari</a>
								</div>-->
						
				            </form>

							</div>
							<div id="printjenis">
							<table class="table" >
								<thead>
									<tr>
										<th>No</th>
										<th>Jenis Pemeriksaan</th>
										<th>Nama Pasien/ RM</th>
										<th>Tgl Pemeriksaan</th>
										<th>amount</th>
										
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($_POST["cari"]))
									{
									
									$jenis=$_POST["jenis"];			
									$tampil=pg_query($dbconn,"SELECT pl.*  from transaksi_invoice_detail pl where pl.id_unit='$_SESSION[id_units]' AND pl.jenis='$jenis' ");
									

									}else{
										$jenis='S';		
										$tampil=pg_query($dbconn,"SELECT pl.* WHERE pl.id_unit='$_SESSION[id_units]' AND pl.jenis ='S'
									    ");	
									}

									
									
									$no=1;
									$amount = 0;
									while($r=pg_fetch_array($tampil)){
										if($jenis=='S'){
				                      $a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$r[id_detail]'"));
				                      
				                      $nama=$a[nama];
				                      
				                    }
				                    elseif($jenis=='M'){
				                      $a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$r[id_detail]'"));
				                       $nama=$a[nama];
				                    }
				                    elseif($jenis=='N'){
				                      $a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_detail]'"));
				                      
				                       $nama=$a[nama];
				                    }
				                     elseif($jenis=='E'){
				                     $h=pg_fetch_assoc(pg_query($dbconn,"SELECT * FROM billing_paket  
															WHERE id='$r[id_detail]' "));
											$nama_transaksi=
				                      
				                       $nama=$h[nama_paket];
				                    }

										$amount += $r["harga"];
																

										$a=explode(" ",$r['waktu_input']);
										$tanggal=DateToIndo2($a[0]);

										$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$r[id_pasien]' "));

										
										?>
										<tr>
											<td><?php echo $no++; ?> </td>
											<td><?php echo $nama;?></td>
											<td><?php echo $a["nama"]." / ".$a["no_rm"]; ?></td>
											<td><?php echo $tanggal ;?></td>
											
											<td><?php echo number_format($r["harga"],0,',','.') ?></td>
									
										</tr>
										<?php
										
									}
									?>
								</tbody>
								<tfoot style="font-weight: bold">
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td>Total</td>
											
											<td><?php echo "Rp. ".number_format($amount,0,',','.')?></td>
									
										</tr>
								</tfoot>
							</table>
							</div>
							<div class="pull-right">


								<button class="btn btn-sm btn-success" onclick='printDiv();' >PRINT</button>
								
									
								<!-- <a href="print_hasil_lab.php?id=<?php echo "$r[id]";?>" target="_BLANk" class="btn btn-danger btn-xs pull-right"  data-toggle="tooltip" data-placement="top" title="Print">Print<i class="icon-print"></i></a>  -->



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



case "view":

 $v=pg_fetch_array(pg_query($dbconn,"Select * from pasien_laborder WHERE id='$_GET[id]'"));
?>

<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Jadwal</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-6 col-lg-6">
				<div id="data_jadwal">

			<div class="card">
				<div class="card-header">
					<div class="col-md-6 pull-left">
						<strong>View Lab Order</strong>
					</div>
					<div class="col-md-6 pull-right">
						<strong><?php echo $v["waktu_input"] ?></strong>
					</div>
				</div>
				<div class="card-block">
					<div class="row">
							<table class="table">
								<tr>

									<td width="150px">Ke</td>
									<td width="10px">:</td>
									<?php $ul=pg_fetch_array(pg_query($dbconn,"Select * from master_unit_lab WHERE id='".$v["id_unit_lab"]."'")); ?>
									<td><?php echo $ul["nama"];?></td>
								</tr>
								<tr>
									<td>Order Id</td><td>:</td><td><?php echo $v["id"];?></td>
								</tr>
								<tr>
								<?php $lp=pg_fetch_array(pg_query($dbconn,"Select * from master_laborder_priority WHERE id='".$v["id_priority"]."'")); 
									?>
									<td>Priority</td><td>:</td>
									<td>
										<?php echo $lp["nama"];?>
									</td>
								</tr>
								<tr>
									<td>Analisa</td><td>:</td><td>
									<table class="table">
									<thead>
										<tr>
											<th>No.</th>
											<th>Nama</th>
										</tr>
									</thead>
									<tbody><?php ?>
									<?php 
										$no=1;
										$q=pg_query("select * from pasien_laborder_detail where id_lab_order=$_GET[id]");

										while($pld = pg_fetch_assoc($q)){
											$la=pg_fetch_array(pg_query("select * from lab_analysis where id='".$pld["id_lab_analysis"]."'"));									

									?>
							
											<tr>
												<td width="20px"><?php echo $no++;?></td>
												<td colspan="2"><?php echo $la['nama'];?></td>
											</tr>
											<?php
											}
										?>

									<?php 
										$q=pg_query("select * from pasien_laborder_detail where id_lab_order=$_GET[id]");

										while($pld = pg_fetch_assoc($q)){
											$la=pg_query("select * from lab_analysis_group_detail where  	id_lab_analysis_group='".$pld["id_lab_analysis_group"]."'");


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
										?>
									</tbody>
									</table>	

									</td>
								</tr>
								<tr>
								<?php $ds=pg_fetch_array(pg_query($dbconn,"Select * from master_karyawan WHERE id='".$v["id_refered_by"]."'")); 

								
								 ?>
									<td>Dirujuk Oleh</td><td>:</td><td><?php echo $ds["nama"];?></td>
								</tr>
								<tr>
								<?php $dk=pg_fetch_array(pg_query($dbconn,"Select * from master_karyawan WHERE id='".$v["id_reply_to"]."'")); 
								 ?>
									<td>Dirujuk Kepada</td><td>:</td><td><?php echo $dk["nama"];?></td>
								</tr>
							</table>
					</div>
				</div>
				<div class="card-footer">
					<button type="button" class="btn btn-default btn-sm" id="btnbatalviewLab">Kembali</button>
				</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>

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

		$('#resetreport').click(function()
		{
			document.location.href = "jenis-pemeriksaan";

		});

			function myFunction() {
		    window.print();
		}

	function printDiv() 
		{

		  var divToPrint=document.getElementById('printjenis');

		  var newWin=window.open('','Print-Window');

		  newWin.document.open();

		  newWin.document.write('<html><head><title>Laporan Pemeriksaan</title>');
		  newWin.document.write(' <link href="assets/css/style.css" rel="stylesheet"></head><body style="background-image: none !important;"  onload="window.print()">');
		  newWin.document.write('<DIV class="logo"><img src="images/logo_laporan_lab.png" style="position: auto;left: 15px;top: 0px;margin-bottom:-10px;"></DIV>	<div style="text-align:center"><h3>Laporan Pemeriksaan</h3></div><div class="table-border table-stripped">');
		  newWin.document.write(divToPrint.innerHTML);
		  newWin.document.write('</div></body></html>');
		  newWin.document.close();
  
		  var res = window.location;
		}
		</script>
