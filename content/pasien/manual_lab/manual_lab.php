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

$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
$id_kunjungan=$a['id_kunjungan'];

?>
<input type="hidden" name="id" value="<?php echo $id_pasien;?>" id="id_pasien">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<input type="hidden" name="rm" value="<?php echo $_REQUEST[id];?>" id="rm">
<div class="card">
	<div class="card-header">
		<strong>HASIL LAB</strong>
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
				<div class="padding-20">
					<table class="table">
						<thead>
							<tr>
								<th width="100px">Tanggal</th>
								<th width="100px">Nama Tindakan</th>
								<th width="150px">Hasil</th>
								<th width="150px">Nilai Normal</th>
								<th width="150px">High Marks</th>
								<th width="90px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_manual_lab WHERE id_pasien='$id_pasien'ORDER BY id DESC");
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['tgl_input']);
									$tanggal_input=DateToIndo2($a[0]);
									
									
									?>
									<tr>
										<td><?php echo $tanggal_input." ".$a[1];?></td>
										<td><?php echo $r['nama_tindakan'];?></td>
										<td><?php echo $r['hasil'];?></td>
										<td><?php echo $r['nilai_normal'];?></td>
										<td><?php echo $r['high_mark'];?></td>
										<td>
											<button type="button" class="btn btn-info btn-xs btnEditLab" id="<?php echo $r['id'];?>" title="Edit"><i class="icon-note"></i></button>
											<button type="button" class="btn btn-danger btn-xs btnHapus" id="<?php echo $r['id'];?>" title="Hapus"><i class="icon-trash"></i></button>
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
		var rm=$("#rm").val();
		var data ='id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&rm='+rm;
		$.ajax({
			type: 'POST',
			data: data,
			url: 'content/pasien/manual_lab/tambah.php',
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});
	});
	
	
	
	$(".btnEditLab").click(function(){
		var id = this.id;
		var rm=$("#rm").val();
		$.ajax({
			type: 'POST',
			url: 'content/pasien/manual_lab/update.php',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});
		
	});
	
	
	
	$(".btnHapus").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus perhatian ini?")){
			var id = this.id;
			var rm=$("#rm").val();
			
			
			$.ajax({
				type: 'POST',
				url: 'content/pasien/manual_lab/hapus.php',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_pasien").load('content/pasien/manual_lab/manual_lab.php?id='+rm);
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