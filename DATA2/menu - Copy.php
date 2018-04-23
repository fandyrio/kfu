<?php
$user=pg_query($dbconn,"SELECT id_level FROM auth_users WHERE id_users='".$_SESSION['login_user']."' ");
		$r=pg_fetch_array($user);

		
 $result=pg_query($dbconn,"SELECT id, id_menu FROM auth_akses_menu WHERE id_level= '".$r['id_level']."'");
 while ($row =pg_fetch_assoc($result)){ 	


?>
<nav class="sidebar-nav">
	<ul class="nav">
		<li class="nav-item">
			<a class="nav-link" href="home"><i class="icon-speedometer"></i> Dashboard <span class="badge badge-primary">NEW</span></a>
		</li>

		<li class="nav-title">
			MENU UTAMA <?php echo $row['id_menu']; ?>
		</li>
		
		<li class="nav-item">
			<a class="nav-link" href="pendaftaran"><i class="icon-login"></i> Pendaftaran</a>
		</li>
		
		<li class="nav-item">
			<a class="nav-link" href="antrian"><i class="icon-user"></i> Antrian</a>
		</li>
		
		<li class="nav-item">
			<a class="nav-link" href="pasien"><i class="icon-people"></i> Pasien</a>
		</li>
		
		
		
		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wallet"></i> Keuangan</a>
			<ul class="nav-dropdown-items">
				<!--<li class="nav-item">
					<a class="nav-link" href="keuangan-customer-billing"><i class="icon-wallet"></i> Billing</a>
				</li>-->
				<li class="nav-item">
					<a class="nav-link" href="keuangan-customer-klaim"><i class="icon-wallet"></i> Klaim</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="keuangan-customer-invoice"><i class="icon-wallet"></i> Invoice</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="keuangan-customer-payment"><i class="icon-wallet"></i> Pembayaran</a>
				</li>
				<!--<li class="nav-item nav-dropdown">
					<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-grid"></i> Supplier</a>
					<ul class="nav-dropdown-items">
						<li class="nav-item">
							<a class="nav-link" href="keuangan-supplier-pembayaran"><i class="icon-star"></i> Pembayaran</a>
						</li>
					</ul>
				</li>
				-->
			</ul>
		</li>

		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-doc"></i> Inventori</a>
			<ul class="nav-dropdown-items">
				<!-- <li class="nav-item nav-dropdown">
					<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-docs"></i> Customer</a>
					<ul class="nav-dropdown-items">
						<li class="nav-item">
							<a class="nav-link" href="inventori-customer-invoice"><i class="icon-star"></i> Invoice</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="inventori-customer-quotation"><i class="icon-star"></i> Quotation</a>
						</li>
					</ul>
				</li> -->
				
				<li class="nav-item nav-dropdown">
					<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-docs"></i> Supplier</a>
					<ul class="nav-dropdown-items">
						<li class="nav-item">
							<a class="nav-link" href="inventori-grn"><i class="icon-star"></i> Terima Barang</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="inventori-supplier-po"><i class="icon-star"></i> Purchase Order</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="inventori-quotation"><i class="icon-star"></i> Penawaran Harga</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="inventori-rq"><i class="icon-star"></i> Permintaan Penawaran</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="inventori-kembali"><i class="icon-star"></i> Pengembalian Barang</a>
						</li>
					</ul>
				</li>
				
				<li class="nav-item nav-dropdown">
					<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-menu"></i> Stok</a>
					<ul class="nav-dropdown-items">
						<li class="nav-item">
							<a class="nav-link" href="inventori-stok-adjustment"><i class="icon-menu"></i> Stock Adjustment</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="inventori-stok-balanced"><i class="icon-menu"></i> Stok Saat ini</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="inventori-stok-pergerakan"><i class="icon-menu"></i> Pergerakan Stok</a>
						</li>
						<!-- <li class="nav-item">
							<a class="nav-link" href="inventori-stok-buka"><i class="icon-menu"></i> Buka Stok</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="inventori-stok-penyesuaian"><i class="icon-menu"></i> Penyesuaian Stok</a>
						</li> -->
						<li class="nav-item">
							<a class="nav-link" href="inventori-stok-mutasi"><i class="icon-menu"></i> Mutasi Stok</a>
						</li>
					</ul>
				</li>
			</ul>
		</li>	
		
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
		</li>

		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-notebook"></i> Report & List</a>
			<ul class="nav-dropdown-items">
				<li class="nav-item">
					<a class="nav-link" href="jenis-pemeriksaan"><i class="icon-notebook"></i> Jenis Pemeriksaan</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="data-pasien"><i class="icon-notebook"></i> Data Pasien</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="laporan-rawat-jalan"><i class="icon-notebook"></i> Laporan Rawat Jalan</a>
				</li>
			</ul>
		</li>
		

		
		<!--<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-graph"></i> Statistik dan Grafis</a>
			<ul class="nav-dropdown-items">
				<li class="nav-item">
					<a class="nav-link" href="analisis-casenote"><i class="icon-graph"></i> Analisis Casenote</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="analisis-keuangan"><i class="icon-graph"></i> Analisis Keuangan</a>
				</li>
				<!--<li class="nav-item">
					<a class="nav-link" href="analisis-inventori"><i class="icon-graph"></i> Analisis Inventori</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="analisis-pasien"><i class="icon-graph"></i> Analisis Pasien</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="analisis-kunjungan"><i class="icon-graph"></i> Analisis Kunjungan</a>
				</li>
			</ul>
		</li>-->
		
		<li class="nav-item">
			<a class="nav-link" href="import-pasien"><i class="fa fa-file-excel-o"></i> Import Data Pasien</a>
		</li>
		
		<!--
		<li class="nav-item">
			<a class="nav-link" href="sinkronisasi"><i class="icon-feed"></i> Sync Data</a>
		</li>
		-->
	</ul>
</nav>
<?php
 }

?>