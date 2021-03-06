<?php
error_reporting(0);
session_start();

include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";
include "../../../config/library.php";

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
<div class="card" id="data_rektal">
	<div class="card-header">
		<strong>Pemeriksaan Rektal</strong>
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
			<div class="col-md-12">
				<p class="title-dark">Data</p>
				<table class="table table-bordered">
					<thead class="text-center">
						<tr>
							<th rowspan="2" width="30px">No.</th>
							<th rowspan="2" width="140px">Tanggal/Jam</th>
							<th rowspan="2">Kunjungan</th>
							<th colspan="2">Haemorrhoid</th>
							<th colspan="2">Anus/Rectum/Parianal</th>
							<th rowspan="2">Keterangan</th>
							<th rowspan="2" width="80px">#</th>
						</tr>
						<tr>
							<th>Hasil</th>
							<th>Keterangan</th>
							<th>Hasil</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$tampil=pg_query($dbconn,"SELECT * FROM pasien_rektal WHERE id_pasien='$id_pasien' AND id_unit='$_SESSION[id_units]' AND status_hapus='N' ORDER BY id DESC");
							
							$no=1;
							while($r=pg_fetch_array($tampil)){
								$a=explode(" ",$r['waktu_input']);
								$tanggal=DateToIndo2($a[0]);
								$jam=$a[1];
								
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
								
								if($r['rektal1_hasil']==1){
									$rektal1_hasil="Normal";
								}
								else{
									$rektal1_hasil="Tidak Normal";
								}
								
								if($r['rektal1_hasil']==1){
									$rektal2_hasil="Normal";
								}
								else{
									$rektal2_hasil="Tidak Normal";
								}
								
								
								?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo "$tanggal/$jam";?></td>
									<td><?php echo $kunjungan;?></td>
									<td><?php echo $rektal1_hasil;?></td>
									<td><?php echo $r['rektal1_keterangan'];?></td>
									<td><?php echo $rektal2_hasil;?></td>
									<td><?php echo $r['rektal2_keterangan'];?></td>
									<td><?php echo $r['keterangan'];?></td>
									<td>
										<button type="button" class="btn btn-info btn-xs btnEdit" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
										<button type="button" class="btn btn-danger btn-xs btnHapus" id="<?php echo $r['id'];?>"><i class="icon-trash" title="Hapus"></i></button>
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
<?php
	pg_close($dbconn);
?>

<script type="text/javascript">
$(function () {
	$(".btnTambah").click(function(){
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan;
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-rektal',
			data: dataString2,
			success: function(msg){
				$("#data_rektal").html(msg);
			}
		});
	});
	
	$(".btnEdit").click(function(){
		var id = this.id;
		var id_kunjungan=$("#id_kunjungan").val();
		$.ajax({
			type: 'POST',
			url: 'form-edit-pasien-rektal',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_rektal").html(msg);
			}
		});
	});
	
	$(".btnHapus").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus rektal ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var dataString2 = 'id_pasien='+id_pasien;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-rektal',
				data: { 
					'id': id
				},
				success: function(msg){
					//$("#data_rektal").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'data-pasien-rektal',
				data: dataString2,
				cache: false,
				success: function(msg){
					$("#data_rektal").html(msg);
					alert("rektal berhasil dihapus");
				}
			});
		}
		else{
			return false;
		}
	});
});
</script>