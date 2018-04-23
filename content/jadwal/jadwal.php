<?php
session_start();
switch($_GET['act']){

	
default:
if(isset($_GET['id_kategori_harga'])){
	$id_kategori_harga=$_GET['id_kategori_harga'];
	$id_unit=$_GET['id_unit'];
	$tanggal_awal=$_GET['tanggal_awal'];
	$tanggal_akhir=$_GET['tanggal_akhir'];
}
else{
	$id_kategori_harga=0;
	$tanggal_awal=date('d-m-Y', strtotime('-7 days'));
	$tanggal_akhir=date('d-m-Y');
	$id_unit=$_SESSION['id_units'];
}
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Jadwal</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i> Data
							
						</div>

						<div class="card-block">
							<fieldset>
								<legend>Filter</legend>
								<form method="GET" class="form-horizontal">
									<div class="form-group row">
										<div class="col-md-9">
											<div class="form-group row">
												<label class="col-sm-2 form-control-label">Cabang</label>
												<div class="col-sm-4">
													<?php
													if($_SESSION['id_units']==1){
														$result =pg_query($dbconn, "SELECT p.* FROM master_unit p
																	 ORDER BY id");
														$disabled="";
													}
													else {									
														$result =pg_query($dbconn, "SELECT p.* FROM master_unit p
																	where p.id='$_SESSION[id_units]' ORDER BY id");
														$disabled="disabled";
													}							
													?>
													<select name='id_unit' class='form-control' <?php echo $disabled; ?>>
														<?php 
														while ($row =pg_fetch_assoc($result)){
														if(isset($_GET["cari"]))
														{													 
															 $id_unit=$_GET["id_unit"];
															 if($id_unit== $row['id']){
																  echo "<option value='".$id_unit."' selected>".$row['nama']."</option>";
																}
																else{
																echo "<option value='".$row['id']."'>".$row['nama']."</option>";
															}									

														}

														 else{
																echo "<option value='".$row['id']."'>".$row['nama']."</option>";
															}

														}
													?>
													</select>
												</div>
												
												<label class="col-sm-2 form-control-label" >Perusahaan</label>
												<div class="col-sm-4">
													<?php										
													$result =pg_query($dbconn, "SELECT u.* FROM master_kategori_harga u 
																	INNER JOIN master_unit_perusahaan p on p.id_perusahaan=u.id
																	where p.id_unit='$_SESSION[id_units]' ORDER BY id");							
													?>
													<select name='id_kategori_harga' class='form-control' required>
														<option value="0">Semua</option>
														<?php 
														while ($row =pg_fetch_assoc($result)){
															if($id_kategori_harga==$row['id']){
																echo"<option value='$row[id]' selected>$row[nama]</option>";
															}
															else{
																echo"<option value='$row[id]'>$row[nama]</option>";
															}									
														}
													?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 form-control-label">Tgl. Awal</label>
												<div class="col-sm-2">
													<input id="datepicker" name="tanggal_awal" value="<?php echo $tanggal_awal;?>" class="form-control" required>
												</div>
												
												<label class="offset-sm-2 col-sm-2 form-control-label">Tgl. Akhir</label>
												<div class="col-sm-2">
													<input id="datepicker2" name="tanggal_akhir" value="<?php echo $tanggal_akhir;?>" class="form-control" required>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<button type="submit" class="btn btn-primary btn-sm" name="cari"><i class="fa fa-search"></i> Tampilkan</button>
											<a href="cetak-jadwal?<?php echo "id_kategori_harga=$id_kategori_harga&tanggal_awal=$tanggal_awal2&tanggal_akhir=$tanggal_akhir";?>" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-print"></i> Cetak</a>
										</div>
									</div>
								</form>
							</fieldset>
							<table class="table  table-condensed" id="myTable">
							<thead>
								<tr>
									<th width="30px">No.</th>
									<th>Jadwal Pemeriksaan</th>
									<th>Nama Pasien / No. RM</th>
									<th>Tempat / Tanggal Lahir</th>
									<th>Jenis Kelamin</th>
									<th>Cabang Terdaftar</th>
									<th width="90px">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(isset($_GET["cari"]))
								{
									$id_kategori_harga=$_GET["id_kategori_harga"];
									$tgl = DateToEng($_GET[tanggal_awal]);
									$tgl_a = DateToEng($_GET[tanggal_akhir]);

									if($id_kategori_harga==0){
									 $tampil=pg_query($dbconn,"SELECT j.*,d.id_pasien FROM jadwal j								
									 INNER JOIN jadwal_detail d on d.id_jadwal=j.id
									 INNER JOIN billing_paket_kategori_harga_unit b on b.id_kategori_harga = j.id_kategori_harga
									 WHERE   j.tanggal between '$tgl' and  '$tgl_a'  and b.id_unit='$_SESSION[id_units]'");

									}
									else{
									$tampil=pg_query($dbconn,"SELECT j.*,d.id_pasien FROM jadwal j								
									 INNER JOIN jadwal_detail d on d.id_jadwal=j.id
									 INNER JOIN billing_paket_kategori_harga_unit b on b.id_kategori_harga = j.id_kategori_harga
									 WHERE  j.id_kategori_harga='$id_kategori_harga' and j.tanggal between '$tgl' and  '$tgl_a' and b.id_kategori_harga='$id_kategori_harga' and b.id_unit='$_SESSION[id_units]'");							
								}

								}else{

									$data =pg_fetch_assoc($result);
									$tampil=pg_query($dbconn,"SELECT j.*,d.id_pasien FROM jadwal j								
									 INNER JOIN jadwal_detail d on d.id_jadwal=j.id
									 WHERE  j.id_kategori_harga='$data[id_kategori_harga]'");

								}

								$no=1;
								while($r=pg_fetch_array($tampil)){
									if($r['foto']!=''){
										$foto="<img src='images/pasien/upload_$r[foto]' class='img-fluid img-thumbnail'>";
									}
									else{
										$foto="<img src='images/default.png' class='img-fluid img-thumbnail'>";
									}
									
									$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$r[id_pasien]'"));
									$u=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_unit WHERE id='$p[id_unit]'"));
									$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_jenkel WHERE id='$p[jenkel]'"));
									$k=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_pasien WHERE id='$p[id_kategori_pasien]'"));
									
									$tanggal_lahir=DateToIndo2($p['tanggal_lahir']);
									
									if($p['tempat_lahir']==''){
										$tempat_lahir="-";
									}
									else{
										$tempat_lahir=$p['tempat_lahir'];
									}
									?>
									<tr>
										
										<td><?php echo $no;?></td>
										<td><?php echo DateToIndo($r[tanggal]);?></td>
										<td><?php echo "$p[nama] / $p[no_rm]";?></td>
										<td><?php echo "$tempat_lahir  $tanggal_lahir";?></td>
										<td><?php echo $j['nama'];?></td>
										<td><?php echo $u['nama'];?></td>
										<td>
											<a href="edit-pasien-<?php echo "$r[id]";?>" class="btn btn-primary btn-xs" title="Edit Pasien" data-toggle="tooltip" data-placement="top" title="Edit pasien"><i class="icon-note"></i></a>
											<!--<a href="hapus-pasien-<?php echo "$r[id]";?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>-->
											<?php
											if($p['status_kunjungan']=='N'){
											?>
												<a href="antrian?no_rm=<?php echo "$p[no_rm]";?>" class="btn btn-success btn-xs"  data-toggle="tooltip"
											data-placement="top" title="Antrian"><i class="icon-login"></i></a>
											<?php
											}
											?>
										</td>
									</tr>
									<?php
									$no++;
								}
								?>
							<tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
break;

case "tambah":
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="jadwal">Jadwal</a></li>
	<li class="breadcrumb-item active">Tambah</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-4 col-lg-4">
				<div class="card">
					<form class="form-horizontal">
					<div class="card-header">
						<i class="icon-user"></i> Pencarian
					</div>
					<div class="card-block">
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="no_rekam_medik">No. Rekam Medis</label>
							<div class="col-md-8">
								<input type="text" id="no_rekam_medik" name="no_rekam_medik" class="form-control" placeholder="No. Rekam Medik" autofocus value="<?php echo $_GET['no_rekam_medik'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="no_bpjs">No. Kartu BPJS</label>
							<div class="col-md-8">
								<input type="text" id="no_bpjs" name="no_bpjs" class="form-control" placeholder="No. Kartu BPJS" value="<?php echo $_GET['no_bpjs'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="nama">Nama</label>
							<div class="col-md-8">
								<input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" value="<?php echo $_GET['nama'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="tanggal_lahir">Tanggal Lahir</label>
							<div class="col-md-8">
								<input id="tanggal_lahir" type="text" name="tanggal_lahir" class="form-control date" placeholder="dd/mm/yyyy" value="<?php echo $_GET['tanggal_lahir'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="id_lainnya">ID Lainnya</label>
							<div class="col-md-8">
								<input type="text" id="id_lainnya" name="id_lainnya" class="form-control" placeholder="ID Lainnya" value="<?php echo $_GET['id_lainnya'];?>">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button type="submit" class="btn btn-sm btn-primary" value="cari_pendaftaran"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
								<a href="#" onclick="history.go(-1)" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Kembali</a>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
			
			<?php
			if(isset($_GET['no_rekam_medik'])){
				?>
					<div class="col-sm-8 col-lg-8">
					<div class="card">
						<div class="card-header">
							<i class="icon-layers"></i> Hasil Pencarian
						</div>
						<div class="card-block">
							<table class="table  table-striped" id="myTable">
								<thead>
									<tr>
										<th width="50px">No.</th>
										<th>No. Rekam Medis</th>
										<th>No. Kartu BPJS</th>
										<th>Nama</th>
										<th>Tanggal Lahir</th>
										<th>ID Lainnya</th>
										<th width="50px">#</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no_rm=$_GET['no_rekam_medik'];
									$no_bpjs=$_GET['no_bpjs'];
									$nama=$_GET['nama'];
									if($_GET['tanggal_lahir']!=''){
										$tanggal_lahir=DateToEng($_GET['tanggal_lahir']);
									}
									else{
										$tanggal_lahir="";
									}
									
									$id_lainnya=$_GET['id_lainnya'];
									
									if($no_rm=='' AND $no_bpjs=='' AND $nama=='' AND $tanggal_lahir=='' AND $id_lainnya==''){
									
									}
									else{
										if($no_rm!=''){
											if($no_bpjs!=''){
												if($nama!=''){
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND nama LIKE '%$nama%' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND nama LIKE '%$nama%'");
														}
													}
												}
												else{
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_bpjs='$no_bpjs'");
														}
													}
												}
											}
											else{
												if($nama!=''){
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND nama LIKE '%$nama%' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND nama LIKE '%$nama%'");
														}
													}
												}
												else{
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm'");
														}
													}
												}
											}
										}
										else{
											if($no_bpjs!=''){
												if($nama!=''){
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND nama LIKE '%$nama%' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND nama LIKE '%$nama%'");
														}
													}
												}
												else{
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_bpjs='$no_bpjs'");
														}
													}
												}
											}
											else{
												if($nama!=''){
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE nama LIKE '%$nama%' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE nama LIKE '%$nama%'");
														}
													}
												}
												else{
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm'");
														}
													}
												}
											}
										}
										$no=1;
										while($r=pg_fetch_array($tampil)){
											$tanggal_lahir=DateToIndo3($r['tanggal_lahir']);
											echo"
											<tr>
												<td>$no</td>
												<td>$r[no_rm]</td>
												<td>$r[no_bpjs]</td>
												<td>$r[nama]</td>
												<td>$tanggal_lahir</td>
												<td>$r[id_lainnya]</td>
												<td>";
													if($r['status_kunjungan']!='Y'){
														echo"<a href='tambah-jadwal-pasien-$r[no_rm]'><button type='button' class='btn btn-xs btn-info'><i class='fa fa-search-plus'></i></button></a>";
													}
												echo"</td>
											</tr>
											";
											$no++;
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>		<!--/.row-->
	</div>
</div>
<?php
break;

case "tambahbaru":

$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_GET[no_rm]'"));
if($d['jenkel']==1){
	$jenkel="<i class='icon-user'></i>";
	$icon_jenkel="<i class='icon-symbol-male'></i>";
}
else{
	$jenkel="<i class='icon-user-female'></i>";
	$icon_jenkel="<i class='icon-symbol-female'></i>";
}

$jp=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_jenis_pasien WHERE id='$d[id_jenis_pasien]'"));
if($d['foto']!=''){
	$gambar="images/pasien/upload_$d[foto]";
}
else{
	$gambar="images/default.png";
}

$tanggal_lahir=DateToIndo2($d['tanggal_lahir']);

$tanggal_hari_ini=DateToIndo2($tgl_sekarang);
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="jadwal">Jadwal</a></li>
	<li class="breadcrumb-item"><a href="tambah-jadwal">Tambah</a></li>
	<li class="breadcrumb-item active">Jadwal Baru</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-4 col-lg-4">
				<div class="card">
					<form class="form-horizontal" action="aksi-tambah-jadwal" method="POST">
					<div class="card-header">
						<i class="icon-calendar"></i> Tambah Jadwal Baru
					</div>
					<div class="card-block">
						<div class="row">
							<div class="col-sm-9">
								<table>
									<tr>
										<td width="20px"><?php echo $jenkel;?></td>
										<td><b><?php echo $d['nama'];?></b></td>
									</tr>
									<tr>
										<td></td>
										<td><?php echo "$tanggal_lahir -  $icon_jenkel";?></td>
									</tr>
									<tr>
										<td></td>
										<td><?php echo $_GET['no_rm'];?></td>
									</tr>
								</table>
							</div>
							<div class="col-sm-3">
								<img src="<?php echo $gambar;?>" class="img-fluid img-thumbnail pull-right" width="70px">
							</div>
						</div>
						<hr>
						<input type="hidden" name="id_pasien" value="<?php echo $d['id'];?>">
						<div class="form-group row">
							<label class="col-md-3 form-control-label" for="tanggal">Tanggal</label>
							<div class="col-md-8">
								<input type="text" id="tanggal" name="tanggal" class="form-control date" placeholder="Tanggal" autofocus value="<?php echo $tanggal_hari_ini;?>" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label" for="tanggal">Jam</label>
							<div class="col-md-8">
								<input type="time" id="jam" name="jam" class="form-control" placeholder="Jam" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label" for="id_poli">Poli</label>
							<div class="col-md-8">
								<select name="id_poli"  class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_departemen ORDER BY nama");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-6">
								<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Simpan</button>
								<a href="#" onclick="history.go(-1)" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Batal</a>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		
		</div>		<!--/.row-->
	</div>
</div>
<?php
break;

case "edit":

$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM jadwal WHERE id='$_GET[id]'"));
$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$p[id_pasien]'"));
if($d['jenkel']==1){
	$jenkel="<i class='icon-user'></i>";
	$icon_jenkel="<i class='icon-symbol-male'></i>";
}
else{
	$jenkel="<i class='icon-user-female'></i>";
	$icon_jenkel="<i class='icon-symbol-female'></i>";
}

$jp=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_jenis_pasien WHERE id='$d[id_jenis_pasien]'"));
if($d['foto']!=''){
	$gambar="images/pasien/upload_$d[foto]";
}
else{
	$gambar="images/default.png";
}

$tanggal_lahir=DateToIndo2($d['tanggal_lahir']);

$tanggal_hari_ini=DateToIndo2($tgl_sekarang);

$tanggal_jadwal=DateToIndo2($p['tanggal']);
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="jadwal">Jadwal</a></li>
	<li class="breadcrumb-item active">Edit</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-4 col-lg-4">
				<div class="card">
					<form class="form-horizontal" action="aksi-edit-jadwal" method="POST">
					<div class="card-header">
						<i class="icon-calendar"></i> Edit
					</div>
					<div class="card-block">
						<div class="row">
							<div class="col-sm-9">
								<table>
									<tr>
										<td width="20px"><?php echo $jenkel;?></td>
										<td><b><?php echo $d['nama'];?></b></td>
									</tr>
									<tr>
										<td></td>
										<td><?php echo "$tanggal_lahir -  $icon_jenkel";?></td>
									</tr>
									<tr>
										<td></td>
										<td><?php echo $_GET['no_rm'];?></td>
									</tr>
								</table>
							</div>
							<div class="col-sm-3">
								<img src="<?php echo $gambar;?>" class="img-fluid img-thumbnail pull-right" width="70px">
							</div>
						</div>
						<hr>
						<input type="hidden" name="id" value="<?php echo $p['id'];?>">
						<div class="form-group row">
							<label class="col-md-3 form-control-label" for="tanggal">Tanggal</label>
							<div class="col-md-8">
								<input type="text" id="tanggal" name="tanggal" class="form-control date" placeholder="Tanggal" autofocus value="<?php echo $tanggal_jadwal;?>" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label" for="tanggal">Jam</label>
							<div class="col-md-8">
								<input type="time" id="jam" name="jam" class="form-control" placeholder="Jam" required value="<?php echo $p['jam'];?>">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-3 form-control-label" for="id_poli">Poli</label>
							<div class="col-md-8">
								<select name="id_poli"  class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_departemen ORDER BY nama");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$p['id_departemen']){
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
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-6">
								<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Simpan</button>
								<a href="#" onclick="history.go(-1)" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Batal</a>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		
		</div>		<!--/.row-->
	</div>
</div>
<?php
break;

case "daftarantrian":
$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM jadwal WHERE id='$_GET[id]'"));
$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$p[id_pasien]'"));
if($d['jenkel']==1){
	$jenkel="<i class='icon-user'></i>";
	$icon_jenkel="<i class='icon-symbol-male'></i>";
}
else{
	$jenkel="<i class='icon-user-female'></i>";
	$icon_jenkel="<i class='icon-symbol-female'></i>";
}

$jp=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_jenis_pasien WHERE id='$d[id_jenis_pasien]'"));
if($d['foto']!=''){
	$gambar="images/pasien/upload_$d[foto]";
}
else{
	$gambar="images/default.png";
}

$tanggal_lahir=DateToIndo2($d['tanggal_lahir']);


$q=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_antrian) AS no_antrian FROM antrian"));
$no_antrian=$q['no_antrian'];
$kode_before = substr($no_antrian,2,6);
$tahun = $thn_sekarang;
$bulan = $bln_sekarang;
$tanggal = $tgl_skrg;

