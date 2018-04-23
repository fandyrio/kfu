<?php
session_start();
error_reporting(0);


if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../../config/conn.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_tanggal.php";
	include "../../../config/fungsi_thumb.php";

	$module=$_GET['module'];
	$act=$_GET['act'];
	if ($module=='gambar' AND $act=='input'){
		
			
		/**/
		
		define('UPLOAD_DIR', '../../../images/pasien/gambar/');
		$img = $_POST['imgBase64'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$nama_file_unik  = uniqid(). '.png';
		$file = UPLOAD_DIR . $nama_file_unik ;
		$success = file_put_contents($file, $data);
		//print $success ? $file : 'Unable to save the file.';
		/**/
		
		$tgl_sekarang=date('Y-m-d');
		$jam_sekarang=date('h:i:s');
		var_dump($_POST['id']);
		$waktu_gambar=DateToEng($_POST['waktu_gambar']);
		pg_query("DELETE from pasien_gambar where id_pasien='$_POST[id_pasien]'");
		pg_query($dbconn,"INSERT INTO pasien_gambar (id_pasien,waktu_input, id_user, gambar, waktu_gambar, status_hapus) VALUES ('$_POST[id_pasien]', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$nama_file_unik', '$tgl_sekarang $jam_sekarang', 'N')");


		
		
		$id_pasien=$_POST['id_pasien'];
		

		?>
		<table class="table">
			<thead>
				<tr>
					<th width="20px"></th>
					<th width="60px">Tanggal</th>
					<th>Kategori</th>
					<th>Judul</th>
					<th>Catatan</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$tampil=pg_query($dbconn,"SELECT * FROM pasien_gambar WHERE id_pasien='$id_pasien' AND status_hapus='N' ORDER BY waktu_gambar DESC");
					while($r=pg_fetch_array($tampil)){
						$tanggal=DateToIndo2($r['waktu_gambar']);
						$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_gambar_kategori WHERE id='$r[id_kategori]'"));
						$nama_kategori=$a['nama'];
						
						?>
						<tr>
							<td><input type="checkbox" name="id_gambar[]" value="<?php echo $r['id'];?>"></td>
							<td><?php echo $tanggal;?></td>
							<td><?php echo $nama_kategori;?></td>
							<td><?php echo $r['judul'];?></td>
							<td><?php echo $r['catatan'];?></td>
							<td>
								<button class="btn btn-info btn-xs btnEditGambar" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
								<button class="btn btn-danger btn-xs btnHapusGambar" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							</td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>

		<script>
		$(".btnEditGambar").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'edit-pasien-gambar',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#form_gambar").html(msg);
				}
			});
			
		});
		
		
		$(".btnHapusGambar").click(function(){
			if(window.confirm("Apakah Anda yakin ingin menghapus gambar ini?")){
				var id = this.id;
				var id_pasien=$("#id_pasien").val();
				var dataString2 = 'id_pasien='+id_pasien;
				
				$.ajax({
					type: 'POST',
					url: 'aksi-hapus-pasien-gambar',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#data_gambar").html(msg);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-gambar',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#form_gambar").html(msg);
					}
				});
			}
			else{
				return false;
			}
		});
		</script>
		
	<?php
	}
	
	elseif ($module=='gambar' AND $act=='inputform'){
		$tanggal_hari_ini=DateToIndo2($tgl_sekarang);
		$id_pasien=$_POST['id_pasien'];
		?>
		<fieldset>
			<legend>Tambah</legend>
			<form id="tambah_pasien_gambar" class="form" action="aksi-tambah-pasien-gambar" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
				<div class="form-group">
					<label>Tanggal</label>
					<input type="text" name="waktu_gambar" id="waktu_gambar" class="date form-control" required autofocus value="<?php echo $tanggal_hari_ini;?>">
				</div>
				
				<!-- <div class="form-group">
					<label>Kategori</label>
					<select class="form-control" name="id_kategori" id="id_kategori">
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM master_gambar_kategori ORDER BY nama");
						while($r=pg_fetch_array($tampil)){
							echo"<option value='$r[id]'>$r[nama]</option>";
						}
						?>
					</select>
				</div> -->
				
				<div class="form-group">
					<label>Judul</label>
					<input type="text" class="form-control" name="judul" id="judul">
				</div>
				
				<div class="form-group">
					<label>Catatan</label>
					<textarea name="catatan" id="catatan" class="form-control"></textarea>
				</div>
				
				<div class="form-group">
					<label>Gambar</label>
					<div class="row">
						<div class="offset-md-3 col-md-6">
							<img id="preview_gambar" src="images/icon/default.png"  alt="" class="img-fluid"/>
							<br>
							<label class="fileContainer text-center">
								Pilih Gambar
								<input type="file" name="fupload" id="fupload" onChange="readURL(this);" accept="image/*"/>
							</label>
						</div>
					</div>
				</div>
				<hr>
				<button type="submit" class="btn btn-primary btn-sm" id="btnSimpanGambar">Simpan</button>
			</form>
		</fieldset>
		
		<script>
		$(document).ready(function (e) {
			$('#tambah_pasien_gambar').on('submit',(function(e) {
				e.preventDefault();
				var formData = new FormData(this);
				var id_pasien=$("#id_pasien").val();
				
				var dataString2 = 'id_pasien='+id_pasien;
				
				$.ajax({
					type:'POST',
					url: $(this).attr('action'),
					data:formData,
					cache:false,
					contentType: false,
					processData: false,
					success:function(data){
						//console.log("success");
						//console.log(data);
						$("#data_gambar").html(data);
					},
					error: function(data){
						//console.log("error");
						//console.log(data);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-gambar',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#form_gambar").html(msg);
					}
				});
			}));
		});
		
		
		$(document).ready(function(){
			$(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
		});
		</script>
	<?php
	}
	
	elseif ($module=='gambar' AND $act=='tampilkan'){
	?>
	<fieldset>
		<legend>Gambar</legend>
		<div class="row">
			<?php
			//$gambar=explode(",",$_POST['checked']);
			foreach($_POST['checked'] as $value){
				$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_gambar WHERE id='$value'"));
				$tanggal=DateToIndo2($a['waktu_gambar']);
				?>
				<div class="col-md-6">
					<div class="gambar-penyakit-pasien">
					<table class="gambar-penyakit">
						<tr>
							<td>
								<center>
									<img id="myImg" src="images/pasien/gambar/<?php echo "$a[gambar]";?>" class="img-fluid img-zoom">
<!-- 
									<img id="myImg" src="img_fjords.jpg" alt="Trolltunga, Norway" width="300" height="200"> -->
								</center>
							</td>
						</tr>
					</table>
					</div>
					<div class="keterangan-gambar" style="padding-left: 20px">
						<span class="title-gambar"><?php echo $a['judul'];?></span>
						<small><i class="icon-calendar"></i> <?php echo $tanggal;?></small>
						<br>
						<?php echo $a['catatan'];?>
					</div>
				</div>

				<?php
			}


			?>
			<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>
		</div>
		
	</fieldset>
	
	<script>
		$(function() {
			$('.img-zoom').on('click', function() {
				$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
				$('#enlargeImageModal').modal('show');
			});
		});


	</script>
	<?php
	}
	
	elseif ($module=='gambar' AND $act=='edit'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_gambar WHERE id='$_POST[id]'"));
		$waktu_gambar=DateToIndo2($d['waktu_gambar']);
		if($d['gambar']!=''){
			$gambar="images/pasien/gambar/$d[gambar]";
		}
		else{
			$gambar="images/icon/default.png";
		}
		?>
		
		<fieldset>
			<legend>Edit</legend>
			<form id="edit_pasien_gambar" class="form" action="aksi-edit-pasien-gambar" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id" id="id" value="<?php echo $d['id'];?>">
				<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $d['id_pasien'];?>">
				<div class="form-group">
					<label>Tanggal</label>
					<input type="text" name="waktu_gambar" id="waktu_gambar" class="date form-control" required autofocus value="<?php echo $waktu_gambar;?>">
				</div>
				
				<div class="form-group">
					<label>Kategori</label>
					<select class="form-control" name="id_kategori" id="id_kategori">
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM master_gambar_kategori ORDER BY nama");
						while($r=pg_fetch_array($tampil)){
							if($r['id']==$d['id_kategori']){
								echo"<option value='$r[id]' selected>$r[nama]</option>";
							}
							else{
								echo"<option value='$r[id]'>$r[nama]</option>";
							}
						}
						?>
					</select>
				</div>
				
				<div class="form-group">
					<label>Judul</label>
					<input type="text" class="form-control" name="judul" id="judul" value="<?php echo $d['judul'];?>">
				</div>
				
				<div class="form-group">
					<label>Catatan</label>
					<textarea name="catatan" id="catatan" class="form-control"><?php echo $d['catatan'];?></textarea>
				</div>
				
				<div class="form-group">
					<label>Gambar</label>
					<div class="row">
						<div class="offset-md-3 col-md-6">
							<img id="preview_gambar" src="<?php echo $gambar;?>"  alt="" class="img-fluid"/>
							<br>
							<!-- <label class="fileContainer text-center">
								Pilih Gambar
								<input type="file" name="fupload" id="fupload" onChange="readURL(this);" accept="image/*"/>
							</label>
							<input type="hidden" name="gambar" value="<?php echo $d['gambar'];?>"> -->
						</div>
					</div>
				</div>
				<hr>
				<button type="submit" class="btn btn-primary btn-sm" id="btnSimpanGambar">Simpan</button>
			</form>
		</fieldset>
		
		<script>
		$(document).ready(function (e) {
			$('#edit_pasien_gambar').on('submit',(function(e) {
				e.preventDefault();
				var formData = new FormData(this);
				var id_pasien=$("#id_pasien").val();
				
				var dataString2 = 'id_pasien='+id_pasien;
				
				$.ajax({
					type:'POST',
					url: $(this).attr('action'),
					data:formData,
					cache:false,
					contentType: false,
					processData: false,
					success:function(data){
						//console.log("success");
						//console.log(data);
						$("#data_gambar").html(data);
					},
					error: function(data){
						//console.log("error");
						//console.log(data);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-gambar',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#form_gambar").html(msg);
					}
				});
			}));
		});

		
		$(document).ready(function(){
			$(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
		});
		</script>
		<?php
	}
	
	elseif ($module=='gambar' AND $act=='update'){
		
		$acak			 = rand(1,99);
		$lokasi_file     = $_FILES['fupload']['tmp_name'];
		$tipe_file       = $_FILES['fupload']['type'];
		$nama_file       = $_FILES['fupload']['name'];
		$nama_file_unik  = $acak.$nama_file;
		
		if ($_FILES["fupload"]["error"] > 0 OR empty($lokasi_file)){
			$nama_file_unik = "$_POST[gambar]";
		}
	  
		else{
			UploadGambarPasien($nama_file_unik);
			unlink("../../../images/pasien/gambar/upload_$_POST[gambar]"); 
		}
		
		pg_query($dbconn,"UPDATE pasien_gambar SET judul='$_POST[judul]', waktu_gambar='$_POST[waktu_gambar]', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]',  catatan='$_POST[catatan]', id_kategori='$_POST[id_kategori]', gambar='$nama_file_unik' WHERE id='$_POST[id]'");
		
		$id_pasien=$_POST['id_pasien'];
		?>
		
		<table class="table">
			<thead>
				<tr>
					<th width="20px"></th>
					<th width="60px">Tanggal</th>
					<th>Kategori</th>
					<th>Judul</th>
					<th>Catatan</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$tampil=pg_query($dbconn,"SELECT * FROM pasien_gambar WHERE id_pasien='$id_pasien' AND status_hapus='N' ORDER BY waktu_gambar DESC");
					while($r=pg_fetch_array($tampil)){
						$tanggal=DateToIndo2($r['waktu_gambar']);
						$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_gambar_kategori WHERE id='$r[id_kategori]'"));
						$nama_kategori=$a['nama'];
						
						?>
						<tr>
							<td><input type="checkbox" name="id_gambar[]" value="<?php echo $r['id'];?>"></td>
							<td><?php echo $tanggal;?></td>
							<td><?php echo $nama_kategori;?></td>
							<td><?php echo $r['judul'];?></td>
							<td><?php echo $r['catatan'];?></td>
							<td>
								<button class="btn btn-info btn-xs btnEditGambar" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
								<button class="btn btn-danger btn-xs btnHapusGambar" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							</td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
		
		<script>
		$(".btnEditGambar").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'edit-pasien-gambar',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#form_gambar").html(msg);
				}
			});
			
		});
		
		$(".btnHapusGambar").click(function(){
			if(window.confirm("Apakah Anda yakin ingin menghapus gambar ini?")){
				var id = this.id;
				var id_pasien=$("#id_pasien").val();
				var dataString2 = 'id_pasien='+id_pasien;
				
				$.ajax({
					type: 'POST',
					url: 'aksi-hapus-pasien-gambar',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#data_gambar").html(msg);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-gambar',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#form_gambar").html(msg);
					}
				});
				
			}
			else{
				return false;
			}
		});

		</script>
		<?php
	}
	
	elseif ($module=='gambar' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_gambar SET status_hapus='Y', id_user='$_SESSION[login_user]', waktu_input='$tgl_sekarang $jam_sekarang' WHERE id='$_POST[id]'");
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_pasien FROM pasien_gambar WHERE id='$_POST[id]'"));
		$id_pasien=$d['id_pasien'];
		?>

		<table class="table">
			<thead>
				<tr>
					<th width="20px"></th>
					<th width="60px">Tanggal</th>
					<th>Judul</th>
					<th>Catatan</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$tampil=pg_query($dbconn,"SELECT * FROM pasien_gambar WHERE id_pasien='$id_pasien' AND status_hapus='N' ORDER BY waktu_gambar DESC");
					while($r=pg_fetch_array($tampil)){
						$tanggal=DateToIndo2($r['waktu_gambar']);
						$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_gambar_kategori WHERE id='$r[id_kategori]'"));
						$nama_kategori=$a['nama'];
						
						?>
						<tr>
							<td><input type="checkbox" name="id_gambar[]" value="<?php echo $r['id'];?>"></td>
							<td><?php echo $tanggal;?></td>
							<td><?php echo $r['judul'];?></td>
							<td><?php echo $r['catatan'];?></td>
							<td>
								<button class="btn btn-info btn-xs btnEditGambar" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
								<button class="btn btn-danger btn-xs btnHapusGambar" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							</td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
					
		<script>
			$(".btnEditGambar").click(function(){
				var id = this.id;
				
				$.ajax({
					type: 'POST',
					url: 'edit-pasien-gambar',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#form_gambar").html(msg);
					}
				});
				
			});
			
			
			$(".btnHapusGambar").click(function(){
				if(window.confirm("Apakah Anda yakin ingin menghapus gambar ini?")){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var dataString2 = 'id_pasien='+id_pasien;
					
					$.ajax({
						type: 'POST',
						url: 'aksi-hapus-pasien-gambar',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_gambar").html(msg);
						}
					});
					
					$.ajax({
						type: 'POST',
						url: 'form-tambah-pasien-gambar',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#form_gambar").html(msg);
						}
					});
					
				}
				else{
					return false;
				}
			});

		</script>
		<?php
	}
	
	pg_close($dbconn);
}
?>