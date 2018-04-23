<nav class="sidebar-nav">
	<ul class="nav">
		<li class="nav-item">
			<a class="nav-link" href="home"><i class="icon-speedometer"></i> Dashboard <span class="badge badge-primary">NEW</span></a>
		</li>

		<li class="nav-title">
			MENU UTAMA 
		</li>
		<!--
		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-layers"></i> Master</a>
			<ul class="nav-dropdown-items">
				<li class="nav-item">
					<a class="nav-link" href="activity-type"><i class="icon-arrow-right"></i> Activity Type</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="crm-status"><i class="icon-arrow-right"></i> CRM Status</a>
				</li>
			</ul>
		</li>-->
		
		<li class="nav-item">
			<a class="nav-link" href="laporan"><i class="icon-doc"></i> Laporan Marketing</a>
		</li>
		<?php
		if($_SESSION['id_units']==1){
		?>
		<li class="nav-item">
			<a class="nav-link" href="transaksi-target"><i class="icon-chart"></i> Transaksi Target</a>
		</li>
		<?php
		}
		?>

		<li class="nav-item">
			<a class="nav-link" href="target-realisasi"><i class="icon-speedometer"></i> Target vs Realisasi</a>
		</li>
		
		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-notebook"></i> MCU</a>
			<ul class="nav-dropdown-items">
				<li class="nav-item">
					<a class="nav-link" href="mcu-perusahaan"><i class="icon-arrow-right"></i> Perusahaan/Instansi</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="mcu-penawaran"><i class="icon-arrow-right"></i> Penawaran</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="mcu-jadwal"><i class="icon-arrow-right"></i> Jadwal</a>
				</li>
			</ul>
		</li>
		
		<li class="nav-item nav-dropdown">
			<a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-docs"></i> Billing</a>
			<ul class="nav-dropdown-items">
				<li class="nav-item">
					<a class="nav-link" href="billing-klaim"><i class="icon-arrow-right"></i> Klaim</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="billing-invoice"><i class="icon-arrow-right"></i> Invoice</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="billing-pembayaran"><i class="icon-arrow-right"></i> Pembayaran</a>
				</li>
			</ul>
		</li>
	</ul>
</nav>
 