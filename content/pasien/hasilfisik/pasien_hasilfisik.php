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
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
<input type="hidden" name="no_rm" value="<?php echo $_POST[id];?>" id="no_rm">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<div id="data_labhasil">
	<div class="card">
		<div class="card-header">
			<strong>Data Resume</strong>
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
								<th>No RM</th>
								<th width="100px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT t.* from antrian t
									WHERE t.id_pasien='$id_pasien'");
						
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_masuk']);
									$tanggal_input=DateToIndo2($a[0]);

									?>
									<tr>
										<td><?php echo $tanggal_input;?></td>
										<td><?php echo $_REQUEST[id];?></td>
										<td>
											
											<button class="btn btn-info btn-xs btnViewLabhasil" id="<?php echo $r['id'];?>"><i class="icon-eye"></i></button>
											
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
	$(".btnViewLabhasil").click(function(){
		var id = this.id;
		var id_pasien=$("#id_pasien").val();
		var id_kunjungan=$("#id_kunjungan").val();
		var no_rm=$("#no_rm").val();

		var dataString2 = 'id_pasien='+id_pasien+'&id_antrian='+id+'&no_rm='+no_rm;
		$.ajax({
			type: 'POST',
			url: 'view-pasien-hasilfisik',
			data: dataString2,
			success: function(msg){
				$("#data_labhasil").html(msg);
			}
		});
		
	});
});
</script>