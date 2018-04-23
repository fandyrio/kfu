<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_POST[id]'"));

if($d['jenkel']==1){
	$jenkel="<i class='icon-symbol-male'></i>";
}
else{
	$jenkel="<i class='icon-symbol-female'></i>";
}

if($d['foto']!=''){
	$foto="images/pasien/upload_$d[foto]";
}
else{
	$foto="images/default.png";
}

$id_pasien=$d['id'];
$id_kategori_harga=$d['id_perusahaan'];
$c=pg_fetch_array(pg_query($dbconn,"SELECT id FROM kunjungan WHERE id_pasien='$id_pasien' AND status_kunjungan='Y' AND id_unit='$_SESSION[id_units]'"));

$id_kunjungan=$c['id'];
?>

<input type="hidden" name="rm" value="<?php echo $_POST[rm];?>" id="rm">
<div id="data_order">
	<div class="card">
		<div class="card-header">
			<strong> Detail Pemesanan Pemeriksaan </strong>
			<span class="pull-right">
			<button type="button" class="btn btn-info btn-xs btnbackLaborder">Back</button>
					
			</span>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead class="table-info">
							<tr>
								<th width="60px">Tanggal</th>
								<th width="100px">Total</th>
								<th>Catatan</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_order WHERE id='$_POST[id]'");

								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);
									?>
									<tr>
										<td><?php echo $tanggal_input;?></td>
										<td><?php echo number_format($r['total'],0,',','.');?></td>
										<td><?php echo $r['catatan'];?></td>
										
										
									</tr>
									<?php
								}
							?>
						</tbody>
					</table>
					<table class="table table-bordered">
								<thead>
									<tr>
										<th width="50px" class="text-center">No.</th>
										<th width="100px" class="text-center">Tanggal</th>
										<th class="text-center">Jenis Pemeriksaan</th>
										<th class="text-center">Detail</th>
										<th class="text-center">Kunjungan</th>
										<th class="text-center">Qty</th>
										<th width="100px" class="text-center">Harga</th>
										<th class="text-center">Sub Total</th>
										<th class="text-center">Catatan</th>
										<th class="text-center" width="60px">#</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND status_aktif='Y' AND status_hapus='N' ORDER BY id ASC");
									
									$no=1;
									$total=0;
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal=DateToIndo2($a[0]);
										$jam=$a[1];
										?>

										<tr>
											<td><?php echo $no;?></td>
											<td><?php echo "$tanggal";?></td>
											
										<?php
										
										$b=pg_fetch_array(pg_query($dbconn,"SELECT m.nama FROM antrian n
												INNER join segmen m on m.id = n.id_segmen 
												WHERE n.id_pasien='$r[id_pasien]' and n.id_unit = '$_SESSION[id_units]' "));
										$kategori="$b[nama]";

										if($r['jenis']=='E'){
											
											$a=pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$r[id_detail]' order by d.id_detail ");

											echo '<td>';
												echo $jenis="MCU";
											echo '</td>';

											echo '<td>';
											$h=pg_fetch_assoc(pg_query($dbconn,"SELECT * FROM billing_paket  
															WHERE id='$r[id_detail]' "));
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
												$lg=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$r[id_detail]'"));
												 echo '<li>'.$lg[nama].'</li>';
												
											}
											else{
												$t=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_detail]'"));
												 echo '<li>'.$t[nama].'</li>';
																			
											}	
																							
											}
											echo '</ul>';
											echo '</td>';
											
										}
										
										if($r['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$r[id_detail]'"));
											echo '<td>';
												echo $jenis="Single Test";
											echo '</td>';
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';	
											
										}
										elseif($r['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$r[id_detail]'"));
											echo '<td>';
												echo $jenis="Multiple Test";
											echo '</td>';
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';
										}
										elseif($r['jenis']=='N'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_detail]'"));
											echo '<td>';
												echo $jenis="Non Laboratorium";
											echo '</td>';
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';
										}
						
										
										$harga=formatRupiah3($r['harga']);
										$disc_amount=formatRupiah3($r['disc_amount']);
										
										$subtotal=$r['harga']*$r['kuantitas'];
										$total+=$subtotal;
										$subtotal=formatRupiah3($subtotal);
										
									
										
										
										?>
										
											
											<td><?php echo $kategori;?></td>
											<td class="text-right"><?php echo $r['kuantitas'];?></td>
											<td class="text-right"><?php echo $harga;?></td>
											<td class="text-right"><?php echo $subtotal;?></td>
											<td><?php echo $catatan;?></td>
											<td>
											<a href="#" class="btn btn-primary btn-xs btnEditBilling" title="Edit" data-toggle="tooltip" data-placement="top" id="<?php echo $r['id'];?>"><i class="icon-note"></i></a>
											<a href="hapus-transaksi-invoice-detail-<?php echo "$r[id]";?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>
											</td>
										</tr>
										<?php
										$no++;
									}
									$total2=formatRupiah3($total);
									?>
								</tbody>
							</table>

				</div>
			</div>
		</div>
	</div>
</div>

<?php
	pg_close($dbconn);
?>

<script type="text/javascript">
$(function () {
	
	$('.btnTambahLaborder').click(function()
	{
		//alert("test");
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val(); 
		var id_kategori_harga=$("#id_kategori_harga").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_kategori_harga='+id_kategori_harga;
		$.ajax({
			type: 'POST',
			url: 'media.php?ajax=FTAMBAH__ORDER',
			data: dataString2,
			cache: false,
			success: function(msg){
				//alert(msg);
				$("#data_order").html(msg);
			}
		});
		
	});
	
	$(".btnViewLaborder").click(function(){
		
		var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
		$.ajax({
			type: 'POST',
			url: 'media.php?ajax=VIEW__ORDER',
			data: dataString2,
			success: function(msg){
			$("#data_order").html(msg);
			
			}
		});
		
		
	});
	
	$(".btnEditLaborder").click(function(){
		var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
		$.ajax({
			type: 'POST',
			url: 'edit-pasien-laborder',
			data: dataString2,
			success: function(msg){
				$("#data_laborder").html(msg);
			}
		});
		
	});
	
	$(".btnHapusLaborder").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus laborder ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-laborder',
				data: dataString2,
				success: function(msg){
					$("#data_laborder").html(msg);
				}
			});
		}
		else{
			return false;
		}
	});
});
</script>