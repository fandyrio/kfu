<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../config/conn.php";
	include "../../config/library.php";

	$module=$_GET['module'];
	$act=$_GET['act'];
	if ($module=='keluarga' AND $act=='input'){
		pg_query($dbconn,"INSERT INTO master_pasien_keluarga (id_hubungan_keluarga, nama, id_pekerjaan, no_telepon, no_handphone, no_telepon_kerja, email, id_provinsi, id_kabupaten, id_kecamatan, id_kelurahan, alamat, id_session, tanggal_edit, jam_edit) VALUES ('$_POST[id_hubungan_keluarga]', '$_POST[nama]', '$_POST[id_pekerjaan]', '$_POST[no_telepon]', '$_POST[no_handphone]', '$_POST[no_telepon_kerja]', '$_POST[email]', '$_POST[id_provinsi]', '$_POST[id_kabupaten]', '$_POST[id_kecamatan]', '$_POST[id_kelurahan]', '$_POST[alamat]', '$_SESSION[id_session]', '$tgl_sekarang', '$jam_sekarang')");
		?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="50px">No.</th>
					<th>Hubungan</th>
					<th>Nama</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_keluarga WHERE id_session='$_SESSION[id_session]'");
				$no=1;
				while($r=pg_fetch_array($tampil)){
					$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_hubungan_keluarga WHERE id='$r[id_hubungan_keluarga]'"));
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $d['nama'];?></td>
						<td><?php echo $r['nama'];?></td>
						<td class="text-center">
							<button type="button" class="btn btn-warning btn-xs btnEditKeluarga" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
							
							<!--<a 	href="aksi-hapus-pasien-keluarga-<?php echo $r['id'];?>"onclick="return confirm('Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>-->
							
							<button type="button" class="btn btn-danger btn-xs btnHapusKeluarga" id="<?php echo $r['id'];?>" ><i class="icon-trash"></i></button>
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>
		
		<script>
		$(".btnEditKeluarga").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'edit-pasien-keluarga',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#form_keluarga_pasien").html(msg);
				}
			});
			
		});
		
		$(".btnHapusKeluarga").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-keluarga',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_keluarga_pasien").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-keluarga',
				success: function(msg){
					$("#form_keluarga_pasien").html(msg);
				}
			});
		});
		</script>
	<?php
	}
	
	elseif ($module=='keluarga' AND $act=='input2'){
		pg_query($dbconn,"INSERT INTO master_pasien_keluarga (id_hubungan_keluarga, nama, id_pekerjaan, no_telepon, no_handphone, no_telepon_kerja, email, id_provinsi, id_kabupaten, id_kecamatan, id_kelurahan, alamat, id_pasien, tanggal_edit, jam_edit) VALUES ('$_POST[id_hubungan_keluarga]', '$_POST[nama]', '$_POST[id_pekerjaan]', '$_POST[no_telepon]', '$_POST[no_handphone]', '$_POST[no_telepon_kerja]', '$_POST[email]', '$_POST[id_provinsi]', '$_POST[id_kabupaten]', '$_POST[id_kecamatan]', '$_POST[id_kelurahan]', '$_POST[alamat]', '$_POST[id_pasien]', '$tgl_sekarang', '$jam_sekarang')");
		?>
		
		<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $_POST['id_pasien'];?>">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="50px">No.</th>
					<th>Hubungan</th>
					<th>Nama</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_keluarga WHERE id_pasien='$_POST[id_pasien]'");
				$no=1;
				while($r=pg_fetch_array($tampil)){
					$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_hubungan_keluarga WHERE id='$r[id_hubungan_keluarga]'"));
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $d['nama'];?></td>
						<td><?php echo $r['nama'];?></td>
						<td class="text-center">
							<button type="button" class="btn btn-warning btn-xs btnEditKeluarga2" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
							
							<!--<a 	href="aksi-hapus-pasien-keluarga-<?php echo $r['id'];?>"onclick="return confirm('Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>-->
							
							<button type="button" class="btn btn-danger btn-xs btnHapusKeluarga2" id="<?php echo $r['id'];?>" ><i class="icon-trash"></i></button>
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>
		
		<script>
		$(".btnEditKeluarga2").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'edit-pasien-keluarga2',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#form_keluarga_pasien").html(msg);
				}
			});
			
		});
		
		$(".btnHapusKeluarga2").click(function(){
			var id = this.id;
			var id_pasien = $("#id_pasien").val();
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-keluarga2',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_keluarga_pasien").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-keluarga2',
				data: { 
					'id_pasien': id_pasien
				},
				success: function(msg){
					$("#form_keluarga_pasien").html(msg);
				}
			});
		});
		</script>
	<?php
	}
	
	elseif ($module=='keluarga' AND $act=='inputform'){
		?>
		<fieldset>
			<legend>Tambah</legend>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_hubungan_keluarga">Hubungan</label>
						<div class="col-md-8">
							<select name="id_hubungan_keluarga" id="id_hubungan_keluarga" class="form-control">
								<option value=""></option>
								<?php 
									$tampil=pg_query($dbconn,"SELECT * FROM master_hubungan_keluarga");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nama">Nama</label>
						<div class="col-md-8">
							<input type="text" id="nama2" name="nama2" class="form-control" placeholder="Nama">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_pekerjaan2">Pekerjaan</label>
						<div class="col-md-8">
							<select name="id_pekerjaan2" id="id_pekerjaan2" class="form-control">
								<option value=""></option>
							<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_pekerjaan");
								while($r=pg_fetch_array($tampil)){
									echo"<option value='$r[id]'>$r[nama]</option>";
								}
							?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_telepon2">Telepon</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon2" name="no_telepon2" class="form-control" placeholder="Telepon">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_handphone2">No. HP</label>
						<div class="col-md-8">
							<input type="text" id="no_handphone2" name="no_handphone2" class="form-control" placeholder="No. Handphone">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_telepon_kerja2">Telp. Kantor</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon_kerja2" name="no_telepon_kerja2" class="form-control" placeholder="Telepon Kantor">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="email2">Email</label>
						<div class="col-md-8">
							<input type="email" id="email2" name="email2" class="form-control" placeholder="Email">
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Provinsi</label>
						<div class="col-md-8">
							<select name="id_provinsi2" id="id_provinsi2" class="form-control">
							<option value="">Pilih</option>
							<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_provinsi");
								while($r=pg_fetch_array($tampil)){
									echo"<option value='$r[id]'>$r[nama]</option>";
								}
							?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Kab/Kota</label>
						<div class="col-md-8">
							<select name="id_kabupaten2" id="id_kabupaten2" class="form-control">
						
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Kecamatan</label>
						<div class="col-md-8">
							<select name="id_kecamatan2" id="id_kecamatan2" class="form-control">
					
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Kelurahan</label>
						<div class="col-md-8">
							<select name="id_kelurahan2" id="id_kelurahan2" class="form-control">
					
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Alamat</label>
						<div class="col-md-8">
							<textarea name="alamat2" id="alamat2" class="form-control"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<hr>
					<button type="button" class="btn btn-success btn-sm" id="btnSimpanKeluarga">Tambah</button>
				</div>
			</div>
		</fieldset>
		<script>
		$("#id_provinsi2").change(function(){
			var id_provinsi=$(this).val();
			$.ajax({
				type 	: 'POST',
				url 	: 'data-kabupaten',
				data	: 'id_provinsi='+id_provinsi,
				success	: function(response){
					$('#id_kabupaten2').html(response);
				}
			});
		});
		
		$("#id_kabupaten2").change(function(){
			var id_kabupaten=$(this).val();
			$.ajax({
				type 	: 'POST',
				url 	: 'data-kecamatan',
				data	: 'id_kabupaten='+id_kabupaten,
				success	: function(response){
					$('#id_kecamatan2').html(response);
				}
			});
		});
		
		$("#id_kecamatan2").change(function(){
			var id_kecamatan=$(this).val();
			$.ajax({
				type 	: 'POST',
				url 	: 'data-kelurahan',
				data	: 'id_kecamatan='+id_kecamatan,
				success	: function(response){
					$('#id_kelurahan2').html(response);

				}
			});
		});
		$("#btnSimpanKeluarga").click(function(e) {
			e.preventDefault();
			var id_hubungan_keluarga = $("#id_hubungan_keluarga").val(); 
			var nama = $("#nama2").val();
			var id_pekerjaan = $("#id_pekerjaan2").val();
			var no_telepon = $("#no_telepon2").val();
			var no_handphone = $("#no_handphone2").val();
			var no_telepon_kerja = $("#no_telepon_kerja2").val();
			var email = $("#email2").val();
			var id_provinsi = $("#id_provinsi2").val();
			var id_kabupaten = $("#id_kabupaten2").val();
			var id_kelurahan = $("#id_kelurahan2").val();
			var id_kecamatan = $("#id_kecamatan2").val();
			var alamat = $("#alamat2").val();
			var dataString = 'id_hubungan_keluarga='+id_hubungan_keluarga+'&nama='+nama+'&id_pekerjaan='+id_pekerjaan+'&no_telepon='+no_telepon+'&no_handphone='+no_handphone+'&no_telepon_kerja='+no_telepon_kerja+'&email='+email+'&id_provinsi='+id_provinsi+'&id_kabupaten='+id_kabupaten+'&id_kecamatan='+id_kecamatan+'&id_kelurahan='+id_kelurahan+'&alamat='+alamat;
			
			$.ajax({
				type:'POST',
				data:dataString,
				url:'aksi-tambah-pasien-keluarga',
				success:function(data) {
					$("#data_keluarga_pasien").html(data);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-keluarga',
				success: function(msg){
					$("#form_keluarga_pasien").html(msg);
				}
			});
		});
		</script>
	<?php
	}
	
	elseif ($module=='keluarga' AND $act=='inputform2'){
		?>
		<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $_POST['id_pasien'];?>">
		<fieldset>
			<legend>Tambah</legend>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_hubungan_keluarga">Hubungan</label>
						<div class="col-md-8">
							<select name="id_hubungan_keluarga" id="id_hubungan_keluarga" class="form-control">
								<option value=""></option>
								<?php 
									$tampil=pg_query($dbconn,"SELECT * FROM master_hubungan_keluarga");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nama">Nama</label>
						<div class="col-md-8">
							<input type="text" id="nama2" name="nama2" class="form-control" placeholder="Nama">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_pekerjaan2">Pekerjaan</label>
						<div class="col-md-8">
							<select name="id_pekerjaan2" id="id_pekerjaan2" class="form-control">
								<option value=""></option>
							<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_pekerjaan");
								while($r=pg_fetch_array($tampil)){
									echo"<option value='$r[id]'>$r[nama]</option>";
								}
							?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_telepon2">Telepon</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon2" name="no_telepon2" class="form-control" placeholder="Telepon">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_handphone2">No. HP</label>
						<div class="col-md-8">
							<input type="text" id="no_handphone2" name="no_handphone2" class="form-control" placeholder="No. Handphone">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_telepon_kerja2">Telp. Kantor</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon_kerja2" name="no_telepon_kerja2" class="form-control" placeholder="Telepon Kantor">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="email2">Email</label>
						<div class="col-md-8">
							<input type="email" id="email2" name="email2" class="form-control" placeholder="Email">
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Provinsi</label>
						<div class="col-md-8">
							<select name="id_provinsi2" id="id_provinsi2" class="form-control">
							<option value="">Pilih</option>
							<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_provinsi");
								while($r=pg_fetch_array($tampil)){
									echo"<option value='$r[id]'>$r[nama]</option>";
								}
							?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Kab/Kota</label>
						<div class="col-md-8">
							<select name="id_kabupaten2" id="id_kabupaten2" class="form-control">
						
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Kecamatan</label>
						<div class="col-md-8">
							<select name="id_kecamatan2" id="id_kecamatan2" class="form-control">
					
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Kelurahan</label>
						<div class="col-md-8">
							<select name="id_kelurahan2" id="id_kelurahan2" class="form-control">
					
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Alamat</label>
						<div class="col-md-8">
							<textarea name="alamat2" id="alamat2" class="form-control"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<hr>
					<button type="button" class="btn btn-success btn-sm" id="btnSimpanKeluarga2">Tambah</button>
				</div>
			</div>
		</fieldset>
		<script>
		$("#id_provinsi2").change(function(){
			var id_provinsi=$(this).val();
			$.ajax({
				type 	: 'POST',
				url 	: 'data-kabupaten',
				data	: 'id_provinsi='+id_provinsi,
				success	: function(response){
					$('#id_kabupaten2').html(response);
				}
			});
		});
		
		$("#id_kabupaten2").change(function(){
			var id_kabupaten=$(this).val();
			$.ajax({
				type 	: 'POST',
				url 	: 'data-kecamatan',
				data	: 'id_kabupaten='+id_kabupaten,
				success	: function(response){
					$('#id_kecamatan2').html(response);
				}
			});
		});
		
		$("#id_kecamatan2").change(function(){
			var id_kecamatan=$(this).val();
			$.ajax({
				type 	: 'POST',
				url 	: 'data-kelurahan',
				data	: 'id_kecamatan='+id_kecamatan,
				success	: function(response){
					$('#id_kelurahan2').html(response);

				}
			});
		});
		$("#btnSimpanKeluarga2").click(function(e) {
			e.preventDefault();
			var id_pasien = $("#id_pasien").val(); 
			var id_hubungan_keluarga = $("#id_hubungan_keluarga").val(); 
			var nama = $("#nama2").val();
			var id_pekerjaan = $("#id_pekerjaan2").val();
			var no_telepon = $("#no_telepon2").val();
			var no_handphone = $("#no_handphone2").val();
			var no_telepon_kerja = $("#no_telepon_kerja2").val();
			var email = $("#email2").val();
			var id_provinsi = $("#id_provinsi2").val();
			var id_kabupaten = $("#id_kabupaten2").val();
			var id_kelurahan = $("#id_kelurahan2").val();
			var id_kecamatan = $("#id_kecamatan2").val();
			var alamat = $("#alamat2").val();
			var dataString = 'id_pasien='+id_pasien+'&id_hubungan_keluarga='+id_hubungan_keluarga+'&nama='+nama+'&id_pekerjaan='+id_pekerjaan+'&no_telepon='+no_telepon+'&no_handphone='+no_handphone+'&no_telepon_kerja='+no_telepon_kerja+'&email='+email+'&id_provinsi='+id_provinsi+'&id_kabupaten='+id_kabupaten+'&id_kecamatan='+id_kecamatan+'&id_kelurahan='+id_kelurahan+'&alamat='+alamat;
			
			$.ajax({
				type:'POST',
				data:dataString,
				url:'aksi-tambah-pasien-keluarga2',
				success:function(data) {
					$("#data_keluarga_pasien").html(data);
				}
			});
			
			$.ajax({
				type: 'POST',
				data: { 
					'id_pasien': id_pasien
				},
				url: 'form-tambah-pasien-keluarga2',
				success: function(msg){
					$("#form_keluarga_pasien").html(msg);
				}
			});
		});
		</script>
	<?php
	}
	
	
	elseif ($module=='keluarga' AND $act=='edit'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien_keluarga WHERE id='$_POST[id]'"));
		?>
		<input type="hidden" name="id" id="id" value="<?php echo $d['id'];?>">
		<fieldset>
			<legend>Edit</legend>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_hubungan_keluarga">Hubungan</label>
						<div class="col-md-8">
							<select name="id_hubungan_keluarga" id="id_hubungan_keluarga" class="form-control">
								<option value=""></option>
								<?php 
									$tampil=pg_query($dbconn,"SELECT * FROM master_hubungan_keluarga");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_hubungan_keluarga']){
											echo"<option value='$r[id]' selected>$r[nama]</option>";
										}
										else{
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nama">Nama</label>
						<div class="col-md-8">
							<input type="text" id="nama2" name="nama2" class="form-control" placeholder="Nama" value="<?php echo $d['nama'];?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_pekerjaan2">Pekerjaan</label>
						<div class="col-md-8">
							<select name="id_pekerjaan2" id="id_pekerjaan2" class="form-control">
								<option value=""></option>
							<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_pekerjaan");
								while($r=pg_fetch_array($tampil)){
									if($r['id']==$d['id_pekerjaan']){
										echo"<option value='$r[id]' selected>$r[nama]</option>";
									}
									else{
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
								}
							?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_telepon2">Telepon</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon2" name="no_telepon2" class="form-control" placeholder="Telepon" value="<?php echo $d['no_telepon'];?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_handphone2">No. HP</label>
						<div class="col-md-8">
							<input type="text" id="no_handphone2" name="no_handphone2" class="form-control" placeholder="No. Handphone" value="<?php echo $d['no_handphone'];?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_telepon_kerja2">Telp. Kantor</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon_kerja2" name="no_telepon_kerja2" class="form-control" placeholder="Telepon Kantor" value="<?php echo $d['no_telepon_kerja'];?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="email2">Email</label>
						<div class="col-md-8">
							<input type="email" id="email2" name="email2" class="form-control" placeholder="Email" value="<?php echo $d['email'];?>">
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Provinsi</label>
						<div class="col-md-8">
							<select name="id_provinsi2" id="id_provinsi2" class="form-control">
							<option value="">Pilih</option>
							<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_provinsi");
								while($r=pg_fetch_array($tampil)){
									if($r['id']==$d['id_provinsi']){
										echo"<option value='$r[id]' selected>$r[nama]</option>";
									}
									else{
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
								}
							?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Kab/Kota</label>
						<div class="col-md-8">
							<select name="id_kabupaten2" id="id_kabupaten2" class="form-control">
								<option value="">Pilih</option>
								<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_kabupaten WHERE id_provinsi='$d[id_provinsi]'");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_kabupaten']){
											echo"<option value='$r[id]' selected>$r[nama]</option>";
										}
										else{
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Kecamatan</label>
						<div class="col-md-8">
							<select name="id_kecamatan2" id="id_kecamatan2" class="form-control">
								<option value="">Pilih</option>
								<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_kecamatan WHERE id_kabupaten='$d[id_kabupaten]'");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_kecamatan']){
											echo"<option value='$r[id]' selected>$r[nama]</option>";
										}
										else{
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
									}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Kelurahan</label>
						<div class="col-md-8">
							<select name="id_kelurahan2" id="id_kelurahan2" class="form-control">
								<option value="">Pilih</option>
								<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_kelurahan WHERE id_kecamatan='$d[id_kecamatan]'");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_kelurahan']){
											echo"<option value='$r[id]' selected>$r[nama]</option>";
										}
										else{
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
									}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Alamat</label>
						<div class="col-md-8">
							<textarea name="alamat2" id="alamat2" class="form-control"><?php echo $d['alamat'];?></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<hr>
					<button type="button" class="btn btn-success btn-sm" id="btnSimpanEditKeluarga">Simpan</button>
				</div>
			</div>
		</fieldset>
		
		<script type="text/javascript">
			$("#id_provinsi2").change(function(){
				var id_provinsi=$(this).val();
				$.ajax({
					type 	: 'POST',
					url 	: 'data-kabupaten',
					data	: 'id_provinsi='+id_provinsi,
					success	: function(response){
						$('#id_kabupaten2').html(response);
					}
				});
			});
			
			$("#id_kabupaten2").change(function(){
				var id_kabupaten=$(this).val();
				$.ajax({
					type 	: 'POST',
					url 	: 'data-kecamatan',
					data	: 'id_kabupaten='+id_kabupaten,
					success	: function(response){
						$('#id_kecamatan2').html(response);
					}
				});
			});
			
			$("#id_kecamatan2").change(function(){
				var id_kecamatan=$(this).val();
				$.ajax({
					type 	: 'POST',
					url 	: 'data-kelurahan',
					data	: 'id_kecamatan='+id_kecamatan,
					success	: function(response){
						$('#id_kelurahan2').html(response);

					}
				});
			});
			
			$("#btnSimpanEditKeluarga").click(function(e) {
				e.preventDefault();
				var id = $("#id").val(); 
				var id_hubungan_keluarga = $("#id_hubungan_keluarga").val(); 
				var nama = $("#nama2").val();
				var id_pekerjaan = $("#id_pekerjaan2").val();
				var no_telepon = $("#no_telepon2").val();
				var no_handphone = $("#no_handphone2").val();
				var no_telepon_kerja = $("#no_telepon_kerja2").val();
				var email = $("#email2").val();
				var id_provinsi = $("#id_provinsi2").val();
				var id_kabupaten = $("#id_kabupaten2").val();
				var id_kelurahan = $("#id_kelurahan2").val();
				var id_kecamatan = $("#id_kecamatan2").val();
				var alamat = $("#alamat2").val();
				var dataString = 'id='+id+'&id_hubungan_keluarga='+id_hubungan_keluarga+'&nama='+nama+'&id_pekerjaan='+id_pekerjaan+'&no_telepon='+no_telepon+'&no_handphone='+no_handphone+'&no_telepon_kerja='+no_telepon_kerja+'&email='+email+'&id_provinsi='+id_provinsi+'&id_kabupaten='+id_kabupaten+'&id_kecamatan='+id_kecamatan+'&id_kelurahan='+id_kelurahan+'&alamat='+alamat;
				
				$.ajax({
					type:'POST',
					data:dataString,
					url:'aksi-edit-pasien-keluarga',
					success:function(data) {
						$("#data_keluarga_pasien").html(data);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-keluarga',
					success: function(msg){
						$("#form_keluarga_pasien").html(msg);
					}
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='keluarga' AND $act=='edit2'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien_keluarga WHERE id='$_POST[id]'"));
		?>
		<input type="hidden" name="id" id="id" value="<?php echo $d['id'];?>">
		<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $d['id_pasien'];?>">
		<fieldset>
			<legend>Edit</legend>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_hubungan_keluarga">Hubungan</label>
						<div class="col-md-8">
							<select name="id_hubungan_keluarga" id="id_hubungan_keluarga" class="form-control">
								<option value=""></option>
								<?php 
									$tampil=pg_query($dbconn,"SELECT * FROM master_hubungan_keluarga");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_hubungan_keluarga']){
											echo"<option value='$r[id]' selected>$r[nama]</option>";
										}
										else{
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nama">Nama</label>
						<div class="col-md-8">
							<input type="text" id="nama2" name="nama2" class="form-control" placeholder="Nama" value="<?php echo $d['nama'];?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_pekerjaan2">Pekerjaan</label>
						<div class="col-md-8">
							<select name="id_pekerjaan2" id="id_pekerjaan2" class="form-control">
								<option value=""></option>
							<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_pekerjaan");
								while($r=pg_fetch_array($tampil)){
									if($r['id']==$d['id_pekerjaan']){
										echo"<option value='$r[id]' selected>$r[nama]</option>";
									}
									else{
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
								}
							?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_telepon2">Telepon</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon2" name="no_telepon2" class="form-control" placeholder="Telepon" value="<?php echo $d['no_telepon'];?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_handphone2">No. HP</label>
						<div class="col-md-8">
							<input type="text" id="no_handphone2" name="no_handphone2" class="form-control" placeholder="No. Handphone" value="<?php echo $d['no_handphone'];?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_telepon_kerja2">Telp. Kantor</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon_kerja2" name="no_telepon_kerja2" class="form-control" placeholder="Telepon Kantor" value="<?php echo $d['no_telepon_kerja'];?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="email2">Email</label>
						<div class="col-md-8">
							<input type="email" id="email2" name="email2" class="form-control" placeholder="Email" value="<?php echo $d['email'];?>">
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Provinsi</label>
						<div class="col-md-8">
							<select name="id_provinsi2" id="id_provinsi2" class="form-control">
							<option value="">Pilih</option>
							<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_provinsi");
								while($r=pg_fetch_array($tampil)){
									if($r['id']==$d['id_provinsi']){
										echo"<option value='$r[id]' selected>$r[nama]</option>";
									}
									else{
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
								}
							?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Kab/Kota</label>
						<div class="col-md-8">
							<select name="id_kabupaten2" id="id_kabupaten2" class="form-control">
								<option value="">Pilih</option>
								<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_kabupaten WHERE id_provinsi='$d[id_provinsi]'");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_kabupaten']){
											echo"<option value='$r[id]' selected>$r[nama]</option>";
										}
										else{
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Kecamatan</label>
						<div class="col-md-8">
							<select name="id_kecamatan2" id="id_kecamatan2" class="form-control">
								<option value="">Pilih</option>
								<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_kecamatan WHERE id_kabupaten='$d[id_kabupaten]'");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_kecamatan']){
											echo"<option value='$r[id]' selected>$r[nama]</option>";
										}
										else{
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
									}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Kelurahan</label>
						<div class="col-md-8">
							<select name="id_kelurahan2" id="id_kelurahan2" class="form-control">
								<option value="">Pilih</option>
								<?php 
								$tampil=pg_query($dbconn,"SELECT * FROM master_kelurahan WHERE id_kecamatan='$d[id_kecamatan]'");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_kelurahan']){
											echo"<option value='$r[id]' selected>$r[nama]</option>";
										}
										else{
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
									}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Alamat</label>
						<div class="col-md-8">
							<textarea name="alamat2" id="alamat2" class="form-control"><?php echo $d['alamat'];?></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<hr>
					<button type="button" class="btn btn-success btn-sm" id="btnSimpanEditKeluarga2">Simpan</button>
				</div>
			</div>
		</fieldset>
		
		<script type="text/javascript">
			$("#id_provinsi2").change(function(){
				var id_provinsi=$(this).val();
				$.ajax({
					type 	: 'POST',
					url 	: 'data-kabupaten',
					data	: 'id_provinsi='+id_provinsi,
					success	: function(response){
						$('#id_kabupaten2').html(response);
					}
				});
			});
			
			$("#id_kabupaten2").change(function(){
				var id_kabupaten=$(this).val();
				$.ajax({
					type 	: 'POST',
					url 	: 'data-kecamatan',
					data	: 'id_kabupaten='+id_kabupaten,
					success	: function(response){
						$('#id_kecamatan2').html(response);
					}
				});
			});
			
			$("#id_kecamatan2").change(function(){
				var id_kecamatan=$(this).val();
				$.ajax({
					type 	: 'POST',
					url 	: 'data-kelurahan',
					data	: 'id_kecamatan='+id_kecamatan,
					success	: function(response){
						$('#id_kelurahan2').html(response);

					}
				});
			});
			
			$("#btnSimpanEditKeluarga2").click(function(e) {
				e.preventDefault();
				var id = $("#id").val(); 
				var id_pasien = $("#id_pasien").val(); 
				var id_hubungan_keluarga = $("#id_hubungan_keluarga").val(); 
				var nama = $("#nama2").val();
				var id_pekerjaan = $("#id_pekerjaan2").val();
				var no_telepon = $("#no_telepon2").val();
				var no_handphone = $("#no_handphone2").val();
				var no_telepon_kerja = $("#no_telepon_kerja2").val();
				var email = $("#email2").val();
				var id_provinsi = $("#id_provinsi2").val();
				var id_kabupaten = $("#id_kabupaten2").val();
				var id_kelurahan = $("#id_kelurahan2").val();
				var id_kecamatan = $("#id_kecamatan2").val();
				var alamat = $("#alamat2").val();
				var dataString = 'id='+id+'&id_hubungan_keluarga='+id_hubungan_keluarga+'&nama='+nama+'&id_pekerjaan='+id_pekerjaan+'&no_telepon='+no_telepon+'&no_handphone='+no_handphone+'&no_telepon_kerja='+no_telepon_kerja+'&email='+email+'&id_provinsi='+id_provinsi+'&id_kabupaten='+id_kabupaten+'&id_kecamatan='+id_kecamatan+'&id_kelurahan='+id_kelurahan+'&alamat='+alamat;
				
				$.ajax({
					type:'POST',
					data:dataString,
					url:'aksi-edit-pasien-keluarga2',
					success:function(data) {
						$("#data_keluarga_pasien").html(data);
					}
				});
				
				$.ajax({
					type: 'POST',
					data: { 
						'id_pasien': id_pasien
					},
					url: 'form-tambah-pasien-keluarga2',
					success: function(msg){
						$("#form_keluarga_pasien").html(msg);
					}
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='keluarga' AND $act=='update'){
		pg_query($dbconn,"UPDATE master_pasien_keluarga SET id_hubungan_keluarga='$_POST[id_hubungan_keluarga]', nama='$_POST[nama]', id_pekerjaan='$_POST[id_pekerjaan]', no_telepon='$_POST[no_telepon]', no_handphone='$_POST[no_handphone]', no_telepon_kerja='$_POST[no_telepon_kerja]', email='$_POST[email]', id_provinsi='$_POST[id_provinsi]', id_kabupaten='$_POST[id_kabupaten]', id_kecamatan='$_POST[id_kecamatan]', id_kelurahan='$_POST[id_kelurahan]', alamat='$_POST[alamat]' WHERE id='$_POST[id]'");
		
		?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="50px">No.</th>
					<th>Hubungan</th>
					<th>Nama</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_keluarga WHERE id_session='$_SESSION[id_session]'");
				$no=1;
				while($r=pg_fetch_array($tampil)){
					$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_hubungan_keluarga WHERE id='$r[id_hubungan_keluarga]'"));
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $d['nama'];?></td>
						<td><?php echo $r['nama'];?></td>
						<td class="text-center">
							<button type="button" class="btn btn-warning btn-xs btnEditKeluarga" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
							<button type="button" class="btn btn-danger btn-xs btnHapusKeluarga" id="<?php echo $r['id'];?>"  ><i class="icon-trash"></i></button>
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>
		
		<script>
		$(".btnEditKeluarga").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'edit-pasien-keluarga',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#form_keluarga_pasien").html(msg);
				}
			});
			
		});
		
		$(".btnHapusKeluarga").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-keluarga',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_keluarga_pasien").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-keluarga',
				success: function(msg){
					$("#form_keluarga_pasien").html(msg);
				}
			});
		
		});
		</script>
		<?php
	}
	
	elseif ($module=='keluarga' AND $act=='update2'){
		pg_query($dbconn,"UPDATE master_pasien_keluarga SET id_hubungan_keluarga='$_POST[id_hubungan_keluarga]', nama='$_POST[nama]', id_pekerjaan='$_POST[id_pekerjaan]', no_telepon='$_POST[no_telepon]', no_handphone='$_POST[no_handphone]', no_telepon_kerja='$_POST[no_telepon_kerja]', email='$_POST[email]', id_provinsi='$_POST[id_provinsi]', id_kabupaten='$_POST[id_kabupaten]', id_kecamatan='$_POST[id_kecamatan]', id_kelurahan='$_POST[id_kelurahan]', alamat='$_POST[alamat]' WHERE id='$_POST[id]'");
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_pasien FROM master_pasien_keluarga WHERE id='$_POST[id]'"));
		?>
		<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $d['id_pasien'];?>">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="50px">No.</th>
					<th>Hubungan</th>
					<th>Nama</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_keluarga WHERE id_pasien='$d[id_pasien]'");
				$no=1;
				while($r=pg_fetch_array($tampil)){
					$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_hubungan_keluarga WHERE id='$r[id_hubungan_keluarga]'"));
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $d['nama'];?></td>
						<td><?php echo $r['nama'];?></td>
						<td class="text-center">
							<button type="button" class="btn btn-warning btn-xs btnEditKeluarga2" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
							<button type="button" class="btn btn-danger btn-xs btnHapusKeluarga2" id="<?php echo $r['id'];?>"  ><i class="icon-trash"></i></button>
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>
		
		<script>
		$(".btnEditKeluarga2").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'edit-pasien-keluarga2',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#form_keluarga_pasien").html(msg);
				}
			});
			
		});
		
		$(".btnHapusKeluarga2").click(function(){
			var id = this.id;
			var id_pasien = $("#id_pasien").val();
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-keluarga2',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_keluarga_pasien").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-keluarga2',
				data: { 
					'id_pasien': id_pasien
				},
				success: function(msg){
					$("#form_keluarga_pasien").html(msg);
				}
			});
		
		});
		</script>
		<?php
	}
	
	elseif ($module=='keluarga' AND $act=='delete'){
		pg_query($dbconn,"DELETE FROM master_pasien_keluarga WHERE id='$_POST[id]'");
		?>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="50px">No.</th>
					<th>Hubungan</th>
					<th>Nama</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_keluarga WHERE id_session='$_SESSION[id_session]'");
				$no=1;
				while($r=pg_fetch_array($tampil)){
					$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_hubungan_keluarga WHERE id='$r[id_hubungan_keluarga]'"));
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $d['nama'];?></td>
						<td><?php echo $r['nama'];?></td>
						<td class="text-center">
							<button type="button" class="btn btn-warning btn-xs btnEditKeluarga" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
							
							<!--<a 	href="aksi-hapus-pasien-keluarga-<?php echo $r['id'];?>"onclick="return confirm('Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>-->
							
							<button type="button" class="btn btn-danger btn-xs btnHapusKeluarga" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>
					
		<script>
			$(".btnEditKeluarga").click(function(){
				var id = this.id;
				
				$.ajax({
					type: 'POST',
					url: 'edit-pasien-keluarga',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#form_keluarga_pasien").html(msg);
					}
				});
				
			});
			
			$(".btnHapusKeluarga").click(function(){
				var id = this.id;
				
				$.ajax({
					type: 'POST',
					url: 'aksi-hapus-pasien-keluarga',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#data_keluarga_pasien").html(msg);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-keluarga',
					success: function(msg){
						$("#form_keluarga_pasien").html(msg);
					}
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='keluarga' AND $act=='delete2'){
		pg_query($dbconn,"DELETE FROM master_pasien_keluarga WHERE id='$_POST[id]'");
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_pasien FROM master_pasien_keluarga WHERE id='$_POST[id]'"));
		?>
		<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $d['id_pasien'];?>">

		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="50px">No.</th>
					<th>Hubungan</th>
					<th>Nama</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_keluarga WHERE id_pasien='$d[id_pasien]'");
				$no=1;
				while($r=pg_fetch_array($tampil)){
					$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_hubungan_keluarga WHERE id='$r[id_hubungan_keluarga]'"));
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $d['nama'];?></td>
						<td><?php echo $r['nama'];?></td>
						<td class="text-center">
							<button type="button" class="btn btn-warning btn-xs btnEditKeluarga2" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
							
							<!--<a 	href="aksi-hapus-pasien-keluarga-<?php echo $r['id'];?>"onclick="return confirm('Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>-->
							
							<button type="button" class="btn btn-danger btn-xs btnHapusKeluarga2" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>
					
		<script>
			$(".btnEditKeluarga2").click(function(){
				var id = this.id;
				
				$.ajax({
					type: 'POST',
					url: 'edit-pasien-keluarga2',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#form_keluarga_pasien").html(msg);
					}
				});
				
			});
			
			$(".btnHapusKeluarga2").click(function(){
				var id = this.id;
				var id_pasien = $("#id_pasien").val();
				
				$.ajax({
					type: 'POST',
					url: 'aksi-hapus-pasien-keluarga2',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#data_keluarga_pasien").html(msg);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-keluarga2',
					data: { 
						'id_pasien': id_pasien
					},
					success: function(msg){
						$("#form_keluarga_pasien").html(msg);
					}
				});
			});
		</script>
		<?php
	}
	pg_close($dbconn);
}
?>