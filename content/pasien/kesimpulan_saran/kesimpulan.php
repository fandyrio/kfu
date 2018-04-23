<?php
error_reporting(0);
session_start();
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";

if(isset($_GET[id])){
	$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_GET[id]'"));
}
else{
	$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_POST[id]'"));
}
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
		<strong>Kesimpulan dan saran</strong>
		<span class="pull-right">
			<?php
			if($id_kunjungan!=''){
			?>
			<button type="button" class="btn btn-primary btn-xs btnTambahAnamnesa" title="Tambah">Tambah</button>
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
							<th>Tanggal/Jam</th>
							<th>Kesimpulan</th>
							<th>Saran</th>
							<th width="80px">#</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$tampil=pg_query($dbconn,"SELECT * FROM pasien_kesimpulan WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND id_kunjungan='$id_kunjungan' ");
							$no=1;
							while($r=pg_fetch_array($tampil)){
								$tanggal=DateToIndo2($r[tanggal]);
								?>
								<tr>
									<td><?php echo "$tanggal";?></td>
									<td><textarea style="width: 100%"><?php echo $r[kesimpulan];?></textarea></td>
									<td><textarea style="width: 100%"><?php echo $r[saran];?></textarea></td>
									<td>
										<button type="button" class="btn btn-info btn-xs btnUpdateAnamnesa" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
										<button type="button" class="btn btn-danger btn-xs btnHapusKes" id="<?php echo $r['id'];?>"><i class="icon-trash" title="Hapus"></i></button>
									</td>
								</tr>
								<?php
								$no++;
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
	
	$('.btnTambahAnamnesa').click(function()
	{
		var no_rm=$("#no_rm").val();
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&no_rm='+no_rm;

		$.ajax({
			type: 'POST',
			url: 'content/pasien/kesimpulan_saran/aksi.php?act=view',
			data : dataString2,
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});
		
	});


	$('.btnUpdateAnamnesa').click(function()
	{
		var no_rm=$("#no_rm").val();
		var id = this.id;
		var dataString2 = 'no_rm='+no_rm+'&id='+id;
		
		$.ajax({
			type: 'POST',
			url: 'content/pasien/kesimpulan_saran/aksi.php?act=update',
			data : dataString2,
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});
		
	});

	
	
	$(".btnHapusKes").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus hasillab ini?")){
			var id_kes = this.id;
			var id =$("#no_rm").val(); 
			
			$.ajax({
				type: 'POST',
				url: 'content/pasien/kesimpulan_saran/aksi.php?act=hapus',
				data: {id_kes:id_kes},
				success: function(msg){
					$("#data_labhasil").load('content/pasien/kesimpulan_saran/kesimpulan.php?id='+id);
				}
			});
		}
		else{
			return false;
		}
	});
});
</script>