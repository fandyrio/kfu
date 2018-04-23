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
	if ($module=='paket' AND $act=='input'){
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_kategori_harga FROM kunjungan WHERE id='$_POST[id_kunjungan]'"));
		$id_kategori_harga=$d['id_kategori_harga'];
		
		$bt=pg_fetch_array(pg_query($dbconn,"SELECT harga FROM billing_paket_kategori_harga_unit WHERE id_billing_paket='$_POST[id_billing_paket]' AND id_kategori_harga='$id_kategori_harga'"));
		$harga=$bt['harga'];
		
		$result=pg_query($dbconn,"INSERT INTO pasien_billing_paket (id_pasien, id_user, waktu_input, status_hapus, harga, catatan, id_billing_paket, id_kunjungan, id_unit) VALUES ('$_POST[id_pasien]', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', 'N', '$harga', '$_POST[catatan]', '$_POST[id_billing_paket]', '$_POST[id_kunjungan]', '$_SESSION[id_units]') RETURNING id");
		
		$insert_row = pg_fetch_row($result);
		$insert_id = $insert_row[0];
		
		pg_query($dbconn,"INSERT INTO transaksi_invoice_detail (id_pasien, id_kunjungan, jenis, harga, status_aktif, id_user, waktu_input, id_master_kategori_harga, id_detail, kuantitas, status_hapus, id_unit) VALUES ('$_POST[id_pasien]', '$_POST[id_kunjungan]', 'BPT', '$harga', 'Y', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', '$id_kategori_harga', '$insert_id', '1', 'N', '$_SESSION[id_units]')");
		
		$data=pg_query($dbconn,"SELECT * FROM billing_paket_detail WHERE id_billing_paket='$_POST[id_billing_paket]'");
		while($d=pg_fetch_array($data)){
			if($d['jenis']=='T'){
				pg_query($dbconn,"INSERT INTO pasien_tindakan (id_pasien, id_user, waktu_input, status_hapus, id_tindakan, id_kunjungan, id_pasien_billing_paket, id_unit) VALUES ('$_POST[id_pasien]', '$_SESSION[login_user]', '$tgl_sekarang $jam_sekarang', 'N',  '$d[id_detail]', '$_POST[id_kunjungan]', '$insert_id', '$_SESSION[id_units]')");
			}
			elseif($d['jenis']=='L'){
				$result=pg_query($dbconn,"INSERT INTO pasien_laborder (waktu_input, id_user, id_pasien, id_kunjungan, status_hapus, status_jawab, status_track, id_pasien_billing_paket, id_unit) VALUES ('$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$_POST[id_pasien]', '$_POST[id_kunjungan]', 'N', 'N', 'Y', '$insert_id', '$_SESSION[id_units]') RETURNING id");
				
			
				$insert_row = pg_fetch_row($result);
				$insert_id = $insert_row[0];
				
				pg_query($dbconn,"INSERT INTO pasien_laborder_detail (id_lab_order, id_lab_analysis, id_pasien, id_kunjungan, status_temp, id_unit) VALUES ('$insert_id', '$d[id_detail]', '$_POST[id_pasien]', '$_POST[id_kunjungan]', 'N', '$_SESSION[id_units]')");
			}
		}
		
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		?>
		<table class="table">
			<thead>
				<tr>
					<th width="100px">Tanggal</th>
					<th>Nama Paket</th>
					<th width="150px">Catatan</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$tampil=pg_query($dbconn,"SELECT * FROM pasien_billing_paket WHERE id_pasien='$id_pasien' AND status_hapus='N' AND id_unit='$_SESSION[id_units]' ORDER BY id DESC");
					while($r=pg_fetch_array($tampil)){
						$a=explode(" ",$r['waktu_input']);
						$tanggal=DateToIndo2($a[0]);
						$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM billing_paket WHERE id='$r[id_billing_paket]'"));
						$nama_paket=$a['nama_paket'];
						
						$a=pg_fetch_array(pg_query($dbconn,"SELECT status_kunjungan FROM kunjungan WHERE id='$r[id_kunjungan]'"));
						$status_kunjungan=$a['status_kunjungan'];
						?>
						<tr>
							<td><?php echo $tanggal;?></td>
							<td><?php echo $nama_paket;?></td>
							<td><?php echo $r['catatan'];?></td>
							<td>
								<?php
								if($status_kunjungan=='Y'){
								?>
								<button class="btn btn-danger btn-xs btnHapusPaket" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
								<?php
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
		$(".btnHapusPaket").click(function(){
			if(window.confirm("Apakah Anda yakin ingin menghapus paket ini?")){
				var id = this.id;
				
				$.ajax({
					type: 'POST',
					url: 'aksi-hapus-pasien-paket',
					data: { 
						'id': id
					},
					success: function(msg){
						$("#data_paket").html(msg);
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
	
	elseif ($module=='paket' AND $act=='inputform'){
		$tanggal_hari_ini=DateToIndo2($tgl_sekarang);
		$id_pasien=$_POST['id_pasien'];
		$id_kunjungan=$_POST['id_kunjungan'];
		?>
		<fieldset>
			<legend>Tambah</legend>
			<form id="tambah_pasien_paket" class="form-horizontal" action="aksi-tambah-pasien-paket" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
				<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
				
				<div class="form-group">
					<label>Daftar Paket</label>
					<select class="js-example-basic-single form-control" name="id_billing_paket" id="id_billing_paket">
						<?php
						$tampil=pg_query($dbconn,"SELECT * FROM billing_paket ORDER BY nama_paket");
						while($r=pg_fetch_array($tampil)){
							echo"<option value='$r[id]'>$r[nama_paket]</option>";
						}
						?>
					</select>
				</div>
				
				<div class="form-group">
					<label>Catatan</label>
					<textarea name="catatan" class="form-control"></textarea>
				</div>
				<hr>
				<button type="submit" class="btn btn-primary btn-sm" id="btnSimpanPaket" <?php if($id_kunjungan==''){echo "disabled";}?>>Simpan</button>
			</form>
		</fieldset>
		
		<script>
		$(document).ready(function (e) {
			$('#tambah_pasien_paket').on('submit',(function(e) {
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
						$("#data_paket").html(data);
					},
					error: function(data){
						//console.log("error");
						//console.log(data);
					}
				});
				
				$.ajax({
					type: 'POST',
					url: 'form-tambah-pasien-paket',
					data: dataString2,
					cache: false,
					success: function(msg){
						$("#form_paket").html(msg);
					}
				});
			}));
		});
		
		</script>
	<?php
	}
	
	
	elseif ($module=='paket' AND $act=='delete'){
		
		$d=pg_fetch_array(pg_query($dbconn,"SELECT id_pasien, id_kunjungan FROM pasien_billing_paket WHERE id='$_POST[id]'"));
		$id_pasien=$d['id_pasien'];
		$id_kunjungan=$d['id_kunjungan'];
		
		pg_query($dbconn,"UPDATE transaksi_invoice_detail SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', status_hapus='Y' WHERE id_pasien='$id_pasien' AND id_kunjungan='$id_kunjungan'");
		
		pg_query($dbconn,"UPDATE pasien_billing_paket SET waktu_input='$tgl_sekarang $jam_sekarang', id_user='$_SESSION[login_user]', status_hapus='Y' WHERE id='$_POST[id]'");
		
		pg_query($dbconn,"UPDATE pasien_laborder SET status_hapus='Y', id_user='$_SESSION[login_user]', waktu_input='$tgl_sekarang $jam_sekarang' WHERE id_pasien_billing_paket='$_POST[id]'");
		
		pg_query($dbconn,"UPDATE pasien_tindakan SET status_hapus='Y', id_user='$_SESSION[login_user]', waktu_input='$tgl_sekarang $jam_sekarang' WHERE id_pasien_billing_paket='$_POST[id]'");
		?>

		<table class="table">
			<thead>
				<tr>
					<th width="100px">Tanggal</th>
					<th>Nama Paket</th>
					<th width="150px">Catatan</th>
					<th width="80px">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$tampil=pg_query($dbconn,"SELECT * FROM pasien_billing_paket WHERE id_pasien='$id_pasien' AND status_hapus='N' ORDER BY id DESC");
					while($r=pg_fetch_array($tampil)){
						$a=explode(" ",$r['waktu_input']);
						$tanggal=DateToIndo2($a[0]);
						$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM billing_paket WHERE id='$r[id_billing_paket]'"));
						$nama_paket=$a['nama_paket'];
						
						$a=pg_fetch_array(pg_query($dbconn,"SELECT status_kunjungan FROM kunjungan WHERE id='$r[id_kunjungan]'"));
						$status_kunjungan=$a['status_kunjungan'];
						?>
						<tr>
							<td><?php echo $tanggal;?></td>
							<td><?php echo $nama_paket;?></td>
							<td><?php echo $r['catatan'];?></td>
							<td>
								<?php
								if($status_kunjungan=='Y'){
								?>
								<button class="btn btn-danger btn-xs btnHapusPaket" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
								<?php
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
			
			
			$(".btnHapusPaket").click(function(){
				if(window.confirm("Apakah Anda yakin ingin menghapus paket ini?")){
					var id = this.id;
					var id_pasien=$("#id_pasien").val();
					var dataString2 = 'id_pasien='+id_pasien;
					
					$.ajax({
						type: 'POST',
						url: 'aksi-hapus-pasien-paket',
						data: { 
							'id': id
						},
						success: function(msg){
							$("#data_paket").html(msg);
						}
					});
					
					$.ajax({
						type: 'POST',
						url: 'form-tambah-pasien-paket',
						data: dataString2,
						cache: false,
						success: function(msg){
							$("#form_paket").html(msg);
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