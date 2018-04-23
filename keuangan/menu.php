<?php
 include "privileges.php";
?>
<nav class="sidebar-nav">
	<ul class="nav">
		<li class="nav-item">
			<a class="nav-link" href="home"><i class="icon-speedometer"></i> Dashboard <span class="badge badge-primary">NEW</span></a>
		</li>

		<li class="nav-title">
			MENU UTAMA 
		</li>
		<?php
		if($Pendaftaran) {  
		echo'<li class="nav-item">
			<a class="nav-link" href="panggil-antrian"><i class="icon-login"></i> Pemanggilan Antrian</a>
			</li>';
		} 
		if($Pendaftaran) {  
		echo'<li class="nav-item">
			<a class="nav-link" href="pendaftaran"><i class="icon-login"></i> Pendaftaran</a>
			</li>';
		}
		if($Antrian) {  
		echo'<li class="nav-item">
			<a class="nav-link" href="antrian"><i class="icon-user"></i> Antrian</a>
		</li>';
		}

		if($Info_Pasien || $Billing) {  
		echo'
		<li class="nav-item">
			<a class="nav-link" href="pasien"><i class="icon-people"></i> Pasien</a>
		</li>';
		}

		if($Antrian) {  
		echo'<li class="nav-item">
			<a class="nav-link" href="jadwal"><i class="icon-clock"></i> Jadwal MCU</a>
		</li>';
		}


		if($lis) {  
		echo'<li class="nav-item">
			<a class="nav-link" href="lis"><i class="fa fa-database"></i> LIS</a>
		</li>';
		}
		
		if($menu_order || $menu_hasil){
		echo '
		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-docs"></i> Lab Tracking</a>
			<ul class="nav-dropdown-items">
				<li class="nav-item">
					<a class="nav-link" href="lab-order"><i class="icon-docs"></i> Order</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="lab-hasil"><i class="icon-docs"></i> Hasil</a>
				</li>
			</ul>
		</li>';
		}
	
		
		if($Invoice || $Pembayaran || $klaim) { 
		echo '
		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-money"></i> Keuangan</a>
			<ul class="nav-dropdown-items">
				
		';
			if($klaim){
				echo '<li class="nav-item">
					<a class="nav-link" href="keuangan-customer-klaim"><i class="icon-wallet"></i> Klaim</a>
				</li>';
			}
			if($Invoice){
				echo '<li class="nav-item">
					<a class="nav-link" href="keuangan-customer-invoice"><i class="icon-wallet"></i> Invoice</a>
				</li>';
			}
			if($Pembayaran){
				echo '
				<li class="nav-item">
					<a class="nav-link" href="keuangan-customer-payment"><i class="icon-wallet"></i> Pembayaran</a>
				</li>
				';
			}
			echo'
			</ul>
		</li>';
		}
		
		if($Rujukan) { 
		echo '
		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wallet"></i> Rujukan</a>
			<ul class="nav-dropdown-items">
				
		';
			if($klaim){
				echo '<li class="nav-item">
					<a class="nav-link" href="keuangan-customer-klaim"><i class="icon-wallet"></i> Form Laboratorium</a>
				</li>';
			}
			if($Invoice){
				echo '<li class="nav-item">
					<a class="nav-link" href="keuangan-customer-invoice"><i class="icon-wallet"></i> Form Non Laboratorium</a>
				</li>';
			}
			if($Pembayaran){
				echo '
				<li class="nav-item">
					<a class="nav-link" href="keuangan-customer-payment"><i class="icon-wallet"></i> Hasil Laboratorium</a>
				</li>
				';
			}
			echo'
			</ul>
		</li>';
		}
		
		
		if($Jenis_Pemeriksaan || $Data_Pasien){
		echo '<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-notebook"></i> Report & List</a>
			<ul class="nav-dropdown-items">';
			if($Jenis_Pemeriksaan){
				echo '<li class="nav-item">
					<a class="nav-link" href="jenis-pemeriksaan"><i class="icon-notebook"></i> Jenis Pemeriksaan</a>
				</li>';
			}
			if($Data_Pasien){
				echo '<li class="nav-item">
					<a class="nav-link" href="data-pasien"><i class="icon-notebook"></i> Data Pasien</a>
				</li>';
			}
			if($Laporan_Rawat_Jalan){
				echo '<li class="nav-item">
					<a class="nav-link" href="laporan-rawat-jalan"><i class="icon-notebook"></i> Laporan Rawat Jalan</a>
				</li>';
			}
			echo'

				
			</ul>
		</li>';
		}
		?>
		<li class="nav-title">
			EXTRAS 
		</li>
		<?php
		
		if($auth_user || $pegawai) { 
		echo '
		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-users"></i> Pegawai</a>
			<ul class="nav-dropdown-items">
				
		';
			if($pegawai){
				echo '<li class="nav-item">
					<a class="nav-link" href="pegawai"><i class="icon-wallet"></i> Data Pegawai</a>
				</li>';
			}
			if($auth_user){
				echo '<li class="nav-item">
					<a class="nav-link" href="auth-user"><i class="icon-user "></i> Auth User</a>
				</li>';
			}
			
		
			echo'
			</ul>
		</li>';
		}
		
		if($Perusahaan || $mcu ) { 
		echo '
		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-file-o"></i> MCU</a>
			<ul class="nav-dropdown-items">
				
		';
			if($Perusahaan ) {  
			echo'
			<li class="nav-item">
				<a class="nav-link" href="perusahaan"><i class="fa fa-square-o"></i> Perusahaan</a>
			</li>';
			}

			if($mcu ) {  
			echo'
			<li class="nav-item">
				<a class="nav-link" href="mcu"><i class="fa fa-square-o"></i> Event/MCU</a>
			</li>';
			}
			
			if($mcu ) {  
			echo'
			<li class="nav-item">
				<a class="nav-link" href="import-pasien"><i class="fa fa-square-o"></i> Upload Pasien</a>
			</li>';
			}
			
			if($mcu ) {  
			echo'
			<li class="nav-item">
				<a class="nav-link" href="mcu"><i class="fa fa-square-o"></i> Resume</a>
			</li>';
			}
			
			if($mcu ) {  
			echo'
			<li class="nav-item">
				<a class="nav-link" href="mcu"><i class="fa fa-square-o"></i> Laporan Hasil Event/MCU</a>
			</li>';
			}
			
			if($mcu ) {  
			echo'
			<li class="nav-item">
				<a class="nav-link" href="mcu"><i class="fa fa-square-o"></i> Export Hasil Event/MCU</a>
			</li>';
			}
			
			if($mcu ) {  
			echo'
			<li class="nav-item">
				<a class="nav-link" href="mcu"><i class="fa fa-square-o"></i> Laporan Rekap Resume</a>
			</li>';
			}
			echo'
			</ul>
		</li>';
		}
		
		if($Terima_Barang || $po || $penawaran_harga || $permintaan_penawaran || $stok_adj || $stok_mutasi) { 
			echo'<li class="nav-item nav-dropdown">
				<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-doc"></i> Inventori</a>
				<ul class="nav-dropdown-items">';
					if($Terima_Barang || $penawaran_harga ){
					echo'
					<li class="nav-item nav-dropdown">
						<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-docs"></i> Supplier</a>
						<ul class="nav-dropdown-items">';
						if($Terima_Barang){
							echo'<li class="nav-item">
								<a class="nav-link" href="inventori-grn"><i class="icon-star"></i> Terima Barang</a>
							</li>';
						}
						if($po){
							echo'<li class="nav-item">
								<a class="nav-link" href="inventori-supplier-po"><i class="icon-star"></i> Purchase Order</a>
							</li>';
						}
						if($penawaran_harga){
							echo '
							<li class="nav-item">
								<a class="nav-link" href="inventori-quotation"><i class="icon-star"></i> Penawaran Harga</a>
							</li>
							';
						}
						if($permintaan_penawaran){
							echo '
							<li class="nav-item">
								<a class="nav-link" href="inventori-rq"><i class="icon-star"></i> Permintaan Penawaran</a>
							</li>
							';
						}
						if($pengembalian_barang){
							echo '						
							<li class="nav-item">
								<a class="nav-link" href="inventori-kembali"><i class="icon-star"></i> Pengembalian Barang</a>
							</li>
							';
						}
							
							
					echo'
						</ul>
					</li>';
				}
					
					if($stok_adj || $stok_saat){
					echo'<li class="nav-item nav-dropdown">
						<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-menu"></i> Stok</a>
						<ul class="nav-dropdown-items">';
						if($stok_adj){
							echo '
							
							<li class="nav-item">
								<a class="nav-link" href="inventori-stok-adjustment"><i class="icon-menu"></i> Stock Adjustment</a>
							</li>
							';
						}
						if($stok_saat){
							echo '						
							<li class="nav-item">
								<a class="nav-link" href="inventori-stok-balanced"><i class="icon-menu"></i> Stok Saat ini</a>
							</li>
							';
						}
						if($stok_movement){
							echo '						
							<li class="nav-item">
								<a class="nav-link" href="inventori-stok-pergerakan"><i class="icon-menu"></i> Pergerakan Stok</a>
							</li>
							';
						}
						if($stok_mutasi){
							echo '						
							<li class="nav-item">
								<a class="nav-link" href="inventori-stok-mutasi"><i class="icon-menu"></i> Mutasi Stok</a>
							</li>
							';
						}
				
							
					echo'		
						</ul>
					</li>';
				}
				
			echo '</ul>
			</li>';
		}
		
		
		echo '<li class="nav-item">
			<a class="nav-link" href="sync"><i class="fa fa-rss"></i> Sync</a>
		</li>';
	
		?>
		
	</ul>
</nav>
 