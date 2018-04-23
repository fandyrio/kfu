<header class="page-header">
	<div class="container-fluid">
        <h2 class="no-margin-bottom">Analysis Group</h2>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
			<li class="breadcrumb-item active">Analysis Group</li>
		</ul>
    </div>
</header>
        
<!-- Dashboard Counts Section-->
<section class="dashboard-counts no-padding-bottom">
	<div class="row">
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h3 class="h4">Data</h3>
				</div>
				<div class="card-body">
					<table id="myTable" class="table ">
						<thead class="table-secondary">
							<tr>
								<th>Kode</th>
								<th >Nama</th>
								<th >#</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$id_unit= $_SESSION['id_unit'];
						$res=pg_query($dbconn,"Select id, id_lab_analysis_group from lab_analysis_group_unit WHERE id_unit='$id_unit' order by id asc");
						while ($row=pg_fetch_assoc($res)) {
							$view=pg_fetch_assoc(pg_query($dbconn,"Select * from lab_analysis_group WHERE id='$row[id_lab_analysis_group]'"));
						?>
							<tr>
								<td><?php echo $view["kode"] ?></td>
								<td><?php echo $view["nama"] ?></td>
								<td class="text-center">
								   <a href="media.php?content=analysis_group&modul=data&view&id=<?php echo $row['id_lab_analysis_group'] ?>" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-eye"></i></a>
								   <a href="media.php?content=analysis_group&modul=simpan&act=delete&id=<?php echo $row['id'] ?>" class="btn btn-danger btn-xs btn-flat" onclick="return confirm('Yakin ingin menghapus data')" ><i class="fa fa-trash"></i></a>
								  
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
		<div class="col-lg-6">
			<div class="card">
			<?php
				if(isset($_GET["view"])){
					include "view.php";

				}
				else{
				 include "tambah.php"; 
				}
			?>
			</div>
		</div>
    </div>
</section>