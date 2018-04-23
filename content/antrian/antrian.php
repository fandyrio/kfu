<?php
$idLogin=$_SESSION['login'];

$getDataLogin=pg_query("select * from auth_users au join master_karyawan mk on mk.id=au.id_karyawan where au.id_users='$idLogin'");
$fetchDataLogin=pg_fetch_assoc($getDataLogin);

$getDataUnit=pg_query("SELECT * from master_unit where id='$_SESSION[id_units]'");
$fetchDataUnit=pg_fetch_array($getDataUnit);
$idOutlet=$fetchDataUnit['id_outlet'];


if($_GET['on']){
	$_SESSION['checked']= 'checked';

}
else{
	unset($_SESSION['checked']);
}
switch($_GET['act']){
default:
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

$tgl_sekarang = date("Y-m-d");
		$jam_sekarang = date("H:i:s");

$tanggal_lahir=DateToIndo2($d['tanggal_lahir']);

$unit=pg_fetch_array(pg_query($dbconn,"SELECT kode FROM master_unit WHERE id='$_SESSION[id_units]'"));
$kode=$unit['kode'];

$q=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_antrian) AS no_antrian FROM antrian WHERE id_unit='$_SESSION[id_units]' and waktu_masuk > '$tgl_sekarang 00:00:00'"));
$no_antrian=$q['no_antrian'];


$tahun = $thn_sekarang;
$bulan = $bln_sekarang;
$tanggal = $tgl_skrg;
$thn = substr($tahun,-2);


$tglBefore=substr($no_antrian,6,6);
var_dump($no_antrian);

$tglNow = $thn.$bulan.$tanggal;
if($tglNow==$tglBefore){
	$urut_before = substr($no_antrian,12,3);//228
	$urut_before++;
	
	$no_antrian_new = $kode.$tglNow.sprintf("%03s",$urut_before);
	
}
else{
	$no_antrian_new = $kode.$tglNow.sprintf("%03s",1);
	
}

//=============================================
		//Get Max Antiran from antrian_reservasi
		$tgl_sekarang = date("Y-m-d");
		$jam_sekarang = date("H:i:s");	
		$antrianUnit=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_antrian) AS no_antrian FROM antrian_reservasi WHERE id_unit='$_SESSION[id_units]'"));
		$no_antrian_unit=$antrianUnit['no_antrian'];


		$tahun = $thn_sekarang;
		$bulan = $bln_sekarang;
		$tanggal = $tgl_skrg;
		$thn = substr($tahun,-2);


		$tglBefore=substr($no_antrian_unit,6,6);

		$tglNow = $thn.$bulan.$tanggal;
		if($tglNow==$tglBefore){
			$urut_before = substr($no_antrian_unit,12,3);//228
			$urut_before++;
				
			$no_antrian_reservasi_new = $kode.$tglNow.sprintf("%03s",$urut_before);		
		}
		else
		{
			$no_antrian_reservasi_new = $kode.$tglNow.sprintf("%03s",1);	
		}

		/*for($x=1;$x<=5;$x++)
		{
			var_dump($no_antrian_reservasi_new);
			$no_antrian_reservasi_new++;echo"<br />";
		}*/

		//==============================================

		if($no_antrian_new!=NULL || $no_antrian_reservasi_new!=NULL)
		{
			if($no_antrian_new == $no_antrian_reservasi_new)
			{
				$antrianReservasi=$no_antrian_reservasi_new;
			}
			else if($no_antrian_new > $no_antrian_reservasi_new)
			{
				$antrianReservasi=$no_antrian_new++;
			}
			else if($no_antrian_new < $no_antrian_reservasi_new)
			{		
				$antrianReservasi=$no_antrian_reservasi_new++;
			}
		}
		else
		{
			$antrianReservasi=$kode.$tglNow.sprintf("%03s",1);
		}
		
		if($_GET['idAntrian']!=NULL)
		{
			$antrianReservasi=$_GET['idAntrian'];
			$antrian='online'; //flag reservasi online
		}
		else
		{
			$antrianReservasi=$antrianReservasi;
			$antrian='manual';//flag reservasi manual
		}

