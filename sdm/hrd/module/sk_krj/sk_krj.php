<?php

function umur($tgl_lahir){
    $tgl=explode("/",$tgl_lahir);
    $cek_jmlhr1=cal_days_in_month(CAL_GREGORIAN,$tgl['1'],$tgl['2']);
    $cek_jmlhr2=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
    $sshari=$cek_jmlhr1-$tgl['0'];
    $ssbln=12-$tgl['1']-1;
    $hari=0;
    $bulan=0;
    $tahun=0;
//hari+bulan
    if($sshari+date('d')>=$cek_jmlhr2){
        $bulan=1;
        $hari=$sshari+date('d')-$cek_jmlhr2;
    }else{
        $hari=$sshari+date('d');
    }
    if($ssbln+date('m')+$bulan>=12){
        $bulan=($ssbln+date('m')+$bulan)-12;
        $tahun=date('Y')-$tgl['2'];
    }else{
        $bulan=($ssbln+date('m')+$bulan);
        $tahun=(date('Y')-$tgl['2'])-1;
    }

      $selisih=$tahun." Thn ".$bulan." Bln ";
    return $selisih;
}
$aksi="module/sk_krj/sk_krj_aksi.php";

switch($_GET[aksi]){
default:
?>		

<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
	<li class="active"><a class="text-black" href="#dat" data-toggle="tab">SK Kerja</a></li>
	<li><a class="text-black" href="#dat1" data-toggle="tab">Riwayat SK Kerja</a></li>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="dat">
<section id="new">
	<div class="box box-solid box-info">
		<div class="box-header">
		<h3 class="btn btn disabled box-title">
		<i class="glyphicon glyphicon-briefcase"></i>
		Daftar SK Kerja Aktif </h3>		
		</div>		
	<div class="box-body">
	<table id="example1" class="table table-bordeblue table-striped">
<thead>
	<tr class="text-green">
		<th>No. SK</th>
		<th>NIP</th>
		<th>Nama Pegawai</th> 
		<th>Tgl. SK</th> 
		<th>Lokasi</th> 
		<th>Unit Kerja</th> 
		<th>Jabatan</th>
		<th>Masa Kerja</th>
		<th>Gaji (Rp)</th>
		<th class="col-sm-1">AKSI</th> 	
	</tr>
</thead>

<tbody>
<?php 
// Tampilkan data dari Database
$sql = "SELECT * FROM sk_krj a, pegawai b, jabatan c, pangkat d, unit_krj e, lokasi_krj f where a.nip=b.nip and a.id_jabatan=c.id_jabatan and a.id_pangkat=d.id_pangkat and a.id_unit_krj=e.id_unit_krj and a.id_lokasi=f.id_lokasi and a.status_sk='aktif'";
$tampil = pg_query($sql);
$no=1;
while ($k = pg_fetch_assoc($tampil)) { 
$Kode = $k['no_sk'];
$msk=IndonesiaTgl($k['tgl_msk']);
?>

	<tr>	
	<td><?php echo $k['no_sk']; ?></a></td>
	<td><a target="blank"href="?module=pegawai&aksi=detail_pegawai&nip=<?php echo $k['nip'];?>"><?php echo $k['nip']; ?></a></td>
	<td><?php echo $k['nm_pegawai']; ?></td>
	<td><?php echo IndonesiaTgl($k['tgl_sk']); ?></td>	
	<td><?php echo $k['nm_lokasi']; ?></td>
	<td><?php echo $k['nm_unit_krj']; ?></td>
	<td><?php echo $k['nm_jabatan']; ?></td>
	<td><?php echo umur($msk); ?></td>
	<td><?php echo format_angka($k['gaji']); ?></td>
	<td align="center">
	<a  class="btn btn-xs btn-info" href="?module=sk_krj&aksi=edit&no_sk=<?php echo $k['no_sk'];?>" alt="Edit Data"><i class="glyphicon glyphicon-pencil"></i> Pilih</a>	
	</td>
	<?php
	}
	?>
	</tr>
			</tbody>
		</table>
	</div><!-- /.box-body -->
</div><!-- /.box -->
</section>
</div>

<div class="tab-pane" id="dat1">
<section id="new1">
<div class="box box-solid box-info">
		
	<div class="box-body">
	<table id="example1" class="table table-bordeblue table-striped">
<thead>
	<tr class="text-green">
		<th>No. SK</th>
		<th>NIP</th>
		<th>Nama Pegawai</th> 
		<th>Tgl. SK</th> 
		<th>Lokasi</th> 
		<th>Unit Kerja</th> 
		<th>Jabatan</th>
		<th>Gaji (Rp)</th>
		<th class="col-sm-1">AKSI</th> 	
	</tr>
</thead>

<tbody>
<?php 
// Tampilkan data dari Database
$sql = "SELECT * FROM sk_krj a, pegawai b, jabatan c, pangkat d, unit_krj e, lokasi_krj f where a.nip=b.nip and a.id_jabatan=c.id_jabatan and a.id_pangkat=d.id_pangkat and a.id_unit_krj=e.id_unit_krj and a.id_lokasi=f.id_lokasi and a.status_sk='nonaktif'";
$tampil = pg_query($sql);
$no=1;
while ($k = pg_fetch_array($tampil)) { 
$Kode = $k['no_sk'];?>

	<tr>	
	<td><?php echo $k['no_sk']; ?></a></td>
	<td><a target="blank"href="?module=pegawai&aksi=detail_pegawai&nip=<?php echo $k['nip'];?>"><?php echo $k['nip']; ?></a></td>
	<td><?php echo $k['nm_pegawai']; ?></td>
	<td><?php echo IndonesiaTgl($k['tgl_sk']); ?></td>	
	<td><?php echo $k['nm_lokasi']; ?></td>
	<td><?php echo $k['nm_unit_krj']; ?></td>
	<td><?php echo $k['nm_jabatan']."/".$k['nm_pangkat']; ?></td>
	<td><?php echo format_angka($k['gaji']); ?></td>
	<td align="center">	
	<a class="btn btn-xs btn-warning" href="<?php echo $aksi ?>?module=sk_krj&aksi=hapus&no_sk=<?php echo $k['no_sk'];?>"  alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA <?php echo $Kode; ?>	?')"> <i class="glyphicon glyphicon-trash"></i></a>
	</td>
	<?php
	}
	?>
	</tr>
			</tbody>
		</table>
	</div><!-- /.box-body -->
</div><!-- /.box -->
</section>
</div>

</div>
<?php 
break;


case "edit" :

?>
		<form class="form-horizontal" action="<?php echo $aksi?>?module=sk_krj&aksi=edit" role="form" method="post">             
		<div class="row">
		<div class="col-md-6">
		<div class="box box-solid box-info">
		<div class="box-header">
		<h3 class="btn btn disabled box-title">
		<i class="glyphicon glyphicon-briefcase"></i> SK Kerja Lama </h3>
			<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
			<i class="fa fa-minus"></i>
			</a></div>	
			<div class="box-body">
		<?php $d=pg_query("select * from sk_krj s, unit_krj u, lokasi_krj l, pangkat x, jabatan j where s.id_jabatan=j.id_jabatan and s.id_lokasi=l.id_lokasi and s.id_pangkat=x.id_pangkat and s.id_unit_krj=u.id_unit_krj and s.no_sk='$_GET[no_sk]' and s.status_sk='aktif'");
		$e=pg_fetch_array($d);
		?>
		<div class="form-group">
		    <label class="col-sm-4 control-label">NIP</label>
		    <div class="col-sm-7">
			  <input type="text" class="form-control" readonly name="nip" value="<?php echo $e['nip'];?>" >
		    </div>
		</div>

		<div class="form-group">
		    <label class="col-sm-4 control-label">Nama Pegawai</label>
		    <div class="col-sm-7">
			<?php 
			$s=pg_fetch_array(pg_query("select nm_pegawai from pegawai where nip='$e[nip]'"));
			?>
		      <input type="text" class="form-control" disabled value="<?php echo $s['nm_pegawai'];?>">
		    </div>
		</div>	
		<!--style="background:url(img/lol.gif);align:center;"-->
		  <hr />  
		<div class="form-group">
		    <label class="col-sm-4 control-label">Nomor SK</label>
		    <div class="col-sm-7">
		      <input type="text" class="form-control" readonly name="no_sk_lm" value="<?php echo $e['no_sk']; ?>">
		    </div></div> 	
		<div class="form-group">
		    <label class="col-sm-4 control-label">Tanggal SK</label>
		    <div class="col-sm-7">
		      <input type="text" class="form-control" disabled value="<?php echo IndonesiaTgl($e['tgl_sk']); ?>">
		    </div></div> 		
		<div class="form-group">
		    <label class="col-sm-4 control-label">Unit Kerja</label>
		    <div class="col-sm-7">
		      <input type="text" class="form-control" disabled value="<?php echo $e['nm_unit_krj']; ?>">
		    </div></div> 
		<div class="form-group">
		    <label class="col-sm-4 control-label">Jabatan / Gaji</label>
		    <div class="col-sm-7">
		      <input type="text" class="form-control" disabled value="<?php echo $e['nm_jabatan']."/".$e['gaji']; ?>">
		    </div></div>
		<div class="form-group">
		    <label class="col-sm-4 control-label">Lokasi Kerja</label>
		    <div class="col-sm-7">
		      <input type="text" class="form-control" disabled value="<?php echo $e['nm_lokasi']." (".$e['alamat_lokasi'].")"; ?>">
		    </div></div> </div></div>	 	
		</div>
		<div class="col-md-6">
		<div class="box box-solid box-info">
		<div class="box-header">
		<h3 class="btn btn disabled box-title">
		<i class="glyphicon glyphicon-briefcase"></i> SK Kerja Baru </h3>
			<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
			<i class="fa fa-minus"></i></a>
				</div>
		<?php
		  $hasil = pg_query("SELECT max(no_sk) as terakhir from sk_krj"); 
		  $data = pg_fetch_array($hasil);
		  $lastID = $data['terakhir']; $lastNoUrut = substr($lastID,13, 20); $nextNoUrut = $lastNoUrut + 1;
		  $nextID = "SK/ZT/".date('m/y')."/".sprintf("%05s",$nextNoUrut);
		?>
			<div class="box-body">
		<div class="form-group">
		    <label class="col-sm-4 control-label">Nomor SK Pegawai</label>
		    <div class="col-sm-7">
		      <input type="text" class="form-control" data-toggle="tooltip" title="Nomor SK Baru" value="<?php echo $nextID; ?>"required="required" name="no_sk">
		    </div></div>
		<div class="form-group">
		    <label class="col-sm-4 control-label">Tgl. SK</label>
		    <div>
			<div class="col-sm-7">
			  <div class="input-group">
			<div class="input-group-addon">
		            <i class="fa fa-calendar"> </i>
		    </div>
		      <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required="required" name="tgl_sk">
			</div></div></div></div>	
		    <div class="form-group">
		    <label class="col-sm-4 control-label">Unit Kerja</label>
		    <div class="col-sm-7">
		<select name="unit_krj" class="form-control">
		<option value=" "> -- Pilih Unit Kerja -- </option>
		<?php $q = pg_query ("select * from unit_krj");
		while ($k = pg_fetch_array($q)){ ?>
		<option value="<?php echo $k['id_unit_krj']; ?>" 
		<?php (@$h['unit_krj']==$k['unit_krj'])?print(" "):print(""); ?>	> <?php echo $k['id_unit_krj']; echo " / ".$k['nm_unit_krj']; ?>
		</option> <?php	} ?>
		</select>
		  </div></div>  
		  <div class="form-group">
		    <label class="col-sm-4 control-label">Jabatan</label>
		    <div class="col-sm-7">	
				<select name="jabatan" class="form-control">
				<option value=" "> -- Pilih Jabatan -- </option>
				<?php $q = pg_query ("select * from jabatan");
				while ($k = pg_fetch_array($q)){ ?>
				<option value="<?php echo $k['id_jabatan']; ?>" 
				<?php (@$h['jabatan']==$k['jabatan'])?print(" "):print(""); ?>	> <?php echo $k['id_jabatan']; echo " / ".$k['nm_jabatan']; ?>
				</option> <?php	} ?>
				</select>
		    </div>
		    </div>  

		  <div class="form-group">
		    <label class="col-sm-4 control-label">Pangkat</label>
		    <div class="col-sm-7">
			<select name="pangkat" class="form-control">
			<option value=" "> -- Pilih pangkat -- </option>
			<?php $q = pg_query ("select * from pangkat");
			while ($k = pg_fetch_array($q)){ ?>
			<option value="<?php echo $k['id_pangkat']; ?>" 
			<?php (@$h['pangkat']==$k['pangkat'])?print(" "):print(""); ?>	> <?php echo $k['nm_pangkat']." / Rp ".format_angka($k['gaji']); ?>
			</option> <?php	} ?>
			</select>
		  </div>
		  </div> 

		  <div class="form-group">
		    <label class="col-sm-4 control-label">Lokasi</label>
		    <div class="col-sm-7">
				<select name="lokasi" class="form-control">
					<option value=" "> -- Pilih lokasi -- </option>
					<?php $q = pg_query ("select * from lokasi_krj");
					while ($k = pg_fetch_array($q)){ ?>
					<option value="<?php echo $k['id_lokasi']; ?>" 
					<?php 
						(@$h['lokasi']==$k['lokasi'])?print(" "):print(""); ?>	> <?php echo $k['id_lokasi']; echo " / ".$k['nm_lokasi']; ?>
					</option> 
					<?php	} ?>
				</select>
		    </div>
		    </div>

		</div>
		</div>	
		<div class="form-group">
		    <label class="col-sm-4"></label>
		    <div class="col-sm-5">
			<hr/>
		      <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
				<a href="?module=cancel">
				<button class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Cancel</button></a>	
				    </div>
		</div>

		</div>

		</form>
	   </div>
	  </div>
	<?php
break;
}
?>

