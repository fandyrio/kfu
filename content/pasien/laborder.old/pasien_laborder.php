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
$c=pg_fetch_array(pg_query($dbconn,"SELECT id FROM kunjungan WHERE id_pasien='$id_pasien' AND status_kunjungan='Y' AND id_unit='$_SESSION[id_units]'"));
$id_kunjungan=$c['id'];
?>
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<div id="data_laborder">
	<div class="card">
		<div class="card-header">
			<strong>Data Lab Order </strong>
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
								<th width="60px">Tanggal</th>
								<th width="100px">No. Referensi</th>
								<th>Dirujuk Oleh</th>
								<th>Dibalas Ke</th>
								<th>Prioritas</th>
								<th>Catatan</th>
								<th width="100px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_laborder WHERE id_pasien='$id_pasien' AND status_hapus='N' AND status_jawab='N' AND id_unit='$_SESSION[id_units]' ORDER BY id DESC");
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_laborder_priority WHERE id='$r[id_priority]'"));
									$nama_prioritas=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_refered_by]'"));
									$dirujuk_oleh=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_reply_to]' "));
									$dibalas_oleh=$a['nama'];
									?>
									<tr>
										<td><?php echo $tanggal_input;?></td>
										<td><?php echo $r['no_referensi'];?></td>
										<td><?php echo $dirujuk_oleh;?></td>
										<td><?php echo $dibalas_oleh;?></td>
										<td><?php echo $nama_prioritas;?></td>
										<td><?php echo $r['catatan'];?></td>
										<td>
											<button class="btn btn-primary btn-xs btnViewLaborder" id="<?php echo $r['id'];?>" title="View"><i class="icon-eye"></i></button>
											<button class="btn btn-info btn-xs btnEditLaborder" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
											<?php
												if($r['status_billing']=='N'){
												?>
												<button class="btn btn-danger btn-xs btnHapusLaborder" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
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
	
	$('.btnTambahLaborder').click(function()
	{
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-laborder',
			data: dataString2,
			cache: false,
			success: function(msg){
				$("#data_laborder").html(msg);
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
			url: 'view-pasien-laborder',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_laborder").html(msg);
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