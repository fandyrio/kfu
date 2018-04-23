<?php
$aksi="module/hukuman/hukuman_aksi.php";


switch($_GET[aksi]){
default:
?>	
	<div class="box box-solid box-info">
		<div class="box-header">
			<h3 class="btn btn disabled box-title">
			<i class="glyphicon glyphicon-thumbs-down"></i>
			Data Hukuman Pegawai </h3>
			<a class="btn btn-default pull-right" href="?module=hukuman&aksi=list_pegawai">
			<i class="fa  fa-plus"></i> Tambah Data Hukuman</a>	
		</div>		
	<div class="box-body">
	<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr class="text-green">
					<th>No. hukuman</th>
					<th>NIP</th>
					<th>Nama Pegawai</th> 
					<th>Tanggal</th> 
					<th>Nama hukuman</th> 
					<th>AKSI</th> 	
				</tr>
			</thead>

			<tbody>
			<?php 
			// Tampilkan data dari Database
			$sql = "SELECT * FROM hukuman a, pegawai b where a.nip=b.nip ";
			$tampil = pg_query($sql);
			$no=1;
			while ($k = pg_fetch_array($tampil)) { 
			$Kode = $k['id_hukuman'];?>

				<tr>	
				<td><?php echo $k['id_hukuman']; ?></a></td>
					<td><a target="blank"href="?module=pegawai&aksi=detail_pegawai&nip=<?php echo $k['nip'];?>"><?php echo $k['nip']; ?></a></td>
					<td><?php echo $k['nm_pegawai']; ?></td>
					<td><?php echo Indonesia2Tgl($k['tgl_hukuman']); ?></td>
					<td><?php echo $k['nm_hukuman']; ?></td>
					<td align="center">
					<a  class="btn btn-xs btn-info" href="?module=hukuman&aksi=edit&id_hukuman=<?php echo $k['id_hukuman'];?>" alt="Edit Data"><i class="glyphicon glyphicon-pencil"></i></a>
					<a class="btn btn-xs btn-warning" href="<?php echo $aksi ?>?module=hukuman&aksi=hapus&id_hukuman=<?php echo $k['id_hukuman'];?>"  alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA <?php echo $Kode; ?>	?')"> <i class="glyphicon glyphicon-trash"></i></a>
					</td>
					<?php
					}
					?>
				</tr>
			</tbody>
		</table>
	</div><!-- /.box-body -->
</div><!-- /.box -->

<?php 
break;
case "list_pegawai": 
?>


	<div class="box box-solid box-info">
	<div class="box-header">
			<h3 class="btn btn disabled box-title">
			<i class="glyphicon glyphicon-thumbs-down"></i>
			List Pegawai </h3>
			
		</div>
		
	<div class="box-body">
	<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr class="text-green">
						<th>NIP</th>
						<th>Nama pegawai</th>
						<th>Kelamin</th> 
						<th>UnitKerja</th> 
						<th>Jabatan/Pangkat</th> 
						<th>Lokasi_Kerja</th> 
						<th>Alamat</th>
						<th>AKSI</th> 	
					</tr>
				</thead>

				<tbody>
				<?php 
				// Tampilkan data dari Database
				$sql = "select * from pegawai z, sk_krj s, unit_krj u, lokasi_krj l, pangkat x, jabatan j where s.id_jabatan=j.id_jabatan and s.id_lokasi=l.id_lokasi and s.id_pangkat=x.id_pangkat and s.id_unit_krj=u.id_unit_krj and z.nip=s.nip and s.status_sk='aktif'";
				$tampil = pg_query($sql);
				$no=1;
				while ($data = pg_fetch_array($tampil)) { 
				$Kode = $data['nip'];?>

					<tr>
					<td><a href="?module=pegawai&aksi=detail_pegawai&nip=<?php echo $data['nip'];?>"><?php echo $data['nip']; ?></a></td>
					<td><?php echo $data['nm_pegawai']; ?></td>
					<td><?php echo $data['jk']; ?></td>
					<td><?php echo $data['nm_unit_krj']; ?></td>
					<td><?php echo $data['nm_jabatan']; echo " / ".$data['nm_pangkat'];  ?></td>
					<td><?php echo $data['nm_lokasi']; ?></td>
					<td><?php echo $data['alamat']; ?></td>
					<td align="center">
					<a class="btn btn-xs btn-danger" href="?module=hukuman&aksi=tambah&nip=<?php echo $data['nip'];?>"    onclick="return confirm('Pilih Pegawai? <?php echo $data['nip']; ?>?')"> <i class="fa fa-book"></i> Pilih?</a>
					</td>
					<?php
					}
					?>
					</tr>
			</tbody>
		</table>
	</div><!-- /.box-body -->
</div><!-- /.box -->
<?php 
break;
case "tambah": 
?>
<?php
  $hasil = pg_query("SELECT max(id_hukuman) as terakhir from hukuman"); $data = pg_fetch_array($hasil);
  $lastID = $data['terakhir']; $lastNoUrut = substr($lastID,13, 20); $nextNoUrut = $lastNoUrut + 1;
  $nextID = "HKM/ZT/".date('m/y')."/".sprintf("%04s",$nextNoUrut);
?>
	<div class="box box-solid box-info">
		<div class="box-header">
			<h3 class="btn btn disabled box-title">
			<i class="glyphicon glyphicon-thumbs-down"></i>
			Data Hukuman Pegawai </h3>
			<a class="btn btn-default pull-right" href="?module=hukuman&aksi=list_pegawai">
			<i class="fa  fa-plus"></i> Tambah Data Hukuman</a>	
		</div>		
	<div class="box-body">
	<form class="form-horizontal" action="<?php echo $aksi?>?module=hukuman&aksi=tambah" role="form" method="post">             
	  <div class="form-group">
	    <label class="col-sm-4 control-label">No. Hukuman / Tanggal</label>
	    <div class="col-sm-3">
	      <input type="text" class="form-control" required="required" name="id_hukuman" value="<?php echo $nextID;?>">
	    </div>
		<div class="col-sm-2">
		  <div class="input-group">
		<div class="input-group-addon">
	       <i class="fa fa-calendar"> </i>
	    </div>
	      <input type="date" class="form-control" required="required" value="<?php echo date("Y-m-d"); ?>" name="tgl_hukuman">
		</div><!-- /.input group -->
		</div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-4 control-label">NIP</label>
	    <div class="col-sm-5">
	      <input type="hidden" class="form-control" name="nip" value="<?php echo $_GET['nip'];?>" >
		  <input type="text" class="form-control" required="required" disabled value="<?php echo $_GET['nip'];?>" >
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-4 control-label">Nama Pegawai</label>
	    <div class="col-sm-5">
		<?php 
		$s=pg_fetch_array(pg_query("select nm_pegawai from pegawai where nip='$_GET[nip]'"));
		?>
	      <input type="text" class="form-control" disabled value="<?php echo $s['nm_pegawai'];?>">
	    </div>
	  </div> 
	  <div class="form-group">
	    <label class="col-sm-4 control-label">hukuman</label>
	    <div class="col-sm-5">
	      <input type="text" class="form-control" required="required" name="nm_hukuman" placeholder="Nama hukuman">
	    </div>
	  </div>     

	  <div class="form-group">
	    <label class="col-sm-4"></label>
	    <div class="col-sm-5">
		<hr/>
	      <button type="submit"name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
	<button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i><i>Reset</i></button>
	<a href="javascript:history.back()" class="btn btn-info pull-right"><i class="fa fa-backward"></i> Kembali</a>			 
	    </div>
	  </div> 
	</form>
	</div>
	</div> 
	<?php	
break;
case "edit" :

	$data=pg_query("select * from hukuman where id_hukuman='$_GET[id_hukuman]'");
	$edit=pg_fetch_array($data);

	?>
	<h3 class="box-title margin text-center">Edit Data hukuman "<?php echo $_GET['id_hukuman']; ?>"</h3>
	<hr/>
		 	
	<form class="form-horizontal" action="<?php echo $aksi?>?module=hukuman&aksi=edit" role="form" method="post">             

	 <div class="form-group">
	    <label class="col-sm-4 control-label">No. hukuman / Tanggal</label>
	    <div class="col-sm-3">
	      <input type="text" class="form-control" readonly  name="id_hukuman" value="<?php echo $edit['id_hukuman'];?>">	  
	    </div>
		<div class="col-sm-2">
		  <div class="input-group">
		<div class="input-group-addon">
	       <i class="fa fa-calendar"> </i>
	    </div>
	      <input type="date" class="form-control" required="required" value="<?php echo $edit['tgl_hukuman'];?>" name="tgl_hukuman">
		</div><!-- /.input group -->
		</div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-4 control-label">NIP</label>
	    <div class="col-sm-5">
		  <input type="text" class="form-control" required="required" disabled value="<?php echo $edit['nip'];?>" >
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-4 control-label">Nama Pegawai</label>
	    <div class="col-sm-5">
		<?php 
		$s=pg_fetch_array(mysql_query("select nm_pegawai from pegawai where nip='$edit[nip]'"));
		?>
	      <input type="text" class="form-control" disabled value="<?php echo $s['nm_pegawai'];?>">
	    </div>
	  </div> 
	  <div class="form-group">
	    <label class="col-sm-4 control-label">Hukuman</label>
	    <div class="col-sm-5">
	      <input type="text" class="form-control" required="required" name="nm_hukuman" value="<?php echo $edit['nm_hukuman'];?>" >
	    </div>
	  </div>  
	<div class="form-group">
	    <label class="col-sm-4"></label>
	    <div class="col-sm-5">
		<hr/>
	      <button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
	<a href="?module=cancel">
	<button class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Batal</button></a>	
	 
	    </div>
	  </div>   
	</form>
	</div>
	</div>
	<?php
break;
}
?>

