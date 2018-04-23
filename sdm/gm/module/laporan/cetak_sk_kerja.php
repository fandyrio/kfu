<?php 
include "head.php";
?>
          <section class="content-header">
            <h1>
             Laporan
              <small>SK Kerja Pegawai</small>
            </h1>
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i> Laporan</a></li>
              <li class="active">SK Kerja</li>
            </ol>
          </section>

           
          <section class="content">
            <div class="text-center">
			<h3><img src="inc/zt.png"/></h3>
	
			</div><br/>
             
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title center">Daftar SK Kerja Pegawai</h3>
							
              </div>
              <div class="box-body">
                <table  class="table table-bordered table-striped">
<thead>
	<tr >
		<th>No. SK</th>
		<th>NIP</th>
		<th>Nama Pegawai</th> 
		<th>Tgl. SK</th> 
		<th>Lokasi</th> 
		<th>Unit Kerja</th> 
		<th>Jabatan</th>		
		<th>Gaji (Rp)</th> 
	</tr>
</thead>

<tbody>
<?php 
// Tampilkan data dari Database
$sql = "SELECT * FROM sk_krj a, pegawai b, jabatan c, pangkat d, unit_krj e, lokasi_krj f where a.nip=b.nip and a.id_jabatan=c.id_jabatan and a.id_pangkat=d.id_pangkat and a.id_unit_krj=e.id_unit_krj and a.id_lokasi=f.id_lokasi and a.status_sk='aktif' order by f.nm_lokasi and a.tgl_sk";
$tampil = pg_query($sql);
$no=1;
while ($k = pg_fetch_array($tampil)) { 
$Kode = $k['no_sk'];
$msk=IndonesiaTgl($k['tgl_msk']);
?>

	<tr>	
	<td><?php echo $k['no_sk']; ?></a></td>
	<td><?php echo $k['nip']; ?></td>
	<td><?php echo $k['nm_pegawai']; ?></td>
	<td><?php echo IndonesiaTgl($k['tgl_sk']); ?></td>	
	<td><?php echo $k['nm_lokasi']; ?></td>
	<td><?php echo $k['nm_unit_krj']; ?></td>
	<td><?php echo $k['nm_jabatan']; ?></td>
	<td><?php echo format_angka($k['gaji']); ?></td>
	<?php
	}
	?>
	</tr>
			</tbody>
		</table>	
              </div><!-- /.box-body -->
            </div>
          </section><!-- /.content -->

<?php
include "tail.php";?>