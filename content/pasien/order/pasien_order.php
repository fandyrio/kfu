<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_REQUEST[id]'"));

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
$q=pg_fetch_array(pg_query($dbconn,"SELECT id_kategori_harga FROM antrian WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]'"));
$id_kategori_harga=$q['id_kategori_harga'];

$c=pg_fetch_array(pg_query($dbconn,"SELECT id FROM kunjungan WHERE id_pasien='$id_pasien' AND status_kunjungan='Y' AND id_unit='$_SESSION[id_units]' order by id desc"));

$id_kunjungan=$c['id'];
?>
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien"> 	
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<input type="hidden" name="id_kategori_harga" value="<?php echo $id_kategori_harga;?>" id="id_kategori_harga">
<input type="hidden" name="rm" value="<?php echo $_POST[id];?>" id="rm">
<div id="data_order">
	<div class="card">
		<div class="card-header">
			<strong>Data Pemesanan Pemeriksaan</strong>
			<span class="pull-right">
				<?php
				if($id_kunjungan!=''){
					?>
					<button type="button" class="btn btn-primary btn-xs btnTambahLaborder">Tambah</button>
					<?php
				}
				else{
				?>
					<button type="button" class="btn btn-primary btn-xs btnTambahLaborder" disabled>Tambah</button>
				<?php
				}
				?>
			</span>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead>
							<tr>
								
								<th>No Transaksi</th>
								<th >Tindakan</th>
								<th width="100px" style="display:none;">Harga</th>
								
								<th width="100px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								/*$b=pg_fetch_array(pg_query($dbconn,"SELECT m.nama FROM antrian n
												INNER join segmen m on m.id = n.id_segmen 
												WHERE n.id_pasien='$id_pasien' and n.id_unit = '$_SESSION[id_units]' "));
								$kategori="$b[nama]";*/

								$inv_dq=pg_query($dbconn,"SELECT DISTINCT t.id, t.no_invoice from  transaksi_invoice t
									where  exists (select null from transaksi_invoice_detail i where i.id_invoice=t.id) 
												and t.id_pasien='$id_pasien' order by t.no_invoice desc");	
							
								while (	$inv_d=pg_fetch_array($inv_dq)){
								$no=1;
								$a=explode(" ",$inv_d['waktu_input']);
								$tanggal_input=DateToIndo2($a[0]);
								$transaksi=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_pasien='$id_pasien'  AND status_aktif='Y' AND status_hapus='N' AND jenis <> 'O' AND id_invoice='$inv_d[id]' ORDER BY id ASC");
							
								
									?>
									<tr>
										<td colspan="6"><?php echo "$inv_d[no_invoice]";?></td>
										
									</tr>
									<?php 

									while($row=pg_fetch_array($transaksi)){

										$id_invoice = $row[id];
										$inv_d = $row[id_invoice];
										$total_h = $row['harga'];
										$harga = number_format($row['harga'],0,',','.');

									?>
									<tr>
									<td></td>
									
										
										
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
										
										if($row['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));
											
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';	
											
										}
										elseif($row['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$row[id_detail]'"));
											
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';
										}
										elseif($row['jenis']=='N'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$row[id_detail]'"));
											
											echo '<td>';
												echo $nama_transaksi="$a[nama]";
											echo '</td>';
										}
										//$harga=formatRupiah3();
										?>
										
										<td style="display:none;"><?php echo $harga;?></td>										
										<td><button class="btn btn-info btn-xs btnEditLaborder"  id="<?php echo $id_invoice;?>" title="Edit"><i class="icon-note"></i></button>
											<button class="btn btn-danger btn-xs btnHapusPasienorder" inv="<?php echo $inv_d ?>" hrg="<?php echo $total_h ?>" id="<?php echo $id_invoice;?>"><i class="icon-trash"></i></button></td>
										</tr>
										
									<?php
								}
							}
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
		var rm=$("#rm").val();
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val(); 
		var id_kategori_harga=$("#id_kategori_harga").val();
		var dataString2 = 'rm='+rm+ '&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_kategori_harga='+id_kategori_harga;
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
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id+'&rm='+rm;
		$.ajax({
			type: 'POST',
			url: 'content/pasien/order/view_order.php',
			data: dataString2,
			success: function(msg){
			$("#data_order").html(msg);
			
			}
		});
		
		
	});
	
	$(".btnEditLaborder").click(function(){
		var id = this.id;
		var rm=$("#rm").val();
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val(); 
		var id_kategori_harga=$("#id_kategori_harga").val();
		var dataString2 = 'id='+id+'&id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id_kategori_harga='+id_kategori_harga+'&rm='+rm;
		$.ajax({
			type: 'POST',
			url: 'media.php?ajax=EDIT__ORDER',
			data: dataString2,
			cache: false,
			success: function(msg){
				//alert(msg);
				$("#data_order").html(msg);
			}
		});
		
	});
	
	$(".btnHapusPasienorder").click(function(){

		if(window.confirm("Apakah Anda yakin ingin menghapus laborder ini?")){
		//	alert("hapus");
			var id = this.id;
			var harga = $(this).attr('hrg');
			var id_i = $(this).attr('inv');
			var rm=$("#rm").val();
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString2 ='id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id+'&harga='+harga+'&inv='+id_i;	
			
			$.ajax({
				type: 'POST',
				url: 'media.php?ajax=HAPUS__ORDER',
				data: dataString2,
				success: function(msg){
					 
					$("#data_order").load('content/pasien/order/pasien_order.php?id='+rm);
				}
			});
			
		}
		else{
			return false;
		}
	});
});
</script>