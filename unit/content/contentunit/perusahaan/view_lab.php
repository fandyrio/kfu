<?php
    $id=$_GET['id'];

    $result=pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='".$id."' ");
    $data = pg_fetch_array($result);
	$harga_modal=number_format($data['harga_modal'],'0', '','.');
?>  

<ul class="nav nav-tabs" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" data-toggle="tab" href="#detail_lab" role="tab" >Detail</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#range_lab" role="tab" >Reference Range</a>
	</li>	
</ul>
	
<div class="card-body">
	<div class="tab-content">
        <div class="tab-pane active" id="detail_lab" role="tabpanel">
            <table class="table table-sm">
				<tr>
					<td width="150px">Kode</td>
					<td width="10px">:</td>
					<td><?php echo $data['kode'];?></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td><?php echo $data['nama'];?></td>
				</tr>
				<tr>
					<td>Deskripsi</td>
					<td>:</td>
					<td><?php echo $data['catatan'];?></td>
				</tr>
				<tr>
					<td>Harga Modal</td>
					<td>:</td>
					<td><?php echo $harga_modal;?></td>
				</tr>
				<tr>
					<td>Satuan</td>
					<td>:</td>
					<td><?php echo $data['satuan'];?></td>
				</tr>
				<tr>
					<td>Specimen</td>
					<td>:</td>
					<td>
						<?php 
						$s=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_specimen WHERE id='$data[id_lab_specimen]'"));
						echo $s['nama'];
						?>
					</td>
				</tr>
				<tr>
					<td>Info URL</td>
					<td>:</td>
					<td><?php echo $data['info_url'];?></td>
				</tr>
				<tr>
					<td>Charge Items (Test)</td>
					<td>:</td>
					<td>
						<?php 
						$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM tindakan WHERE id='$data[id_tindakan]'"));
						echo $a['nama'];
						?>
					</td>
				</tr>
				<tr>
					<td>Kategori</td>
					<td>:</td>
					<td>
						<?php 
						$tampil=pg_query($dbconn,"SELECT b.nama FROM lab_analysis_kategori a, lab_kategori b WHERE a.id_lab_analysis='$id' AND a.id_lab_kategori=b.id");
						while($r=pg_fetch_array($tampil)){
							echo"$r[nama]<br>";
						}
						?>
					</td>
				</tr>
				<tr>
					<td>Lokasi</td>
					<td>:</td>
					<td>
						<?php 
						$tampil=pg_query($dbconn,"SELECT b.nama FROM lab_analysis_location a, lab_location b WHERE a.id_lab_analysis='$id' AND a.id_lab_location=b.id");
						while($r=pg_fetch_array($tampil)){
							echo"$r[nama]<br>";
						}
						?>
					</td>
				</tr>
				<tr>
					<td>Additional Info</td>
					<td>:</td>
					<td>
						<?php 
						$tampil=pg_query($dbconn,"SELECT b.nama FROM lab_analysis_addtional_info a, lab_additional_info b WHERE a.id_lab_analysis='$id' AND a.id_lab_additional_info=b.id");
						while($r=pg_fetch_array($tampil)){
							echo"$r[nama]<br>";
						}
						?>
					</td>
				</tr>
			</table>
		</div>
		
		<div class="tab-pane" id="range_lab" role="tabpanel">
           
			<table class="table table-bordered table-striped table-sm">
				<thead>
					<tr>
						<th >Jenis Kelamin</th>
						<th >Dari Usia</th>
						<th >Ke Usia</th>
						<th >Low Range</th>
						<th >High Range</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$res=pg_query($dbconn,"Select * from  lab_analisis_referal_range where id_lab_analisis='".$id."'");
					while ($row=pg_fetch_assoc($res)) {
						$j=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_jenkel WHERE id='$row[id_jenkel]'"));
					?>
						<tr>
							<td><?php echo $j["nama"] ?></td>
							<td><?php echo $row["usia_awal"] ?></td>
							<td><?php echo $row["usia_akhir"] ?></td>
							<td><?php echo $row["nilai_rendah"] ?></td>
							<td><?php echo $row["nilai_tinggi"] ?></td>
						</tr>
				<?php
					} 
				?> 
				</tbody>
			</table>
        </div> 
	</div>
</div>

<div class="card-footer">
	 <button type="button" value="batal" class="btn btn-sm btn-primary " id="kembali_lab" >Kembali</button>
</div>
