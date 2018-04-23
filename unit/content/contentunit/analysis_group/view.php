<?php
	$id=$_GET['id'];

	$result=pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='".$id."' ");
	$data = pg_fetch_array($result);


?>	
<div class="card-header d-flex align-items-center">
    <h3 class="h4">View </h3>
</div>
<div class="card-body">
	<table class="table table-sm">
		<tr>
			<td width="150px">Kode</td>
			<td width="10px">:</td>
			<td><?php echo $data['kode']; ?></td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td><?php echo $data['nama']; ?></td>
		</tr>
		<tr>
			<td>Deskripsi</td>
			<td>:</td>
			<td><?php echo $data['deskripsi']; ?></td>
		</tr>
		<tr>
			<td>Charge Item (Test)</td>
			<td>:</td>
			<td>
				<?php 
				$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM tindakan WHERE id='$data[id_tindakan]'"));
				echo $a['nama'];
				?>
			</td>
		</tr>
		<tr>
			<td>Analisis</td>
			<td>:</td>
			<td>
				<?php
				$tampil=pg_query($dbconn,"SELECT b.nama FROM lab_analysis_group_detail a, lab_analysis b WHERE a.id_lab_analysis_group='$id' AND a.id_lab_analysis=b.id");
				while($r=pg_fetch_array($tampil)){
					echo"$r[nama]<br>";
				}
				?>
			</td>
		</tr>
	</table>
</div>


<div class="card-footer">
	 <button type="button" value="batal" class="btn btn-sm btn-primary " onClick="window.location='media.php?content=analysis_group';" >Kembali</button>
</div>

            
