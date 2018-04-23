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
	<li class="breadcrumb-item active">Payment</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i>Data Payment
							<!--<span class="pull-right">
								<a href="tambah-keuangan-customer-payment" class="btn btn-primary btn-xs">Tambah</a>
							</span>-->
						</div>
						<div class="card-block">
							<form method="post" class="form-horizontal">
								<div class="form-group row">
									<label class="col-md-1 form-control-label" >Dari Tanggal</label>
									<div class="col-sm-2">
										<input type="text" class="form-control date" name="tanggal_awal" value="<?php echo $tanggal_awal;?>">
									</div>
									
									<label class="col-md-2 form-control-label">Sampai Tanggal</label>
									<div class="col-sm-2">
										<input type="text" class="form-control date" name="tanggal_akhir" value="<?php echo $tanggal_akhir;?>">
									</div>
									<button type="submit" class="btn btn-primary btn-xs" style="margin-right:10px;" name="cari"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
								</div>
							</form>

							<table class="table" id="myTable">
								<thead>
									<tr>
										<th>Tanggal/Jam</th>
										<th>No. Payment</th>
										<th>Nama Pembayar</th>
										<th>Cara Pembayaran</th>
										<th>No. Invoice</th>
										<th>Amount</th>
										<th>Kasir</th>
										<th width="100px">#</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM transaksi_payment WHERE id_unit='$_SESSION[id_units]' AND waktu_input BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' AND status_hapus='N' ORDER BY id");
									
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal=DateToIndo2($a[0]);
										
										
										if($r['id_user']==1){
											$nama_kasir="Administrasi";
										}
										else{
											$a=pg_fetch_array(pg_query($dbconn,"SELECT a.nama FROM master_karyawan a, auth_users b WHERE a.id=b.id_karyawan AND b.id_users='$r[id_users]'"));
											$nama_kasir=$a['nama'];
										}
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_metode_pembayaran WHERE id='$r[id_metode_pembayaran]'"));
										$cara_pembayaran=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT no_invoice FROM transaksi_invoice WHERE id='$r[id_invoice]'"));
										$no_invoice=$a['no_invoice'];
										
										$amount=formatRupiah($r['harga_invoice']);
										?>
										<tr>
											<td><?php echo "$tanggal";?></td>
											<td><?php echo $r['no_payment'];?></td>
											<td><?php echo $r['nama_pembayar'];?></td>
											<td><?php echo $cara_pembayaran;?></td>
											<td><?php echo $no_invoice;?></td>
											<td class="text-right"><?php echo $amount;?></td>
											<td class="text-right"><?php echo $nama_kasir;?></td>
											<td>
												<a href="view-keuangan-customer-payment-<?php echo $r['no_payment'];?>" class="btn btn-primary btn-xs" title="View" data-toggle="tooltip" data-placement="top" id="<?php echo $r['id'];?>"><i class="icon-eye"></i></a>
												<a href="hapus-keuangan-customer-payment-<?php echo "$r[no_invoice]";?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>
												<a href="cetak-keuangan-customer-payment-<?php echo $r['no_payment'];?>" class="btn btn-success btn-xs" title="Cetak" data-toggle="tooltip" data-placement="top" id="<?php echo $r['id'];?>" target="_blank"><i class="fa fa-print"></i></a>
												
											</td>
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
	</div>
</div>
<?php
break;

case "tambah":
$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM transaksi_invoice WHERE id='$_GET[id]'"));
$id=$d['id'];
$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$d[id_pasien]'"));
$id_pasien=$p['id'];
if($p['jenkel']==1){
	$jenkel="<i class='icon-user'></i>";
	$icon_jenkel="<i class='icon-symbol-male'></i>";
}
else{
	$jenkel="<i class='icon-user-female'></i>";
	$icon_jenkel="<i class='icon-symbol-female'></i>";
}
if($p['foto']!=''){
	$gambar="images/pasien/upload_$p[foto]";
}
else{
	$gambar="images/default.png";
}
$nama_pembayar=$p['nama'];
$no_handphone=$p['no_handphone'];
$tanggal_lahir=DateToIndo2($p['tanggal_lahir']);

