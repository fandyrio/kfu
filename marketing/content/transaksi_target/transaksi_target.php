<?php
switch($_GET['act']){

default:
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Transaksi Target</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<i class="icon-list"></i> Data
						<span class="pull-right">
							<button class="btn btn-primary btn-sm" id="btnTambah">Tambah</button>
						</span>
					</div>
					<div class="card-block table-responsive">
						<table class="table  table-condensed" id="myTable">
							<thead class="text-center">
								<tr>
									<th width="50px">No.</th>
									<th>Unit</th>
									<th>Segmen</th>
									<th>Description</th>
									<th>Tahun</th>
									<th>Jan</th>
									<th>Feb</th>
									<th>Mar</th>
									<th>Apr</th>
									<th>May</th>
									<th>Jun</th>
									<th>Jul</th>
									<th>Aug</th>
									<th>Sep</th>
									<th>Oct</th>
									<th>Nov</th>
									<th>Des</th>
									<th>Total</th>
									<th width="60px">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$tampil=pg_query($dbconn,"SELECT * FROM mt_transaksi_target ORDER BY id DESC");
								while($r=pg_fetch_array($tampil)){
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_unit WHERE id='$r[id_unit]'"));
									$nama_unit=$a['nama'];
									
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM segmen WHERE id='$r[id_segmen]'"));
									$nama_segmen=$a['nama'];
									
									$total=$r['bln1']+$r['bln2']+$r['bln3']+$r['bln4']+$r['bln5']+$r['bln6']+$r['bln7']+$r['bln8']+$r['bln9']+$r['bln10']+$r['bln11']+$r['bln12'];
									
									$bln1=formatRupiah3($r['bln1']);
									$bln2=formatRupiah3($r['bln2']);
									$bln3=formatRupiah3($r['bln3']);
									$bln4=formatRupiah3($r['bln4']);
									$bln5=formatRupiah3($r['bln5']);
									$bln6=formatRupiah3($r['bln6']);
									$bln7=formatRupiah3($r['bln7']);
									$bln8=formatRupiah3($r['bln8']);
									$bln9=formatRupiah3($r['bln9']);
									$bln10=formatRupiah3($r['bln10']);
									$bln11=formatRupiah3($r['bln11']);
									$bln12=formatRupiah3($r['bln12']);
									$total2=formatRupiah3($total);
									?>
									<tr>
										<td><?php echo $r['id'];?></td>
										<td><?php echo $nama_unit;?></td>
										<td><?php echo $nama_segmen;?></td>
										<td><?php echo $r['description'];?></td>
										<td><?php echo $r['tahun'];?></td>
										<td class="text-right"><?php echo $bln1;?></td>
										<td class="text-right"><?php echo $bln2;?></td>
										<td class="text-right"><?php echo $bln3;?></td>
										<td class="text-right"><?php echo $bln4;?></td>
										<td class="text-right"><?php echo $bln5;?></td>
										<td class="text-right"><?php echo $bln6;?></td>
										<td class="text-right"><?php echo $bln7;?></td>
										<td class="text-right"><?php echo $bln8;?></td>
										<td class="text-right"><?php echo $bln9;?></td>
										<td class="text-right"><?php echo $bln10;?></td>
										<td class="text-right"><?php echo $bln11;?></td>
										<td class="text-right"><?php echo $bln12;?></td>
										<td class="text-right"><?php echo $total2;?></td>
										<td class="text-center">
											<button type="button" class="btn btn-warning btn-xs btn-flat btnEdit" id="<?php echo $r['id'];?>" data-toggle="tooltip" data-placement="top" title="Edit">
												<i class="fa fa-edit"></i>
											</button>
											<a 	href="aksi-hapus-transaksi-target-<?php echo $r['id'];?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
												<button type="button" class="btn btn-danger btn-flat btn-xs" data-toggle="tooltip" data-placement="top" title="Hapus">
													<i class="fa fa-trash"></i>
												</button>
											</a>
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
			<!--/.col-->
		</div>
		<!--/.row-->
	</div>
</div>
<!-- /.conainer-fluid -->
<div id="form-modal" class="modal fade melayang2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<script type="text/javascript">
	$("#btnTambah").click(function(){
		$.ajax({
			type: 'POST',
			url: 'tambah-transaksi-target',
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
			url: 'edit-transaksi-target',
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
}
?>