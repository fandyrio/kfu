<?php
switch($_GET['act']){

default:
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">CRM Status</li>
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
									<th width="50px">ID.</th>
									<th>Description</th>
									<th width="60px">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$tampil=pg_query($dbconn,"SELECT * FROM master_mt_crm_status ORDER BY id DESC");

								while($r=pg_fetch_array($tampil)){
									
									?>
									<tr>
										<td><?php echo $r['id'];?></td>
										<td><?php echo $r['nama'];?></td>
										<td>
											<button type="button" class="btn btn-warning btn-xs btn-flat btnEdit" id="<?php echo $r['id'];?>" data-toggle="tooltip" data-placement="top" title="Edit">
												<i class="fa fa-edit"></i>
											</button>
											<a 	href="aksi-hapus-crm-status-<?php echo $r['id'];?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
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
			url: 'tambah-crm-status',
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
			url: 'edit-crm-status',
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