$id_kategori_harga=$d['id_kategori_harga_bayar'];

$diskon=$d['diskon'];
$diskon2=formatRupiah($diskon);

$total=$d['total'];
$total2=formatRupiah($total);

$total_net=$total-$diskon;
$total_net2=formatRupiah($total_net);
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="keuangan-customer-payment">Pembayaran</a></li>
	<li class="breadcrumb-item active">Tambah</li>
</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div class="card">
					<input type="hidden" name="id_invoice" value="<?php echo $d['id'];?>">
					<div class="card-header">
						<i class="icon-plus"></i> Pembayaran Untuk Invoice <b>#<?php echo $_GET['no_invoice'];?></b>
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
										<td><?php echo "$tanggal_lahir -  $icon_jenkel";?></td>
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
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="text-center">Tanggal Transaksi</th>
									<th class="text-center">Detail</th>
									<th class="text-center">Kuantitas</th>
									<th class="text-center">Penjamin</th>
									<th class="text-center">Harga</th>
									<th class="text-center">Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$tampil=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_invoice='$id'");
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal=DateToIndo2($a[0]);
									$jam=$a[1];
									/**/

										if($r['jenis']=='E'){
											
											
											$h=pg_fetch_assoc(pg_query($dbconn,"SELECT * FROM billing_paket  
															WHERE id='$r[id_detail]' "));
											$nama_transaksi=$h[nama_paket];
											$catatan=$a['catatan'];
											
											
											
										}
										
										if($r['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$r[id_detail]'"));
											$nama_transaksi="$a[nama]";
											$catatan=$a['catatan'];
												
											
										}
										elseif($r['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$r[id_detail]'"));
											$nama_transaksi="$a[nama]";
											$catatan=$a['catatan'];

											
										}
										elseif($r['jenis']=='N'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_detail]'"));
											$nama_transaksi="$a[nama]";
											$catatan=$a['catatan'];
											
										}
										elseif($r['jenis']=='O'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_resep a 
												WHERE a.id_pasien='$r[id_pasien]' AND a.id_kunjungan='$r[id_kunjungan]' AND a.status_proses='Y'"));
											$nama_transaksi="$a[nama_brand]";											
										}
									/**/			

									
									$harga=formatRupiah3($r['harga']);
									$disc_amount=formatRupiah3($r['disc_amount']);
									
									$subtotal=$r['harga']*$r['kuantitas'];
									$subtotal=formatRupiah3($subtotal);

									$m_u=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_kategori_harga WHERE id='$r[id_kategori_harga]'"));
									?>
									<tr>
										<td><?php echo "$tanggal $jam";?></td>
										<td><?php echo $nama_transaksi;?></td>
										<td class="text-right"><?php echo $r['kuantitas'];?></td>
										<td class="text-right"><?php echo $m_u[nama];?></td>
										<td class="text-right"><?php echo $harga;?></td>
										<td class="text-right"><?php echo $subtotal;?></td>
									</tr>
									<?php
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5"><b>TOTAL</b></td>
									<td class="text-right"><b><?php echo $total2;?></b></td>
								</tr>
								<tr>
									<td colspan="5"><b>DISKON</b></td>
									<td class="text-right"><b><?php echo $diskon2;?></b></td>
								</tr>
								<tr>
									<td colspan="5"><b>TOTAL NET</b></td>
									<td class="text-right"><b><?php echo $total_net2;?></b></td>
								</tr>
							</tfoot>
						</table>


						<form class="form-horizontal" method="POST" action="aksi-tambah-keuangan-customer-payment">
						<!--  -->
						<?php
							$distc=pg_query($dbconn,"SELECT DISTINCT id_kategori_harga FROM transaksi_invoice_detail WHERE id_invoice='$id'");
							?>
							<fieldset style="width: 450px">
								<legend>Ditagihkan</legend>
								<table class="table" style="width:400px" >
									<thead>
										<th >Billing Kepada</th>
										<th>Jumlah Bayarr</th>
									</thead>
									<tbody>
							<?php
								while($ti=pg_fetch_array($distc)){
									$idh=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_kategori_harga WHERE id='$ti[id_kategori_harga]'"));

									$hrg=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_invoice='$id' and id_kategori_harga='$ti[id_kategori_harga]'");

									$total = 0;
									while($tid= pg_fetch_array($hrg) ){
										$subtotal = $tid['harga']*$tid['kuantitas'];

										$total += $subtotal;
									}
									/*total yang harus dibayar*/
									$hrg=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_invoice='$id' and id_kategori_harga='1'");

									$total1 = 0;
									while($tid= pg_fetch_array($hrg) ){
										$subtotal = $tid['harga']*$tid['kuantitas'];

										$total1 += $subtotal;
									}
									/*end*/
									?>

									<tr>
										<td><?php if($ti[id_kategori_harga]=='1'){
											echo $p[nama];
											echo "<input type='hidden' name='total_bayar' id='total_bayar' value='$total1'>";

											}else
											{echo $idh[nama];
												} ?>
													
										</td>
										<td><?php echo formatRupiah($total) ?></td>
										
									</tr>
									

							<?php
								}
						?>
								</tbody>
								</table>
							</fieldset>	
						<!--  -->
						<input type="hidden" name="id_invoice" value="<?php echo $id;?>">
						<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>">
						
						<div class="form-group row">
							<label class="col-md-2">Metode Pembayaran</label>
							<div class="col-md-3">
								<select name="id_metode_bayar" class="form-control" id="id_metode_bayar">
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_metode_pembayaran");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
									?>
								</select>
							</div>
							<div class="col-md-1"></div>
							<label class="col-md-1">Catatan</label>
							<div class="col-md-3">
								<textarea name="catatan" class="form-control"></textarea>
							</div>
							
						</div>
						<div class="hidden">
						<div class="form-group row">
						
							<label class="col-md-2">Bank</label>
							<div class="col-md-3">
								<select name="id_bank" class="form-control">
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM master_bank");
									while($r=pg_fetch_array($tampil)){
										echo"<option value='$r[id]'>$r[nama]</option>";
									}
									?>
								</select>
							</div>
							<div class="col-md-1"></div>
							<label class="col-md-1">No. Transaksi</label>
							<div class="col-md-3">
								<input type="text" class="form-control" name="no_transaksi">
							</div>
						</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-2">Terima</label>
							<div class="col-md-3">
								<input type="text" class="form-control" value="" id="jumlah_bayar">
								<input type="hidden" class="form-control" value="" name="jumlah_bayar" id="jumlah_bayar2">
								<input type="hidden" class="form-control" value="<?php echo $total;?>" name="total" id="total">
							</div>
							
							<div class="col-md-1"></div>
							<label class="col-md-1">Kembali</label>
							<div class="col-md-3">
								<input type="text" class="form-control" value="" id="dana_kembali" disabled>
								<input type="hidden" class="form-control" value="" name="dana_kembali" id="dana_kembali2">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-2">Pembayar</label>
							<div class="col-md-3">
								<input type="text" class="form-control" value="<?php echo $nama_pembayar;?>" name="nama_pembayar">
							</div>
							
							<div class="col-md-1"></div>
							<label class="col-md-1">No. HP</label>
							<div class="col-md-3">
								<input type="text" class="form-control" value="<?php echo $no_handphone;?>" name="no_handphone">
							</div>
						</div>
						
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-6">
								<button type="submit" class="btn btn-sm btn-primary" id="btnSimpanPayment" disabled><i class="fa fa-dot-circle-o"></i> Simpan dan Cetak</button>
								<a href="javascript: window.history.go(-1)" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Batal</a>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function convertToRupiah(angka){
		var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
		var rev2    = '';
		for(var i = 0; i < rev.length; i++){
			rev2  += rev[i];
			if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
				rev2 += '.';
			}
		}
		return rev2.split('').reverse().join('');
	}
	
	$('#id_metode_bayar').on('change', function() {
		var id=$("#id_metode_bayar").val();
		if(id>1){
			$(".hidden").show();
		}
		else{
			$(".hidden").hide();
		}
	});
	
	$("#jumlah_bayar").keyup(function(){
		var total = $("#total_bayar").val();
		var jumlah_bayar = $("#jumlah_bayar").val();
		jumlah_bayar = jumlah_bayar.replace(/\./g, "");
		var dana_kembali = jumlah_bayar-total;
		
		if(jumlah_bayar>=0){
			dana_kembali2 = convertToRupiah(dana_kembali);
			$("#dana_kembali").val(dana_kembali2);
			$("#dana_kembali2").val(dana_kembali);
			
			if(jumlah_bayar){
				$("#jumlah_bayar").val(convertToRupiah(jumlah_bayar));
			}
			//
			$("#jumlah_bayar2").val(jumlah_bayar);
		}
		if(dana_kembali>=0){
			$("#btnSimpanPayment").prop('disabled',false);
		}
		else{
			$("#btnSimpanPayment").prop('disabled',true);
		}
	});
	
	/*
	$('#jumlah_bayar').keyup(function() {
		var jumlah_bayar=parseInt($("#jumlah_bayar").val());
		var total=parseInt($("#total").val());
		var dana_kembali = parseInt(jumlah_bayar-total);
		
		$("#jumlah_bayar").val(convertToRupiah(jumlah_bayar));
		$("#dana_kembali").val(convertToRupiah(dana_kembali));
		$("#dana_kembali2").val(dana_kembali);
		
		return false;
	});
	*/
	
	$(function() {
		$('.currency').maskMoney({thousands:'.', allowZero:true, precision:0});
	})
</script> 
<?php

break;

case "view":
$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM transaksi_payment WHERE no_payment='$_GET[no_payment]'"));
$v=pg_fetch_array(pg_query($dbconn,"SELECT * FROM transaksi_invoice WHERE id='$d[id_invoice]'"));
$id_invoice=$d['id_invoice'];
$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$v[id_pasien]'"));

if($p['jenkel']==1){
	$jenkel="<i class='icon-user'></i>";
	$icon_jenkel="<i class='icon-symbol-male'></i>";
}
else{
	$jenkel="<i class='icon-user-female'></i>";
	$icon_jenkel="<i class='icon-symbol-female'></i>";
}
if($p['foto']!=''){
	$gambar="images/pasien/upload_$p[foto]";
}
else{
	$gambar="images/default.png";
}
$nama_pembayar=$p['nama'];
$no_handphone=$p['no_handphone'];
$tanggal_lahir=DateToIndo2($p['tanggal_lahir']);

$diskon=$v['diskon'];
$diskon2=formatRupiah($diskon);

$total=$v['total'];
$total2=formatRupiah($total);

$total_net=$total-$diskon;
$total_net2=formatRupiah($total_net);
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="keuangan-customer-payment">Pembayaran</a></li>
	<li class="breadcrumb-item active">View</li>
</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div class="card">
					<input type="hidden" name="id_invoice" value="<?php echo $d['id'];?>">
					<div class="card-header">
						<i class="icon-plus"></i> Pembayaran Untuk Invoice <b>#<?php echo $v['no_invoice'];?></b>
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
										<td><?php echo "$tanggal_lahir -  $icon_jenkel";?></td>
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
						<?php
						$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_metode_pembayaran WHERE id='$d[id_metode_pembayaran]'"));
						
						$nama_metode_bayar=$a['nama'];
						
						$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_bank WHERE id='$d[id_bank]'"));
						$nama_bank=$a['nama'];
						?>
						
						<div class="row">
							<div class="col-md-6">
								<table>
									<tr>
										<td width="150px">No. Payment</td>
										<td width="10px">:</td>
										<td><b>#<?php echo $d['no_payment'];?></b></td>
									</tr>
									<tr>
										<td>Metode Pembayaran</td>
										<td>:</td>
										<td><?php echo $nama_metode_bayar;?></td>
									</tr>
									<tr>
										<td>Nama Pembayar</td>
										<td>:</td>
										<td><?php echo $d['nama_pembayar'];?></td>
									</tr>
									
									<tr>
										<td>No. Handphone</td>
										<td>:</td>
										<td><?php echo $d['no_handphone'];?></td>
									</tr>
									
									<tr>
										<td>Catatan</td>
										<td>:</td>
										<td><?php echo $d['catatan'];?></td>
									</tr>
								</table>
							</div>
							<div class="col-md-6">
								<?php
								if($d['id_metode_pembayaran']!=1){
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_bank WHERE id='$d[id_bank]'"));
									$nama_bank=$a['nama'];
									?>
									<table>
										<tr>
											<td width="100px">Bank</td>
											<td width="10px">:</td>
											<td><?php echo $nama_bank;?></td>
										</tr>
										<tr>
											<td>No. Transaksi</td>
											<td>:</td>
											<td><?php echo $d['no_kartu'];?></td>
										</tr>
									</table>
									<?php
								}
								?>
							</div>
						</div>
						<hr>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="text-center">Tanggal Transaksi</th>
									<th class="text-center">Detail</th>
									<th class="text-center">Kuantitas</th>
									<th class="text-center">Harga</th>
									<th class="text-center">Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$tampil=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_invoice='$id_invoice'");
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal=DateToIndo2($a[0]);
									$jam=$a[1];
									
									if($r['jenis']=='LO'){
										$a=pg_fetch_array(pg_query($dbconn,"SELECT no_referensi, catatan FROM pasien_laborder WHERE id='$r[id_detail]'"));
										$nama_transaksi="Lab Order - No. Ref $a[no_referensi]";
										$catatan=$a['catatan'];
									}
									elseif($r['jenis']=='BPT'){
										$a=pg_fetch_array(pg_query($dbconn,"SELECT b.nama_paket, a.catatan FROM pasien_billing_paket a, billing_paket b WHERE a.id_billing_paket=b.id AND a.id='$r[id_detail]'"));
										
										$nama_transaksi="$a[nama_paket]";
										$catatan=$a['catatan'];
									}
									elseif($r['jenis']=='BT'){
										$a=pg_fetch_array(pg_query($dbconn,"SELECT a.nama, b.catatan FROM tindakan a, pasien_tindakan b WHERE a.id=b.id_tindakan AND b.id='$r[id_detail]'"));
										$nama_transaksi="Tindakan - ".$a['nama'];
										$catatan=$a['catatan'];
									}
									
									$harga=formatRupiah3($r['harga']);
									$disc_amount=formatRupiah3($r['disc_amount']);
									
									$subtotal=$r['harga']*$r['kuantitas'];
									$subtotal=formatRupiah3($subtotal);
									?>
									<tr>
										<td><?php echo "$tanggal $jam";?></td>
										<td><?php echo $nama_transaksi;?></td>
										<td class="text-right"><?php echo $r['kuantitas'];?></td>
										<td class="text-right"><?php echo $harga;?></td>
										<td class="text-right"><?php echo $subtotal;?></td>
									</tr>
									<?php
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4"><b>TOTAL</b></td>
									<td class="text-right"><b><?php echo $total2;?></b></td>
								</tr>
								<tr>
									<td colspan="4"><b>DISKON</b></td>
									<td class="text-right"><b><?php echo $diskon2;?></b></td>
								</tr>
								<tr>
									<td colspan="4"><b>TOTAL NET</b></td>
									<td class="text-right"><b><?php echo $total_net2;?></b></td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php

break;

}
?>