<?php
error_reporting(0);
include "../../config/conn.php";

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

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_panggilan WHERE id='$d[id_title]'"));
$nama_panggilan=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_goldar WHERE id='$d[id_goldar]'"));
$nama_goldar=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_status_kawin WHERE id='$d[id_status_kawin]'"));
$nama_status_kawin=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_suku WHERE id='$d[id_suku]'"));
$nama_suku=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_pekerjaan WHERE id='$d[id_pekerjaan]'"));
$nama_pekerjaan=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kebangsaan WHERE id='$d[id_kebangsaan]'"));
$nama_kebangsaan=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_pasien WHERE id='$d[id_kategori_pasien]'"));
$nama_kategori_pasien=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_jenis_pasien WHERE id='$d[id_jenis_pasien]'"));
$nama_jenis_pasien=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_warga_negara WHERE id='$d[id_warga_negara]'"));
$nama_warga_negara=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_bahasa WHERE id='$d[id_bahasa]'"));
$nama_bahasa=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_agama WHERE id='$d[id_agama]'"));
$nama_agama=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_provinsi WHERE id='$d[id_provinsi]'"));
$nama_provinsi=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kabupaten WHERE id='$d[id_kabupaten]'"));
$nama_kabupaten=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kecamatan WHERE id='$d[id_kecamatan]'"));
$nama_kecamatan=$j['nama'];

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kelurahan WHERE id='$d[id_kelurahan]'"));
$nama_kelurahan=$j['nama'];

?>

<div class="card">
	<div class="card-header">
		<strong>Data Pasien</strong>
		<span class="pull-right">
			<a href="edit-pasien-<?php echo $d['id'];?>" class="btn btn-primary btn-xs">EDIT</a>
		</span>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-md-6">
				<p class="title-dark">Demographics<span class="pull-right"><?php echo $jenkel;?></span></p>
				<div class="padding-20">
					<table>
						<tr><td>Member ID</td><td>:</td><td><?php echo $d['customer_id'];?></td></tr>
						<tr><td width="100px">No. RM</td><td width="10px">:</td><td width="200px"><?php echo $d['no_rm'];?></td>
							<td rowspan="3">
								<img src="<?php echo $foto;?>" class="img-fluid img-thumbnail" width="50px">
							</td>
						</tr>
						<tr><td>NIK</td><td>:</td><td><?php echo $d['nik'];?></td></tr>
						<tr><td>ID Lainnya</td><td>:</td><td><?php echo $d['id_lainnya'];?></td></tr>
						<tr><td>Nama</td><td>:</td><td><?php echo $d['nama'];?></td></tr>
						<tr><td>Kategori Pasien</td><td>:</td><td><?php echo $nama_kategori_pasien;?></td></tr>
						<tr><td>Jenis Pasien</td><td>:</td><td><?php echo $nama_jenis_pasien;?></td></tr>
						<tr><td>Pekerjaan</td><td>:</td><td><?php echo $nama_pekerjaan;?></td></tr>
					</table>
				</div>
				<br>
				<p class="title-dark">Alamat</p>
				<div class="padding-20">
					<table>
						<tr><td width="100px">Provinsi</td><td width="10px">:</td><td width="200px"><?php echo $nama_provinsi;?></td></tr>
						<tr><td>Kabupaten/Kota</td><td>:</td><td><?php echo $nama_kabupaten;?></td></tr>
						<tr><td>Kecamatan</td><td>:</td><td><?php echo $nama_kecamatan;?></td></tr>
						<tr><td>Kelurahan</td><td>:</td><td><?php echo $nama_kelurahan;?></td></tr>
						<tr><td>Alamat</td><td>:</td><td><?php echo $d['alamat'];?></td></tr>
					</table>
				</div>
			</div>
			
			<div class="col-md-6">
				<p class="title-dark">Detail Lainnya</p>
				<div class="padding-20">
					<table>
						<tr><td width="100px">Golongan Darah</td><td width="10px">:</td><td><?php echo $nama_goldar;?></td></tr>
						<tr><td>Warga Negara</td><td>:</td><td><?php echo $nama_warga_negara;?></td></tr>
						<tr><td>Bahasa</td><td>:</td><td><?php echo $nama_bahasa;?></td></tr>
						<tr><td>Suku</td><td>:</td><td><?php echo $nama_suku;?></td></tr>
						<tr><td>Agama</td><td>:</td><td><?php echo $nama_agama;?></td></tr>
						<tr><td>Status Kawin</td><td>:</td><td><?php echo $nama_status_kawin;?></td></tr>
						<tr><td>&nbsp;</td><td></td><td></td></tr>
					</table>
				</div>
				<br>
				<p class="title-dark">Telepon</p>
				<div class="padding-20">
					<table>
						<tr><td width="100px">Rumah</td><td width="10px">:</td><td><?php echo $d['no_telepon'];?></td></tr>
						<tr><td>Mobile</td><td>:</td><td><?php echo $d['no_handphone'];?></td></tr>
						<tr><td>Kantor</td><td>:</td><td><?php echo $d['no_telepon_kerja'];?></td></tr>
						<tr><td>Email</td><td>:</td><td><?php echo $d['email'];?></td></tr>
					</table>
				</div>
			</div>
			<div class="col-md-12">
				<br>
				<p class="title-dark">Saudara Biologis</p>
				<div class="padding-20">
					<table class="table">
						<thead>
							<tr>
								<th width="200px">Nama</th>
								<th width="200px">Hubungan</th>
								<th width="100px">Telepon</th>
								<th width="150px">No. Handphone</th>
								<th>Alamat</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_keluarga WHERE id_pasien='$d[id]'");
							while($r=pg_fetch_array($tampil)){
								$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_hubungan_keluarga WHERE id='$r[id_hubungan_keluarga]'"));
								$nama_hubungan_keluarga=$a['nama'];
								
								?>
								<tr>
									<td><?php echo $r['nama'];?></td>
									<td><?php echo $nama_hubungan_keluarga;?></td>
									<td><?php echo $r['no_telepon'];?></td>
									<td><?php echo $r['no_handphone'];?></td>
									<td><?php echo $r['alamat'];?></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<br>
				<p class="title-dark">Penjamin Keluarga</p>
				<div class="padding-20">
					<table class="table">
						<thead>
							<tr>
								<th width="200px">Nama</th>
								<th width="200px">Hubungan</th>
								<th width="100px">Telepon</th>
								<th width="150px">No. Handphone</th>
								<th>Alamat</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_penjamin WHERE id_pasien='$d[id]'");
							while($r=pg_fetch_array($tampil)){
								$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_hubungan_keluarga WHERE id='$r[id_hubungan]'"));
								$nama_hubungan_keluarga=$a['nama'];
								
								?>
								<tr>
									<td><?php echo $r['nama'];?></td>
									<td><?php echo $nama_hubungan_keluarga;?></td>
									<td><?php echo $r['no_telepon'];?></td>
									<td><?php echo $r['no_handphone'];?></td>
									<td><?php echo $r['alamat'];?></td>
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