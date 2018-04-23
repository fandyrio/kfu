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
?>
<input type="hidden" name="id" value="<?php echo $id_pasien;?>" id="id_pasien">
<div class="card">
	<div class="card-header">
		<strong>Peringatan</strong>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-md-8" id="data_peringatan">
				<fieldset>
					<legend>Data</legend>
					<p class="title-dark">Current</p>
					<div class="padding-20">
						<table class="table">
							<thead>
								<tr>
									<th width="60px">Tanggal</th>
									<th width="150px">Teks</th>
									<th width="80px">ATC Code</th>
									<th>Catatan</th>
									<th width="100px">#</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$tampil=pg_query($dbconn,"SELECT * FROM pasien_peringatan WHERE id_pasien='$id_pasien' AND status_aktif='Y' AND status_hapus='N' ORDER BY id DESC");
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal_input=DateToIndo2($a[0]);
										
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_tbl_atccode WHERE id='$r[id_kode_atc]'"));
										$nama_kode=$a['code'];
										?>
										<tr>
											<td><?php echo $tanggal_input;?></td>
											<td><?php echo $r['judul'];?></td>
											<td><?php echo $nama_kode;?></td>
											<td><?php echo $r['catatan'];?></td>
											<td>
												<button class="btn btn-info btn-xs btnEditPeringatan" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
												<button class="btn btn-warning btn-xs btnStopPeringatan" id="<?php echo $r['id'];?>"><i class="icon-ban"></i></button>
												<button class="btn btn-danger btn-xs btnHapusPeringatan" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
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
									<th width="150px">Teks</th>
									<th width="80px">ATC Code</th>
									<th>Catatan</th>
									<th width="100px">#</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$tampil=pg_query($dbconn,"SELECT * FROM pasien_peringatan WHERE id_pasien='$id_pasien' AND status_aktif='N' AND status_hapus='N' ORDER BY id DESC");
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal_input=DateToIndo2($a[0]);
										
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_tbl_atccode WHERE id='$r[id_kode_atc]'"));
										$nama_kode=$a['code'];
										?>
										<tr>
											<td><?php echo $tanggal_input;?></td>
											<td><?php echo $r['judul'];?></td>
											<td><?php echo $nama_kode;?></td>
											<td><?php echo $r['catatan'];?></td>
											<td>
												<button class="btn btn-danger btn-xs btnHapusPeringatan" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
											</td>
										</tr>
										<?php
									}
								?>
							</tbody>
						</table>
					</div>
				</fieldset>
			</div>
			
			<div class="col-md-4" id="form_peringatan">
				<fieldset>
					<legend>Tambah</legend>
					<form class="form" action="#" method="POST">
						
						<div class="form-group">
							<label>Teks</label>
							<input type="text" name="judul" id="judul" class="form-control" required>
						</div>
						
						<div class="form-group">
							<label>ATC Code</label>
							<select class="js-example-basic-single form-control" name="id_kode_atc" id="id_kode_atc">
								<?php
								$tampil=pg_query($dbconn,"SELECT * FROM master_tbl_atccode ORDER BY id");
								while($r=pg_fetch_array($tampil)){
									echo"<option value='$r[id]'>$r[code] - $r[deskripsi]</option>";
								}
								?>
							</select>
						</div>
						
						<div class="form-group">
							<label>Catatan</label>
							<textarea name="catatan" id="catatan" class="form-control"></textarea>
						</div>
						<button type="button" class="btn btn-primary btn-sm" id="btnSimpanPeringatan">Simpan</button>
					</form>
				</fieldset>
			</div>
		</div>
	</div>
</div>

<?php
	pg_close($dbconn);
?>

<script type="text/javascript">
$(function () {
	
	
	$('#btnSimpanPeringatan').click(function()
	{
		var id_pasien=$("#id_pasien").val();
		var judul=$("#judul").val();
		var id_kode_atc=$("#id_kode_atc").val();
		var catatan=$("#catatan").val();
		var dataString = 'id_pasien='+id_pasien+'&judul='+judul+'&id_kode_atc='+id_kode_atc+'&catatan='+catatan;
		
		var dataString2 = 'id_pasien='+id_pasien;
		
		$.ajax({
			type: "POST",
			url: "aksi-tambah-pasien-peringatan",
			data: dataString,
			cache: false,
			beforeSend: function(){ $("#btnSimpanPeringatan").val('Submitting...');},
			success: function(data){
				$("#data_peringatan").html(data);
			}
		});
		
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-peringatan',
			data: dataString2,
			cache: false,
			success: function(msg){
				$("#form_peringatan").html(msg);
			}
		});
		
		$.ajax({
			type: 'POST',
			url: 'action-button',
			cache: false,
			success: function(msg){
				$("#action_button").html(msg);
			}
		});
	});
	
	$(".btnEditPeringatan").click(function(){
		var id = this.id;
		
		$.ajax({
			type: 'POST',
			url: 'edit-pasien-peringatan',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form_peringatan").html(msg);
			}
		});
		
	});
	
	$(".btnStopPeringatan").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menonaktifkan peringatan ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var dataString2 = 'id_pasien='+id_pasien;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-stop-pasien-peringatan',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_peringatan").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-peringatan',
				data: dataString2,
				cache: false,
				success: function(msg){
					$("#form_peringatan").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'action-button',
				data: dataString2,
				cache: false,
				success: function(msg){
					$("#action_button").html(msg);
				}
			});
		}
		else{
			return false;
		}
	});
	
	$(".btnHapusPeringatan").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus peringatan ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var dataString2 = 'id_pasien='+id_pasien;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-peringatan',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_peringatan").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-peringatan',
				data: dataString2,
				cache: false,
				success: function(msg){
					$("#form_peringatan").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'action-button',
				data: dataString2,
				cache: false,
				success: function(msg){
					$("#action_button").html(msg);
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