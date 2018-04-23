<header class="page-header">
	<div class="container-fluid">
        <h2 class="no-margin-bottom">Test</h2>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
			<li class="breadcrumb-item active">Test</li>
		</ul>
    </div>
</header>
        <!-- Dashboard Counts Section-->
<section class="forms"> 
    <div class="container-fluid">
        <div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">
						<h3 class="h4">Data 	</h3>
					</div>
					<div class="card-body">
						<table id="myTable" class="table ">
							<thead class="table-secondary">
								<tr>
									<th>Kode</th>
									<th>Nama</th>
									<th ></th>
								</tr>
							</thead>
							<tbody>
							<?php
							$unit = $_SESSION['id_unit'];
							$res=pg_query($dbconn,"Select distinct id_tindakan from tindakan_kategori_harga_unit where id_unit='$unit' order by id_tindakan asc");
							while ($row=pg_fetch_assoc($res)) {
								$data=pg_fetch_array(pg_query($dbconn,"Select * from tindakan where id='".$row["id_tindakan"]."' "));
								 ?>
								<tr>
									<td style="vertical-align:middle;"><?php echo $data["kode"] ?></td>
									<td style="vertical-align:middle;"><?php echo $data["nama"] ?></td>                      
									<td class="text-center" style="vertical-align:middle;">
										<a href="media.php?content=tindakan&modul=data&update&id=<?php echo $row['id_tindakan'] ?>" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-edit"></i></a>
										<a href="media.php?content=tindakan&modul=hapus&id=<?php echo $row['id_tindakan'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
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
					if(isset($_GET["update"])){
						include "update.php";

					}
					else{
					 include "tambah.php"; 
					}
				?>
				</div>
			</div>
		</div>
	</div>
      <!-- /.row -->
</section>