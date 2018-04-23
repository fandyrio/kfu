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

	$module=$_GET['module'];
	$act=$_GET['act'];
	
	$tanggal_hari_ini=DateToIndo2($tgl_sekarang);
	if ($module=='pengukuran' AND $act=='input'){
		$result=pg_query($dbconn,"INSERT INTO pasien_pengukuran (id_group, id_pasien, nama_pengukuran, catatan, id_user, waktu_input, status_hapus, id_unit) VALUES ('$_POST[id_group]', '$_POST[id_pasien]', '$_POST[nama_pengukuran]', '$_POST[catatan_pengukuran]', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', 'N', '$_SESSION[id_units]') RETURNING id");
		
		$insert_row = pg_fetch_row($result);
		$insert_id = $insert_row[0];
			
		foreach($_POST['checked'] as $key => $value){
			$id=$value;
			$nilai=$_POST['nilai#'.$value];
			$tanggal=DateToEng($_POST['tanggal#'.$value]);
			$jam=$_POST['jam#'.$value];
			$catatan=$_POST['catatan#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_pengukuran_detail (id_pasien_pengukuran, id_pengukuran, nilai, tanggal, jam, catatan, id_unit) VALUES ('$insert_id', '$id', '$nilai', '$tanggal', '$jam', '$catatan', '$_SESSION[id_units]')");
			
		}
		
		$id_pasien=$_POST['id_pasien'];
		
		?>
		<table class="table">
			<thead>
				<tr>
					<th width="30px">No.</th>
					<th width="80px">Tanggal</th>
					<th width="600px">Nama</th>
					<th>Catatan</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$tampil=pg_query($dbconn,"SELECT * FROM pasien_pengukuran WHERE id_pasien='$id_pasien' AND status_hapus='N' ORDER BY id DESC");
					$no=1;
					while($r=pg_fetch_array($tampil)){
						$a=explode(" ",$r['waktu_input']);
						$tanggal=DateToIndo2($a[0]);
						?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $tanggal;?></td>
							<td><?php echo $r['nama_pengukuran'];?></td>
							<td><?php echo $r['catatan'];?></td>
							<td>
								<button class="btn btn-info btn-xs btnEditPengukuran" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
								<button class="btn btn-danger btn-xs btnHapusPengukuran" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							</td>
						</tr>
						<tr>
							<td colspan="5">
							<table class="table">
								<thead>
									<tr>
										<th width="108px"></th>
										<th width="200px">Pengukuran</th>
										<th width="100px">Nilai</th>
										<th width="100px">Satuan</th>
										<th width="100px">Tanggal</th>
										<th width="100px">Jam</th>
										<th>Catatan</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$pengukuran_detail=pg_query($dbconn,"SELECT * FROM pasien_pengukuran_detail WHERE id_pasien_pengukuran='$r[id]'");
									while($pd=pg_fetch_array($pengukuran_detail)){
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama, satuan FROM master_pengukuran WHERE id='$pd[id_pengukuran]'"));
										$nama_pengukuran=$a['nama'];
										$nama_satuan=$a['satuan'];
										$tanggal=DateToIndo2($pd['tanggal']);
										?>
										<tr>
											<th></th>
											<td><?php echo $nama_pengukuran;?></td>
											<td><?php echo $pd['nilai'];?></td>
											<td><?php echo $nama_satuan;?></td>
											<td><?php echo $tanggal;?></td>
											<td><?php echo $pd['jam'];?></td>
											<td><?php echo $pd['catatan'];?></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
							</td>
						</tr>
						<tr>
							<td colspan="5"></td>
						</tr>
						<?php
						$no++;
					}
				?>
			</tbody>
		</table>
		<?php
	}
	
	elseif ($module=='pengukuran' AND $act=='inputform'){
		$id_pasien=$_POST['id_pasien'];
		?>
		<fieldset>
			<legend>Tambah</legend>
			<form id="tambah_pasien_pengukuran" class="form-horizontal" action="aksi-tambah-pasien-pengukuran" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
				<div class="form-group row">
					<label class="col-sm-1">Kategori</label>
					<div class="col-sm-2">
						<select class="form-control" name="id_group" id="id_group"required>
							<option value="">Pilih</option>
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM master_pengukuran_group ORDER BY nama");
							while($r=pg_fetch_array($tampil)){
								echo"<option value='$r[id]'>$r[nama]</option>";
							}
							?>
						</select>
					</div>
					
					<label class="col-sm-1">Nama</label>
					<div class="col-sm-3">
						<input type="text" name="nama_pengukuran" id="nama_pengukuran" class="form-control" required>
					</div>
					
					<label class="col-sm-1">Catatan</label>
					<div class="col-sm-4">
						<input type="text" name="catatan_pengukuran" id="catatan_pengukuran" class="form-control">
					</div>
				</div>
				
				<div class="form-group">
					<label><strong>Detail</strong></label>
					<div id="detail_form_pengukuran"></div>
				</div>
				<hr>
				<button type="submit" class="btn btn-primary btn-sm" id="btnSimpanPengukuran">Simpan</button>
			</form>
		</fieldset>
		
		<script>
		
		$(document).ready(function (e) {
			$('#tambah_pasien_pengukuran').on('submit',(function(e) {
				e.preventDefault();
				var formData = new FormData(this);
				var id_pasien=$("#id_pasien").val();
				
				var dataString2 = 'id_pasien='+id_pasien;
				var checked = [];
				$("input[name='checked[]']:checked").each(function ()
				{
					checked.push(parseInt($(this).val()));
				});
				
				if(checked==''){
					alert("Tolong pilih salah satu pengukuran");
				}
				else{
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
							$("#data_pengukuran").html(data);
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
				}
			}));
		});

		$(function () {
			$("#id_group").change(function(){
				var id_group=$(this).val();
				$.ajax({
					type 	: 'POST',
					url 	: 'data-master-pengukuran',
					data	: 'id_group='+id_group,
					success	: function(response){
						$('#detail_form_pengukuran').html(response);
					}
				});
				
				$.ajax({
					type 	: 'POST',
					url 	: 'nama-pengukuran',
					data	: 'id_group='+id_group,
					success	: function(response){
						$('#nama_pengukuran').val(response);
					}
				});
			});
			
		});
		
		$(document).ready(function(){
			$(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
		});
		</script>
	<?php
	}
	
	elseif ($module=='pengukuran' AND $act=='tampilkan'){
	?>
	
	<?php
	}
	
	elseif ($module=='pengukuran' AND $act=='edit'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_pengukuran WHERE id='$_POST[id]'"));
		
		?>
		
		<fieldset>
			<legend>Edit</legend>
			<form id="edit_pasien_pengukuran" class="form" action="aksi-edit-pasien-pengukuran" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id" id="id" value="<?php echo $d['id'];?>">
				<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $d['id_pasien'];?>">
				<div class="form-group row">
					<label class="col-sm-1">Kategori</label>
					<div class="col-sm-2">
						<select class="form-control" name="id_group" id="id_group">
							<option value="">Pilih</option>
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM master_pengukuran_group ORDER BY nama");
							while($r=pg_fetch_array($tampil)){
								if($r['id']==$d['id_group']){
									echo"<option value='$r[id]' selected>$r[nama]</option>";
								}
								else{
									echo"<option value='$r[id]'>$r[nama]</option>";
								}
							}
							?>
						</select>
					</div>
					
					<label class="col-sm-1">Nama</label>
					<div class="col-sm-3">
						<input type="text" name="nama_pengukuran" id="nama_pengukuran" class="form-control" value="<?php echo $d['nama_pengukuran'];?>">
					</div>
					
					<label class="col-sm-1">Catatan</label>
					<div class="col-sm-4">
						<input type="text" name="catatan_pengukuran" id="catatan_pengukuran" class="form-control" value="<?php echo $d['catatan'];?>">
					</div>
				</div>
				
				<div class="form-group">
					<label>Detail</label>
					<div id="detail_form_pengukuran">
						<table class="table">
							<thead>
								<th width="20p"></th>
								<th width="150px">Pengukuran</th>
								<th width="100px">Nilai</th>
								<th width="50px">Satuan</th>
								<th width="120px">Tanggal</th>
								<th width="120px">Jam</th>
								<th>Catatan</th>
							</thead>
							<tbody>
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM master_pengukuran WHERE id_group='$d[id_group]'");
						while($r=pg_fetch_array($tampil)){
							$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_pengukuran_detail WHERE id_pasien_pengukuran='$d[id]' AND id_pengukuran='$r[id]'"));
							
							$tanggal=DateToIndo2($p['tanggal']);
						?>
							<tr>
								<td><input type="checkbox" name="checked[]" value="<?php echo $r['id'];?>"<?php if($p['id']!=''){echo "checked";}?>></td>
								<td><?php echo $r['nama'];?></td>
								<td><input type="text" class="form-control" name="nilai#<?php echo $r['id'];?>" value="<?php echo $p['nilai'];?>"></td>
								<td><?php echo $r['satuan'];?></td>
								<td><input type="text" class="form-control date" name="tanggal#<?php echo $r['id'];?>" value="<?php echo $tanggal;?>"></td>
								<td><input type="time" class="form-control" name="jam#<?php echo $r['id'];?>" value="<?php echo $p['jam'];?>"></td>
								<td><input type="text" name="catatan#<?php echo $r['id'];?>" class="form-control" value="<?php echo $p['catatan'];?>"></td>
							</tr>
						<?php
						}
						?>
							</tbody>
						</table>
					</div>
				</div>
				<hr>
				<button type="submit" class="btn btn-primary btn-sm" id="btnSimpanEditPengukuran">Simpan</button>
			</form>
		</fieldset>
		
		<script>
		$(document).ready(function (e) {
			$('#edit_pasien_pengukuran').on('submit',(function(e) {
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
						$("#data_pengukuran").html(data);
					},
					error: function(data){
						//console.log("error");
						//console.log(data);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-pengukuran',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#form_pengukuran").html(msg);
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
	
	elseif ($module=='pengukuran' AND $act=='update'){
		
		
		pg_query($dbconn,"UPDATE pasien_pengukuran SET nama_pengukuran='$_POST[nama_pengukuran]', catatan='$_POST[catatan_pengukuran]', id_user='$_SESSION[login_user]', waktu_input='$tgl_sekarang $jam_sekarang' WHERE id='$_POST[id]'");
		
		$id_pasien=$_POST['id_pasien'];
		
		pg_query($dbconn,"DELETE FROM pasien_pengukuran_detail WHERE id_pasien_pengukuran='$_POST[id]'");
		
		foreach($_POST['checked'] as $key => $value){
			$id=$value;
			$nilai=$_POST['nilai#'.$value];
			$tanggal=DateToEng($_POST['tanggal#'.$value]);
			$jam=$_POST['jam#'.$value];
			$catatan=$_POST['catatan#'.$value];
			
			pg_query($dbconn,"INSERT INTO pasien_pengukuran_detail (id_pasien_pengukuran, id_pengukuran, nilai, tanggal, jam, catatan, id_unit) VALUES ('$_POST[id]', '$id', '$nilai', '$tanggal', '$jam', '$catatan', '$_SESSION[id_units]')");
		}
		?>
		
		<table class="table">
			<thead>
				<tr>
					<th width="30px">No.</th>
					<th width="80px">Tanggal</th>
					<th width="600px">Nama</th>
					<th>Catatan</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$tampil=pg_query($dbconn,"SELECT * FROM pasien_pengukuran WHERE id_pasien='$id_pasien' AND status_hapus='N' ORDER BY id DESC");
					$no=1;
					while($r=pg_fetch_array($tampil)){
						$a=explode(" ",$r['waktu_input']);
						$tanggal=DateToIndo2($a[0]);
						?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $tanggal;?></td>
							<td><?php echo $r['nama_pengukuran'];?></td>
							<td><?php echo $r['catatan'];?></td>
							<td>
								<button class="btn btn-info btn-xs btnEditPengukuran" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
								<button class="btn btn-danger btn-xs btnHapusPengukuran" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							</td>
						</tr>
						<tr>
							<td colspan="5">
							<table class="table">
								<thead>
									<tr>
										<th width="108px"></th>
										<th width="200px">Pengukuran</th>
										<th width="100px">Nilai</th>
										<th width="100px">Satuan</th>
										<th width="100px">Tanggal</th>
										<th width="100px">Jam</th>
										<th>Catatan</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$pengukuran_detail=pg_query($dbconn,"SELECT * FROM pasien_pengukuran_detail WHERE id_pasien_pengukuran='$r[id]'");
									while($pd=pg_fetch_array($pengukuran_detail)){
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama, satuan FROM master_pengukuran WHERE id='$pd[id_pengukuran]'"));
										$nama_pengukuran=$a['nama'];
										$nama_satuan=$a['satuan'];
										$tanggal=DateToIndo2($pd['tanggal']);
										?>
										<tr>
											<th></th>
											<td><?php echo $nama_pengukuran;?></td>
											<td><?php echo $pd['nilai'];?></td>
											<td><?php echo $nama_satuan;?></td>
											<td><?php echo $tanggal;?></td>
											<td><?php echo $pd['jam'];?></td>
											<td><?php echo $pd['catatan'];?></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
							</td>
						</tr>
						<tr>
							<td colspan="5"></td>
						</tr>
						<?php
						$no++;
					}
				?>
			</tbody>
		</table>
		
		<script>
		$(".btnEditPengukuran").click(function(){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'edit-pasien-pengukuran',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#form_pengukuran").html(msg);
				}
			});
			
		});
		
		$(".btnHapusPengukuran").click(function(){
			if(window.confirm("Apakah Anda yakin ingin menghapus pengukuran ini?")){
				var id = this.id;
				var id_pasien=$("#id_pasien").val();
				var dataString2 = 'id_pasien='+id_pasien;
				
				$.ajax({
					type: 'POST',
					url: 'aksi-hapus-pasien-pengukuran',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#data_pengukuran").html(msg);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-pengukuran',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#form_pengukuran").html(msg);
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
	
	elseif ($module=='pengukuran' AND $act=='delete'){
		pg_query($dbconn,"UPDATE pasien_pengukuran SET status_hapus='Y', waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]' WHERE id='$_POST[id]'");
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_pasien FROM pasien_pengukuran WHERE id='$_POST[id]'"));
		$id_pasien=$d['id_pasien'];
		?>

		<table class="table">
			<thead>
				<tr>
					<th width="30px">No.</th>
					<th width="80px">Tanggal</th>
					<th width="600px">Nama</th>
					<th>Catatan</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$tampil=pg_query($dbconn,"SELECT * FROM pasien_pengukuran WHERE id_pasien='$id_pasien' AND status_hapus='N' ORDER BY id DESC");
					$no=1;
					while($r=pg_fetch_array($tampil)){
						$a=explode(" ",$r['waktu_input']);
						$tanggal=DateToIndo2($a[0]);
						?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $tanggal;?></td>
							<td><?php echo $r['nama_pengukuran'];?></td>
							<td><?php echo $r['catatan'];?></td>
							<td>
								<button class="btn btn-info btn-xs btnEditPengukuran" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
								<button class="btn btn-danger btn-xs btnHapusPengukuran" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
							</td>
						</tr>
						<tr>
							<td colspan="5">
							<table class="table">
								<thead>
									<tr>
										<th width="108px"></th>
										<th width="200px">Pengukuran</th>
										<th width="100px">Nilai</th>
										<th width="100px">Satuan</th>
										<th width="100px">Tanggal</th>
										<th width="100px">Jam</th>
										<th>Catatan</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$pengukuran_detail=pg_query($dbconn,"SELECT * FROM pasien_pengukuran_detail WHERE id_pasien_pengukuran='$r[id]'");
									while($pd=pg_fetch_array($pengukuran_detail)){
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama, satuan FROM master_pengukuran WHERE id='$pd[id_pengukuran]'"));
										$nama_pengukuran=$a['nama'];
										$nama_satuan=$a['satuan'];
										$tanggal=DateToIndo2($pd['tanggal']);
										?>
										<tr>
											<th></th>
											<td><?php echo $nama_pengukuran;?></td>
											<td><?php echo $pd['nilai'];?></td>
											<td><?php echo $nama_satuan;?></td>
											<td><?php echo $tanggal;?></td>
											<td><?php echo $pd['jam'];?></td>
											<td><?php echo $pd['catatan'];?></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
							</td>
						</tr>
						<tr>
							<td colspan="5"></td>
						</tr>
						<?php
						$no++;
					}
				?>
			</tbody>
		</table>
					
		<script>
			$(".btnEditPengukuran").click(function(){
				var id = this.id;
				
				$.ajax({
					type: 'POST',
					url: 'edit-pasien-pengukuran',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#form_pengukuran").html(msg);
					}
				});
				
			});
			
			$(".btnHapusPengukuran").click(function(){
				if(window.confirm("Apakah Anda yakin ingin menghapus pengukuran ini?")){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var dataString2 = 'id_pasien='+id_pasien;
					
					$.ajax({
						type: 'POST',
						url: 'aksi-hapus-pasien-pengukuran',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_pengukuran").html(msg);
						}
					});
					
					$.ajax({
						type: 'POST',
						url: 'form-tambah-pasien-pengukuran',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#form_pengukuran").html(msg);
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
	
	elseif ($module=='pengukuran' AND $act=='data_master'){
		?>
		<table class="table">
			<thead>
				<th width="20p"></th>
				<th width="150px">Pengukuran</th>
				<th width="100px">Nilai</th>
				<th width="50px">Satuan</th>
				<th width="120px">Tanggal</th>
				<th width="120px">Jam</th>
				<th>Catatan</th>
			</thead>
			<tbody>
		<?php
		$tampil=pg_query($dbconn,"SELECT * FROM master_pengukuran WHERE id_group='$_POST[id_group]'");
		
		while($r=pg_fetch_array($tampil)){
		?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?php echo $r['id'];?>"></td>
				<td><?php echo $r['nama'];?></td>
				<td><input type="text" class="form-control" name="nilai#<?php echo $r['id'];?>"></td>
				<td><?php echo $r['satuan'];?></td>
				<td><input type="text" class="form-control date" name="tanggal#<?php echo $r['id'];?>" value="<?php echo $tanggal_hari_ini;?>"></td>
				<td><input type="time" class="form-control" name="jam#<?php echo $r['id'];?>" value="00:00:00"></td>
				<td><input type="text" name="catatan#<?php echo $r['id'];?>" class="form-control"></td>
			</tr>
		<?php
		}
		?>
			</tbody>
		</table>
		
		<script type="text/javascript">		
			$(document).ready(function(){
				$(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
			});
		</script>
		<?php
	}
	
	elseif ($module=='pengukuran' AND $act=='nama_pengukuran'){
		$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_pengukuran_group WHERE id='$_POST[id_group]'"));
		echo $d['nama'];
	}
	pg_close($dbconn);
}
?>