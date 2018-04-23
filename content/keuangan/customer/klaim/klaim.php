<?php

switch($_GET['act']){
	
default:

if(isset($_GET['tanggal_awal'])){
	$tanggal_awal=$_GET['tanggal_awal'];
	$tanggal_akhir=$_GET['tanggal_akhir'];
}
else{
	$tanggal_awal="01-$bln_sekarang-$thn_sekarang";
	$tanggal_akhir="$tgl_skrg-$bln_sekarang-$thn_sekarang";
}
$tanggal_awal2=DateToEng($tanggal_awal);
$tanggal_akhir2=DateToEng($tanggal_akhir);
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Klaim</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i>Data Klaim
							<span class="pull-right">
								<a href="tambah-keuangan-customer-klaim" class="btn btn-primary btn-xs">Tambah</a>
							</span>
						</div>
						<div class="card-block">
							<form method="post" class="form-horizontal">
								<div class="form-group row">
									<label class="col-md-1 form-control-label" >Dari Tanggal</label>
									<div class="col-sm-2">
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1"><i class="icon-calendar"></i></span>
											<input type="text" class="form-control date" name="tanggal_awal" value="<?php echo $tanggal_awal;?>">
										</div>
									</div>
									
									<label class="col-md-2 form-control-label">Sampai Tanggal</label>
									<div class="col-sm-2">
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1"><i class="icon-calendar"></i></span>
											<input type="text" class="form-control date" name="tanggal_akhir" value="<?php echo $tanggal_akhir;?>">
										</div>
									</div>
									<button type="submit" class="btn btn-primary btn-xs" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
								</div>
							</form>

							<table class="table" id="myTable2">
								<thead>
									<tr>
										<th>Tanggal</th>
										<th>Nama Pasien</th>
										<th>Status</th>
										<th>Service Provider</th>
										<th>Dokter</th>
										<th>Amount</th>
										<th>Catatan</th>
										<th width="60px">#</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM transaksi_klaim WHERE id_unit='$_SESSION[id_units]' AND tanggal_klaim BETWEEN '$tanggal_awal2' AND '$tanggal_akhir2' ORDER BY id");
									
									$total=0;
									while($r=pg_fetch_array($tampil)){										
										$tanggal=DateToIndo2($r['tanggal_klaim']);
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_rumahsakit WHERE id='$r[id_rumahsakit]'"));
										$nama_rumahsakit=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_pasien WHERE id='$r[id_pasien]'"));
										$nama_pasien=$a['nama'];
										
										
										$amount=formatRupiah3($r['jumlah']);
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_status_klaim WHERE id='$r[id_status_klaim]'"));
										$nama_klaim=$a['nama'];
										
										$total+=$r['jumlah'];
										?>
										<tr>
											<td><?php echo "$tanggal";?></td>
											<td><?php echo $nama_pasien;?></td>
											<td><?php echo $nama_klaim;?></td>
											<td><?php echo $nama_rumahsakit;?></td>
											<td><?php echo $r['nama_dokter'];?></td>
											<td><?php echo $amount;?></td>
											<td><?php echo $r['catatan'];?></td>
											<td>
												<a href="edit-keuangan-customer-klaim-<?php echo $r['id'];?>" class="btn btn-primary btn-xs" title="Edit" data-toggle="tooltip" data-placement="top"><i class="icon-note"></i></a>
												<a href="hapus-keuangan-customer-klaim-<?php echo "$r[id]";?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>
											</td>
										</tr>
										<?php
									}
									$total=formatRupiah2($total);
									?>
								</tbody>
							</table>
							<!--<h6>TOTAL : <b><?php echo $total; ?></b></h6>-->
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
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="keuangan-customer-klaim">Klaim</a></li>
	<li class="breadcrumb-item active">Tambah</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<?php
			if(isset($_GET['no_rm'])!=''){
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
				
				$tanggal_lahir=DateToIndo2($d['tanggal_lahir']);
				$usia=HitungUsia($d['tanggal_lahir']);
				
				$tanggal_hari_ini=DateToIndo2($tgl_sekarang);
				?>
				<div class="col-sm-5 col-lg-5">
					<div class="card">
						<form class="form-horizontal" action="aksi-tambah-keuangan-customer-klaim" method="POST">
						<input type="hidden" name="id_pasien" value="<?php echo $d['id'];?>">
						<div class="card-header">
							<i class="icon-plus"></i> Tambah Klaim
						</div>
						<div class="card-block">
							<table>
								<tr><td width="300px"><i class="icon-note"></i> <b><?php echo $d['no_rm'];?></b></td></tr>
								<tr><td colspan="2"><i class="icon-user"></i> <?php echo $d['nama'];?></td></tr>
								<tr><td colspan="2"><i class="icon-calendar"></i> <?php echo "$tanggal_lahir";?></td></tr>
							</table>
							<hr>
							<div class="form-group row">
								<label class="col-md-4 form-control-label">Perusahaan</label>
								<div class="col-md-8">
									<select name="id_kategori_harga" class="form-control">
										<?php
										$tampil=pg_query($dbconn,"SELECT * FROM master_kategori_harga WHERE id>1");
										while($r=pg_fetch_array($tampil)){
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 form-control-label">Tanggal</label>
								<div class="col-md-4">
									<input type="text" name="tanggal_klaim" class="form-control date" value="<?php echo $tanggal_hari_ini;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 form-control-label">Status</label>
								<div class="col-md-8">
									<select name="id_status_klaim" class="form-control">
										<?php
										$tampil=pg_query($dbconn,"SELECT * FROM master_status_klaim");
										while($r=pg_fetch_array($tampil)){
											echo"<option value='$r[id]'>$r[nama]</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 form-control-label">Amount</label>
								<div class="col-md-4">
									<input type="number" class="form-control" id="jumlah" name="jumlah" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 form-control-label">Catatan</label>
								<div class="col-md-8">
									<textarea name="catatan" class="form-control"></textarea>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12">
									<fieldset>
										<legend>Service Provider</legend>
										<div class="form-group row">
											<label class="col-md-4 form-control-label">Klinik / Rumah Sakit</label>
											<div class="col-md-8">
												<select name="id_rumahsakit" class="form-control js-example-basic-single">
													<?php
													$tampil=pg_query($dbconn,"SELECT * FROM master_rumahsakit ORDER BY nama");
													while($r=pg_fetch_array($tampil)){
														echo"<option value='$r[id]'>$r[nama]</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-4 form-control-label">Dokter</label>
											<div class="col-md-8">
												<input type="text" name="nama_dokter" class="form-control">
											</div>
										</div>
									</fieldset>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-12">
									<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Simpan</button>
									<a href="keuangan-customer-klaim"><button type="button" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Batal</button></a>
								</div>
								<!--<div class="col-md-6">
									<a href="pendaftaran?act=sidik" class="btn btn-success btn-sm pull-right"><i class="fa fa-500px"></i> Sidik Jari</a>
								</div>-->
							</div>
						</div>
						</form>
					</div>
				</div>
				<?php
			}
			else{
			?>
			<div class="col-sm-4 col-lg-4">
				<div class="card">
					<form class="form-horizontal">
					<div class="card-header">
						<i class="icon-user"></i> Pencarian
					</div>
					<div class="card-block">
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="no_rekam_medik">No. RM</label>
							<div class="col-md-8">
								<input type="text" id="no_rekam_medik" name="no_rekam_medik" class="form-control" placeholder="No. Rekam Medis" autofocus value="<?php echo $_GET['no_rekam_medik'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="no_bpjs">No. BPJS</label>
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
								<button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
							</div>
							<!--<div class="col-md-6">
								<a href="pendaftaran?act=sidik" class="btn btn-success btn-sm pull-right"><i class="fa fa-500px"></i> Sidik Jari</a>
							</div>-->
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
								<tr class="text-center">
									<th width="50px">No.</th>
									<th>No. Rekam Medis</th>
									<th>No. Kartu BPJS</th>
									<th>Nama</th>
									<th>Tanggal Lahir</th>
									<th>ID Lainnya</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<?php
								
								
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
											<td>
												<a href='tambah-keuangan-customer-klaim?no_rm=$r[no_rm]'><button type='button' class='btn btn-xs btn-success'><i class='icon-plus'></i></button></a>
											</td>
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
			}
			?>
		</div>		<!--/.row-->
	</div>
</div>

<script type="text/javascript">
	/*function convertToRupiah(angka){
		var rupiah = '';
		var angkarev = angka.toString().split('').reverse().join('');
		for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
		return rupiah.split('',rupiah.length-1).reverse().join('');
	}
	/
	$('#jumlah').on('change', function() {
		var jumlah=$("#jumlah").val();
		var angka=convertToRupiah(jumlah);
		$("#jumlah").val(angka);
	});
	*/
</script>
<?php
break;

case "edit":
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
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="keuangan-customer-klaim">Klaim</a></li>
	<li class="breadcrumb-item active">Tambah</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<?php
				$k=pg_fetch_array(pg_query($dbconn,"SELECT * FROM transaksi_klaim WHERE id='$_GET[id]'"));
				$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$k[id_pasien]'"));
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
				
				$tanggal_lahir=DateToIndo2($d['tanggal_lahir']);
				$usia=HitungUsia($d['tanggal_lahir']);
				
				$tanggal_klaim=DateToIndo2($k['tanggal_klaim']);
				?>
				<div class="col-sm-5 col-lg-5">
					<div class="card">
						<form class="form-horizontal" action="aksi-edit-keuangan-customer-klaim" method="POST">
						<input type="hidden" name="id" value="<?php echo $k['id'];?>">
						<div class="card-header">
							<i class="icon-plus"></i> Edit Klaim
						</div>
						<div class="card-block">
							<table>
								<tr><td width="300px"><i class="icon-note"></i> <b><?php echo $d['no_rm'];?></b></td></tr>
								<tr><td colspan="2"><i class="icon-user"></i> <?php echo $d['nama'];?></td></tr>
								<tr><td colspan="2"><i class="icon-calendar"></i> <?php echo "$tanggal_lahir";?></td></tr>
							</table>
							<hr>
							<div class="form-group row">
								<label class="col-md-4 form-control-label">Perusahaan</label>
								<div class="col-md-8">
									<select name="id_kategori_harga" class="form-control">
										<?php
										$tampil=pg_query($dbconn,"SELECT * FROM master_kategori_harga WHERE id>1");
										while($r=pg_fetch_array($tampil)){
											if($r['id']==$k['id_kategori_harga']){
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
								<label class="col-md-4 form-control-label">Tanggal</label>
								<div class="col-md-4">
									<input type="text" name="tanggal_klaim" class="form-control date" value="<?php echo $tanggal_klaim;?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 form-control-label">Status</label>
								<div class="col-md-8">
									<select name="id_status_klaim" class="form-control">
										<?php
										$tampil=pg_query($dbconn,"SELECT * FROM master_status_klaim");
										while($r=pg_fetch_array($tampil)){
											if($r['id']==$k['id_status_klaim']){
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
								<label class="col-md-4 form-control-label">Amount</label>
								<div class="col-md-4">
									<input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo $k['jumlah'];?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 form-control-label">Catatan</label>
								<div class="col-md-8">
									<textarea name="catatan" class="form-control"><?php echo $k['catatan'];?></textarea>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12">
									<fieldset>
										<legend>Service Provider</legend>
										<div class="form-group row">
											<label class="col-md-4 form-control-label">Klinik / Rumah Sakit</label>
											<div class="col-md-8">
												<select name="id_rumahsakit" class="form-control js-example-basic-single">
													<?php
													$tampil=pg_query($dbconn,"SELECT * FROM master_rumahsakit ORDER BY nama");
													while($r=pg_fetch_array($tampil)){
														if($r['id']==$k['id_rumahsakit']){
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
											<label class="col-md-4 form-control-label">Dokter</label>
											<div class="col-md-8">
												<input type="text" name="nama_dokter" class="form-control" value="<?php echo $k['nama_dokter'];?>">
											</div>
										</div>
									</fieldset>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-12">
									<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Simpan</button>
									<a href="keuangan-customer-klaim"><button type="button" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Batal</button></a>
								</div>
								<!--<div class="col-md-6">
									<a href="pendaftaran?act=sidik" class="btn btn-success btn-sm pull-right"><i class="fa fa-500px"></i> Sidik Jari</a>
								</div>-->
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
break;
}
?>