if(isset($_GET['id_kategori_harga'])){
	$id_kategori_harga=$_GET['id_kategori_harga'];
	$id_segmen=$_GET['id_segmen'];
	$tanggal_awal=$_GET['tanggal_awal'];
	$tanggal_akhir=$_GET['tanggal_akhir'];
}
else{
	$id_kategori_harga=0;
	$id_segmen=0;
	$tanggal_awal=date('d-m-Y', strtotime('-7 days'));
	$tanggal_akhir=date('d-m-Y');
}
$tanggal_awal2=DateToEng($tanggal_awal);
$tanggal_akhir2=DateToEng($tanggal_akhir);
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Antrian</li>
	<li class="breadcrumb-menu d-md-down-none">

		<?php
			if(!$_GET['no_rm']){
		?>
		<div class="btn-group" role="group" aria-label="Button group">
			<a class="btn" href="#"><i class="icon-clock"></i> <span id="waktu_countdown" class="red">30</span> <span class="red">detik<span></a>
		</div>
		<?php
		}



		?>
	</li>
</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<?php
			if($_GET['no_rm']){
				$no_rm=$_GET['no_rm'];
				$getData=pg_query("SELECT * from master_pasien where no_rm='$no_rm'");
			?>
			<div class="col-md-12">
				<div class="card">
					<form class="form-horizontal" method="POST" action="aksi-tambah-antrian">
					<input type="hidden" name="id_pasien" value="<?php echo $d['id'];?>">
					<div class="card-header">
						<i class="icon-login"></i> Antrian Baru
					</div>
					<div class="card-block">


						<div class="row">
							<div class="col-sm-9">
								<table>
									<tr>
										<td width="20px"><?php echo $jenkel;?></td>
										<td><b><?php echo $d['nama'];?></b> </td>
											
											
									</tr>
									<tr>
										<td></td>
										<td><?php echo "$tanggal_lahir -  $icon_jenkel";?></td>
									</tr>
									<tr>
										<td></td>
										<td><?php echo $_GET['no_rm'];?></td>
									</tr>
									<tr>
										<td></td>
										<td><?php echo $d['jabatan_karyawan'];?></td>
									</tr>
								</table>
							</div>
							<div class="col-sm-3">
								<img src="<?php echo $gambar;?>" class="img-fluid img-thumbnail pull-right" width="70px">
							</div>
						</div>
						<hr>
						<div class="form-group row">
							<label class="col-md-1 form-control-label" for="id_lainnya">No Antrian</label>
							<div class="col-md-2">
								<input type="text" id="no_antrian" name="no_antrian" class="form-control" placeholder="No Antrian" value="<?php echo $antrianReservasi;?>" required>
								<input type="hidden" id="status_antrian" name="status_antrian" class="form-control" placeholder="status_antrian" value="<?php echo $antrian;?>" required>
							</div>

							<label class="offset-md-1 form-control-label" for="id_poli">Poly</label>
							<div class="col-md-3">

							
									<?php
									if($_GET['idDokter']!="")
									{
										$getDokter=pg_query("SELECT * from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id_dokter='$_GET[idDokter]'");
										$fetchDokter=pg_fetch_assoc($getDokter);
										$namaPoly=$fetchDokter['name'];
										$idPoly=$fetchDokter['poly_id'];
										echo"
										<input type='hidden' name='poly' value='$idPoly'>
										<input type='text' name='Namapoly' value='$namaPoly' class='form-control'>";
									}
									else
									{
										$getPoly=pg_query("SELECT * from poly_perklinik ppk join master_poly mp on mp.id=ppk.id_poly where id_klinik='$_SESSION[id_units]'");
										?>
										<select name="poly" id="poly" class="form-control" required>
											<option value="0">pilih</option>
										<?php
										while($fetchPoly=pg_fetch_assoc($getPoly))
										{
											echo "<option value='$fetchPoly[id]'>$fetchPoly[name]</option>";
										}
										?>
										</select>
										<?php
									}

									?>
								
							</div>
						
							<label class="offset-md-1 form-control-label" for="id_dokter">Dokter</label>
							<div class="col-md-3">
								<?php
								if($_GET['idDokter']!="")
								{
									$getDokter=pg_query("SELECT * from master_karyawan where id_dokter='$_GET[idDokter]'");
									$fetchDokter=pg_fetch_assoc($getDokter);
									$namaDokter=$fetchDokter['nama'];
									$idDokter=$fetchDokter['id'];
								}
								else
								{
									$namaDokter="";
									$idDokter="";
								}
								?>
								<input type="text" name="nama_dokter" id="nama_dokter" class="form-control" value="<?php echo $namaDokter; ?>">
								<input type="hidden" name="id_dokter" id='id_dokter' value="<?php echo $idDokter ?>">
								<div id="listDokter" style="border:1px solid black;position:absolute;display:none;width:260px;background-color:white;"></div>
							</div>	
						</div>
						<div class="form-grop row">
							<label class="col-md-1 form-control-label" for="id_poli">Penjamin</label>
							<div class="col-md-2">
								<select name="id_kategori_harga" id="id_kategori_harga" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_kategori_harga where id_outlet='$idOutlet' or id=0 ORDER BY id");
									while($r=pg_fetch_array($tampil)){
										if($d['id_perusahaan']==$r['kode_penjamin']){
											echo"<option value='$d[id_perusahaan]' selected>$r[nama]</option>";

										}else{
										echo"<option value='$r[kode_penjamin]'>$r[nama]</option>";
										}
									}
									?>
								</select>
							</div>

							<label class="offset-md-1 col-md-1 form-control-label" for="id_prioritas">Prioritas</label>
							<div class="col-md-2">
								<select name="id_prioritas" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_prioritas_pasien ORDER BY id");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
									?>
								</select>
							</div>
							<div class="col-md-2">
							<div class="checkbox" id="test">
								<?php
									if($d['id_perusahaan']=="005001000")
									{
										?>
												<label><input type="checkbox" class="form-control prb" name="prb" value="Y">Status PRB</label>
										<?php
									}
									?>
							</div>
							</div>
						</div>
						<hr />
						<div class="form-grop row">
							<?php
								$getDataPasien=pg_query("SELECT * from master_pasien where no_rm='$no_rm'");
								$fetchDataPasien=pg_fetch_array($getDataPasien);
									if($fetchDataPasien['customer_id']=="" && isset($_GET['idDokter']) && $_GET['id_dokter']!="")
									{
										?>
											<label class="col-md-1 form-control-label" for="id_prioritas">CustomerID</label>
											<div class="col-md-2">
												<input type="text" class="form-control prb" name="customerID" required autfocus>
												<input type="hidden" class="form-control prb" name="reservasiID" value="<?php echo $_GET['idReservasi'] ?>" required autfocus>	
											</div>
										<?php
									}
										?>
						</div>
						

						<!-- 
							<label class="col-md-1 form-control-label" for="id_dokter">Segmen</label>
							<div class="col-md-2">
								<select name="id_segmen" id="id_segmen" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM segmen ORDER BY id asc");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
									?>
								</select>
							</div>

							<label class="offset-md-1 col-md-1 form-control-label">Detail Segmen</label>
							<div class="col-md-3" id="detail_paket">
								<input type="text" name="detail_segmen" class="form-control">
							</div> -->
						
						
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-6">
								<button type="submit" class="btn btn-sm btn-primary save"><i class="fa fa-dot-circle-o"></i> Simpan</button>
								<a href="javascript: window.history.go(-1)" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Batal</a>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
			<?php
			}
			else{
			?>
			<div class="col-sm-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<i class="icon-grid"></i> Data
					</div>
					<div class="card-block">
					<!-- FORM FILTER-->
						<fieldset>
							<legend>Filter</legend>
							<form method="get" class="form-horizontal">
								<div class="form-group row">
									<div class="col-sm-9">
										<div class="form-group row">
											<label class="col-sm-2 form-control-label" >Penjamin</label>
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
											
											<label class="col-sm-2 form-control-label">Segmens</label>
											<div class="col-sm-4">
												<select name="id_segmen" id="id_segmen" class="form-control" required>
													<option value="0">Semua</option>
													<?php
													$tampil=pg_query($dbconn,"SELECT * FROM segmen ORDER BY id asc");
													while($r=pg_fetch_array($tampil)){
														if($id_segmen==$r['id']){
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
										
										<div class="form-group row" style='display:'>
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
								
									<div class="col-sm-3">
										<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Tampilkan</button>
										<a href="cetak-antrian?<?php echo "id_kategori_harga=$id_kategori_harga&id_segmen=$id_segmen&tanggal_awal=$tanggal_awal2&tanggal_akhir=$tanggal_akhir2";?>" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-print"></i> Cetak</a>
									</div>
								</div>
							</form>
						</fieldset>
						<?php
						if(isset($_GET['status']))
						{
							if($_GET['status']=="NKF")
							{
								echo"<div class='btn btn-danger btn-xs'>Pasien sudah tidak bisa mendaftar</div>";	
							}
							else 
							{
								echo"<div class='btn btn-warning btn-xs'>Pasien disarankan untuk pindah Faskes</div>";
							}
							
						}

						?>
							<!-- -->
						<div id="data_antrian">
						<table class="table" id="myTable">
							<thead>
								<tr>
									<th width="50px"></th>
									<th width="160px">Jam Masuk</th>
									<th>No. Antrian</th>
									<th>Nama Pasien / No. RM</th>
									<th>Nama Dokter</th>
									<th>Penjamin</th>
									<th width="120px">#</th>
								</tr>
							</thead>
							<tbody>
								<?php

								//var_dump($id_kategori_harga);
								/*if($fetchDataLogin['id_level']==2)
								{
									if($id_kategori_harga==0){
										if($id_segmen==0){
											$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE id_dokter='$fetchDataLogin[id_dokter]' AND status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' AND  waktu_masuk BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' ORDER BY id_prioritas DESC , no_antrian");
										}
										else{
											$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE id_dokter='$fetchDataLogin[id_dokter]' and status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' AND  id_segmen='$id_segmen' AND waktu_masuk BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' ORDER BY id_prioritas DESC , no_antrian");
										}
									}	
									else{
										if($id_segmen==0){
											$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE id_dokter='$fetchDataLogin[id_dokter]' and status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' AND id_kategori_harga='$id_kategori_harga' AND waktu_masuk BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' ORDER BY id_prioritas DESC ,no_antrian");
										}
										else{
											$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE id_dokter='$fetchDataLogin[id_dokter]' and status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' AND id_kategori_harga='$id_kategori_harga' AND id_segmen='$id_segmen' AND  waktu_masuk BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' ORDER BY id_prioritas DESC ,no_antrian");
										}
									}
								}
								else
								{
								*/	if($id_kategori_harga==0){
										if($id_segmen==0){
											$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' AND  waktu_masuk BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' ORDER BY id_prioritas DESC , no_antrian");
										}
										else{
											$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' AND  id_segmen='$id_segmen' AND waktu_masuk BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' ORDER BY id_prioritas DESC , no_antrian");
										}
									}	
									else{
										if($id_segmen==0){
											$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' AND id_kategori_harga='$id_kategori_harga' AND waktu_masuk BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' ORDER BY id_prioritas DESC ,no_antrian");
										}
										else{
											$tampil=pg_query($dbconn,"SELECT * FROM antrian WHERE status_antrian='Y' AND status_aktif='Y' AND id_unit='$_SESSION[id_units]' AND id_kategori_harga='$id_kategori_harga' AND id_segmen='$id_segmen' AND  waktu_masuk BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' ORDER BY id_prioritas DESC ,no_antrian");
										}
									}
								//}
								
								//$no=1;
								while($r=pg_fetch_array($tampil)){
									if($r['id_dokter']!="")
									{
										$k=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan WHERE id='$r[id_dokter]'"));
										$namaDokter=$k['nama'];
									}
									else
									{
										$namaDokter="-";
									}
									
									$p=pg_fetch_array(pg_query($dbconn,"SELECT nama, no_rm, id FROM master_pasien WHERE id='$r[id_pasien]'"));
									
									$a=explode(" ",$r['waktu_masuk']);
									$tanggal_masuk=DateToIndo2($a[0]);
									
									
									$kh=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE kode_penjamin='$r[id_kategori_harga]'"));
									$nama_kategori_harga=$kh['nama'];

									$pr=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_prioritas_pasien WHERE id='$r[id_prioritas]'"));
									
									$prioritas="<button class='btn btn-$pr[warna] btn-xs' title='$pr[nama]'><i class=' fa fa-square'></i></button>";
									
									$s=pg_fetch_array(pg_query($dbconn,"SELECT * FROM segmen WHERE id='$r[id_segmen]'"));
									$nama_segmen="<button class='btn btn-$s[warna] btn-xs' title='$s[nama]'><i class='icon-user'></i></button>";
									?>
									<tr>
										<td><?php echo "$prioritas $nama_segmen";?></td>
										<td><?php echo "$tanggal_masuk $a[1]";?></td>
										<td><?php echo $r['no_antrian'];?></td>
										<td><a href="pasien-detail-<?php echo $p['no_rm'];?>"><?php echo "$p[nama] / $p[no_rm]";?></a></td>
										<td><?php echo $namaDokter ?></td>
										<td><?php echo $nama_kategori_harga;?></td>
										<td>
											<!--<button type="button" rel="tooltip" class="btnLamaAntri btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Lama Antrian" id="<?php echo $r['id'];?>">
												<i class="icon-magnifier"></i>
											</button>-->
											
											<!--<a href="edit-antrian-<?php echo "$r[id]";?>" class="btn btn-primary btn-xs" title="Edit Antrian" data-toggle="tooltip" data-placement="top" title="Edit Antrian"><i class="icon-note"></i></a>-->
											<a href="hapus-antrian-<?php echo "$r[id]";?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>
											
											<a href="keuangan-customer-billing-<?php echo "$p[no_rm]";?>" class="btn btn-success btn-xs"  title="Billing" data-toggle="tooltip" data-placement="top"><i class="icon-calculator"></i></a>
											
											<!-- <a href="cetak-kartu-pasien-<?php echo "$p[no_rm]";?>" class="btn btn-secondary btn-xs" title="Cetak no pasien" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-print"></i></a>										 -->
											
											<!--<a href="cetak-gelang-pasien-<?php echo "$p[no_rm]";?>" class="btn btn-warning btn-xs" title="Cetak Gelang Pasien" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-print"></i></a>-->
											
											<a href="cetak-nomor-antrian?id=<?php echo $r['no_cetak_antrian'] ?>" class="btn btn-info btn-xs" title="Cetak no pasien" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-print"></i></a>
											<!-- <a href="form-<?php echo "$p[no_rm]";?>" class="btn btn-secondary btn-xs" title="Form Pemeriksaan" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-file-text "></i></a> -->
										</td>
									</tr>
									<?php
									//$no++;
								}
								?>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>
	</div>
</div>
<div id="form-modal" class="modal fade">
			
</div>
<script type="text/javascript">
$(document).ready(function(){ 
	
	var count = 30;
	var id_kategori_harga='<?php echo $id_kategori_harga;?>';
	var id_segmen='<?php echo $id_segmen;?>';
	var tanggal_awal='<?php echo $tanggal_awal2;?>';
	var tanggal_akhir='<?php echo $tanggal_akhir2;?>';
	var idDokter=$("#id_dokter").val();
/*	if(idDokter=="")
	{
		$(".save").prop("disabled", true);	
	}
	else
	{
		$(".save").prop("disabled", false);		
	}*/

	setInterval(function() {
		count--;

		// update timer here
		$("#waktu_countdown").html(count);
		if (count === 0) {
			$.ajax({
				url: "data-antrian",
				cache: false,
				data: { 
					'id_kategori_harga': id_kategori_harga,
					'id_segmen' : id_segmen,
					'tanggal_awal' : tanggal_awal,
					'tanggal_akhir' : tanggal_akhir
				},
				success: function(msg){
					$("#data_antrian").html(msg);
				}
			});
			count = 30;
		}
	}, 1000);



	$("#poly").change(function()
	{
		$("#listDokter").hide();
		$("#nama_dokter").val("");
	});

	$("#nama_dokter").keyup(function()
	{
		var nama_dokter=$("#nama_dokter").val();
		var id_poly=$("#poly").val();
		$.ajax(
		{
			url:'content/antrian/getDocter.php',
			data:{nama_dokter:nama_dokter, id_poly:id_poly},
			type:"POST",
			success:function(result)
			{
				$("#listDokter").html(result).show();
				
			},
			error:function()
			{
				alert(0);
			}
		});
	});

	/*$("#id_dokter").change(function()
	{
		var idDokter=$("#id_dokter").val();
		
		$.ajax(
		{
			url:'getPolyDoctor',
			data:{idDokter:idDokter},
			type:'POST',
			success:function(result)
			{
				$("#poly").html(result);
			}
		});
	});	*/
	
	$(".btnLamaAntri").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'lama-antrian',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form-modal").html(msg);
				$("#form-modal").modal('show'); 
			}
		});
	});

  
    $("#id_segmen, #id_kategori_harga").click(function(){
    	var id = $('#id_segmen').val();
    	var id_penjamin = $('#id_kategori_harga').val();
		if(id==4){
			$.ajax({
				type: 'POST',
				url: 'data-paket',
				data: { 
					'id': id,
					'id_penjamin' : id_penjamin
				},
				success: function(msg){
					$("#detail_paket").html(msg);
				}
			});
		}
		else{
			$("#detail_paket").html('<input type="text" name="detail_segmen" class="form-control">');
		}
	});

});
</script>

