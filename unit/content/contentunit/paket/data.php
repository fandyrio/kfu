<header class="page-header">
	<div class="container-fluid">
        <h2 class="no-margin-bottom">Paket</h2>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
			<li class="breadcrumb-item active">Paket</li>
		</ul>
    </div>
</header>
        
<!-- Dashboard Counts Section-->
<section class="tables">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">
						<h3 class="h4">Data</h3>
					</div>
					<div class="card-body">
						<table class="table table-sm">
							<thead class="table-secondary">
								<tr>
									<th>Nama</th>
									<th width="60px">#</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$unit = $_SESSION['id_unit'];
							$res=pg_query($dbconn,"Select distinct id_billing_paket from billing_paket_kategori_harga_unit where id_unit='$unit' order by id_billing_paket asc");
							while ($row=pg_fetch_assoc($res)) {
								$data=pg_fetch_array(pg_query($dbconn,"Select * from billing_paket where id='".$row["id_billing_paket"]."' "));
							?>
								<tr>
									<td><?php echo $data["nama_paket"] ?></td>
									<td class="text-center">
									   <a href="media.php?content=paket&modul=data&update&id=<?php echo $row['id_billing_paket'] ?>" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-edit"></i></a>
									   <a href="media.php?content=paket&modul=hapus&id=<?php echo $row['id_billing_paket'] ?>" class="btn btn-danger btn-xs btn-flat" onclick="return confirm('Yakin ingin menghapus data')"><i class="fa fa-trash"></i></a>
									  
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
            
			<div class="col-lg-6 ">
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
</section>