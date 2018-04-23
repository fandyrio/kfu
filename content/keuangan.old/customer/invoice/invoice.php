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
	<li class="breadcrumb-item active">Invoice</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div id="data_jadwal">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i>Data Invoice
							
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
										<th>No. Invoice</th>
										<th>Perusahaan</th>
										<th>Nama Pasien</th>
										<th>Issued by</th>
										<th>Amount</th>
										<th width="50px" class="text-center">Status</th>
										<th width="80px">#</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$tampil=pg_query($dbconn,"SELECT * FROM transaksi_invoice WHERE id_unit='$_SESSION[id_units]' AND waktu_input BETWEEN '$tanggal_awal2 00:00:00' AND '$tanggal_akhir2 23:59:59' AND status_issue='1' ORDER BY id");
									
									while($r=pg_fetch_array($tampil)){
										$a=explode(" ",$r['waktu_input']);
										$tanggal=DateToIndo2($a[0]);
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$r[id_kategori_harga_bayar]'"));
										$nama_perusahaan=$a['nama'];
										
										$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_pasien WHERE id='$r[id_pasien]'"));
										$nama_pasien=$a['nama'];
										
										if($r['id_users']==1){
											$nama_user="Administrasi";
										}
										else{
											$a=pg_fetch_array(pg_query($dbconn,"SELECT a.nama FROM master_karyawan a, auth_users b WHERE a.id=b.id_karyawan AND b.id_users='$r[id_users]'"));
											$nama_user=$a['nama'];
										}
										
										$amount=formatRupiah3($r['total']);
										
										if($r['status_bayar']=='Y'){
											$status="<button class='btn btn-success btn-xs'><i class='icon-check'></i></button>";
										}
										else{
											$status="<button class='btn btn-danger btn-xs'><i class='icon-close'></i></button>";
										}
										?>
										<tr>
											<td><?php echo "$tanggal $a[1]";?></td>
											<td><?php echo $r['no_invoice'];?></td>
											<td><?php echo $nama_perusahaan;?></td>
											<td><?php echo $nama_pasien;?></td>
											<td><?php echo $nama_user;?></td>
											<td class="text-right"><?php echo $amount;?></td>
											<td class="text-center"><?php echo $status;?></td>
											<td>
												<a href="view-keuangan-customer-invoice-<?php echo $r['no_invoice'];?>-<?php echo $r['id'];?>" class="btn btn-primary btn-xs" title="View" data-toggle="tooltip" data-placement="top" id="<?php echo $r['id'];?>"><i class="icon-eye"></i></a>
												<!--<a href="hapus-keuangan-customer-invoice-<?php echo "$r[no_invoice]";?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>-->
												<?php
												if($r['status_bayar']=='Y'){
												?>
												<a href="tambah-keuangan-customer-payment-<?php echo $r['no_invoice'];?>" class="btn btn-success btn-xs" title="Pembayaran" data-toggle="tooltip" data-placement="top"><i class="icon-calculator"></i></a>
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
break;

case "view":

$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM transaksi_invoice WHERE id='$_GET[id]'"));


$p=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE id='$d[id_pasien]'"));

$a=explode(" ",$d['waktu_input']);
$tanggal=DateToIndo($a[0]);
$jam=$a[1];
$invoice=$d['id'];

$k=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$d[id_kategori_harga_bayar]'"));
$nama_kategori_harga=$k['nama'];

$diskon=$d['diskon'];
$diskon2=formatRupiah($diskon);

$total=$d['total'];
$total2=formatRupiah($total);

$total_net=$total-$diskon;
$total_net2=formatRupiah($total_net);
?>

<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="keuangan-customer-invoice">Invoice</a></li>
	<li class="breadcrumb-item active">Detail</li>

</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-6 pull-left">
							<strong>View Invoice <b>#<?php echo "$d[no_invoice] ($nama_kategori_harga)";?></b></strong>
						</div>
					</div>
					<div class="card-block">
						<!--<button type="button" class="btn btn-primary btn-xs btnSwitchInvoice" id="<?php echo $d['id'];?>"><i class="icon-screen-desktop"></i> Switch Payment</button>-->
						
						<a href="cetak-keuangan-customer-invoice-<?php echo $d['no_invoice'];?>" class="btn btn-danger btn-xs" target="_blank"><i class="fa fa-print"></i> Cetak</a>
						
						<?php
						if($d['status_bayar']!='Y'){
						?>
						<a href="tambah-keuangan-customer-payment-<?php echo $d['no_invoice'];?>-<?php echo $d['id'];?>" class="btn btn-success btn-xs"><i class="icon-calculator"></i> Pembayaran</a>
						<?php
						}
						?>
						<br><br>
						<div class="row">
							<div class="col-md-6">
								
								<table>
									<tr><td width="200px"><i class="icon-note"></i> <b><?php echo $p['no_rm'];?></b></td></tr>
									<tr><td colspan="2"><i class="icon-user"></i> <?php echo $p['nama'];?></td></tr>
								</table>
							</div>
							<div class="col-md-6">
								<span class="pull-right text-right">
								<b><?php echo $d['no_invoice'];?></b><br>
								<?php echo "$tanggal $jam"; ?>
								</span>
							</div>
						</div>
						<br>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="text-center">Tanggal Transaksi</th>
									<th class="text-center">Detail</th>
									<th class="text-center">Kuantitas</th>
									<th class="text-center">Harga</th>
									<th class="text-center">Penjamin</th>
									<th class="text-center">Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$tampil=pg_query($dbconn,"SELECT * FROM transaksi_invoice_detail WHERE id_invoice='$d[id]'");
								
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal=DateToIndo2($a[0]);
									$jam=$a[1];
									
									if($r['jenis']=='E'){
											
											$a=pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$r[id_detail]' order by d.id_detail ");
											$h=pg_fetch_assoc($a); 
											$nama_transaksi= $h[nama_paket];
											;
											
										}
										
										if($r['jenis']=='S'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$r[id_detail]'"));
											$nama_transaksi="$a[nama]";
											
											
										}
										elseif($r['jenis']=='M'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$r[id_detail]'"));
											 $nama_transaksi="$a[nama]";
											
										}
										elseif($r['jenis']=='N'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$r[id_detail]'"));
											$nama_transaksi="$a[nama]";
											
										}
										elseif($r['jenis']=='O'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_resep a 
												WHERE a.id_pasien='$r[id_pasien]' AND a.id_kunjungan='$r[id_kunjungan]' AND a.status_proses='Y'"));
											$nama_transaksi="$a[nama_brand]";											
										}

									$m_u=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_kategori_harga WHERE id='$r[id_kategori_harga]'"));	
									
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
										<td class="text-right"><?php echo $m_u[nama];?></td>
										<td class="text-right"><?php echo $subtotal;?></td>
										<td></td>
									</tr>
									<?php
								}
								//$total=formatRupiah($total);
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
						
						<?php
						if($d['status_bayar']=='Y'){
						?>
						<center>
							<img src="images/lunas.jpg">
						</center>
						<?php
						}
						?>
					</div>
					<div class="card-footer">
						<button type="button" class="btn btn-secondary btn-sm" id="btnbatalviewLab">Kembali</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="form-modal" class="modal fade"></div>
<script>
	$('#btnbatalviewLab').click(function()
	{
		document.location.href = "keuangan-customer-invoice";

	});
	
	$(".btnSwitchInvoice").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'edit-keuangan-customer-invoice',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form-modal").html(msg);
				$("#form-modal").modal('show'); 
			}
		});
	});
</script>
<?php
break;

}
?>