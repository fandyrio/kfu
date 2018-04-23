<!-- Page Header-->
<header class="page-header">
	<div class="container-fluid">
		<h2 class="no-margin-bottom">Dashboard</h2>
	</div>
</header>
<!-- Dashboard Counts Section-->

<section class="dashboard-counts no-padding-bottom">
	<div class="container-fluid">
		<div class="alert alert-info">
			<strong>Hi, <?php echo $karyawan['nama'];?>.</strong>
			Waktu Login Anda : 
			<?php 
				$tanggal=DateToIndo($users['tanggal_login']);
				$jam=$users['jam_login'];
				echo "$tanggal $jam";
			?>
			
		</div>
		<div class="row bg-white has-shadow">
			<!-- Item -->
			<div class="col-xl-3 col-sm-6">
				<div class="item d-flex align-items-center">
					<div class="icon bg-violet"><i class="icon-user"></i></div>
					<div class="title"><span>Jumlah<br>Karyawan</span>
						<div class="progress">
							<div role="progressbar" style="width: 105%; height: 4px;" aria-valuenow="{#val.value}" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-violet"></div>
						</div>
					</div>
					<div class="number">
						<strong>
						<?php 
							$d=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(a.id) AS tot FROM master_karyawan_unit a, master_karyawan b WHERE a.id_karyawan=b.id AND b.id_jabatan!='1' AND a.id_unit='$_SESSION[id_unit]'"));
							echo $d['tot'];
						?>
						</strong>
					</div>
				</div>
			</div>
			<!-- Item -->
			<div class="col-xl-3 col-sm-6">
				<div class="item d-flex align-items-center">
					<div class="icon bg-red"><i class="fa fa-user-plus"></i></div>
					<div class="title"><span>Jumlah<br>Dokter</span>
						<div class="progress">
							<div role="progressbar" style="width: 100%; height: 4px;" aria-valuenow="{#val.value}" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>
						</div>
					</div>
					<div class="number"><strong>
					<?php 
						$d=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(a.id) AS tot FROM master_karyawan_unit a, master_karyawan b WHERE a.id_karyawan=b.id AND b.id_jabatan=1 AND a.id_unit='$_SESSION[id_unit]'"));
						
						echo $d['tot'];
					?>
					</strong></div>
				</div>
			</div>
			
			<!-- Item -->
			<div class="col-xl-3 col-sm-6">
				<div class="item d-flex align-items-center">
					<div class="icon bg-green"><i class="icon-bill"></i></div>
					<div class="title"><span>Jumlah<br>Test</span>
						<div class="progress">
							<div role="progressbar" style="width: 100%; height: 4px;" aria-valuenow="{#val.value}" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-green"></div>
						</div>
					</div>
					<div class="number"><strong>
					<?php 
						$data = pg_query($dbconn,"SELECT DISTINCT id_tindakan FROM tindakan_kategori_harga_unit WHERE id_unit='$_SESSION[id_unit]' GROUP BY id_tindakan");
						$d=pg_num_rows($data);
						echo $d;
					?>
					</strong></div>
				</div>
			</div>
			
			<!-- Item -->
			<div class="col-xl-3 col-sm-6">
				<div class="item d-flex align-items-center">
					<div class="icon bg-orange"><i class="icon-check"></i></div>
					<div class="title"><span>Jumlah<br>Lab Analysis</span>
						<div class="progress">
							<div role="progressbar" style="width: 100%; height: 4px;" aria-valuenow="{#val.value}" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-orange"></div>
						</div>
					</div>
					<div class="number"><strong>
					<?php 
						$data = pg_query($dbconn,"SELECT DISTINCT id_lab_analysis FROM lab_analysis_unit WHERE id_unit='$_SESSION[id_unit]' GROUP BY id_lab_analysis");
						$d=pg_num_rows($data);
						echo $d;
					?>
					</strong></div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="tables">   
	<div class="container-fluid">
		<div class="row ">
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<h3 class="h4">Data User Login</h3>
					</div>
					<div class="card-body">
						<table class="table table-sm">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Jabatan</th>
									<th>Waktu Login</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$tampil=pg_query($dbconn,"SELECT a.id_karyawan, a.tanggal_login, a.jam_login, c.nama, c.id_jabatan FROM auth_users a, master_karyawan_unit b, master_karyawan c WHERE a.id_karyawan=b.id_karyawan AND b.id_unit='$_SESSION[id_unit]' AND a.status_login='Y' AND a.id_karyawan=c.id");
								
								while($r=pg_fetch_array($tampil)){
									$j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan_jabatan WHERE id='$r[id_jabatan]'"));
									$tanggal=DateToIndo2($r['tanggal_login']);
									?>
									<tr>
										<td><?php echo $r['nama'];?></td>
										<td><?php echo $j['nama'];?></td>
										<td><?php echo "$tanggal $r[jam_login]";?></td>
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
</section>