<?php
$aksi="module/jabatan/jabatan_aksi.php";
switch($_GET[aksi]){
default:
	?>	
	<div class="row">

			<div class="col-md-6">
				<div class="box box-solid box-info">
					<div class="box-header">
					<h3 class="btn disabled box-title">
				
					Data </h3>	
					</div>		
				<div class="box-body">
				<table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr class="text-green">
							<th>No</th> 
							<th>Nama jabatan</th> 
							<th>AKSI</th> 	
						</tr>
					</thead>

			<tbody>
			<?php 
			// Tampilkan data dari Database
			$sql = "SELECT * FROM jabatan";
			$tampil = pg_query($sql);
			$no=1;
			while ($tampilkan = pg_fetch_array($tampil)) { 
			$Kode = $tampilkan['id_jabatan'];

			?>

				<tr>
				<td><?php echo $no++; ?></td> 
				<td><?php echo $tampilkan['nm_jabatan']; ?></td> 
				<td align="center">
				<a class="btn btn-xs btn-info" href="?module=jabatan&aksi=edit&id_jabatan=<?php echo $tampilkan['id_jabatan'];?>" alt="Edit Data"><i class="glyphicon glyphicon-pencil"></i></a>
				<a class="btn btn-xs btn-danger"href="<?php echo $aksi ?>?module=jabatan&aksi=hapus&id_jabatan=<?php echo $tampilkan['id_jabatan'];?>"  alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA <?php echo $Kode; ?>	?')"> <i class="glyphicon glyphicon-trash"></i></a>
				</td>
				<?php
				}
				?>
				</tr>
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
			</div>

		<div class="col-md-6">
			<div class="box box-solid box-info">
				<div class="box-header">
				<h3 class="btn btn disabled box-title">
	
				Tambah</h3>		 	
				</div>		
				<div class="box-body">
				<?php
					$sql ="SELECT max(id_jabatan) as terakhir from jabatan";
					  $hasil = pg_query($sql);
					  $data = pg_fetch_array($hasil);
					  $lastID = $data['terakhir'];
					  $lastNoUrut = substr($lastID, 3, 9);
					  $nextNoUrut = $lastNoUrut + 1;
					  $nextID = "JAB".sprintf("%03s",$nextNoUrut);
					?> 
					<form class="form-horizontal" action="<?php echo $aksi?>?module=jabatan&aksi=tambah" role="form" method="post">    <div class="box-body">      

					  <div class="form-group">
					    <label class="col-sm-2">ID Jabatan</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" required="required" name="id_jabatan" value="<?php echo  $nextID; ?>" >
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="col-sm-2">Nama Jabatan</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" required="required" name="nm_jabatan" placeholder="Nama Jabatan">
					    </div>
					  </div><div class="form-group">
					    <div class="col-sm-7">
					
					      	<button type="submit"name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
							<button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i><i> Reset</i></button> 
					    </div>
					  </div>
					  </div>
					</form>

			</div>
		</div>
	</div>
	</div>
	<?php	
break;

case "edit" :
	$data=pg_query("select * from jabatan where id_jabatan='$_GET[id_jabatan]'");
	$edit=pg_fetch_array($data);
	?>

	<h3 class="box-title margin text-center">Edit Data jabatan "<?php echo $_GET['id_jabatan']; ?>"</h3>
	<br/>
	<form class="form-horizontal" action="<?php echo $aksi?>?module=jabatan&aksi=edit" role="form" method="post">             

	  <div class="form-group">
	    <label class="col-sm-4 control-label">ID jabatan </label>
	    <div class="col-sm-5">
	      <input type="text" class="form-control" readonly name="id_jabatan" value="<?php echo $edit['id_jabatan']; ?>" >
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-4 control-label">Nama Jabatan</label>
	    <div class="col-sm-5">
	      <input type="text" class="form-control" required="required" name="nm_jabatan"value="<?php echo $edit['nm_jabatan']; ?>">
	    </div>
	  </div>
	  
	<div class="form-group">
	    <label class="col-sm-4"></label>
	    <div class="col-sm-5">
		<hr/>
	<button type="submit"name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
	<a href="?module=jabatan">
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