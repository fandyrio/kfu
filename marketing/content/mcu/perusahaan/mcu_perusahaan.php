<?php
switch($_GET['act']){

default:
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">MCU Perusahaan</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<i class="icon-list"></i> Data
					</div>
					<div class="card-block">
						<table class="table  table-condensed" id="myTable">
							<thead>
								<tr>
									<th width="50px">No.</th>
									<th>Kategori</th>
									<th>Nama</th>
									<th>Telepon</th>
									<th>Alamat</th>
									<th>Jlh Event MCU</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$id_unit= $_SESSION['id_units'];
								$tampil=pg_query($dbconn,"SELECT k.*  from master_kategori_harga k inner join master_unit_perusahaan p ON p.id_perusahaan = k.id WHERE id_unit = '$id_unit' AND k.id>1");
								$no=1;
								while($r=pg_fetch_array($tampil)){
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_tipe_penjamin WHERE id='$r[id_jenis]'"));
									$nama_jenis=$a['nama'];
									
									$a=pg_fetch_assoc(pg_query($dbconn,"SELECT COUNT(a.id) AS tot FROM billing_paket_kategori_harga_unit a, billing_paket b WHERE a.id_billing_paket=b.id AND b.status='7' AND a.id_unit='$_SESSION[id_units]' AND a.id_kategori_harga='$r[id]'"));
									
									$tot=$a['tot'];
									?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo $nama_jenis;?></td>
										<td><a href="view-mcu-perusahaan-<?php echo $r['id'];?>"><?php echo $r['nama'];?></a></td>
										<td><?php echo $r['alamat'];?></td>
										<td><?php echo $r['telepon'];?></td>
										<td><?php echo $tot;?></td>
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
			<!--/.col-->
		</div>
		<!--/.row-->
	</div>
</div>
<!-- /.conainer-fluid -->
<div id="form-modal" class="modal fade melayang2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="form-modal2" class="modal fade"></div>

<script type="text/javascript">
	$("#btnTambah").click(function(){
		$.ajax({
			type: 'POST',
			url: 'tambah-activity-type',
			data: { 
				
			},
			success: function(msg){
				
				$("#form-modal").html(msg);
				$("#form-modal").modal('show'); 
			}
		});
	});
	$(".btnEdit").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'edit-activity-type',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form-modal").html(msg);
				$("#form-modal").modal('show'); 
			}
		});
	});
</script
<?php
break;

case "view":
$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_kategori_harga WHERE id='$_GET[id]'"));
$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_tipe_penjamin WHERE id='$d[id_jenis]'"));
$nama_jenis=$a['nama'];
$a=explode(" ",$d['waktu_login']);
$tanggal_login=DateToIndo2($a[0]);
$jam_login=$a[1];

?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="mcu-perusahaan">MCU Perusahaan</a></li>
	<li class="breadcrumb-item active">Detail</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<i class="icon-list"></i> Detail
					</div>
					<div class="card-block">
						<table class="table">
							<tr><td>Nama</td><td width="10px">:</td><td><?php echo $d['nama'];?></td></tr>
							<tr><td>Jenis</td><td>:</td><td><?php echo $nama_jenis;?></td></tr>
							<tr><td>Username</td><td>:</td><td><?php echo $d['username'];?></td></tr>
							<tr><td>Telepon</td><td>:</td><td><?php echo $d['telepon'];?></td></tr>
							<tr><td>Alamat</td><td>:</td><td><?php echo $d['alamat'];?></td></tr>
							<tr><td>Waktu login terakhir</td><td>:</td><td><?php echo "$tanggal_login $jam_login";?></td></tr>
						</table>
					</div>
				</div>
			</div>
			
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<i class="icon-list"></i> Data Event MCU
					</div>
					<div class="card-block">
						<table class="table  table-condensed" id="myTable">
							<thead>
								<tr>
									<th width="50px">No.</th>
									<th>Tanggal</th>
									<th>Nama Event</th>
									<th>Harga</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$id_unit= $_SESSION['id_units'];
								$tampil=pg_query($dbconn,"SELECT * FROM billing_paket WHERE id_perusahaan='$_GET[id]' AND status='6' OR id_perusahaan='$_GET[id]' AND status='7'");
								$no=1;
								while($r=pg_fetch_array($tampil)){
									$tanggal_awal=DateToIndo2($r['tgl_awal']);
									$tanggal_akhir=DateToIndo2($r['tgl_akhir']);
									$harga_net=formatRupiah2($r['harga_net']);
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_status_penawaran WHERE id='$r[status]'"));
									$status="<span class='badge badge-$a[warna]'>$a[nama]</span>";
									?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo "$tanggal_awal s/d $tanggal_akhir";?></td>
										<td><?php echo $r['nama'];?></td>
										<td><?php echo $harga_net;?></td>
										<td><?php echo $status;?></td>
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
			<!--/.col-->
		</div>
		<!--/.row-->
	</div>
</div>
<?php
break;
}
?>