<?php
switch($_GET['act']){

default:
if(isset($_GET['id_kategori_harga'])){
	$id_kategori_harga=$_GET['id_kategori_harga'];
	
	$tanggal_awal=$_GET['tanggal_awal'];
	$tanggal_akhir=$_GET['tanggal_akhir'];
	$id_unit=$_GET['id_unit'];
}
else{
	$id_kategori_harga=0;
	
	$tanggal_awal=date('d-m-Y', strtotime('-7 days'));
	$tanggal_akhir=date('d-m-Y');
	$id_unit=$_SESSION['id_units'];
}
$tanggal_awal2=DateToEng($tanggal_awal);
$tanggal_akhir2=DateToEng($tanggal_akhir);
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Pasien</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<i class="icon-list"></i> Data Pasien
					</div>
					<div class="card-block">
					<!-- FORM FILTER-->
						<!-- FORM FILTER-->
						<fieldset>
							<legend>Filter</legend>
							<form method="get" class="form-horizontal">
								<div class="form-group row">
								<label class="col-sm-1 form-control-label" >Cabang</label>
										<div class="col-sm-3">
											<?php
											if($_SESSION['id_units']==1){
												$result =pg_query($dbconn, "SELECT p.* FROM master_unit p
															 ORDER BY id");
												$disabled="";
											}else {									
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
									
										<label class="col-sm-1 form-control-label" >Jenis Pasien</label>
										<div class="col-sm-3">
											<?php										
											$result =pg_query($dbconn, "SELECT u.* FROM master_kategori_harga u 
															INNER JOIN master_unit_perusahaan p on p.id_perusahaan=u.id
															where p.id_unit='$_SESSION[id_units]' ORDER BY id");							
											?>
											<select name='id_kategori_harga' class='form-control' required>
											<option value="0">Semua</option>
												<?php 
												while ($row =pg_fetch_assoc($result)){
												if(isset($_GET["cari"]))
												{													 
													 $id_kategori_harga=$_GET["id_kategori_harga"];
													 if($id_kategori_harga== $row['id']){
														  echo "<option value='".$id_kategori_harga."' selected>".$row['nama']."</option>";
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
										<div class="col-sm-3">
										<button type="submit" class="btn btn-primary btn-sm" style="margin-right:10px;" name="cari"><i class="fa fa-search"></i> Tampilkan</button>
										<a href="content/pasien/cetak_pasien.php?<?php echo "id_kategori_harga=$id_kategori_harga&tanggal_awal=$tanggal_awal2&tanggal_akhir=$tanggal_akhir2";?>" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-print"></i> Cetak</a>
										</div>
									
									</div>
									<div class="form-group row">
									<label class="col-sm-1 form-control-label">Tgl. Awal</label>
									<div class="col-sm-2">
										<input id="datepicker" name="tanggal_awal" value="<?php echo $tanggal_awal;?>" class="form-control" required>
									</div>
									
									<label class="offset-sm-1 col-sm-1 form-control-label">Tgl. Akhir</label>
									<div class="col-sm-2">
										<input id="datepicker2" name="tanggal_akhir" value="<?php echo $tanggal_akhir;?>" class="form-control" required>
									</div>
									</div>
								
								
							</form>
						</fieldset>
							<!-- -->
						<div id="printpasien">
						<table class="table  table-condensed" id="myTable">
							<thead>
								<tr>
									<th width="30px">No.</th>
									<th>Tgl Daftar</th>
									<th>Nama Pasien / No. RM</th>
									<th>Tanggal Lahir</th>
									<th>Jenis Kelamin</th>
									<th>Kategori Pasien</th>
									<th width="90px">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								
								if($id_kategori_harga==0){
										$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE status_hapus!='Y' AND id_unit='$id_unit'  AND  tanggal_edit BETWEEN '$tanggal_awal2' AND '$tanggal_akhir2' ORDER BY id desc");
								}
								else{
									$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE status_hapus!='Y' AND id_unit='$id_unit' AND id_perusahaan='$id_kategori_harga'  AND  tanggal_edit BETWEEN '$tanggal_awal2' AND '$tanggal_akhir2'ORDER BY id desc");

								}

								$no=1;
								while($r=pg_fetch_array($tampil)){
									if($r['foto']!=''){
										$foto="<img src='images/pasien/upload_$r[foto]' class='img-fluid img-thumbnail'>";
									}
									else{
										$foto="<img src='images/default.png' class='img-fluid img-thumbnail'>";
									}
									
									$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_jenkel WHERE id='$r[jenkel]'"));
									$k=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$r[id_perusahaan]'"));

									
									$tanggal_lahir=DateToIndo2($r['tanggal_lahir']);
									
									if($r['tempat_lahir']==''){
										$tempat_lahir="-";
									}
									else{
										$tempat_lahir=$r['tempat_lahir'];
									}
									?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo DateToIndo2($r['tanggal_edit']);?></td>
										<td><a href="pasien-detail-<?php echo $r['no_rm'];?>"><?php echo "$r[nama] / $r[no_rm]";?></a></td>
										<td><?php echo "$tanggal_lahir";?></td>
										<td><?php echo $j['nama'];?></td>
										<td><?php echo $k['nama'];?></td>
										<td>
											<a href="edit-pasien-<?php echo "$r[id]";?>" class="btn btn-primary btn-xs" title="Edit Pasien" data-toggle="tooltip" data-placement="top" title="Edit pasien"><i class="icon-note"></i></a>
											<!--<a href="hapus-pasien-<?php echo "$r[id]";?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>-->
											<?php
											if($r['status_kunjungan']=='N'){
											?>
												<a href="antrian?no_rm=<?php echo "$r[no_rm]";?>" class="btn btn-success btn-xs"  data-toggle="tooltip"
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
			<!--/.col-->
		</div>
		<!--/.row-->
	</div>
</div>
<script>

		

		function myFunction() {
		    window.print();
		}

	function printDiv() 
		{

		  var divToPrint=document.getElementById('printpasien');

		  var newWin=window.open('','Print-Window');

		  newWin.document.open();

		  newWin.document.write('<html><head><title>Laporan Data Pasien</title>');
		  newWin.document.write(' <link href="assets/css/style.css" rel="stylesheet"></head><body style="background-image: none !important;"  onload="window.print()">');
		  newWin.document.write('<DIV class="logo"><img src="images/logo_laporan_lab.png" style="position: auto;left: 15px;top: 0px;margin-bottom:-10px;"></DIV>	<div style="text-align:center"><h3>Laporan Pemeriksaan</h3></div><div class="table-border table-stripped">');
		  newWin.document.write(divToPrint.innerHTML);
		  newWin.document.write('</div></body></html>');
		  newWin.document.close();
  
		  var res = window.location;
		}
		</script>
<!-- /.conainer-fluid -->
<?php
break;

case "detail":
$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_GET[no_rm]'"));

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

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_pasien WHERE id='$d[id_kategori_pasien]'"));
$nama_kategori_pasien=$j['nama'];

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

$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_jenis_pasien WHERE id='$d[id_jenis_pasien]'"));
$nama_jenis_pasien=$j['nama'];

$tanggal_lahir=DateToIndo2($d['tanggal_lahir']);


//var_dump(HitungUsia($d['tanggal_lahir']);
$usia=HitungUsia($d['tanggal_lahir']);


$id_pasien=$d['id'];

?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="pasien">Pasien</a></li>
	<li class="breadcrumb-item active">Detail</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		
		<div class="row">
			<div class="col-md-2">
				<div class="card">
					<div class="card-header">
						Pasien
						<div class="pull-right" id="action_button">
						<?php
							$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_perhatian WHERE id_pasien='$d[id]' AND status_aktif='Y' AND status_hapus='N'"));
							if($c['tot']>0){
							?>
							<button type="button" class="btn btn-warning btn-xs btnPerhatianPasien" id="<?php echo $_GET['no_rm'];?>"><i class="fa fa-exclamation-circle"></i></button>
							<?php
							}
							
							$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_peringatan WHERE id_pasien='$d[id]' AND status_aktif='Y' AND status_hapus='N'"));
							if($c['tot']>0){
							?>
							<button type="button" class="btn btn-danger btn-xs btnPeringatanPasien" id="<?php echo $_GET['no_rm'];?>"><i class="fa fa-exclamation-triangle"></i></button>
							<?php
							}
						?>
						</div>
					</div>
					<div class="card-block">
						<table>
							<tr><td width="200px"><i class="icon-note"></i> <b><?php echo $d['no_rm'];?></b></td><td width="50px"><?php echo $jenkel;?></span></td></tr>
							<tr><td colspan="2"><i class="icon-user"></i> <?php echo $d['nama'];?></td></tr>
							<tr><td colspan="2"><i class="icon-calendar"></i> <?php echo "$tanggal_lahir";?></td></tr>
							<!--<tr><td colspan="2">&nbsp; &nbsp; <?php echo "$usia";?></td></tr>-->
						</table>
						<hr>
						<label >Subjective</label><br>
						<?php if($Info_Pasien){ ?>
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnInfoPasien" data-toggle="tooltip" data-placement="right" title="Info Pasien"><i class="icon-arrow-right-circle"></i> Info Pasien</a><br>
						<?php }
						if($Kunjungan_Pasien){ ?>
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnKunjunganPasien" data-toggle="tooltip" data-placement="right" title="Kunjungan Pasien"><i class="icon-arrow-right-circle"></i> Kunjungan</a><br>
						<?php }
						if($Kunjungan_Pasien){ ?>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnPerhatianPasien" data-toggle="tooltip" data-placement="right" title="Perhatian"><i class="icon-arrow-right-circle"></i> Perhatian</a><br>
						<?php }
						if($Peringatan){ ?>
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnKeluhanPasien" data-toggle="tooltip" data-placement="right" title="Keluhan"><i class="icon-arrow-right-circle"></i> Keluhan</a><br>
						<?php }
						?>
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnAmbilSampel" data-toggle="tooltip" data-placement="right" title="Form Pemeriksaan"><i class="icon-arrow-right-circle"></i> Jenis Sampel</a>
						<br>

						 <a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnGambarPasien" data-toggle="tooltip" data-placement="right" title="Gambar"><i class="icon-arrow-right-circle"></i> Gambar</a><br>
						
						<!-- <a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnFormPemeriksaan" data-toggle="tooltip" data-placement="right" title="Form Pemeriksaan"><i class="icon-arrow-right-circle"></i> Form Pemeriksaan</a><br> -->
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnAmbilGambar" data-toggle="tooltip" data-placement="right" title="Ambil Gambar"><i class="icon-arrow-right-circle"></i> Ambil Gambar</a> 
						<hr>

						<label >Objective</label><br>
						
						<!-- <a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnResepPasien" data-toggle="tooltip" data-placement="right" title="Pengambilan Bahan"><i class="icon-arrow-right-circle"></i> Pengambilan Bahan</a><br> -->
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnAnamnesaPasien" data-toggle="tooltip" data-placement="right" title="Anamnesa"><i class="icon-arrow-right-circle"></i> Anamnesa</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnPemeriksaanFisikPasien" data-toggle="tooltip" data-placement="right" title="Pemeriksaan Fisik"><i class="icon-arrow-right-circle"></i> Pemeriksaan Fisik</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnMataPasien" data-toggle="tooltip" data-placement="right" title="Mata"><i class="icon-arrow-right-circle"></i> Pemeriksaan Mata</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnThtPasien" data-toggle="tooltip" data-placement="right" title="THT"><i class="icon-arrow-right-circle"></i> Pemeriksaan THT</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnMulutPasien" data-toggle="tooltip" data-placement="right" title="Mulut"><i class="icon-arrow-right-circle"></i> Pemeriksaan Mulut</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnLeherPasien" data-toggle="tooltip" data-placement="right" title="Leher"><i class="icon-arrow-right-circle"></i> Pemeriksaan Leher</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnThoraxPasien" data-toggle="tooltip" data-placement="right" title="Thorax"><i class="icon-arrow-right-circle"></i> Thorax</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnAbdomenPasien" data-toggle="tooltip" data-placement="right" title="Abdomen"><i class="icon-arrow-right-circle"></i> Abdomen</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnRektalPasien" data-toggle="tooltip" data-placement="right" title="Pemeriksaan Rektal"><i class="icon-arrow-right-circle"></i> Pemeriksaan Rektal</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnExtremitasPasien" data-toggle="tooltip" data-placement="right" title="Extremitas"><i class="icon-arrow-right-circle"></i> Extremitas</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnPemeriksaanNeurologisPasien" data-toggle="tooltip" data-placement="right" title="Pemeriksaan Neurologis"><i class="icon-arrow-right-circle"></i> Neurologis</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnPemeriksaanKulitPasien" data-toggle="tooltip" data-placement="right" title="Pemeriksaan Kulit"><i class="icon-arrow-right-circle"></i> Pemeriksaan Kulit</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnLainPasien" data-toggle="tooltip" data-placement="right" title="Pemeriksaan Lainnya"><i class="icon-arrow-right-circle"></i> Pemeriksaan Lainnya</a>
						<hr>

						<label >Assesment</label><br>
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnOrderPasien" data-toggle="tooltip" data-placement="right" title="Order"><i class="icon-arrow-right-circle"></i> Order Lab dan Tindakan</a><br>
				
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnDiagnosaPasien" data-toggle="tooltip" data-placement="right" title="Diagnosa"><i class="icon-arrow-right-circle"></i> Diagnosa</a><br>
				
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnCatatResep" data-toggle="tooltip" data-placement="right" title="Resep"><i class="icon-arrow-right-circle"></i> 
						Catat Resep</a><br>
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnResepPasien" data-toggle="tooltip" data-placement="right" title="Resep"><i class="icon-arrow-right-circle"></i> 
						Tebus Resep</a>					
						<hr>

						<label >Planning</label><br>
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnHasilLabPasien" data-toggle="tooltip" data-placement="right" title="Hasil Lab"><i class="icon-arrow-right-circle"></i> Hasil Lab</a><br>
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnPemeriksaanFisik" data-toggle="tooltip" data-placement="right" title="Hasil Fisik"><i class="icon-arrow-right-circle"></i> Resume</a><br>
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnKesimpulanAnamnesa" data-toggle="tooltip" data-placement="right" title="Hasil Lab"><i class="icon-arrow-right-circle"></i> Kesimpulan Anamnesa</a>

						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnTindakLanjut" data-toggle="tooltip" data-placement="right" title="Tindak Lanjut"><i class="icon-arrow-right-circle"></i> Tindak Lanjut</a>						
						<hr>

						<label >Billing</label><br>
						<?php
						if($Billing){ ?>
						
						<a href="keuangan-customer-billing-<?php echo $_GET['no_rm'];?>" data-toggle="tooltip" data-placement="right" title="Billing"><i class="icon-arrow-right-circle"></i> Billing</a>
						<?php }?><br>
						<hr>

						<label >Histori</label><br>
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnSingleTestPasien" data-toggle="tooltip" data-placement="right" title="Single Test"><i class="icon-arrow-right-circle"></i> Data Laboratorium</a><br>
						
						<!-- <a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnMultiTestPasien" data-toggle="tooltip" data-placement="right" title="Multi Test"><i class="icon-arrow-right-circle"></i> Data Multi Test</a><br> -->
						
						<a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnNonLabPasien" data-toggle="tooltip" data-placement="right" title="Non-Laboratiorium"><i class="icon-arrow-right-circle"></i> Data Tindakan</a><br>
						
						<!-- <a href="#" id="<?php echo $_GET['no_rm'];?>" class="btnMcuPasien" data-toggle="tooltip" data-placement="right" title="MCU"><i class="icon-arrow-right-circle"></i> MCU</a> -->
						
					</div>
				</div>
			</div>
			
			<div class="col-md-10">
				<div id="data_pasien">
					<div class="card">
						<div class="card-header">
							Data Pasien
							<span class="pull-right">
								<a href="edit-pasien-<?php echo $d['id'];?>" class="btn btn-primary btn-xs">EDIT</a>
							</span>
						</div>
						<div class="card-block">
							<div class="row">
								<div class="col-md-6">
									<p class="title-dark">Demographic <span class="pull-right"><?php echo $jenkel;?></span></p>
									<div class="padding-20">
										<table>
											<tr><td width="100px">No. RM</td><td width="10px">:</td><td width="200px"><?php echo $d['no_rm'];?></td>
												<td rowspan="3">
													<img src="<?php echo $foto;?>" class="img-fluid img-thumbnail" width="50px">
												</td>
											</tr>
											<tr><td>NIK</td><td>:</td><td><?php echo $d['nik'];?></td></tr>
											<tr><td>ID Lainnya</td><td>:</td><td><?php echo $d['id_lainnya'];?></td></tr>
											<tr><td>Nama</td><td>:</td><td><?php echo $nama_panggilan.'. '.$d['nama'];?></td></tr>
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
									
									<!--<br>
									<p class="title-dark">Perusahaan</p>
									<div class="padding-20">
										<table class="table">
											<thead>
												<tr>
													<th>Nama Perusahaan</th>
													<th>Sub Perusahaan</th>
													<th>No. Staff</th>
													<th>Pekerjaan</th>
													<th>Telepon</th>
													<th>Alamat</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_perusahaan WHERE id_pasien='$d[id]'");
												while($r=pg_fetch_array($tampil)){
													$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_perusahaan WHERE id='$r[id_perusahaan]'"));
													$nama_perusahaan=$a['nama'];
													
													?>
													<tr>
														<td><?php echo $nama_perusahaan;?></td>
														<td><?php echo $r['nama_subperusahaan'];?></td>
														<td><?php echo $r['no_staff'];?></td>
														<td><?php echo $r['pekerjaan'];?></td>
														<td><?php echo $r['no_telepon'];?></td>
														<td><?php echo $r['alamat'];?></td>
													</tr>
													<?php
												}
												?>
											</tbody>
										</table>
									</div>
									-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/.col-->
		</div>
		<!--/.row-->
	</div>
</div>

<script type="text/javascript" src="assets/js/ajax/pasien.js"></script>

<?php
$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_perhatian WHERE id_pasien='$d[id]' AND status_aktif='Y' AND status_hapus='N'"));
$c2=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM pasien_peringatan WHERE id_pasien='$d[id]' AND status_aktif='Y' AND status_hapus='N'"));

if($c['tot']>0 AND $c2['tot']>0){
?>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#data_perhatian").modal('show');
		});
	</script>
<?php	
}
else{
	if($c['tot']>0){
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#data_perhatian").modal('show');
		});
	</script>
	<?php
	}


	if($c2['tot']>0){
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#data_peringatan").modal('show');
		});
	</script>
	<?php
	}
}
?>

<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-info" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Gambar</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<img src="" class="enlargeImageModalSource" style="width: 100%;">
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>


<script>
function showDialog2() {
    $("#data_perhatian").removeClass("fade").modal("hide");
    $("#data_peringatan").modal("show").addClass("fade");
}

$("#dialog-ok").on("click", function () {
    showDialog2();
});
</script>
<?php
break;

case "edit":
$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$_GET[id]'"));
$tanggal_lahir=DateToIndo2($d['tanggal_lahir']);
$id_pasien=$d['id'];
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="pasien">Pasien</a></li>
	<li class="breadcrumb-item active">Edit</li>

</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<form class="form-horizontal" method="POST" action="aksi-edit-pasien" enctype="multipart/form-data">
						<input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $d['id'];?>">
						<div class="card-header">
							<i class="fa fa-edit"></i> Edit</b>
						</div>
						<div class="card-block">
							<ul class="nav nav-tabs" role="tablist" id="myTab">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1">Pasien</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3">Saudara Biologis</a>
								</li>
								<!--
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4">Perusahaan</a>
								</li>
								-->
								
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5">Penjamin Keluarga</a>
								</li>
							</ul>

							<div class="tab-content">
								<div class="tab-pane active" id="tab1" role="tabpanel">
									<div class="row">
										<div class="col-md-5">
											<fieldset>
												<legend>Pasien</legend>
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="no_bpjs">Jenis Pasien</label>
													<div class="col-md-9">
														<select name="id_jenis_pasien" class="form-control" id="id_jenis_pasien">
															<?php
															$tampil=pg_query($dbconn,"SELECT * FROM master_jenis_pasien ORDER BY id");
															while($r=pg_fetch_array($tampil)){
																if($r['id']==$d['id_jenis_pasien']){
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
													<label class="col-md-3 form-control-label" for="no_bpjs">No. BPJS</label>
													<div class="col-md-9">
														<input type="text" id="no_bpjs" name="no_bpjs" class="form-control" placeholder="No. Kartu BPJS" value="<?php echo $d['no_bpjs'];?>">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="no_rm">No. RM <span class="red">*</span></label>
													<div class="col-md-9">
														<input type="text" id="no_rm" name="no_rm" class="form-control" placeholder="No. Rekam Medis" disabled required value="<?php echo $d['no_rm'];?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="nik">NIK</label>
													<div class="col-md-9">
														<input type="text" id="nik" name="nik" class="form-control" placeholder="NIK" value="<?php echo $d['nik'];?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="id_lainnya">ID Lainnya</label>
													<div class="col-md-9">
														<input type="text" id="id_lainnya" name="id_lainnya" class="form-control" placeholder="ID Lainnya" value="<?php echo $d['id_lainnya'];?>">
													</div>
													
												</div>
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="nik">Nama <span class="red">*</span></label>
													<div class="col-md-9">
														<input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Lengkap" value="<?php echo $d['nama'];?>">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="tanggal_lahir">Tempat/Tanggal Lahir <span class="red">*</span></label>
													<div class="col-md-5">
														<input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required value="<?php echo $d['tempat_lahir'];?>">
													</div>
													<div class="col-md-4">
														<input id="tanggal_lahir" type="text" name="tanggal_lahir" class="form-control date" placeholder="dd/mm/yyyy" required value="<?php echo $tanggal_lahir;?>">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="id_title">Panggilan</label>
													<div class="col-md-4">
														<select name="id_title" class="form-control">
															<option value="0"></option>
															<?php 
															$tampil=pg_query($dbconn,"SELECT * FROM master_panggilan");
															while($r=pg_fetch_array($tampil)){
																if($r['id']==$d['id_title']){
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
													<label class="col-md-3 form-control-label" for="id_jenis_kelamin">Jenis Kelamin <span class="red">*</span></label>
													<div class="col-md-4">
														<select name="jenkel" class="form-control" required>
															<option value=""></option>
															<?php 
															$tampil=pg_query($dbconn,"SELECT * FROM master_jenkel");
															while($r=pg_fetch_array($tampil)){
																if($r['id']==$d['jenkel']){
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
													<label class="col-md-3 form-control-label" for="id_kategori_pasien">Kategori Pasien</label>
													<div class="col-md-9">
														<select name="id_kategori_pasien" class="form-control">
															<option value=""></option>
															<?php 
															$tampil=pg_query($dbconn,"SELECT * FROM master_kategori_pasien");
															while($r=pg_fetch_array($tampil)){
																if($r['id']==$d['id_kategori_pasien']){
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
													<label class="col-md-3 form-control-label" for="id_pekerjaan">Pekerjaan</label>
													<div class="col-md-9">
														<select name="id_pekerjaan" class="form-control">
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
											</fieldset>
											
											<fieldset>
												<legend>Alamat</legend>
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="id_provinsi">Provinsi</label>
													<div class="col-md-9">
														<select name="id_provinsi" id="id_provinsi" class="form-control">
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
													<label class="col-md-3 form-control-label" for="id_kabupaten">Kab/Kota</label>
													<div class="col-md-9">
														<select name="id_kabupaten" id="id_kabupaten" class="form-control">
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
													<label class="col-md-3 form-control-label" for="id_kecamatan">Kecamatan</label>
													<div class="col-md-9">
														<select name="id_kecamatan" id="id_kecamatan" class="form-control">
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
													<label class="col-md-3 form-control-label" for="id_kelurahan">Kelurahan</label>
													<div class="col-md-9">
														<select name="id_kelurahan" id="id_kelurahan" class="form-control">
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
													<label class="col-md-3 form-control-label" for="alamat">Alamat</label>
													<div class="col-md-9">
														<textarea name="alamat" class="form-control" placeholder="Alamat"><?php echo $d['alamat'];?></textarea>
													</div>
												</div>
											</fieldset>
										</div>
										
										<div class="col-7">
											<div class="form-group row">
												<div class="col-md-8">
													<fieldset>
														<legend>Detail Lainnya</legend>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="id_goldar">G. Darah</label>
															<div class="col-md-9">
																<select name="id_goldar" class="form-control" placeholder="Golongan Darah">
																	<option value="0"></option>
																	<?php
																	$tampil=pg_query($dbconn,"SELECT * FROM master_goldar");
																	while($r=pg_fetch_array($tampil)){
																		if($r['id']==$d['id_goldar']){
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
															<label class="col-md-3 form-control-label" for="id_kebangsaan">W. Negara</label>
															<div class="col-md-9">
																<select name="id_warga_negara" class="form-control">
																	<option value="0"></option>
																	<?php
																	$tampil=pg_query($dbconn,"SELECT * FROM master_warga_negara");
																	while($r=pg_fetch_array($tampil)){
																		if($r['id']==$d['id_warga_negara']){
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
															<label class="col-md-3 form-control-label" for="id_bahasa">Bahasa</label>
															<div class="col-md-9">
																<select name="id_bahasa" class="form-control">
																	<option value="0"></option>
																	<?php
																	$tampil=pg_query($dbconn,"SELECT * FROM master_bahasa");
																	while($r=pg_fetch_array($tampil)){
																		if($r['id']==$d['id_bahasa']){
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
															<label class="col-md-3 form-control-label" for="id_suku">Suku</label>
															<div class="col-md-9">
																<select name="id_suku" class="form-control">
																	<option value="0"></option>
																	<?php
																	$tampil=pg_query($dbconn,"SELECT * FROM master_suku");
																	while($r=pg_fetch_array($tampil)){
																		if($r['id']==$d['id_suku']){
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
															<label class="col-md-3 form-control-label" for="id_agama">Agama</label>
															<div class="col-md-9">
																<select name="id_agama" class="form-control">
																	<option value="0"></option>
																	<?php
																	$tampil=pg_query($dbconn,"SELECT * FROM master_agama");
																	while($r=pg_fetch_array($tampil)){
																		if($r['id']==$d['id_agama']){
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
															<label class="col-md-3 form-control-label" for="id_status_kawin">S. Kawin</label>
															<div class="col-md-9">
																<select name="id_status_kawin" class="form-control">
																	<option value="0"></option>
																	<?php
																	$tampil=pg_query($dbconn,"SELECT * FROM master_status_kawin");
																	while($r=pg_fetch_array($tampil)){
																		if($r['id']==$d['id_status_kawin']){
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
													</fieldset>
													
													<fieldset>
														<legend>Telepon</legend>
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="no_telepon">Rumah</label>
															<div class="col-md-9">
																<input type="text" id="no_telepon" name="no_telepon" class="form-control" placeholder="Rumah" value="<?php echo $d['no_telepon'];?>">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="no_handphone">Mobile</label>
															<div class="col-md-9">
																<input type="text" id="no_handphone" name="no_handphone" class="form-control" placeholder="Mobile" value="<?php echo $d['no_handphone'];?>">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="no_telepon_kerja">Kantor</label>
															<div class="col-md-9">
																<input type="text" id="no_telepon_kerja" name="no_telepon_kerja" class="form-control" placeholder="Kantor" value="<?php echo $d['no_telepon_kerja'];?>">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="nik">Email</label>
															<div class="col-md-9">
																<input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo $d['email'];?>">
															</div>
														</div>
													</fieldset>
												</div>
												
												<div class="col-md-4">
													<fieldset>
														<legend>Foto</legend>
														<?php
														if($d['foto']!=''){
														?>
															<img id="preview_gambar" src="images/pasien/upload_<?php echo $d['foto'];?>"  alt="" class="img-fluid"/>
															<input type="hidden" name="foto" value="<?php echo $d['foto'];?>">
														<?php
														}
														else{
														?>
															<img id="preview_gambar" src="images/icon/default.png"  alt="" class="img-fluid"/>
														<?php
														}
														?>
														<br>
														<label class="fileContainer text-center">
															Pilih Foto
															<input type="file" name="fupload" id="fupload" onChange="readURL(this);" accept="image/*"/>
														</label>
													</fieldset>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="tab-pane" id="tab3" role="tabpanel">
									<div class="row">
										<div class="col-md-12">
											
										</div>
										<div class="col-md-5">
											<fieldset>
												<legend>Data</legend>
												<div id="data_keluarga_pasien">
													<table class="table ">
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
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_keluarga WHERE id_pasien='$d[id]'");
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
																		
																		
																		<button type="button" class="btn btn-danger btn-xs btnHapusKeluarga2" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
																		
																	</td>
																</tr>
																<?php
																$no++;
															}
															?>
														</tbody>
													</table>
												</div>
											</fieldset>
										</div>
										<div class="col-md-7" id="form_keluarga_pasien">
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
										</div>
									</div>
								</div>
								
								<!--tab4-->
								<div class="tab-pane" id="tab4" role="tabpanel">
									<div class="row">
										<div class="col-md-12">
											<fieldset>
												<legend>Data</legend>
												<table class="table ">
													<thead>
														<tr>
															<th width="50px">No.</th>
															<th>Nama</th>
															<th>Telepon</th>
														</tr>
													</thead>
												</table>
											</fieldset>
										</div>
										<div class="col-md-12">
											<fieldset>
												<legend>#</legend>
												<ul class="nav nav-tabs" role="tablist" id="myTab2">
													<li class="nav-item">
														<a class="nav-link active" data-toggle="tab" href="#tab4a" role="tab" aria-controls="tab1">Detail</a>
													</li>
													<!--<li class="nav-item">
														<a class="nav-link" data-toggle="tab" href="#tab4b" role="tab" aria-controls="tab4b">Un-cover items</a>
													</li>-->
													<li class="nav-item">
														<a class="nav-link" data-toggle="tab" href="#tab4c" role="tab" aria-controls="tab4c">Instruksi Biling</a>
													</li>
												</ul>
												<div class="tab-content">
													<div class="tab-pane active" id="tab4a" role="tabpanel">
														
														<!--
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="nama_subperusahaan">Perusahaan</label>
															<div class="col-md-6">
																<select name="id_perusahaan">
																
																</select>
															</div>
														</div>
														-->
														
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="pekerjaan_perusahaan">Pekerjaan</label>
															<div class="col-md-6">
																<input type="text" id="pekerjaan_perusahaan" name="pekerjaan_perusahaan" class="form-control">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="nama_subperusahaan">Perusahaan</label>
															<div class="col-md-6">
																<input type="text" id="nama_subperusahaan" name="nama_subperusahaan" class="form-control">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="no_staff_perusahaan">No. Staff</label>
															<div class="col-md-2">
																<input type="text" id="no_staff_perusahaan" name="no_staff_perusahaan" class="form-control" placeholder="">
															</div>
															<div class="col-md-1"></div>
															<label class="col-md-1 form-control-label" for="id_departemen_perusahaan">Departemen</label>
															<div class="col-md-2">
																<select name="id_departemen_perusahaan" id="id_departemen_perusahaan" class="form-control">
																
																</select>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="valid_from_perusahaan">Valid From</label>
															<div class="col-md-2">
																<input type="text" id="valid_from_perusahaan" name="valid_from_perusahaan" class="form-control" placeholder="">
															</div>
															<div class="col-md-1"></div>
															<label class="col-md-1 form-control-label" for="valid_too_perusahaan">Valid Too</label>
															<div class="col-md-2">
																<input type="text" id="valid_too_perusahaan" name="valid_too_perusahaan" class="form-control" placeholder="">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="visit_limit_perusahaan">Visit Limit</label>
															<div class="col-md-2">
																<input type="number" id="visit_limit_perusahaan" name="visit_limit_perusahaan" class="form-control" placeholder="" value="0">
															</div>
															<div class="col-md-1"></div>
															<label class="col-md-1 form-control-label" for="co_payment_perusahaan">Co-payment</label>
															<div class="col-md-2">
																<input type="number" id="co_payment_perusahaan" name="co_payment_perusahaan" class="form-control" placeholder="" value="0">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="no_telepon_perusahaan">Telepon</label>
															<div class="col-md-2">
																<input type="text" id="no_telepon_perusahaan" name="no_telepon_perusahaan" class="form-control" placeholder="">
															</div>
															<div class="col-md-1"></div>
														</div>
													</div>
													
													<div class="tab-pane" id="tab4b" role="tabpanel">
														<table class="table ">
															<thead>
																<tr>
																	<th>Charge Items</th>
																	<th>Harga</th>
																	<th>Jenis</th>
																</tr>
															</thead>
														</table>
													</div>
													
													<div class="tab-pane" id="tab4c" role="tabpanel">
														
													</div>
												</div>
											</fieldset>
										</div>
									</div>
								</div>
								
								<!--tab5-->
								<div class="tab-pane" id="tab5" role="tabpanel">
								   <div class="row">
										<div class="col-md-5">
											<fieldset>
												<legend>Data</legend>
												<div id="data_penjamin_pasien">
													<table class="table ">
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
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_penjamin WHERE id_pasien='$id_pasien'");
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
												</div>
											</fieldset>
										</div>
										<div class="col-md-7" id="form_penjamin_pasien">
											<fieldset>
												<legend>Tambah</legend>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="nik">Perusahaan</label>
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
															<label class="col-md-4 form-control-label" for="email_penjamin">Email</label>
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
															<label class="col-md-4 form-control-label" for="visit_limit_penjamin">Visit Limit</label>
															<div class="col-md-8">
																<input type="number" id="visit_limit_penjamin" name="visit_limit_penjamin" class="form-control" placeholder="Visit Limit">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="co_payment_penjamin">Co-payment</label>
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
																<textarea name="catatan_penjamin" id="catatan_penjamin" class="form-control"></textarea>
															</div>
														</div>
													</div>
													
													<div class="col-md-12">
														<hr>
														<button type="button" class="btn btn-success btn-sm" id="btnSimpanPenjamin2">Simpan</button>
													</div>
												</div>
											</fieldset>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-sm btn-primary" ><i class="fa fa-dot-circle-o"></i> Simpan</button>
							<a href="pendaftaran" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Batal</a>
						</div>
					</form>
				</div>
			</div>
		</div>		<!--/.row-->
	</div>
</div>

<script src="assets/js/ajax/pendaftaran_keluarga.js" type="text/javascript"></script>
<script src="assets/js/ajax/pendaftaran_penjamin.js" type="text/javascript"></script>

<script type="text/javascript">
$(function () {
	$("#id_jenis_pasien").change(function(){
		var id_jenis_pasien=$(this).val();
		if(id_jenis_pasien==2){
			$("#no_bpjs").prop('disabled', false);
			$("#no_bpjs").focus();
		}
		else{
			$("#no_bpjs").prop('disabled', true);
		}
	});
});
</script>
<?php
break;
}
?>