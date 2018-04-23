<?php
switch($_GET['act']){

default:
if(isset($_GET['id_unit'])){
	$id_unit=$_GET['id_unit'];
}
else{
	$id_unit=$_SESSION['id_units'];
}
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Alat Bantu</li>
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
						<fieldset>
							<legend>Filter</legend>
							<form method="get" class="form-horizontal">
								<div class="form-group row">
									<label class="col-sm-1 form-control-label" >Cabang</label>
									<div class="col-sm-3">
										<?php
										if($_SESSION['id_units']==1){
											$result =pg_query($dbconn, "SELECT p.* FROM master_unit p
														 ORDER BY id");
											$disabled="";
										}
										else {									
											$result =pg_query($dbconn, "SELECT p.* FROM master_unit p
														where p.id='$_SESSION[id_units]' ORDER BY id");
											$disabled="disabled";
										}							
										?>
										<select name='id_unit' class='form-control' <?php echo $disabled; ?>>
											<?php 
											while ($row =pg_fetch_assoc($result)){
											if(isset($_GET["cari"]))
											{													 
												 $id_unit=$_GET["id_unit"];
												 if($id_unit== $row['id']){
													  echo "<option value='".$id_unit."' selected>".$row['nama']."</option>";
													}
													else{
													echo "<option value='".$row['id']."'>".$row['nama']."</option>";
												}									

											}

											 else{
													echo "<option value='".$row['id']."'>".$row['nama']."</option>";
												}

											}
										?>
										</select>
									</div>
									<div class="col-sm-3">
										<button type="submit" class="btn btn-primary btn-sm" style="margin-right:10px;" name="cari"><i class="fa fa-search"></i> Tampilkan</button>
									</div>
								</div>
							</form>
						</fieldset>
						<table class="table  table-condensed" id="myTable">
							<thead>
								<tr>
									<th width="50px">No.</th>
									<th>Cabang</th>
									<th>Nama</th>
									<th>Jumlah</th>
									<th>Otomatis</th>
									<th width="60px">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$tampil=pg_query($dbconn,"SELECT * FROM inv_alat_bantu_unit WHERE id_unit='$id_unit' ORDER BY id DESC");
								$no=1;
								while($r=pg_fetch_array($tampil)){
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_unit WHERE id='$r[id_unit]'"));
									$nama_unit=$a['nama'];
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM inv_alat_bantu WHERE id='$r[id_inv_alat_bantu]'"));
									$nama=$a['nama'];
									if($r['otomatis']=='Y'){
										$otomatis="<span class='badge badge-success'>Ya</span>";
									}
									else{
										$otomatis="<span class='badge badge-danger'>Tidak</span>";
									}
									?>
									<tr>
										<td><?php echo $r['id'];?></td>
										<td><?php echo $nama_unit;?></td>
										<td><?php echo $nama;?></td>
										<td><?php echo $r['jumlah'];?></td>
										<td><?php echo $otomatis;?></td>
										<td>
											<button type="button" class="btn btn-warning btn-xs btn-flat btnEdit" id="<?php echo $r['id'];?>" data-toggle="tooltip" data-placement="top" title="Edit">
												<i class="fa fa-edit"></i>
											</button>
											<a 	href="aksi-hapus-alat-bantu-<?php echo $r['id'];?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
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
			url: 'tambah-alat-bantu',
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
			url: 'edit-alat-bantu',
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