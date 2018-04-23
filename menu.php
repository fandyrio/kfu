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
		if($Pemanggilan_Antrian) {  
		echo'<li class="nav-item">
			<a class="nav-link" href="panggil-antrian"><i class="icon-login"></i> Pemanggilan Antrian</a>
			</li>';
		} 
		if($Pendaftaran) {  
		echo'<li class="nav-item">
			<a class="nav-link" href="getAllReservasi"><i class="icon-login"></i> Pendaftaran</a>
			</li>';
		}
		if($Antrian) {  
		echo'<li class="nav-item">
			<a class="nav-link" href="antrian"><i class="icon-user"></i> Antrian</a>
		</li>';
		}

		if($Kunjungan_Pasien || $Billing) {  
		echo'
		<li class="nav-item">
			<a class="nav-link" href="pasien"><i class="icon-people"></i> Pasien</a>
		</li>';
		}

		
		if($Keuangan) { 
		echo '
		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-money"></i> Keuangan</a>
			<ul class="nav-dropdown-items">
				
		';
			
			if(!$Invoice){
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
			if($klaim){
				echo '<li class="nav-item">
					<a class="nav-link" href="keuangan-customer-klaim"><i class="icon-wallet"></i> Klaim</a>
				</li>';
			}
			echo'
			</ul>
		</li>';
		}
		
		
		if($ReportList){
		echo '<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-notebook"></i> Report & List</a>
			<ul class="nav-dropdown-items">';
			
				echo '<li class="nav-item">
					<a class="nav-link" href="jenis-pemeriksaan"><i class="icon-notebook"></i> Jenis Pemeriksaan</a>
				</li>';
			
				echo '<li class="nav-item">
					<a class="nav-link" href="data-pasien"><i class="icon-notebook"></i> Data Pasien</a>
				</li>';

				echo '<li class="nav-item">
					<a class="nav-link" href="laporan-pasien"><i class="icon-notebook"></i> laporan Pasien</a>
				</li>';
			
				echo '<li class="nav-item">
					<a class="nav-link" href="laporan-rawat-jalan"><i class="icon-notebook"></i> Laporan Rawat Jalan</a>
				</li>';
			
			echo '<li class="nav-item">
					<a class="nav-link" href="laporan-fee-dokter"><i class="icon-notebook"></i> Laporan Fee Dokter</a>
				</li>';
			echo '<li class="nav-item">
					<a class="nav-link" href="laporan-prb"><i class="icon-notebook"></i> Laporan PRB</a>
				</li>';
			echo'

				
			</ul>
		</li>';

		echo'
			<li class="nav-item">
				<a class="nav-link" href="dokter"><i class="fa fa-square-o"></i> Dokter</a>
			</li>';
		}

		echo'
			<li class="nav-item">
				<a class="nav-link" href="settings_klinik"><i class="fa fa-cog"></i> Settings</a>
			</li>';
			
		?>
		<div id='test' style="display:none">
		<li class="nav-title">
			EXTRAS 
		</li>
		<?php
		
		if($Pegawai) { 
		echo '
		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-users"></i> Pegawai</a>
			<ul class="nav-dropdown-items">
				
		';
			
				echo '<li class="nav-item">
					<a class="nav-link" href="pegawai"><i class="icon-wallet"></i> Data Pegawai</a>
				</li>';
			
			
				echo '<li class="nav-item">
					<a class="nav-link" href="auth-user"><i class="icon-user "></i> Auth User</a>
				</li>';
			
			
		
			echo'
			</ul>
		</li>';
		}
		
		if($Perusahaan ) {  
			echo'
			<li class="nav-item">
				<a class="nav-link" href="perusahaan"><i class="fa fa-square-o"></i> Perusahaan</a>
			</li>';
			}


		if($Perusahaan ) {  
			echo'
			<li class="nav-item">
				<a class="nav-link" href="rajikan"><i class="fa fa-square-o"></i> Racikan</a>
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
						if($permintaan_penawaran){
							echo '
							<li class="nav-item">
								<a class="nav-link" href="inventori-rq"><i class="icon-star"></i> Permintaan Penawaran</a>
							</li>
							';
						}
						if($penawaran_harga){
							echo '
							<li class="nav-item">
								<a class="nav-link" href="inventori-quotation"><i class="icon-star"></i> Penawaran Harga</a>
							</li>
							';
						}
						if($po){
							echo'<li class="nav-item">
								<a class="nav-link" href="inventori-supplier-po"><i class="icon-star"></i> Purchase Order</a>
							</li>';
						}
						if($Terima_Barang){
							echo'<li class="nav-item">
								<a class="nav-link" href="inventori-grn"><i class="icon-star"></i> Terima Barang</a>
							</li>';
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
		
		echo '
		<li class="nav-item">
			<a class="nav-link" href="pos"><i class="icon-menu"></i>POS</a>
		</li>';

		echo '
		<li class="nav-item">
			<a class="nav-link" href="sync"><i class="fa fa-rss"></i> Sync</a>
		</li>';
	
		?>
	</div>	
	</ul>
</nav>
 