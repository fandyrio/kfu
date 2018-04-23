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

$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
$id_kunjungan=$a['id_kunjungan'];

?>
<input type="hidden" name="id" value="<?php echo $id_pasien;?>" id="id_pasien">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<div class="card">
	<div class="card-header">
		<strong>Perhatian</strong>
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
			<div class="col-md-12" id="data_perhatian">
				<p class="title-dark">Current</p>
				<div class="padding-20">
					<table class="table">
						<thead>
							<tr>
								<th width="60px">Tanggal</th>
								<th width="150px">Kunjungan</th>
								<th width="100px">Kategori</th>
								<th width="150px">Teks</th>
								<th width="80px">ATC Code</th>
								<th>Catatan</th>
								<th width="90px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_perhatian WHERE id_pasien='$id_pasien' AND status_aktif='Y' AND status_hapus='N' ORDER BY id DESC");
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_perhatian_kategori WHERE id='$r[id_kategori_perhatian]'"));
									$nama_kategori_perhatian=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_tbl_atccode WHERE id='$r[id_kode_atc]'"));
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
										<td><?php echo $nama_kategori_perhatian;?></td>
										<td><?php echo $r['judul'];?></td>
										<td><?php echo $nama_kode;?></td>
										<td><?php echo $r['catatan'];?></td>
										<td>
											<button type="button" class="btn btn-info btn-xs btnEditPerhatian" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
											<button type="button" class="btn btn-warning btn-xs btnStopPerhatian" id="<?php echo $r['id'];?>" title="Stop"><i class="icon-ban"></i></button>
											<button type="button" class="btn btn-danger btn-xs btnHapusPerhatian" id="<?php echo $r['id'];?>" title="Hapus"><i class="icon-trash"></i></button>
										</td>
									</tr>
									<?php
								}
							?>
						</tbody>
					</table>
				</div>
				<br>
				<p class="title-dark">Discontinued</p>
				<div class="padding-20">
					<table class="table">
						<thead>
							<tr>
								<th width="60px">Tanggal</th>
								<th width="150px">Kunjungan</th>
								<th width="100px">Kategori</th>
								<th width="150px">Teks</th>
								<th width="80px">ATC Code</th>
								<th>Catatan</th>
								<th width="90px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_perhatian WHERE id_pasien='$id_pasien' AND status_aktif='N' AND status_hapus='N' ORDER BY id DESC");
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_perhatian_kategori WHERE id='$r[id_kategori_perhatian]'"));
									$nama_kategori_perhatian=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_tbl_atccode WHERE id='$r[id_kode_atc]'"));
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
										<td><?php echo $nama_kategori_perhatian;?></td>
										<td><?php echo $r['judul'];?></td>
										<td><?php echo $nama_kode;?></td>
										<td><?php echo $r['catatan'];?></td>
										<td>
											<button type="button" class="btn btn-danger btn-xs btnHapusPerhatian" id="<?php echo $r['id'];?>" title="Hapus"><i class="icon-trash"></i></button>
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
	$("#id_kategori_perhatian").change(function(){
		var id_kategori_perhatian=$(this).val();
		if(id_kategori_perhatian==1){
			$('#id_kode_atc').prop('disabled', false);
		}
		else{
			$('#id_kode_atc').prop('disabled', true);
		}
	});
	
	$(".btnTambah").click(function(){
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-perhatian',
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});
	});
	
	
	
	$(".btnEditPerhatian").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'form-edit-pasien-perhatian',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});
		
	});
	
	$(".btnStopPerhatian").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menonaktifkan perhatian ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var dataString2 = 'id_pasien='+id_pasien;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-stop-pasien-perhatian',
				data: { 
					'id': id
				},
				success: function(msg){
					//$("#data_perhatian").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'data-pasien-perhatian',
				data: dataString2,
				cache: false,
				success: function(msg){
					$("#data_perhatian").html(msg);
					alert("Perhatian berhasil dinonaktifkan");
				}
			});
		}
		else{
			return false;
		}
	});
	
	$(".btnHapusPerhatian").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus perhatian ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var dataString2 = 'id_pasien='+id_pasien;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-perhatian',
				data: { 
					'id': id
				},
				success: function(msg){
					//$("#data_perhatian").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'data-pasien-perhatian',
				data: dataString2,
				cache: false,
				success: function(msg){
					$("#data_perhatian").html(msg);
					alert("Perhatian berhasil dihapus");
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