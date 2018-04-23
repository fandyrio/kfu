<?php
$aksi="module/lokasi/lokasi_aksi.php";


switch($_GET[aksi]){
default:
?>		

	<div class="box box-solid box-info">
		<div class="box-header">
		<h3 class="btn btn disabled box-title">
		Data </h3>
		<a class="btn btn-default pull-right"href="?module=lokasi&aksi=tambah">
		<i class="fa  fa-plus"></i> Tambah Data</a>		
		</div>		
	<div class="box-body">
	<table id="example1" class="table table-bordered table-striped">
  <thead>
  	<tr class="text-green">
  		<th>No</th>		
  		<th>Nama Lokasi</th>
  		<th>Alamat</th> 
  		<th>No. Hp</th> 
  		<th>Aksi</th> 
  	</tr>
  </thead>

    <tbody>
    <?php 
    // Tampilkan data dari Database
    $sql = "SELECT * FROM lokasi_krj";
    $tampil = pg_query($sql);
    $no=1;
    while ($tampilkan = pg_fetch_array($tampil)) { 

    $Kode = $tampilkan['id_lokasi'];
    ?>

    	<tr>
    	<td><?php echo $no++; ?></td>	
    	<td><?php echo $tampilkan['nm_lokasi']; ?></td>
    	<td><?php echo $tampilkan['alamat_lokasi']; ?></td>
    	<td><?php echo $tampilkan['no_hp']; ?></td>
    	<td align="center">
    	<a class="btn btn-xs btn-info" href="?module=lokasi&aksi=edit&id_lokasi=<?php echo $tampilkan['id_lokasi'];?>" alt="Edit Data"><i class="glyphicon glyphicon-pencil"></i></a>
    	<a class="btn btn-xs btn-danger"href="<?php echo $aksi ?>?module=lokasi&aksi=hapus&id_lokasi=<?php echo $tampilkan['id_lokasi'];?>"  alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA <?php echo $Kode; ?>	?')"> <i class="glyphicon glyphicon-trash"></i></a>
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
  //ID
  $sql ="SELECT max(id_lokasi) as terakhir from lokasi_krj";
    $hasil = pg_query($sql);
    $data = pg_fetch_array($hasil);
    $lastID = $data['terakhir'];
    $lastNoUrut = substr($lastID, 3, 9);
    $nextNoUrut = $lastNoUrut + 1;
    $nextID = "LOK".sprintf("%03s",$nextNoUrut);
  ?>

  <form class="form-horizontal" action="<?php echo $aksi?>?module=lokasi&aksi=tambah" role="form" method="post">             
    <div class="form-group">
      <label class="col-sm-4 control-label">ID lokasi </label>
      <div class="col-sm-5">
        <input type="text" class="form-control" required="required" name="id_lokasi" value="<?php echo  $nextID; ?>" >
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Nama Lokasi</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" required="required" name="nm_lokasi" placeholder="Nama lokasi">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Nomor HP</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" required="required" name="no_hp" value="+62">
      </div>
    </div>
  <div class="form-group">
      <label class="col-sm-4 control-label">alamat</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" required="required" name="alamat" placeholder="Alamat">
      </div>
    </div>  
    <div class="form-group">
      <label class="col-sm-4 control-label">  </label>
      <div class="col-sm-5">
  <button type="submit"name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
  <button type="reset" class="btn btn-danger"><i class="glyphicon glyphicon-floppy-disk"></i><i> Reset</i></button>
      </div>
    </div> 
  </form> 
  <?php	
break;
case "edit" :
  $data=pg_query("select * from lokasi_krj where id_lokasi='$_GET[id_lokasi]'");
  $edit=pg_fetch_array($data);
  ?>
  <form class="form-horizontal" action="<?php echo $aksi?>?module=lokasi&aksi=edit" role="form" method="post">             

    <div class="form-group">
      <label class="col-sm-4 control-label">ID lokasi </label>
      <div class="col-sm-5">
        <input type="text" class="form-control" readonly name="id_lokasi" value="<?php echo $edit['id_lokasi']; ?>" >
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Nama lokasi</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" required="required" name="nm_lokasi"value="<?php echo $edit['nm_lokasi']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Nomor Hp</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" required="required" name="no_hp"value="<?php echo $edit['no_hp']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Alamat</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" required="required" name="alamat"value="<?php echo $edit['alamat_lokasi']; ?>">
      </div>
    </div>
    
  <div class="form-group">
      <label class="col-sm-4"></label>
      <div class="col-sm-5">
  	<hr/>
  <button type="submit"name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
  <a href="?module=lokasi">
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