<?php
$module=$_GET['module'];
$content=$_GET['content'];
?>
<span class="heading">Menu Kerja</span>
<ul class="list-unstyled">
	<li <?php if($module=='home'){ echo "class='active'";}?>> 
		<a href="home"><i class="icon-home"></i>Dashboard</a>
	</li>
	<!--<li><a href="#dashvariants" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Dropdown </a>
		<ul id="dashvariants" class="collapse list-unstyled">
			<li><a href="#">Page</a></li>
			<li><a href="#">Page</a></li>
			<li><a href="#">Page</a></li>
			<li><a href="#">Page</a></li>
		</ul>
	</li>
	-->
	<li <?php if($content=='karyawan'){ echo "class='active'";}?>> 
		<a href="karyawan"> <i class="icon-user"></i>Karyawan </a>
	</li>
	<li <?php if($content=='dokter'){ echo "class='active'";}?>> 
		<a href="dokter"> <i class="fa fa-user-plus"></i>Dokter </a>
	</li>
	<li <?php if($content=='perusahaan'){ echo "class='active'";}?>> 
		<a href="perusahaan"> <i class="icon-user"></i>Perusahaan </a>
	</li>
	<li <?php if($content=='paket'){ echo "class='active'";}?>> 
		<a href="paket"> <i class="fa fa-sticky-note-o"></i>Paket </a>
	</li>
	<li <?php if($content=='test'){ echo "class='active'";}?>> 
		<a href="tindakan"> <i class="icon-padnote"></i>Test</a>
	</li>
	<li <?php if($content=='commision_group'){ echo "class='active'";}?>> 
		<a href="commision"> <i class="fa fa-credit-card"></i>Commision Group</a>
	</li>
	<li <?php if($content=='analysis' or $content=='analysis_group'){ echo "class='active'";}?>><a href="#dashvariants" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-medkit"></i>Lab </a>
		<ul id="dashvariants" class="collapse list-unstyled">
			<li><a href="lab">Analysis</a></li>
			<li><a href="group">Group</a></li>
		</ul>
	</li>
	<li <?php if($content=='level' or $content=='menu' or $content=='user' or $content=='akses'){ echo "class='active'";}?>><a href="#levelakses" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-key"></i>Akses Level </a>
		<ul id="levelakses" class="collapse list-unstyled">
			<li <?php if($content=='akses'){ echo "class='active'";}?>><a href="akses">Akses</a></li>
			<li><a href="user">User</a></li>
			<li><a href="menu">Modul Menu</a></li>
			<li><a href="level">Level</a></li>
		</ul>
	</li>
</ul>

<span class="heading">Extras</span>
<ul class="list-unstyled">
	<li <?php if($module=='profile'){ echo "class='active'";}?>> 
		<a href="profile"> <i class="icon-user"></i>Profile Admin </a>
	</li>
</ul>