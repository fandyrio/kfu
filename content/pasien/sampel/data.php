<?php
session_start();
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

$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
$id_kunjungan=$a['id_kunjungan'];

?>
<input type="hidden" name="no_rm" value="<?php echo $_POST[id];?>" id="no_rm">
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<div class="card">
	<div class="card-header">
		<strong>Data Sampel</strong>
		<span class="pull-right">
			<?php
			if($id_kunjungan!=''){
			?>
			<button type="button" class="btn btn-primary btn-xs btnTambah" title="Tambah">Tambah</button>
			<?php
			}
			?>
		</span>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-md-12" id="data_sampel">
				
				<div class="padding-20">
					<table class="table">
						<thead>
							<tr>
								<th width="60px">Tanggal</th>
								<th width="150px">Kunjungan</th>
								<th width="100px">Nama Spesimen</th>
								<th>Catatan</th>
								<th width="90px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_sampel WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]'  ORDER BY id  DESC");
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);									
									
									
									$ar=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM lab_specimen where id='$r[id_specimen]'"));
									
									$nama_kode=$a['code'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT a.detail_segmen, a.id_paket, b.keterangan FROM antrian a, segmen b WHERE a.id_segmen=b.id AND a.id_kunjungan='$r[id_kunjungan]' AND a.status_aktif='Y'"));
									if($a['id_paket']!=''){
										$b=pg_fetch_array(pg_query($dbconn,"SELECT nama_paket FROM billing_paket WHERE id='$a[id_paket]'"));
										$kunjungan="$a[keterangan]-$b[nama_paket]";
									}
									else{
										if($a['detail_segmen']!=''){
											$kunjungan="$a[keterangan]-$a[detail_segmen]";
										}
										else{
											$kunjungan="$a[keterangan]";
										}
									}
									?>
									<tr>
										<td><?php echo $tanggal_input;?></td>
										<td><?php echo $kunjungan;?></td>
										<td><?php echo $ar['nama'];?></td>
										<td><?php echo $r['catatan'];?></td>
										<td>
											
											<a href="content/pasien/sampel/cetak_sampel_pasien.php?no_rm=<?php echo $_POST[id].'&kunjungan='.$id_kunjungan.'&tipe='.$ar[nama];?>" class="btn btn-secondary btn-xs" title="Cetak Label Sampel" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-print"></i></a>
											
											<button type="button" class="btn btn-danger btn-xs btnHapusSampel" id="<?php echo $r['id'];?>" title="Hapus"><i class="icon-trash"></i></button>
										</td>
									</tr>
									<?php
								}
							?>
						</tbody>
					</table>
				</div>
				<br>
				
			</div>
		</div>
	</div>
</div>

<?php
	pg_close($dbconn);
?>

<script type="text/javascript">
$(function () {
	
	
	$('.btnTambah').click(function()
	{
		var no_rm=$("#no_rm").val();
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&no_rm='+no_rm;

		$.ajax({
			type: 'POST',
			url: 'content/pasien/sampel/aksi.php?act=add',
			data : dataString2,
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});
		
	});
	
	
	
	
	$(".btnHapusSampel").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus perhatian ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var rm =$("#no_rm").val(); 
			var dataString2 = 'id_pasien='+id_pasien;
			
			$.ajax({
				type: 'POST',
				url: 'content/pasien/sampel/aksi.php?act=hapus',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_pasien").load('content/pasien/sampel/data.php?id='+rm);
				}
			});
			
			
		}
		else{
			return false;
		}
	});
});

$(document).ready(function(){
	$('.js-example-basic-single').select2();
});
</script>