$thn = substr($tahun,-2);
$kode_now = $thn.$bulan.$tanggal;
if($kode_before==$kode_now){
	$no_urut = (int) substr($no_antrian,8,3);
	$no_urut++;
	
	$no_antrian_new = 'QE'.$kode_before.sprintf("%03s",$no_urut);
}
else{
	$no_antrian_new = 'QE'.$kode_now.sprintf("%03s",1);
}
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="pendaftaran">Pendaftaran</a></li>
	<li class="breadcrumb-item active">Antrian</li>

</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-4 col-lg-4">
				<div class="card">
					<form class="form-horizontal" method="POST" action="aksi-tambah-antrian-jadwal">
					<input type="hidden" name="id_pasien" value="<?php echo $d['id'];?>">
					<input type="hidden" name="id_jadwal" value="<?php echo $p['id'];?>">
					<div class="card-header">
						<i class="icon-user"></i> Antrian Baru
					</div>
					<div class="card-block">
						<div class="row">
							<div class="col-sm-9">
								<table>
									<tr>
										<td width="20px"><?php echo $jenkel;?></td>
										<td><b><?php echo $d['nama'];?></b></td>
									</tr>
									<tr>
										<td></td>
										<td><?php echo "$tanggal_lahir -  $icon_jenkel";?></td>
									</tr>
									<tr>
										<td></td>
										<td><?php echo $_GET['no_rm'];?></td>
									</tr>
								</table>
							</div>
							<div class="col-sm-3">
								<img src="<?php echo $gambar;?>" class="img-fluid img-thumbnail pull-right" width="70px">
							</div>
						</div>
						<hr>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="id_lainnya">No Antrian</label>
							<div class="col-md-8">
								<input type="text" id="no_antrian" name="no_antrian" class="form-control" placeholder="No Antrian" value="<?php echo $no_antrian_new;?>" required autofocus>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="id_prioritas">Prioritas</label>
							<div class="col-md-8">
								<select name="id_prioritas" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_prioritas_pasien ORDER BY id");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="id_poli">Poli</label>
							<div class="col-md-8">
								<select name="id_departemen" id="id_poli" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_departemen ORDER BY nama");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$p['id_departemen']){
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
							<label class="col-md-4 form-control-label" for="id_dokter">Dokter</label>
							<div class="col-md-8">
								<select name="id_dokter" id="id_dokter" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_karyawan WHERE id_departemen='$p[id_departemen]' AND id_jabatan='1' ORDER BY nama");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="id_poli">Jenis Kunjungan</label>
							<div class="col-md-8">
								<select name="id_jenis_kunjungan" id="id_jenis_kunjungan" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM kunjungan_jenis ORDER BY id");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="id_poli">Kategori Harga</label>
							<div class="col-md-8">
								<select name="id_kategori_harga" id="id_kategori_harga" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_kategori_harga ORDER BY id");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="catatan">Catatan</label>
							<div class="col-md-8">
								<textarea name="catatan" class="form-control"></textarea>
							</div>
						</div>
						
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-6">
								<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Simpan</button>
								<a href="javascript: window.history.go(-1)" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Batal</a>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>		<!--/.row-->
	</div>
</div>

<script type="text/javascript">
$("#id_poli").change(function(){
	var id_poli=$(this).val();
	$.ajax({
		type 	: 'POST',
		url 	: 'data-dokter',
		data	: 'id_poli='+id_poli,
		success	: function(response){
			$('#id_dokter').html(response);
		}
	});
});
</script>
<?php
break;
}
?>