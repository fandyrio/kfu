<?php
$aksi="module/unit_krj/unit_krj_aksi.php";


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

		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr class="text-green">
					<th>No</th> 
					<th>Nama Unit Kerja</th> 
					<th>AKSI</th> 	
				</tr>
			</thead>

					<tbody>
					<?php 
					// Tampilkan data dari Database
					$sql = "SELECT * FROM unit_krj";
					$tampil = pg_query($sql);
					$no=1;
					while ($tampilkan = pg_fetch_array($tampil)) { 
					$Kode = $tampilkan['id_unit_krj'];

					?>

						<tr>
						<td><?php echo $no++; ?></td> 
						<td><?php echo $tampilkan['nm_unit_krj']; ?></td> 
						<td align="center">
						<a class="btn btn-xs btn-info" href="?module=unit_krj&aksi=edit&id_unit_krj=<?php echo $tampilkan['id_unit_krj'];?>" alt="Edit Data"><i class="glyphicon glyphicon-pencil"></i></a>
						<a class="btn btn-xs btn-danger" href="<?php echo $aksi ?>?module=unit_krj&aksi=hapus&id_unit_krj=<?php echo $tampilkan['id_unit_krj'];?>"  alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA <?php echo $Kode; ?>	?')"> <i class="glyphicon glyphicon-trash"></i></a>
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
		$sql ="SELECT max(id_unit_krj) as terakhir from unit_krj";
	  	$hasil = pg_query($sql);
	  	$data = pg_fetch_array($hasil);
	  	$lastID = $data['terakhir'];
	  	$lastNoUrut = substr($lastID, 3, 9);
	  	$nextNoUrut = $lastNoUrut + 1;
	  	$nextID = "UKJ".sprintf("%03s",$nextNoUrut);
	?> 

	 <form class="form-horizontal" action="<?php echo $aksi?>?module=unit_krj&aksi=tambah" role="form" method="post">             
		  <div class="form-group">
		    <label class="col-sm-4 control-label">ID Unit Kerja</label>
		    <div class="col-sm-7">
		      <input type="text" class="form-control" required="required" name="id_unit_krj" value="<?php echo  $nextID; ?>" >
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-4 control-label">Nama Unit Kerja</label>
		    <div class="col-sm-7">
		      <input type="text" class="form-control" required="required" name="nm_unit_krj" placeholder="Nama Unit Kerja">
		    </div>
		  </div><div class="form-group">
		    <label class="col-sm-4"></label>
		    <div class="col-sm-7">
			<hr/>
		      	<button type="submit" name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
				<button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i><i> Reset</i></button> 
		    </div>
		  </div>
		</form>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>

	</div>
<?php	
break;


case "edit" :
	$data=pg_query("select * from unit_krj where id_unit_krj='$_GET[id_unit_krj]'");
	$edit=pg_fetch_array($data);
	?>


	<form class="form-horizontal" action="<?php echo $aksi?>?module=unit_krj&aksi=edit" role="form" method="post">             

	  <div class="form-group">
	    <label class="col-sm-4 control-label">ID Unit Kerja </label>
	    <div class="col-sm-5">
	      <input type="text" class="form-control" readonly name="id_unit_krj" value="<?php echo $edit['id_unit_krj']; ?>" >
	    </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-4 control-label">Nama Unit Kerja</label>
	    <div class="col-sm-5">
	      <input type="text" class="form-control" required="required" name="nm_unit_krj"value="<?php echo $edit['nm_unit_krj']; ?>">
	    </div>
	  </div>
	  
		<div class="form-group">
		    <label class="col-sm-4"></label>
		    <div class="col-sm-5">
			<hr/>
			<button type="submit"name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
			<a href="?module=unit_krj">
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
