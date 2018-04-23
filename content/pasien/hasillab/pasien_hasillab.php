<?php
error_reporting(0);
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
$c=pg_fetch_array(pg_query($dbconn,"SELECT id FROM kunjungan WHERE id_pasien='$id_pasien' AND status_kunjungan='Y'"));
$id_kunjungan=$c['id'];
?>
<input type="hidden" name="no_rm" value="<?php echo $_POST[id];?>" id="no_rm">
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<div id="data_labhasil">
	<div class="card">
		<div class="card-header">
			<strong>Data Hasil Lab</strong>
			<span class="pull-right">
			</span>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Jenis Pemeriksaan</th>
								<th>Detail</th>
								<th>No RM</th>
								<th>qty</th>
								<th width="100px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT t.* from transaksi_invoice_detail t
									WHERE  t.id_pasien='$id_pasien' and t.id_kunjungan='$id_kunjungan' and t.jenis <>'N'");
						
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);

									 if($r['jenis']=='E'){
											
											$a=pg_fetch_array(pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$r[id_detail]' order by d.id_detail "));
											$jenis="MCU";
											$nama_transaksi=$a[nama_paket];										
											
										}
										
										if($r['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$r[id_detail]'"));
											$jenis= "SINGLE TEST";								
											$nama_transaksi=$a[nama];
											
											
										}
										if($r['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$r[id_detail]'"));
											$jenis="Multiple Test";
											$nama_transaksi=$a[nama];
											
										}
								
									?>
									<tr>
										<td><?php echo $tanggal_input;?></td>
										<td><?php echo $jenis; ?></td>
										<td><?php echo $nama_transaksi;?></td>
										<td><?php echo $_REQUEST[id];?></td>
										<td><?php echo $r[kuantitas];?></td>
										<td>
											<button class="btn btn-primary btn-xs btnEditLabhasil" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
											<a href="content/pasien/hasillab/print_hasil_lab.php?id=<?php echo "$r[id]";?>" target="_blank" class="btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i> </a>
											
										</td>
									</tr>
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
<?php
	pg_close($dbconn);
?>

<script type="text/javascript">
$(function () {
	
	$('.btnEditLabhasil').click(function()
	{
		var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var no_rm=$("#no_rm").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id+'&no_rm='+no_rm;
	
		$.ajax({
			type: 'POST',
			url: 'content/pasien/hasillab/aksi_hasillab_pasien.php?module=hasillab&act=edit',
			data: dataString2,
			
			success: function(msg){
				$("#data_labhasil").html(msg);
			}
		});
		
	});
	
	$(".btnViewLabhasil").click(function(){
		var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
		$.ajax({
			type: 'POST',
			url: 'view-pasien-hasillab',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_labhasil").html(msg);
			}
		});
		
	});
	
	
	$(".btnHapusLabhasil").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus hasillab ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var id_kunjungan=$("#id_kunjungan").val();
			var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-hasil',
				data: dataString2,
				success: function(msg){
					$("#data_labhasil").html(msg);
				}
			});
		}
		else{
			return false;
		}
	});
});
</script>