<?php
include ("../koneksi.php");  ?>
<br/>

<!-- <div class="">
<?php 
$data=pg_query("SELECT * FROM lokasi_krj");
while ($k = pg_fetch_array($data)) { 
?>

<div class="col-xs-1 text-center">
  <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgColor="#39CCCC"/>
  <div class="knob-label"><?php echo $k['nm_lokasi']; ?></div>
</div> 
<?php } ?>
</div><!-- /.row -->
<div class="box box-solid box-info">
	<div class="box-header">
      		<h3 class="btn disabled box-title">
      		Informasi</h3>	
      		</div>	
	<div class="box-body">
		<div class="col-md-12">
			<h4>Hak Akses sebagai HRD:</h4>
			<li>Mengelola data Pegawai</li>
			<li>Mengelola data SK Kerja</li>
			<li>Mengelola data Prestasi Pegawai</li>
			<li>Mengelola data Hukuman Pegawai</li>
		</div>
	</div>
</div><!-- /.row --
