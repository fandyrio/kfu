<?php
session_start();

switch($_GET['act']){
	
default:

if(isset($_GET['cari'])){
	
	$tanggal_awal=$_GET['tanggal_awal'];
	$tanggal_akhir=$_GET['tanggal_akhir'];
	$id_unit=$_GET['id_unit'];
	$id_status=$_GET['id_status'];
}
else{
	
	$tanggal_awal=date('d-m-Y', strtotime('-7 days'));
	$tanggal_akhir=date('d-m-Y');
	$id_unit=$_SESSION['id_units'];
	$id_status =0;
}
$tanggal_awal2=DateToEng($tanggal_awal);
$tanggal_akhir2=DateToEng($tanggal_akhir);

?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Lab Order</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i>Data Lab Order	
						</div>
						<div class="card-block">
							<form method="get" class="form-horizontal">
								<div class="form-group row">
								<label class="col-sm-1 form-control-label" >Cabang</label>
										<div class="col-sm-3">
											<?php
											if($_SESSION['id_units']==1){
												$result =pg_query($dbconn, "SELECT p.* FROM master_unit p
															 ORDER BY id");
												$disabled="";
											}else {									
											$result =pg_query($dbconn, "SELECT p.* FROM master_unit p
															where p.id='$_SESSION[id_units]' ORDER BY id");
											$disabled="disabled";
											}							
											?>
											<select name='id_unit' class='form-control' <?php echo $disabled; ?>>
											
												<?php 
												while ($row =pg_fetch_assoc($result)){
												if(isset($_GET["cari"]))
												{													 
													 $id_unit=$_GET["id_unit"];
													 if($id_unit== $row['id']){
														  echo "<option value='".$id_unit."' selected>".$row['nama']."</option>";
														}
														else{
														echo "<option value='".$row['id']."'>".$row['nama']."</option>";
													}									

												}

												 else{
														echo "<option value='".$row['id']."'>".$row['nama']."</option>";
													}

												}
											?>
											</select>
										</div>
									<label class="col-md-1 form-control-label" >Status</label>
									<div class="col-sm-2">
										<?php 
										$result =pg_query($dbconn, "SELECT * FROM master_status_laborder");
										?>
										<select name='id_status' class='form-control' required>
											<option value='0'>Semua</option>
											<?php 
											while ($row =pg_fetch_assoc($result)){
											if(isset($_GET["cari"]))
											{
												 
										   		 $id_status=$_GET["id_status"];
												 if($id_status== $row['id']){
							                          echo "<option value='".$id_status."' selected>".$row['nama']."</option>";
							                        }
							                        else{
							                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
							                    }									

											}

											 else{
							                        echo "<option value='".$row['id']."'>".$row['nama']."</option>";
							                    }

											}
										?>
										</select>
									</div>
									
									
									<button type="submit" class="btn btn-primary btn-sm" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
									<button type="reset" class="btn btn-sm btn-danger" id="resetlaborder"><i class="fa fa-ban"></i> Reset</button>
									</div>
									<div class="form-group row">
									<label class="col-sm-1 form-control-label">Tgl. Awal</label>
									<div class="col-sm-2">
										<input id="datepicker" name="tanggal_awal" value="<?php echo $tanggal_awal;?>" class="form-control" required>
									</div>
									
									<label class="offset-sm-1 col-sm-1 form-control-label">Tgl. Akhir</label>
									<div class="col-sm-2">
										<input id="datepicker2" name="tanggal_akhir" value="<?php echo $tanggal_akhir;?>" class="form-control" required>
									</div>
									</div>
								
							</form>

							<table class="table" id="myTable" >
						<thead class="table-secondary">
							<tr>
								<th width="40px">No</th>	
								<th width="40px">No Order</th>								
								<th>Nama</th>
								<th>Jenis Pemeriksaan</th>
								<th>Detail</th>
								<th>Kunjungan</th>
								<th>Status</th>
								<th>#</th>
								
							</tr>
						</thead>
						<tbody>
							<?php
							$id_unit =$_SESSION['id_units'];						
							//$filter =false;						
							

							if($id_unit > 1){
								$query= "SELECT * FROM transaksi_invoice_detail  where  id_unit='$id_unit'  AND  waktu_input  >= '$tanggal_awal2' AND waktu_input <= '$tanggal_akhir2' ";	
							}					
							else{
								$query= "SELECT * FROM transaksi_invoice_detail where waktu_input  >= '$tanggal_awal2' AND waktu_input <= '$tanggal_akhir2' ";	
							}
							//var_dump($query);
							 $query.=" ORDER BY id asc";
							 $tampil=pg_query($dbconn,$query);

							
								$no=1;
								while($r=pg_fetch_array($tampil)){
								$b=pg_fetch_array(pg_query($dbconn,"SELECT m.nama FROM antrian n
												INNER join segmen m on m.id = n.id_segmen 
												WHERE n.id_pasien='$r[id_pasien]' and n.id_unit = '$_SESSION[id_units]' "));
								$kategori=$b[nama];
								$nama_pasien=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_pasien WHERE id='$r[id_pasien]'"));
			

									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);
									if($id_status){
									$transaksi=pg_query($dbconn,"SELECT * FROM lab_order WHERE id_pasien='$r[id_pasien]'   AND id_transaksi_invoice_detail='$r[id]' AND status='$id_status' ORDER BY id ASC");
									
									
									}
									else{
										$transaksi=pg_query($dbconn,"SELECT * FROM lab_order WHERE id_pasien='$r[id_pasien]'   AND id_transaksi_invoice_detail='$r[id]' ORDER BY id ASC");			
									}

									
									?>

									
									<tr>
									<?php 
									while($row=pg_fetch_array($transaksi)){
										$status=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_status_laborder WHERE id='$row[status]'"));
										$harga = number_format($row['harga'],0,',','.');
										

									?>
									
									

									<td><?php echo $no++;?></td>
									<td><?php echo $row[id];?></td>
									<td > <b><?php echo $nama_pasien['nama']?><b></td>	
										
										
										<?php if($row['jenis']=='E'){
											
											$a=pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$row[id_detail]' order by d.id_detail ");

											echo '<td>';
												echo $jenis="MCU";
											echo '</td>';

											echo '<td>';
											$h=pg_fetch_assoc(pg_query($dbconn,"SELECT * FROM billing_paket  
															WHERE id='$row[id_detail]' "));
											$nama_transaksi=$h[nama_paket];
											echo $nama_transaksi;
											echo '<ul style="margin:0 auto">';
											while($row=pg_fetch_assoc($a)){
												?>

											<?php	
												
											if($row['jenis']=='L'){
												$l=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));
												 echo '<li>'.$l[nama].'</li>';	
												 									
												
											}
											elseif($row['jenis']=='LG'){
												$lg=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$row[id_detail]'"));
												 echo '<li>'.$lg[nama].'</li>';
												
											}
											else{
												$t=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$row[id_detail]'"));
												 echo '<li>'.$t[nama].'</li>';
																			
											}	
																							
											}
											echo '</ul>';
											echo '</td>';
											
										}
										
										elseif($row['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));
											echo '<td>';
												echo $jenis="Single Test";
											echo '</td>';
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';	
											
										}
										elseif($row['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$row[id_detail]'"));
											echo '<td>';
												echo $jenis="Multiple Test";
											echo '</td>';
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';
										}
										elseif($row['jenis']=='N'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$row[id_detail]'"));
											echo '<td>';
												echo $jenis="Non Laboratorium";
											echo '</td>';
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';
										}
										//$harga=formatRupiah3();
										?>
										<td><?php echo $kategori;?></td>
										<td><?php echo $status['nama'];?></td>
										<td>
										<a href="view-lab-order-<?php echo $row[id];?>" class="btn btn-primary btn-xs" title="View" data-toggle="tooltip" data-placement="top" title="View"><i class="icon-eye"></i></a>
										<?php 
										//LOCK MAINTENANCE
										if($row[status]==100){
										?>
										<a href="view-lab-hasil-<?php echo "$r[id]";?>" class="btn btn-info btn-xs" title="View Hasil Lab" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-hospital-o"></i></a>
										<?php }?>
										</td>
										</tr>
										
									<?php
								}?>
									
									
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
<?php
break;







case "cari":

	$id_rujuk=$_POST["id_rujuk"];
	$id_rujuk_ke=$_POST["id_rujuk_ke"];

?>




<?php
break;
case "view":


include "view.php";
break;
}
?>



	<script>
		$('#btnbatalviewLab').click(function()
		{
			document.location.href = "lab-order";

		});

		/*$('#btnCariLab').click(function()
		{
			var data = $('#dirujuk_o').serialize();

			alert(data);
			//document.location.href = "lab-order";

					$.ajax({
						type: 'POST',
						url: 'cari-lab-order',
						data: data,
						cache: false,
						success: function(msg){
							$("#form_tindakan").html(msg);
						}
					});			

		});*/
		$('#resetlaborder').click(function()
		{
			document.location.href = "lab-order";

		});

		</script>
