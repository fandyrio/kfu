<?php
switch($_GET['act']){
	
default:
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Jadwal MCU</li>
</ol>

<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">   
			<div class="col-md-12 " >
				<div class="card">
					<div class="card-header">
						<i class="icon-grid"></i> Data
					</div>
					<div class="card-body">
						<table id="myTable" class="table ">
							<thead>
								<tr>
									<th width="10px">No.</th>
									<th width="">Tanggal</th>
									<th width="">Paket</th>
									<th width="">Unit</th>
									<th>Status</th>
									<th>Jumlah Pasien</th>
									<th>Keterangan</th>
								</tr>
							</thead>
							<tbody>
								<?php
								
									$q= "Select p.*, u.harga, unit.nama, unit.id AS id_unit, u.id AS id_billing_paket_unit  from billing_paket p 
									  INNER JOIN billing_paket_kategori_harga_unit u ON u.id_billing_paket = p.id
									  LEFT OUTER JOIN master_unit unit ON  unit.id=u.id_unit
									  WHERE   p.status='7' AND p.id_perusahaan='$_SESSION[login_user]' OR p.status='6' AND p.id_perusahaan='$_SESSION[login_user]' ORDER BY p.nama_paket ASC";
									  
								$res=pg_query($dbconn,$q);
								$no=1;
								while ($row=pg_fetch_assoc($res)) {
									$result =pg_fetch_array(pg_query($dbconn, "SELECT * FROM master_status_penawaran  where id= '$row[status]' "));
									$status="<span class='badge badge-$result[warna]'>$result[nama]</span>";
								 
									$c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM antrian WHERE id_paket='$row[id]' AND id_unit='$row[id_unit]'"));
									$tot=$c['tot'];
								?>
									<tr>     
										<td class="text-left" style="vertical-align:middle;"><?php echo $no++;?></td>                   
										<td class="text-left" style="vertical-align:middle;"><?php echo DatetoIndo2($row["tgl_awal"])." s/d ".DatetoIndo2($row["tgl_akhir"]);?></td>
										<td class="text-left" style="vertical-align:middle;"><a href="view-mcu-jadwal-<?php echo $row['id_billing_paket_unit'];?>"><?php echo $row["nama_paket"];?></a></td>
										<td class="text-left" style="vertical-align:middle;"><?php echo $row["nama"];?></td>
										<td><?php echo $status;?></td>
										<td><?php echo $tot;?></td>
										<td><?php echo $row['keterangan'];?></td>
										
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
<?php
break;

case "view":
$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM  billing_paket_kategori_harga_unit WHERE id='$_GET[id]'"));
$id_billing_paket=$d['id_billing_paket'];
$id_unit=$d['id_unit'];
$id_kategori_harga=$d'id_kategori_harga'];

?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="mcu-penawaran">Penawaran</a></li>
	<li class="breadcrumb-item active">Detail</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<i class="icon-list"></i> Detail Event
					</div>
					<div class="card-block">
						<?php
							$q= "Select status, nama_paket,  harga_net, harga_gross, disc_amount, disc_persen, created_unit, id_perusahaan, keterangan from billing_paket where id='$id_billing_paket' ";
							// var_dump($q);
							$res=pg_query($dbconn,$q);
							$r=pg_fetch_array($res);
							$status= $r['status'];
							$result =pg_fetch_array(pg_query($dbconn, "SELECT nama FROM master_kategori_harga  where id= '$r[id_perusahaan]' "));
				          ?>
						<table class="table">
							<tr><td width="150px">Nama</td><td width="10px">:</td><td><?php echo $r['nama_paket'];?></td></tr>
							<tr><td>Catatan/Keterangan</td><td width="10px">:</td><td><?php echo $r['keterangan'];?></td></tr>
						</table>
							
						<table id="myTable" class="table ">
							<thead>
								<tr>
									<th width="10px">No.</th>
									<th width="">Nama Pemeriksaan</th>
									<th width="">Harga</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$id_users =$_SESSION['login_user'];
								$q= "Select * from billing_paket_detail  where id_billing_paket= '$id_billing_paket' ORDER BY id ASC";
								$res=pg_query($dbconn,$q);
								$no=1;
								$total_harga=0;
								while ($row=pg_fetch_assoc($res)) {
									$total_harga+=$row["harga"];
									?>
									<tr>     
										<td class="text-left" style="vertical-align:middle;"><?php echo $no++;?></td> 
										<?php
										if($row['jenis']=='L'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));
											echo '<td>';
											echo "Single  ".$nama_transaksi="$a[nama]";
											echo '</td>'; 
										} 
										else if($row['jenis']=='G'){
											$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$row[id_detail]'"));
											echo '<td>';
											echo "Multi ".$a['nama'];
											echo '</td>'; 
										} 
										else if($row['jenis']=='T'){
										$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$row[id_detail]'"));
											echo '<td>';
											echo "Non Lab ".$a[nama];
											echo '</td>'; 
										} 
										?>
										<td class="text-right"><?php echo formatRupiah3($row["harga"]);?></td>
									</tr>
								<?php 
								} 
								?> 
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"><b>Total</b></td>
									<td class="text-right"><?php echo formatRupiah($r['harga_gross']);?></td>
								</tr>
								<tr>
									<td colspan="2"><b>Diskon</b></td>
									<td class="text-right"><?php if($r['disc_persen']!=0) echo "$r[disc_persen] %"; else echo formatRupiah($r['disc_amount']);?></td>
								</tr>
								<tr>
									<td colspan="2"><b>Harga Net</b></td>
									<td class="text-right"><?php echo formatRupiah($r['harga_net']);?></td>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="card-footer">
						<?php
						if($r['status']<4 OR $r['status']==8){
						?>
							<button type="button" id="<?php echo $_GET['id']?>" class="btn btn-warning btn-sm btn-flat btnPermintaanRevisi">Permintaan Revisi</button>
							
							<button type="button" id="<?php echo $_GET['id']?>" class="btn btn-success btn-sm btn-flat btnTerima">Terima</button>
							
							<button type="button" id="<?php echo $_GET['id']?>" class="btn btn-danger btn-sm btn-flat btnTolak">Tolak</button>
						<?php
						}
						?>
						<a href="mcu-penawaran" class="btn btn-info btn-sm">Kembali</a>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<i class="icon-list"></i> Data Pasien
					</div>
					<div class="card-block">
						<table class="table">
							<thead>
								<tr>
									<th width="10px">No.</th>
									<th width="">No. RM / Nama</th>
									<th width="">Tempat/Tanggal Lahir</th>
									<th>No. Handphone</th> 
									<th>Divisi</th> 
									<th>Departemen</th> 
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$tampil=pg_query($dbconn,"SELECT id_pasien, waktu_masuk FROM antrian WHERE id_paket='$id_billing_paket' AND id_unit='$id_unit' AND id_kategori_harga='$id_kategori_harga'");
								$no=1;
								while($r=pg_fetch_array($tampil)){
									
									?>
									
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

<script type="text/javascript">
	$('.btnPermintaanRevisi').click(function()
	{
		var id=$(this).attr('id');
		var dataString2 = 'id='+id;
		$.ajax({
			type: 'POST',
			url: 'permintaan-revisi-mcu-penawaran',
			data : dataString2,
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});	
	});
	
	$('.btnTerima').click(function()
	{
		var id=$(this).attr('id');
		var dataString2 = 'id='+id;
		$.ajax({
			type: 'POST',
			url: 'terima-mcu-penawaran',
			data : dataString2,
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});	
	});
	
	$('.btnTolak').click(function()
	{
		var id=$(this).attr('id');
		var dataString2 = 'id='+id;
		$.ajax({
			type: 'POST',
			url: 'tolak-mcu-penawaran',
			data : dataString2,
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});	
	});
</script>
<?php
break;
}
?>