<?php
break;

case "edit":
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="antrian">Antrian</a></li>
	<li class="breadcrumb-item active">Edit Antrian</li>

</ol>
<?php
$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM antrian WHERE id='$_GET[id]'"));
$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$d[id_pasien]'"));
if($p['jenkel']==1){
	$jenkel="<i class='icon-user'></i>";
	$icon_jenkel="<i class='icon-symbol-male'></i>";
}
else{
	$jenkel="<i class='icon-user-female'></i>";
	$icon_jenkel="<i class='icon-symbol-female'></i>";
}

$jp=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_jenis_pasien WHERE id='$p[id_jenis_pasien]'"));
if($p['foto']!=''){
	$gambar="images/pasien/upload_$p[foto]";
}
else{
	$gambar="images/default.png";
}

$tanggal_lahir=DateToIndo2($p['tanggal_lahir']);
?>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-4 col-lg-4">
				<div class="card">
					<form class="form-horizontal" method="POST" action="aksi-edit-antrian">
					<input type="hidden" name="id" value="<?php echo $d['id'];?>">
					<div class="card-header">
						<i class="icon-user"></i> Edit Antrian
					</div>
					<div class="card-block">
						<div class="row">
							<div class="col-sm-9">
								<table>
									<tr>
										<td width="20px"><?php echo $jenkel;?></td>
										<td><b><?php echo $p['nama'];?></b></td>
									</tr>
									<tr>
										<td></td>
										<td><?php echo "$tanggal_lahir - $icon_jenkel";?></td>
									</tr>
									<tr>
										<td></td>
										<td><?php echo $p['no_rm'];?></td>
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
								<input type="text" id="no_antrian" name="no_antrian" class="form-control" placeholder="No Antrian" value="<?php echo $d['no_antrian'];?>" required autofocus disabled>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="id_prioritas">Segmen</label>
							<div class="col-md-8">
								<select name="id_segmen" id="id_segmen" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM segmen");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_segmen']){
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

						<!-- <div class="form-group row" id="detail_segmen">
							<label class="col-md-4 form-control-label" for="id_dokter">Detail Segmen</label>
							<div class="col-md-8">
								<input type="text" name="detail_segmen" class="form-control" value="<?php echo $d['detail_segmen'] ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="id_prioritas">Prioritas</label>
							<div class="col-md-8">
								<select name="id_prioritas" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_prioritas_pasien");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_prioritas']){
											echo"<option value='$r[id]' selected>$r[nama]</option>";
										}
										else{
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
									}
									?>
								</select>
							</div>
						</div> -->
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="id_dokter">Dokter Pemeriksa</label>
							<div class="col-md-8">

								<select name="id_dokter" id="id_dokter" class="form-control" required>
								<?php
								if($d['id_kategori_harga']=="005001000")
								{
									$tampil=pg_query($dbconn,"SELECT * FROM master_karyawan WHERE (id_jabatan='1' and poly_id ='1') or (id_jabatan='1' and poly_id ='2') ORDER BY nama");
								}
								else
								{
									$tampil=pg_query($dbconn,"SELECT * FROM master_karyawan WHERE id_jabatan='1' ORDER BY nama");
								}
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_dokter']){
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
							<label class="col-md-4 form-control-label">Penjamin</label>
							<div class="col-md-8">
								<select name="id_kategori_harga" id="id_kategori_harga" class="form-control" required>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_kategori_harga ORDER BY id");
									while($r=pg_fetch_array($tampil)){
										if($r['id']==$d['id_kategori_harga']){
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
							<div class="col-md-12">
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
$(document).ready(function(){ 
	
    $("#id_segmen").click(function(){
    	var id = $('#id_segmen').val();
    		if((id==2) || (id==3)){
				var div = $('#detail_segmen');
				if (div.is(':visible')) div.hide();
				else div.show();
			}else{
				$('#detail_segmen').hide();
			}
      
            });

});
</script>
<?php
break;

}
?>
<script type="text/javascript">
$(document).ready(function()
{
	$("#test").click(function()
	{
		alert($(".prb"),val());
	})
});

</script>