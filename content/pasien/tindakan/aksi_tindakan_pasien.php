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
	if ($module=='tindakan' AND $act=='input'){
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_kategori_harga FROM kunjungan WHERE id='$_POST[id_kunjungan]'"));
		$id_kategori_harga=$d['id_kategori_harga'];
		
		
		$bt=pg_fetch_array(pg_query($dbconn,"SELECT harga FROM tindakan_kategori_harga_unit WHERE id_tindakan='$_POST[id_tindakan]' AND id_kategori_harga='$id_kategori_harga'"));
		$harga=$bt['harga'];
		
		$result=pg_query($dbconn,"INSERT INTO pasien_tindakan (id_pasien, id_user, waktu_input, status_hapus, harga, catatan, id_tindakan, id_kunjungan, status_billing, id_unit) VALUES ('$_POST[id_pasien]', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', 'N', '$harga', '$_POST[catatan]', '$_POST[id_tindakan]', '$_POST[id_kunjungan]', 'N', '$_SESSION[id_units]') RETURNING id");


		
		$insert_row = pg_fetch_row($result);
		$insert_id = $insert_row[0];
		
		pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, waktu_input, id_kategori_harga, id_detail, kuantitas, status_hapus, id_unit) VALUES ('$_POST[id_pasien]', '$_POST[id_kunjungan]', 'N', '$harga', 'Y', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$id_kategori_harga', '$insert_id', '1', 'N', '$_SESSION[id_units]')");
		
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		?>
		<table class="table">
			<thead>
				<tr>
					<th width="100px">Tanggal</th>
					<th>Kode</th>
					<th>Nama</th>
					<th width="150px">Catatan</th>
					<th width="30px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$tampil=pg_query($dbconn,"SELECT * FROM pasien_tindakan WHERE id_pasien='$id_pasien' AND status_hapus='N' AND id_unit='$_SESSION[id_units]' ORDER BY id DESC");
					while($r=pg_fetch_array($tampil)){
						$a=explode(" ",$r['waktu_input']);
						$tanggal=DateToIndo2($a[0]);
						$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_tindakan]'"));
						$nama_tindakan=$a['nama'];
						$nama_kode=$a['kode'];
						
						$a=pg_fetch_array(pg_query($dbconn,"SELECT status_kunjungan FROM kunjungan WHERE id='$r[id_kunjungan]'"));
						$status_kunjungan=$a['status_kunjungan'];
						?>
						<tr>
							<td><?php echo $tanggal;?></td>
							<td><?php echo $nama_kode;?></td>
							<td><?php echo $nama_tindakan;?></td>
							<td><?php echo $r['catatan'];?></td>
							<td>
								<?php
								if($r['status_billing']='N'){
									if($status_kunjungan=='Y'){
									?>
									<button class="btn btn-danger btn-xs btnHapusTindakan" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
									<?php
									}
								}
								?>
							</td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>

		<script>
		$(".btnHapusTindakan").click(function(){
			if(window.confirm("Apakah Anda yakin ingin menghapus tindakan ini?")){
				var id = this.id;
				
				$.ajax({
					type: 'POST',
					url: 'aksi-hapus-pasien-tindakan',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#data_tindakan").html(msg);
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
	
	elseif ($module=='tindakan' AND $act=='inputform'){
		$tanggal_hari_ini=DateToIndo2($tgl_sekarang);
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		?>
		<fieldset>
			<legend>Tambah</legend>
			<form id="tambah_pasien_tindakan" class="form-horizontal" action="aksi-tambah-pasien-tindakan" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
				<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
				
				<div class="form-group">
					<label>Daftar Tindakan</label>
					<select class="js-example-basic-single form-control" name="id_tindakan" id="id_tindakan">
						<?php
						$tampil=pg_query($dbconn,"Select distinct id_tindakan from tindakan_kategori_harga_unit where id_unit='".$_SESSION['id_units']."' order by id_tindakan asc");

						while($r=pg_fetch_array($tampil)){
							$data=pg_fetch_array(pg_query($dbconn,"Select * from tindakan where id='".$r["id_tindakan"]."' "));

							echo"<option value='$r[id_tindakan]'>$data[nama]</option>";
						}
						?>
					</select>
				</div>
				
				<div class="form-group">
					<label>Catatan</label>
					<textarea name="catatan" class="form-control"></textarea>
				</div>
				<hr>
				<button type="submit" class="btn btn-primary btn-sm" id="btnSimpanTindakan" <?php if($id_kunjungan==''){echo "disabled";}?>>Simpan</button>
			</form>
		</fieldset>
		
		<script>
		$(document).ready(function (e) {
			$('#tambah_pasien_tindakan').on('submit',(function(e) {
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
						$("#data_tindakan").html(data);
					},
					error: function(data){
						//console.log("error");
						//console.log(data);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-tindakan',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#form_tindakan").html(msg);
					}
				});
			}));
		});
		
		$(function () {
			$("#id_group").change(function(){
				var id_group=$(this).val();
				$.ajax({
					type 	: 'POST',
					url 	: 'data-group-tindakan',
					data	: 'id_group='+id_group,
					success	: function(response){
						$('#id_billing_tindakan').html(response);
					}
				});
			});
		});
		</script>
	<?php
	}
	
	
	elseif ($module=='tindakan' AND $act=='delete'){
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_pasien, id_kunjungan FROM pasien_tindakan WHERE id='$_POST[id]'"));
		$id_pasien=$d['id_pasien'];
		$id_kunjungan=$d['id_kunjungan'];
		
		pg_query($dbconn,"UPDATE transaksi_invoice_detail SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', status_hapus='Y' WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan' AND id_unit='$_SESSION[id_units]'");
		pg_query($dbconn,"UPDATE pasien_tindakan SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', status_hapus='Y' WHERE id='$_POST[id]' ");

		

		?>

		<table class="table">
			<thead>
				<tr>
					<th width="100px">Tanggal</th>
					<th>Kode</th>
					<th>Nama</th>
					<th width="150px">Catatan</th>
					<th width="30px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$tampil=pg_query($dbconn,"SELECT * FROM pasien_tindakan WHERE id_pasien='$id_pasien' AND status_hapus='N' AND id_unit='$_SESSION[id_units]' ORDER BY id DESC");
					while($r=pg_fetch_array($tampil)){
						$a=explode(" ",$r['waktu_input']);
						$tanggal=DateToIndo2($a[0]);
						$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_tindakan]'"));
						$nama_tindakan=$a['nama'];
						$nama_kode=$a['kode'];
						
						$a=pg_fetch_array(pg_query($dbconn,"SELECT status_kunjungan FROM kunjungan WHERE id='$r[id_kunjungan]'"));
						$status_kunjungan=$a['status_kunjungan'];
						?>
						<tr>
							<td><?php echo $tanggal;?></td>
							<td><?php echo $nama_kode;?></td>
							<td><?php echo $nama_tindakan;?></td>
							<td><?php echo $r['catatan'];?></td>
							<td>
								<?php
								if($r['status_billing']=='N'){
									if($status_kunjungan=='Y'){
									?>
									<button class="btn btn-danger btn-xs btnHapusTindakan" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
									<?php
									}
								}
								?>
							</td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
					
		<script>
			
			
			$(".btnHapusTindakan").click(function(){
				if(window.confirm("Apakah Anda yakin ingin menghapus tindakan ini?")){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var dataString2 = 'id_pasien='+id_pasien;
					
					$.ajax({
						type: 'POST',
						url: 'aksi-hapus-pasien-tindakan',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_tindakan").html(msg);
						}
					});
					
					$.ajax({
						type: 'POST',
						url: 'form-tambah-pasien-tindakan',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#form_tindakan").html(msg);
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
	elseif ($module=='tindakan' AND $act=='data_group_tindakan'){
		$tampil=pg_query($dbconn,"SELECT * FROM billing_tindakan WHERE id_billing_group='$_POST[id_group]'");
		while($r=pg_fetch_array($tampil)){
			echo"<option value='$r[id]'>$r[kode] - $r[nama]</td>";
		}
	}
	
	pg_close($dbconn);
}
?>