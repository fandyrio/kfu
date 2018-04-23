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
			<strong>Data Diagnosa</strong>
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
								<th>Tipe Diagnosa</th>
								<th width="100px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php

								$tampil=pg_query($dbconn,"SELECT * FROM pasien_diagnosa pd
														WHERE  pd.status_hapus='N' and pd.id_pasien='$id_pasien' ");
								
								while($data=pg_fetch_array($tampil)){
									

									$a=pg_fetch_array(pg_query($dbconn,"SELECT type_diagnosa FROM pasien_diagnosa_detail WHERE id_pasien_diagnosa='$data[id]'"));

									if($a['type_diagnosa']=='N'){
										$type='ICD10';
										
									}else{
										$type='ICPC';
										
									}
																		
									?>
									<tr>
										<td><?php echo $data['tgl_diagnosa'];?></td>
										
										
										<td><?php echo $data['catatan'];?></td>
										<td><?php echo $type;?></td>
										
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
		var no_rm=$("#no_rm").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&no_rm='+no_rm;
		//alert("on");
		$.ajax({
			type: 'POST',
			url: 'content/pasien/diagnosa/aksi_diagnosa_pasien.php?module=diagnosa&act=inputform',
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
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
		//alert(dataString2);
		$.ajax({
			type: 'POST',
			url: 'aksi-view-pasien-diagnosa',
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
		var id_kunjungan=$("#id_kunjungan").val();
		var dataString2 = 'id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&id='+id;
			
			alert("hapus");
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-diagnosa',
				data: dataString2,
				success: function(msg){
						//alert("msg");
					$("#data_diagnosa").html(msg);
				}
			});
		}
		else{
			return false;
		}
	});
});
</script>

