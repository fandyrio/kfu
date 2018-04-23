<?php
switch($_GET['act']){

default:
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Laporan Marketing</li>
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
					<div class="card-block">
						<table class="table  table-condensed" id="myTable">
							<thead>
								<tr>
									<th width="50px">No.</th>
									<th>Waktu Input</th>
									<th>Tanggal</th>
									<th>Jlh Dokter Yang Dikunjungi</th>
									<th>Jlh Instansi Yang Dikunjungi</th>
									<th>Jlh Pasien Yang Dikirim Dokter</th>
									<th>Respon Segmen</th>
									<th width="60px">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$tampil=pg_query($dbconn,"SELECT * FROM mt_laporan WHERE id_user='$_SESSION[login_user]' ORDER BY id DESC");
								$no=1;
								while($r=pg_fetch_array($tampil)){
									$a=explode(" ",$r['waktu_input']);
									$tanggal_input=DateToIndo2($a[0]);
									$jam_input=$a[1];
									$tanggal=DateToIndo2($r['tanggal']);
									?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo "$tanggal_input $jam_input";?></td>
										<td><?php echo $tanggal;?></td>
										<td><?php echo $r['jumlah1'];?></td>
										<td><?php echo $r['jumlah2'];?></td>
										<td><?php echo $r['jumlah3'];?></td>
										<td><?php echo $r['respon'];?></td>
										<td>
											<button type="button" class="btn btn-warning btn-xs btn-flat btnEdit" id="<?php echo $r['id'];?>" data-toggle="tooltip" data-placement="top" title="Edit">
												<i class="fa fa-edit"></i>
											</button>
											<a 	href="aksi-hapus-laporan-<?php echo $r['id'];?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
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
			url: 'tambah-laporan',
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
			url: 'edit-laporan',
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