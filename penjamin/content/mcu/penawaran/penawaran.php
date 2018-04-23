<?php
switch($_GET['act']){
	
default:
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Penawaran</li>
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
									<th width="">Waktu Input</th>
									<th width="">Paket</th>
									<th width="">Harga</th>
									<th>Keterangan</th>
									<th width="">Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$res=pg_query($dbconn,"SELECT * FROM billing_paket WHERE id_perusahaan='$_SESSION[login_user]' ORDER BY nama_paket");
								$no=1;
								while ($row=pg_fetch_assoc($res)) {
									$harga_net=formatRupiah3($row['harga_net']);
									$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_status_penawaran WHERE id='$row[status]'"));
									$status="<span class='badge badge-$a[warna]'>$a[nama]</span>";
								?>
									<tr>     
										<td class="text-left" style="vertical-align:middle;"><?php echo $no++;?></td>                   
										<td class="text-left" style="vertical-align:middle;"><?php echo $row["waktu_input"];?></td>
										<td class="text-left" style="vertical-align:middle;"><a href="view-mcu-penawaran-<?php echo $row['id'];?>"><?php echo $row["nama_paket"];?></a></td>
										<td><?php echo $harga_net;?></td>
										<td><?php echo $row['keterangan'];?></td>
										<td><?php echo $status;?></td>
									</tr>
								<?php 		
								} 
								?> 
							</tbody>
						</table>
					</div>
					<!-- /.col -->
				</div>
			</div>
		</div>
    </div>
</div>
<?php
break;

case "view":
pg_query($dbconn,"UPDATE billing_paket_penawaran_log SET dilihat='Y' WHERE id_perusahaan='$_SESSION[login_user]' AND id_billing_paket='$_GET[id]'");

?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="mcu-penawaran">Penawaran</a></li>
	<li class="breadcrumb-item active">Detail</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-7">
				<div class="card">
					<div class="card-header">
						<i class="icon-list"></i> Detail Event
					</div>
					<div class="card-block">
						<?php
							$q= "Select status, nama_paket,  harga_net, harga_gross, disc_amount, disc_persen, created_unit, id_perusahaan, keterangan from billing_paket where id='$_GET[id]' ";
							// var_dump($q);
							$res=pg_query($dbconn,$q);
							$r=pg_fetch_array($res);
							$status= $r['status'];
							$result =pg_fetch_array(pg_query($dbconn, "SELECT nama FROM master_kategori_harga  where id= '$r[id_perusahaan]' "));
				          ?>
						<table class="table">
							<tr><td width="150px">Nama</td><td width="10px">:</td><td><?php echo $r['nama_paket'];?></td></tr>
							<tr><td>Perusahaan</td><td>:</td><td><?php echo $result['nama'];?></td></tr>
							<tr><td>Catatan/Keterangan</td><td width="10px">:</td><td><?php echo $r['keterangan'];?></td></tr>
							<!--<tr><td>Harga</td><td>:</td><td><?php echo formatRupiah($r['harga_gross']);?></td></tr>
							<tr><td>Diskon</td><td>:</td><td><?php if($r['disc_persen']!=0){ echo "$r[disc_persen] %";} else echo formatRupiah($r['disc_amount']);?></td></tr>
							<tr><td>Harga Net</td><td>:</td><td><b><?php echo formatRupiah($r['harga_net']);?></b></td></tr>-->
							
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
								$q= "Select * from billing_paket_detail  where id_billing_paket= '$_GET[id]' ORDER BY id ASC";
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
			<div class="col-md-5">
				<div class="card">
					<div class="card-header">
						<i class="icon-list"></i> Log
					</div>
					<div class="card-block">
					 <?php
				        $q= "Select *  from billing_paket_penawaran_log where id_billing_paket='$_GET[id]' ORDER BY waktu_input ASC";
				         $res=pg_query($dbconn,$q);
				      

				        
				          ?>
						<table class="table">
							<thead>
								<tr>
									<th width="10px">No.</th>
									<th width="">Waktu</th>
									<th width="">Status</th>
									<th>Catatan/Keterangan</th> 
									<th width="">Oleh</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$n=1;
								while ($row=pg_fetch_assoc($res)) {
									$result =pg_fetch_array(pg_query($dbconn, "SELECT * FROM master_status_penawaran  where id= '$row[id_status_penawaran]' "));
									$a=explode(" ",$row['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);
									$jam_input=$a[1];
									$status="<span class='badge badge-$result[warna]'>$result[nama]</span>";
									if($row['created_by']=='P'){
										$who=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$row[id_perusahaan]'"));
									}
									else{
										$who =pg_fetch_array(pg_query($dbconn, "SELECT b.nama FROM auth_users a, master_karyawan b where a.id_karyawan=b.id AND a.id_users= '$row[id_users]' "));
									}
								?>
									<tr>
										<td><?php echo $n++;?></td>
										<td><?php echo "$tanggal_input $jam_input";?></td>
										<td><?php echo $status;?></td>
										<td><?php echo $row['catatan'];?></td>
										<td><?php echo $who['nama'];?></td>
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
