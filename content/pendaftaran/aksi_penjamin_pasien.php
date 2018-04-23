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
	if ($module=='penjamin' AND $act=='input'){
		if($_POST['visit_limit']==''){
			$visit_limit=0;
		}
		else{
			$visit_limit=$_POST['visit_limit'];
		}
		
		if($_POST['co_payment']==''){
			$co_payment=0;
		}
		else{
			$co_payment=$_POST['co_payment'];
			
		}
		pg_query($dbconn,"INSERT INTO master_pasien_penjamin (id_hubungan, nama, id_pekerjaan, no_telepon, no_handphone, no_telepon_kerja, email, id_provinsi, id_kabupaten, id_kecamatan, id_kelurahan, alamat, catatan, id_session, id_perusahaan, visit_limit, co_payment) VALUES ('$_POST[id_hubungan]', '$_POST[nama]', '$_POST[id_pekerjaan]', '$_POST[no_telepon]', '$_POST[no_handphone]', '$_POST[no_telepon_kerja]', '$_POST[email]', '$_POST[id_provinsi]', '$_POST[id_kabupaten]', '$_POST[id_kecamatan]', '$_POST[id_kelurahan]', '$_POST[alamat]', '$_POST[catatan]', '$_SESSION[id_session]', '$_POST[id_perusahaan]', '$visit_limit', '$co_payment')");
		
		?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="50px">No.</th>
					<th>Nama</th>
					<th>Telepon</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_penjamin WHERE id_session='$_SESSION[id_session]'");
				$no=1;
				while($r=pg_fetch_array($tampil)){
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $r['nama'];?></td>
						<td><?php echo $r['no_telepon'];?></td>
						<td class="text-center">
							<button type="button" class="btn btn-warning btn-xs btnEditPenjamin" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
							
							<button type="button" class="btn btn-danger btn-xs btnHapusPenjamin" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>

		<script>
		$(".btnEditPenjamin").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'edit-pasien-penjamin',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#form_penjamin_pasien").html(msg);
				}
			});
			
		});
		
		$(".btnHapusPenjamin").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-penjamin',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_penjamin_pasien").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-penjamin',
				success: function(msg){
					$("#form_penjamin_pasien").html(msg);
				}
			});
		});
		</script>
		
	<?php
	}
	
	elseif ($module=='penjamin' AND $act=='input2'){
		if($_POST['visit_limit']==''){
			$visit_limit=0;
		}
		else{
			$visit_limit=$_POST['visit_limit'];
		}
		
		if($_POST['co_payment']==''){
			$co_payment=0;
		}
		else{
			$co_payment=$_POST['co_payment'];
			
		}
		pg_query($dbconn,"INSERT INTO master_pasien_penjamin (id_hubungan, nama, id_pekerjaan, no_telepon, no_handphone, no_telepon_kerja, email, id_provinsi, id_kabupaten, id_kecamatan, id_kelurahan, alamat, catatan, id_pasien, id_perusahaan, visit_limit, co_payment) VALUES ('$_POST[id_hubungan]', '$_POST[nama]', '$_POST[id_pekerjaan]', '$_POST[no_telepon]', '$_POST[no_handphone]', '$_POST[no_telepon_kerja]', '$_POST[email]', '$_POST[id_provinsi]', '$_POST[id_kabupaten]', '$_POST[id_kecamatan]', '$_POST[id_kelurahan]', '$_POST[alamat]', '$_POST[catatan]', '$_POST[id_pasien]', '$_POST[id_perusahaan]', '$visit_limit', '$co_payment')");
		
		?>
		<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $_POST['id_pasien'];?>">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="50px">No.</th>
					<th>Nama</th>
					<th>Telepon</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_penjamin WHERE id_pasien='$_POST[id_pasien]'");
				$no=1;
				while($r=pg_fetch_array($tampil)){
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $r['nama'];?></td>
						<td><?php echo $r['no_telepon'];?></td>
						<td class="text-center">
							<button type="button" class="btn btn-warning btn-xs btnEditPenjamin2" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
							
							<button type="button" class="btn btn-danger btn-xs btnHapusPenjamin2" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>

		<script>
		$(".btnEditPenjamin2").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'edit-pasien-penjamin2',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#form_penjamin_pasien").html(msg);
				}
			});
			
		});
		
		$(".btnHapusPenjamin2").click(function(){
			var id = this.id;
			var id_pasien = $("#id_pasien").val();
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-penjamin2',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_penjamin_pasien").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-penjamin2',
				data: { 
					'id_pasien': id_pasien
				},
				success: function(msg){
					$("#form_penjamin_pasien").html(msg);
				}
			});
		});
		</script>
		
	<?php
	}
	
	elseif ($module=='penjamin' AND $act=='inputform'){
		?>
		<fieldset>
			<legend>Tambah</legend>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Panel</label>
						<div class="col-md-8">
							<select name="id_perusahaan_penjamin" id="id_perusahaan_penjamin" class="form-control">
								<option value=""></option>
								<?php 
									$tampil=pg_query($dbconn,"SELECT * FROM master_perusahaan");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Hubungan</label>
						<div class="col-md-8">
							<select name="id_hubungan_penjamin" id="id_hubungan_penjamin" class="form-control">
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
						<label class="col-md-4 form-control-label" for="nama_penjamin">Nama</label>
						<div class="col-md-8">
							<input type="text" id="nama_penjamin" name="nama_penjamin" class="form-control" placeholder="Nama">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_pekerjaan_penjamin">Pekerjaan</label>
						<div class="col-md-8">
							<select name="id_pekerjaan_penjamin" id="id_pekerjaan_penjamin" class="form-control">
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
						<label class="col-md-4 form-control-label" for="no_telepon_penjamin">Telepon</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon_penjamin" name="no_telepon_penjamin" class="form-control" placeholder="Telepon">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_handphone_penjamin">No. HP</label>
						<div class="col-md-8">
							<input type="text" id="no_handphone_penjamin" name="no_handphone_penjamin" class="form-control" placeholder="No. Handphone">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="email_penjamin">Email Penjamin</label>
						<div class="col-md-8">
							<input type="email" id="email_penjamin" name="email_penjamin" class="form-control" placeholder="Email">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_telepon_kerja_penjamin">Telp. Kantor</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon_kerja_penjamin" name="no_telepon_kerja_penjamin" class="form-control" placeholder="Telepon Kantor">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="visit_limit_penjamin">Visit Limit (Rp)</label>
						<div class="col-md-8">
							<input type="number" id="visit_limit_penjamin" name="visit_limit_penjamin" class="form-control" placeholder="Visit Limit">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="co_payment_penjamin">Co-payment (Rp)</label>
						<div class="col-md-8">
							<input type="number" id="co_payment_penjamin" name="co_payment_penjamin" class="form-control" placeholder="Co-payment">
						</div>
					</div>
					
				</div>
				
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_provinsi3">Provinsi</label>
						<div class="col-md-8">
							<select name="id_provinsi3" id="id_provinsi3" class="form-control">
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
						<label class="col-md-4 form-control-label" for="id_kabupaten3">Kab/Kota</label>
						<div class="col-md-8">
							<select name="id_kabupaten3" id="id_kabupaten3" class="form-control">
						
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_kecamatan3">Kecamatan</label>
						<div class="col-md-8">
							<select name="id_kecamatan3" id="id_kecamatan3" class="form-control">
					
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_kelurahan3">Kelurahan</label>
						<div class="col-md-8">
							<select name="id_kelurahan3" id="id_kelurahan3" class="form-control">
					
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="alamat_penjamin">Alamat</label>
						<div class="col-md-8">
							<textarea name="alamat_penjamin"  id="alamat_penjamin" class="form-control"></textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="catatan_penjamin">Catatan</label>
						<div class="col-md-8">
							<textarea name="catatan_penjamin" id="catatn_penjamin" class="form-control"></textarea>
						</div>
					</div>
				</div>
				
				<div class="col-md-12">
					<hr>
					<button type="button" class="btn btn-success btn-sm" id="btnSimpanPenjamin">Tambah</button>
				</div>
			</div>
		</fieldset>
		<script>
		$("#id_provinsi3").change(function(){
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
		
		$("#id_kabupaten3").change(function(){
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
		
		$("#id_kecamatan3").change(function(){
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
			
		$("#btnSimpanPenjamin").click(function(e) {
			e.preventDefault();
			var id_perusahaan = $("#id_perusahaan_penjamin").val(); 
			var id_hubungan = $("#id_hubungan_penjamin").val(); 
			var nama= $("#nama_penjamin").val();
			var id_pekerjaan = $("#id_pekerjaan_penjamin").val();
			var no_telepon = $("#no_telepon_penjamin").val();
			var no_handphone = $("#no_handphone_penjamin").val();
			var no_telepon_kerja = $("#no_telepon_kerja_penjamin").val();
			var email = $("#email_penjamin").val();
			var visit_limit = $("#visit_limit_penjamin").val();
			var co_payment = $("#co_payment_penjamin").val();
			var id_provinsi = $("#id_provinsi3").val();
			var id_kabupaten = $("#id_kabupaten3").val();
			var id_kelurahan = $("#id_kelurahan3").val();
			var id_kecamatan = $("#id_kecamatan3").val();
			var alamat = $("#alamat_penjamin").val();
			var catatan = $("#catatan_penjamin").val();
			var dataString = 'id_perusahaan='+id_perusahaan+'&id_hubungan='+id_hubungan+'&nama='+nama+'&id_pekerjaan='+id_pekerjaan+'&no_telepon='+no_telepon+'&no_handphone='+no_handphone+'&no_telepon_kerja='+no_telepon_kerja+'&email='+email+'&id_provinsi='+id_provinsi+'&id_kabupaten='+id_kabupaten+'&id_kecamatan='+id_kecamatan+'&id_kelurahan='+id_kelurahan+'&alamat='+alamat+'&catatan='+catatan+'&visit_limit='+visit_limit+'&co_payment='+co_payment;
			
			$.ajax({
				type:'POST',
				data:dataString,
				url:'aksi-tambah-pasien-penjamin',
				success:function(data) {
					$("#data_penjamin_pasien").html(data);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-penjamin',
				success: function(msg){
					$("#form_penjamin_pasien").html(msg);
				}
			});
		});
		</script>
	<?php
	}
	
	elseif ($module=='penjamin' AND $act=='inputform2'){
		?>
		<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $_POST['id_pasien'];?>">
		<fieldset>
			<legend>Tambah</legend>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Panel</label>
						<div class="col-md-8">
							<select name="id_perusahaan_penjamin" id="id_perusahaan_penjamin" class="form-control">
								<option value=""></option>
								<?php 
									$tampil=pg_query($dbconn,"SELECT * FROM master_perusahaan");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Hubungan</label>
						<div class="col-md-8">
							<select name="id_hubungan_penjamin" id="id_hubungan_penjamin" class="form-control">
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
						<label class="col-md-4 form-control-label" for="nama_penjamin">Nama</label>
						<div class="col-md-8">
							<input type="text" id="nama_penjamin" name="nama_penjamin" class="form-control" placeholder="Nama">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_pekerjaan_penjamin">Pekerjaan</label>
						<div class="col-md-8">
							<select name="id_pekerjaan_penjamin" id="id_pekerjaan_penjamin" class="form-control">
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
						<label class="col-md-4 form-control-label" for="no_telepon_penjamin">Telepon</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon_penjamin" name="no_telepon_penjamin" class="form-control" placeholder="Telepon">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_handphone_penjamin">No. HP</label>
						<div class="col-md-8">
							<input type="text" id="no_handphone_penjamin" name="no_handphone_penjamin" class="form-control" placeholder="No. Handphone">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="email_penjamin">Email Penjamin</label>
						<div class="col-md-8">
							<input type="email" id="email_penjamin" name="email_penjamin" class="form-control" placeholder="Email">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_telepon_kerja_penjamin">Telp. Kantor</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon_kerja_penjamin" name="no_telepon_kerja_penjamin" class="form-control" placeholder="Telepon Kantor">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="visit_limit_penjamin">Visit Limit (Rp)</label>
						<div class="col-md-8">
							<input type="number" id="visit_limit_penjamin" name="visit_limit_penjamin" class="form-control" placeholder="Visit Limit">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="co_payment_penjamin">Co-payment (Rp)</label>
						<div class="col-md-8">
							<input type="number" id="co_payment_penjamin" name="co_payment_penjamin" class="form-control" placeholder="Co-payment">
						</div>
					</div>
					
				</div>
				
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_provinsi3">Provinsi</label>
						<div class="col-md-8">
							<select name="id_provinsi3" id="id_provinsi3" class="form-control">
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
						<label class="col-md-4 form-control-label" for="id_kabupaten3">Kab/Kota</label>
						<div class="col-md-8">
							<select name="id_kabupaten3" id="id_kabupaten3" class="form-control">
						
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_kecamatan3">Kecamatan</label>
						<div class="col-md-8">
							<select name="id_kecamatan3" id="id_kecamatan3" class="form-control">
					
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_kelurahan3">Kelurahan</label>
						<div class="col-md-8">
							<select name="id_kelurahan3" id="id_kelurahan3" class="form-control">
					
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="alamat_penjamin">Alamat</label>
						<div class="col-md-8">
							<textarea name="alamat_penjamin"  id="alamat_penjamin" class="form-control"></textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="catatan_penjamin">Catatan</label>
						<div class="col-md-8">
							<textarea name="catatan_penjamin" id="catatn_penjamin" class="form-control"></textarea>
						</div>
					</div>
				</div>
				
				<div class="col-md-12">
					<hr>
					<button type="button" class="btn btn-success btn-sm" id="btnSimpanPenjamin2">Tambah</button>
				</div>
			</div>
		</fieldset>
		<script>
		$("#id_provinsi3").change(function(){
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
		
		$("#id_kabupaten3").change(function(){
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
		
		$("#id_kecamatan3").change(function(){
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
			
		$("#btnSimpanPenjamin2").click(function(e) {
			e.preventDefault();
			var id_pasien = $("#id_pasien").val(); 
			var id_perusahaan = $("#id_perusahaan_penjamin").val(); 
			var id_hubungan = $("#id_hubungan_penjamin").val(); 
			var nama= $("#nama_penjamin").val();
			var id_pekerjaan = $("#id_pekerjaan_penjamin").val();
			var no_telepon = $("#no_telepon_penjamin").val();
			var no_handphone = $("#no_handphone_penjamin").val();
			var no_telepon_kerja = $("#no_telepon_kerja_penjamin").val();
			var email = $("#email_penjamin").val();
			var visit_limit = $("#visit_limit_penjamin").val();
			var co_payment = $("#co_payment_penjamin").val();
			var id_provinsi = $("#id_provinsi3").val();
			var id_kabupaten = $("#id_kabupaten3").val();
			var id_kelurahan = $("#id_kelurahan3").val();
			var id_kecamatan = $("#id_kecamatan3").val();
			var alamat = $("#alamat_penjamin").val();
			var catatan = $("#catatan_penjamin").val();
			var dataString = 'id_pasien='+id_pasien+'&id_perusahaan='+id_perusahaan+'&id_hubungan='+id_hubungan+'&nama='+nama+'&id_pekerjaan='+id_pekerjaan+'&no_telepon='+no_telepon+'&no_handphone='+no_handphone+'&no_telepon_kerja='+no_telepon_kerja+'&email='+email+'&id_provinsi='+id_provinsi+'&id_kabupaten='+id_kabupaten+'&id_kecamatan='+id_kecamatan+'&id_kelurahan='+id_kelurahan+'&alamat='+alamat+'&catatan='+catatan+'&visit_limit='+visit_limit+'&co_payment='+co_payment;
			
			$.ajax({
				type:'POST',
				data:dataString,
				url:'aksi-tambah-pasien-penjamin2',
				success:function(data) {
					$("#data_penjamin_pasien").html(data);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-penjamin2',
				data: { 
					'id_pasien': id_pasien
				},
				success: function(msg){
					$("#form_penjamin_pasien").html(msg);
				}
			});
		});
		</script>
	<?php
	}
	
	elseif ($module=='penjamin' AND $act=='edit'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien_penjamin WHERE id='$_POST[id]'"));
		?>
		<input type="hidden" name="id" id="id" value="<?php echo $d['id'];?>">
		<fieldset>
			<legend>Edit</legend>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Panel</label>
						<div class="col-md-8">
							<select name="id_perusahaan_penjamin" id="id_perusahaan_penjamin" class="form-control">
								<option value=""></option>
								<?php 
									$tampil=pg_query($dbconn,"SELECT * FROM master_perusahaan");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_perusahaan']){
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
						<label class="col-md-4 form-control-label" for="nik">Hubungan</label>
						<div class="col-md-8">
							<select name="id_hubungan_penjamin" id="id_hubungan_penjamin" class="form-control">
								<option value=""></option>
								<?php 
									$tampil=pg_query($dbconn,"SELECT * FROM master_hubungan_keluarga");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_hubungan']){
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
						<label class="col-md-4 form-control-label" for="nama_penjamin">Nama</label>
						<div class="col-md-8">
							<input type="text" id="nama_penjamin" name="nama_penjamin" class="form-control" placeholder="Nama" value="<?php echo $d['nama'];?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_pekerjaan_penjamin">Pekerjaan</label>
						<div class="col-md-8">
							<select name="id_pekerjaan_penjamin" id="id_pekerjaan_penjamin" class="form-control">
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
						<label class="col-md-4 form-control-label" for="no_telepon_penjamin">Telepon</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon_penjamin" name="no_telepon_penjamin" class="form-control" placeholder="Telepon" value="<?php echo $d['no_telepon'];?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_handphone_penjamin">No. HP</label>
						<div class="col-md-8">
							<input type="text" id="no_handphone_penjamin" name="no_handphone_penjamin" class="form-control" placeholder="No. Handphone" value="<?php echo $d['no_handphone'];?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="email_penjamin">Email Penjamin</label>
						<div class="col-md-8">
							<input type="email" id="email_penjamin" name="email_penjamin" class="form-control" placeholder="Email" value="<?php echo $d['email'];?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_telepon_kerja_penjamin">Telp. Kantor</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon_kerja_penjamin" name="no_telepon_kerja_penjamin" class="form-control" placeholder="Telepon Kantor" value="<?php echo $d['no_telepon_kerja'];?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="visit_limit_penjamin">Visit Limit (Rp)</label>
						<div class="col-md-8">
							<input type="number" id="visit_limit_penjamin" name="visit_limit_penjamin" class="form-control" placeholder="Visit Limit" value="<?php echo $d['visit_limit'];?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="co_payment_penjamin">Co-payment (Rp)</label>
						<div class="col-md-8">
							<input type="number" id="co_payment_penjamin" name="co_payment_penjamin" class="form-control" placeholder="Co-payment" value="<?php echo $d['co_payment'];?>">
						</div>
					</div>
					
				</div>
				
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_provinsi3">Provinsi</label>
						<div class="col-md-8">
							<select name="id_provinsi3" id="id_provinsi3" class="form-control">
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
						<label class="col-md-4 form-control-label" for="id_kabupaten3">Kab/Kota</label>
						<div class="col-md-8">
							<select name="id_kabupaten3" id="id_kabupaten3" class="form-control">
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
						<label class="col-md-4 form-control-label" for="id_kecamatan3">Kecamatan</label>
						<div class="col-md-8">
							<select name="id_kecamatan3" id="id_kecamatan3" class="form-control">
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
						<label class="col-md-4 form-control-label" for="id_kelurahan3">Kelurahan</label>
						<div class="col-md-8">
							<select name="id_kelurahan3" id="id_kelurahan3" class="form-control">
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
						<label class="col-md-4 form-control-label" for="alamat_penjamin">Alamat</label>
						<div class="col-md-8">
							<textarea name="alamat_penjamin"  id="alamat_penjamin" class="form-control"><?php echo $d['alamat'];?>"</textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="catatan_penjamin">Catatan</label>
						<div class="col-md-8">
							<textarea name="catatan_penjamin" id="catatan_penjamin" class="form-control"><?php echo $d['catatan'];?>"</textarea>
						</div>
					</div>
				</div>
				
				<div class="col-md-12">
					<hr>
					<button type="button" class="btn btn-success btn-sm" id="btnSimpanEditPenjamin">Simpan</button>
				</div>
			</div>
		</fieldset>
		
		<script type="text/javascript">
			$("#id_provinsi3").change(function(){
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
			
			$("#id_kabupaten3").change(function(){
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
			
			$("#id_kecamatan3").change(function(){
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
			
			$("#btnSimpanEditPenjamin").click(function(e) {
				e.preventDefault();
				var id = $("#id").val(); 
				var id_perusahaan = $("#id_perusahaan_penjamin").val(); 
				var id_hubungan = $("#id_hubungan_penjamin").val(); 
				var nama= $("#nama_penjamin").val();
				var id_pekerjaan = $("#id_pekerjaan_penjamin").val();
				var no_telepon = $("#no_telepon_penjamin").val();
				var no_handphone = $("#no_handphone_penjamin").val();
				var no_telepon_kerja = $("#no_telepon_kerja_penjamin").val();
				var email = $("#email_penjamin").val();
				var visit_limit = $("#visit_limit_penjamin").val();
				var co_payment = $("#co_payment_penjamin").val();
				var id_provinsi = $("#id_provinsi3").val();
				var id_kabupaten = $("#id_kabupaten3").val();
				var id_kelurahan = $("#id_kelurahan3").val();
				var id_kecamatan = $("#id_kecamatan3").val();
				var alamat = $("#alamat_penjamin").val();
				var catatan = $("#catatan_penjamin").val();
				var dataString = 'id='+id+'&id_perusahaan='+id_perusahaan+'&id_hubungan='+id_hubungan+'&nama='+nama+'&id_pekerjaan='+id_pekerjaan+'&no_telepon='+no_telepon+'&no_handphone='+no_handphone+'&no_telepon_kerja='+no_telepon_kerja+'&email='+email+'&id_provinsi='+id_provinsi+'&id_kabupaten='+id_kabupaten+'&id_kecamatan='+id_kecamatan+'&id_kelurahan='+id_kelurahan+'&alamat='+alamat+'&catatan='+catatan+'&visit_limit='+visit_limit+'&co_payment='+co_payment;
				
				$.ajax({
					type:'POST',
					data:dataString,
					url:'aksi-edit-pasien-penjamin',
					success:function(data) {
						$("#data_penjamin_pasien").html(data);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-penjamin',
					success: function(msg){
						$("#form_penjamin_pasien").html(msg);
					}
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='penjamin' AND $act=='edit2'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien_penjamin WHERE id='$_POST[id]'"));
		?>
		<input type="hidden" name="id" id="id" value="<?php echo $d['id'];?>">
		<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $d['id_pasien'];?>">
		<fieldset>
			<legend>Edit</legend>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="nik">Panel</label>
						<div class="col-md-8">
							<select name="id_perusahaan_penjamin" id="id_perusahaan_penjamin" class="form-control">
								<option value=""></option>
								<?php 
									$tampil=pg_query($dbconn,"SELECT * FROM master_perusahaan");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_perusahaan']){
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
						<label class="col-md-4 form-control-label" for="nik">Hubungan</label>
						<div class="col-md-8">
							<select name="id_hubungan_penjamin" id="id_hubungan_penjamin" class="form-control">
								<option value=""></option>
								<?php 
									$tampil=pg_query($dbconn,"SELECT * FROM master_hubungan_keluarga");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_hubungan']){
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
						<label class="col-md-4 form-control-label" for="nama_penjamin">Nama</label>
						<div class="col-md-8">
							<input type="text" id="nama_penjamin" name="nama_penjamin" class="form-control" placeholder="Nama" value="<?php echo $d['nama'];?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_pekerjaan_penjamin">Pekerjaan</label>
						<div class="col-md-8">
							<select name="id_pekerjaan_penjamin" id="id_pekerjaan_penjamin" class="form-control">
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
						<label class="col-md-4 form-control-label" for="no_telepon_penjamin">Telepon</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon_penjamin" name="no_telepon_penjamin" class="form-control" placeholder="Telepon" value="<?php echo $d['no_telepon'];?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_handphone_penjamin">No. HP</label>
						<div class="col-md-8">
							<input type="text" id="no_handphone_penjamin" name="no_handphone_penjamin" class="form-control" placeholder="No. Handphone" value="<?php echo $d['no_handphone'];?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="email_penjamin">Email Penjamin</label>
						<div class="col-md-8">
							<input type="email" id="email_penjamin" name="email_penjamin" class="form-control" placeholder="Email" value="<?php echo $d['email'];?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="no_telepon_kerja_penjamin">Telp. Kantor</label>
						<div class="col-md-8">
							<input type="text" id="no_telepon_kerja_penjamin" name="no_telepon_kerja_penjamin" class="form-control" placeholder="Telepon Kantor" value="<?php echo $d['no_telepon_kerja'];?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="visit_limit_penjamin">Visit Limit (Rp)</label>
						<div class="col-md-8">
							<input type="number" id="visit_limit_penjamin" name="visit_limit_penjamin" class="form-control" placeholder="Visit Limit" value="<?php echo $d['visit_limit'];?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="co_payment_penjamin">Co-payment (Rp)</label>
						<div class="col-md-8">
							<input type="number" id="co_payment_penjamin" name="co_payment_penjamin" class="form-control" placeholder="Co-payment" value="<?php echo $d['co_payment'];?>">
						</div>
					</div>
					
				</div>
				
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="id_provinsi3">Provinsi</label>
						<div class="col-md-8">
							<select name="id_provinsi3" id="id_provinsi3" class="form-control">
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
						<label class="col-md-4 form-control-label" for="id_kabupaten3">Kab/Kota</label>
						<div class="col-md-8">
							<select name="id_kabupaten3" id="id_kabupaten3" class="form-control">
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
						<label class="col-md-4 form-control-label" for="id_kecamatan3">Kecamatan</label>
						<div class="col-md-8">
							<select name="id_kecamatan3" id="id_kecamatan3" class="form-control">
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
						<label class="col-md-4 form-control-label" for="id_kelurahan3">Kelurahan</label>
						<div class="col-md-8">
							<select name="id_kelurahan3" id="id_kelurahan3" class="form-control">
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
						<label class="col-md-4 form-control-label" for="alamat_penjamin">Alamat</label>
						<div class="col-md-8">
							<textarea name="alamat_penjamin"  id="alamat_penjamin" class="form-control"><?php echo $d['alamat'];?>"</textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 form-control-label" for="catatan_penjamin">Catatan</label>
						<div class="col-md-8">
							<textarea name="catatan_penjamin" id="catatan_penjamin" class="form-control"><?php echo $d['catatan'];?>"</textarea>
						</div>
					</div>
				</div>
				
				<div class="col-md-12">
					<hr>
					<button type="button" class="btn btn-success btn-sm" id="btnSimpanEditPenjamin2">Simpan</button>
				</div>
			</div>
		</fieldset>
		
		<script type="text/javascript">
			$("#id_provinsi3").change(function(){
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
			
			$("#id_kabupaten3").change(function(){
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
			
			$("#id_kecamatan3").change(function(){
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
			
			$("#btnSimpanEditPenjamin2").click(function(e) {
				e.preventDefault();
				var id = $("#id").val(); 
				var id_pasien = $("#id_pasien").val();
				var id_perusahaan = $("#id_perusahaan_penjamin").val(); 
				var id_hubungan = $("#id_hubungan_penjamin").val(); 
				var nama= $("#nama_penjamin").val();
				var id_pekerjaan = $("#id_pekerjaan_penjamin").val();
				var no_telepon = $("#no_telepon_penjamin").val();
				var no_handphone = $("#no_handphone_penjamin").val();
				var no_telepon_kerja = $("#no_telepon_kerja_penjamin").val();
				var email = $("#email_penjamin").val();
				var visit_limit = $("#visit_limit_penjamin").val();
				var co_payment = $("#co_payment_penjamin").val();
				var id_provinsi = $("#id_provinsi3").val();
				var id_kabupaten = $("#id_kabupaten3").val();
				var id_kelurahan = $("#id_kelurahan3").val();
				var id_kecamatan = $("#id_kecamatan3").val();
				var alamat = $("#alamat_penjamin").val();
				var catatan = $("#catatan_penjamin").val();
				var dataString = 'id='+id+'&id_perusahaan='+id_perusahaan+'&id_hubungan='+id_hubungan+'&nama='+nama+'&id_pekerjaan='+id_pekerjaan+'&no_telepon='+no_telepon+'&no_handphone='+no_handphone+'&no_telepon_kerja='+no_telepon_kerja+'&email='+email+'&id_provinsi='+id_provinsi+'&id_kabupaten='+id_kabupaten+'&id_kecamatan='+id_kecamatan+'&id_kelurahan='+id_kelurahan+'&alamat='+alamat+'&catatan='+catatan+'&visit_limit='+visit_limit+'&co_payment='+co_payment;
				
				$.ajax({
					type:'POST',
					data:dataString,
					url:'aksi-edit-pasien-penjamin2',
					success:function(data) {
						$("#data_penjamin_pasien").html(data);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-penjamin2',
					data: { 
						'id_pasien': id_pasien
					},
					success: function(msg){
						$("#form_penjamin_pasien").html(msg);
					}
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='penjamin' AND $act=='update'){
		
		if($_POST['visit_limit']==''){
			$visit_limit=0;
		}
		else{
			$visit_limit=$_POST['visit_limit'];
		}
		
		if($_POST['co_payment']==''){
			$co_payment=0;
		}
		else{
			$co_payment=$_POST['co_payment'];
			
		}
		
		pg_query($dbconn,"UPDATE master_pasien_penjamin SET id_hubungan='$_POST[id_hubungan]', nama='$_POST[nama]', id_pekerjaan='$_POST[id_pekerjaan]', no_telepon='$_POST[no_telepon]', no_handphone='$_POST[no_handphone]', no_telepon_kerja='$_POST[no_telepon_kerja]', email='$_POST[email]', id_provinsi='$_POST[id_provinsi]', id_kabupaten='$_POST[id_kabupaten]', id_kecamatan='$_POST[id_kecamatan]', id_kelurahan='$_POST[id_kelurahan]', alamat='$_POST[alamat]', id_perusahaan='$_POST[id_perusahaan]', catatan='$_POST[catatan]', visit_limit='$visit_limit', co_payment='$co_payment' WHERE id='$_POST[id]'");
		
		?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="50px">No.</th>
					<th>Nama</th>
					<th>Telepon</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_penjamin WHERE id_session='$_SESSION[id_session]'");
				$no=1;
				while($r=pg_fetch_array($tampil)){
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $r['nama'];?></td>
						<td><?php echo $r['no_telepon'];?></td>
						<td class="text-center">
							<button type="button" class="btn btn-warning btn-xs btnEditPenjamin" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
							<button type="button" class="btn btn-danger btn-xs btnHapusPenjamin" id="<?php echo $r['id'];?>" ><i class="icon-trash"></i></button>
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>
		
		<script>
		$(".btnEditPenjamin").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'edit-pasien-penjamin',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#form_penjamin_pasien").html(msg);
				}
			});
			
		});
		
		$(".btnHapusPenjamin").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-penjamin',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_penjamin_pasien").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-penjamin',
				success: function(msg){
					$("#form_penjamin_pasien").html(msg);
				}
			});
		
		});
		</script>
		<?php
	}
	
	elseif ($module=='penjamin' AND $act=='update2'){
		
		if($_POST['visit_limit']==''){
			$visit_limit=0;
		}
		else{
			$visit_limit=$_POST['visit_limit'];
		}
		
		if($_POST['co_payment']==''){
			$co_payment=0;
		}
		else{
			$co_payment=$_POST['co_payment'];
			
		}
		
		pg_query($dbconn,"UPDATE master_pasien_penjamin SET id_hubungan='$_POST[id_hubungan]', nama='$_POST[nama]', id_pekerjaan='$_POST[id_pekerjaan]', no_telepon='$_POST[no_telepon]', no_handphone='$_POST[no_handphone]', no_telepon_kerja='$_POST[no_telepon_kerja]', email='$_POST[email]', id_provinsi='$_POST[id_provinsi]', id_kabupaten='$_POST[id_kabupaten]', id_kecamatan='$_POST[id_kecamatan]', id_kelurahan='$_POST[id_kelurahan]', alamat='$_POST[alamat]', id_perusahaan='$_POST[id_perusahaan]', catatan='$_POST[catatan]', visit_limit='$visit_limit', co_payment='$co_payment' WHERE id='$_POST[id]'");
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_pasien FROM master_pasien_penjamin WHERE id='$_POST[id]'"));
		?>
		<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $d['id_pasien'];?>">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="50px">No.</th>
					<th>Nama</th>
					<th>Telepon</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_penjamin WHERE id_pasien='$d[id_pasien]'");
				$no=1;
				while($r=pg_fetch_array($tampil)){
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $r['nama'];?></td>
						<td><?php echo $r['no_telepon'];?></td>
						<td class="text-center">
							<button type="button" class="btn btn-warning btn-xs btnEditPenjamin2" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
							<button type="button" class="btn btn-danger btn-xs btnHapusPenjamin2" id="<?php echo $r['id'];?>" ><i class="icon-trash"></i></button>
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>
		
		<script>
		$(".btnEditPenjamin2").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'edit-pasien-penjamin2',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#form_penjamin_pasien").html(msg);
				}
			});
			
		});
		
		$(".btnHapusPenjamin2").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-penjamin2',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_penjamin_pasien").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-penjamin2',
				data: { 
					'id_pasien': id_pasien
				},
				success: function(msg){
					$("#form_penjamin_pasien").html(msg);
				}
			});
		
		});
		</script>
		<?php
	}
	
	elseif ($module=='penjamin' AND $act=='delete'){
		pg_query($dbconn,"DELETE FROM master_pasien_penjamin WHERE id='$_POST[id]'");
		?>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="50px">No.</th>
					<th>Nama</th>
					<th>Telepon</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_penjamin WHERE id_session='$_SESSION[id_session]'");
				$no=1;
				while($r=pg_fetch_array($tampil)){
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $r['nama'];?></td>
						<td><?php echo $r['no_telepon'];?></td>
						<td class="text-center">
							<button type="button" class="btn btn-warning btn-xs btnEditPenjamin" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
							
							<!--<a 	href="aksi-hapus-pasien-penjamin-<?php echo $r['id'];?>"onclick="return confirm('Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>-->
							
							<button type="button" class="btn btn-danger btn-xs btnHapusPenjamin"  id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>
					
		<script>
			$(".btnEditPenjamin").click(function(){
				var id = this.id;
				
				$.ajax({
					type: 'POST',
					url: 'edit-pasien-penjamin',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#form_penjamin_pasien").html(msg);
					}
				});
				
			});
			
			$(".btnHapusPenjamin").click(function(){
				var id = this.id;
				
				$.ajax({
					type: 'POST',
					url: 'aksi-hapus-pasien-penjamin',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#data_penjamin_pasien").html(msg);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-penjamin',
					success: function(msg){
						$("#form_penjamin_pasien").html(msg);
					}
				});
			});
		</script>
		<?php
	}
	
	elseif ($module=='penjamin' AND $act=='delete2'){
		pg_query($dbconn,"DELETE FROM master_pasien_penjamin WHERE id='$_POST[id]'");
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_pasien FROM master_pasien_keluarga WHERE id='$_POST[id]'"));
		?>
		<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $d['id_pasien'];?>">
		
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="50px">No.</th>
					<th>Nama</th>
					<th>Telepon</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_penjamin WHERE id_session='$_SESSION[id_session]'");
				$no=1;
				while($r=pg_fetch_array($tampil)){
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $r['nama'];?></td>
						<td><?php echo $r['no_telepon'];?></td>
						<td class="text-center">
							<button type="button" class="btn btn-warning btn-xs btnEditPenjamin" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
							
							<!--<a 	href="aksi-hapus-pasien-penjamin-<?php echo $r['id'];?>"onclick="return confirm('Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>-->
							
							<button type="button" class="btn btn-danger btn-xs btnHapusPenjamin"  id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							
						</td>
					</tr>
					<?php
					$no++;
				}
				?>
			</tbody>
		</table>
					
		<script>
			$(".btnEditPenjamin").click(function(){
				var id = this.id;
				
				$.ajax({
					type: 'POST',
					url: 'edit-pasien-penjamin',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#form_penjamin_pasien").html(msg);
					}
				});
				
			});
			
			$(".btnHapusPenjamin").click(function(){
				var id = this.id;
				
				$.ajax({
					type: 'POST',
					url: 'aksi-hapus-pasien-penjamin',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#data_penjamin_pasien").html(msg);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-penjamin',
					success: function(msg){
						$("#form_penjamin_pasien").html(msg);
					}
				});
			});
		</script>
		<?php
	}
	
	pg_close($dbconn);
}
?>