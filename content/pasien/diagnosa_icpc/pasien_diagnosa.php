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
<div id="data_diagnosa">
	<div class="card">
		<div class="card-header">
			<strong>Data Diagnosa Icpc</strong>
			<span class="pull-right">
				<?php
				if($id_kunjungan!=''){
					?>
					<button type="button" class="btn btn-primary btn-xs btnTambahDiagnosa">Tambah</button>
					<?php
				}
				else{
				?>
					<button type="button" class="btn btn-primary btn-xs btnTambahDiagnosa" disabled>Tambah</button>
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
								<th>Tanggal</th>							
								<th>Catatan</th>
								<th width="100px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php

								$tampil=pg_query($dbconn,"SELECT * FROM pasien_diagnosa_icpc pd
														WHERE  pd.status_hapus='N' and pd.id_pasien='$id_pasien' ");
								
								while($data=pg_fetch_array($tampil)){
									

									$a=pg_fetch_array(pg_query($dbconn,"SELECT a.detail_segmen, a.id_paket, b.keterangan FROM antrian a, segmen b WHERE a.id_segmen=b.id AND a.id_kunjungan='$data[id_kunjungan]'  AND a.status_aktif='Y'"));

									$nama_icd10=$a['nama'];
									$code= $a['code'];
																		
									?>
									<tr>
										<td><?php echo $data['tgl_diagnosa'];?></td>
										
										
										<td><?php echo $data['catatan'];?></td>
										
										<td>
											<button class="btn btn-primary btn-xs btnViewDiagnosa" 
											id="<?php echo $data['id'];?>" title="View">
											<i class="icon-eye"></i>
											</button>
											<button class="btn btn-info btn-xs btnHapusDiagnosa" id="<?php echo $data['id'];?>" title="Hapus"><i class="icon-trash"></i></button>
											
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
	
	$('.btnTambahDiagnosa').click(function()
	{
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var no_rm=$("#no_rm").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&no_rm='+no_rm;
		//alert("on");
		$.ajax({
			type: 'POST',
			url: 'content/pasien/diagnosa_icpc/tambah_diagnosa_icpc.php',
			data: dataString2,			
			success: function(msg){
				$("#data_diagnosa").html(msg);
			}
		});
		
	});
	
	$(".btnViewDiagnosa").click(function(){
		var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var no_rm=$("#no_rm").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id+'&no_rm='+no_rm;
		
		$.ajax({
			type: 'POST',
			url: 'content/pasien/diagnosa_icpc/view_diagnosa_icpc.php',
			data: dataString2,
			success: function(msg){
				$("#data_diagnosa").html(msg);
			}
		});
		
		
	});
	
	
	
	$(".btnHapusDiagnosa").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus diagnosa ini?")){
			var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var no_rm=$("#no_rm").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
			alert("hapus");
			$.ajax({
				type: 'POST',
				url: 'content/pasien/diagnosa_icpc/aksi_diagnosa_icpc.php?act=deletediagnosa',
				data: dataString2,
				success: function(msg){
						//alert("msg");
					$("#data_diagnosa").load("content/pasien/diagnosa_icpc/pasien_diagnosa.php?id="+no_rm);
				}
			});
		}
		else{
			return false;
		}
	});
});
</script>