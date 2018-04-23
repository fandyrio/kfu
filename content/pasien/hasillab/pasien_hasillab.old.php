<?php
error_reporting(0);
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
$c=pg_fetch_array(pg_query($dbconn,"SELECT id FROM kunjungan WHERE id_pasien='$id_pasien' AND status_kunjungan='Y'"));
$id_kunjungan=$c['id'];
?>
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
								<th width="60px">Tanggal</th>
								<th width="100px">No. Referensi</th>
								<th>Dirujuk Oleh</th>
								<th>Dibalas Ke</th>
								<th>Prioritas</th>
								<th>Status</th>
								<th width="100px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT t.* from transaksi_invoice_detail t
									INNER JOIN pasien_order p on p.id=t.id_pasien_order and p.id_pasien=t.id_pasien
									WHERE p.id_pasien='$id_pasien' and t.id_pasien='$id_pasien'");

								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_laborder_priority WHERE id='$r[id_priority]'"));
									
									$nama_prioritas=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_refered_by]'"));
									$dirujuk_oleh=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_reply_to]'"));;
									$dibalas_oleh=$a['nama'];
									
									if($r['status_jawab']=='N'){
										$status="<button class='btn btn-xs btn-warning'>-</button>";
									}
									else{
										$status="<button class='btn btn-xs btn-success'><i class='icon-check'></i></button>";
									}
									?>
									<tr>
										<td><?php echo $tanggal_input;?></td>
										<td><?php echo $r['no_referensi'];?></td>
										<td><?php echo $dirujuk_oleh;?></td>
										<td><?php echo $dibalas_oleh;?></td>
										<td><?php echo $nama_prioritas;?></td>
										<td><?php echo $status;?></td>
										<td>
											<button class="btn btn-primary btn-xs btnEditLabhasil" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
											<button class="btn btn-info btn-xs btnViewLabhasil" id="<?php echo $r['id'];?>"><i class="icon-eye"></i></button>
											<?php
												if($r['status_billing']=='N'){
												?>
												<button class="btn btn-danger btn-xs btnHapusLabhasil" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
												<?php
												}
											?>
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
		alert("woi");
		var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
		$.ajax({
			type: 'POST',
			url: 'edit-pasien-hasillab',
			data: dataString2
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