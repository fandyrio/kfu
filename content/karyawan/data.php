<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
    <li class="breadcrumb-item active">Karyawan</li>
</ol>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header">
						<i class="icon-grid"></i> Data
					</div>
					<div class="card-body">
						<table id="myTable" class="table table-sm">
							<thead class="table-secondary">
								<tr>
									<th>Kode</th>
									<th>Nama</th>
									<th >#</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$id_unit= $_SESSION['id_units'];
							$res=pg_query($dbconn,"Select u.id, u.id_karyawan from master_karyawan_unit u inner join master_karyawan v on v.id = u.id_karyawan where u.id_unit='$id_unit' ");


							while ($row=pg_fetch_assoc($res)) {
								$view=pg_fetch_assoc(pg_query($dbconn,"Select * from master_karyawan WHERE id='$row[id_karyawan]'"));
							?>
								<tr>
									<td><?php echo $view["kode"] ?></td>
									<td><?php echo $view["nama"] ?></td>
									<td class="text-center">
										<a href="media.php?content=karyawan&modul=data&update&id=<?php echo $row['id_karyawan'] ?>" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-eye"></i></a>
										<!-- <a href="media.php?content=karyawan&modul=simpan&act=delete&id=<?php echo $row['id'] ?>" class="btn btn-danger btn-xs btn-flat" onclick="return confirm('Yakin ingin menghapus data ?')" ><i class="fa fa-trash"></i></a> -->
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
				

				<?php
				if(isset($_GET["update"])){
					include "update.php";

				}
				
				 ?>
				
			</div>
		</div>
    </div>

