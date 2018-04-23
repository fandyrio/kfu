<?php
$aksi="module/pangkat/pangkat_aksi.php";


switch($_GET[aksi]){
default:
?>		
<div class="row">


  <div class="col-md-6">
      	<div class="box box-solid box-info">
      		<div class="box-header">
      		<h3 class="btn disabled box-title">
      		Data Master pangkat</h3>	
      		</div>		
      	<div class="box-body">
      	<table id="example1" class="table table-bordered table-striped">
      <thead>
      	<tr class="text-green">
      		<th>No</th> 
      		<th>Pangkat</th> 
      		<th>Gaji</th> 
      		<th>#</th> 	
      	</tr>
      </thead>

      <tbody>
      <?php 
      // Tampilkan data dari Database
      $sql = "SELECT * FROM pangkat";
      $tampil = pg_query($sql);
      $no=1;
      while ($tampilkan = pg_fetch_array($tampil)) { 
      $Kode = $tampilkan['id_pangkat'];

      ?>

      	<tr>
      	<td><?php echo $no++; ?></td> 
      	<td><?php echo $tampilkan['nm_pangkat']; ?></td> 
      	<td>Rp. <?php echo format_angka($tampilkan['gaji']) ; ?></td> 
      	<td align="center">
      	<a class="btn btn-xs btn-info" href="?module=pangkat&aksi=edit&id_pangkat=<?php echo $tampilkan['id_pangkat'];?>" alt="Edit Data"><i class="glyphicon glyphicon-pencil"></i></a>
      	<a class="btn btn-xs btn-danger"href="<?php echo $aksi ?>?module=pangkat&aksi=hapus&id_pangkat=<?php echo $tampilkan['id_pangkat'];?>"  alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA <?php echo $Kode; ?>	?')"> <i class="glyphicon glyphicon-trash"></i></a>
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
   
    Tambah Data pangkat</h3>      
    </div>    
      <div class="box-body">
      <?php
        $sql ="SELECT max(id_pangkat) as terakhir from pangkat";
          $hasil = pg_query($sql);
          $data = pg_fetch_array($hasil);
          $lastID = $data['terakhir'];
          $lastNoUrut = substr($lastID, 3, 9);
          $nextNoUrut = $lastNoUrut + 1;
          $nextID = "PKT".sprintf("%03s",$nextNoUrut);
    ?> 
   <form class="form-horizontal" action="<?php echo $aksi?>?module=pangkat&aksi=tambah" role="form" method="post">             
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-2">ID pangkat</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" required="required" name="id_pangkat" value="<?php echo  $nextID; ?>" >
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2">Nama Pangkat</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" required="required" name="nm_pangkat" placeholder="Nama pangkat">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2">Gaji</label>
        <div class="col-sm-7">
          <input type="number" class="form-control" required="required" name="gaji" placeholder="Gaji">
        </div>
      </div><div class="form-group">
        <div class="col-sm-7">
      
          <button type="submit"name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
          <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i><i>Reset</i></button> 
        </div>
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
$data=pg_query("select * from pangkat where id_pangkat='$_GET[id_pangkat]'");
$edit=pg_fetch_array($data);
?>

<h3 class="box-title margin text-center">Edit Data pangkat "<?php echo $_GET['id_pangkat']; ?>"</h3>
<br/>
<form class="form-horizontal" action="<?php echo $aksi?>?module=pangkat&aksi=edit" role="form" method="post">             

  <div class="form-group">
    <label class="col-sm-4 control-label">ID Pangkat </label>
    <div class="col-sm-5">
      <input type="text" class="form-control" readonly name="id_pangkat" value="<?php echo $edit['id_pangkat']; ?>" >
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-4 control-label">Pangkat</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" required="required" name="nm_pangkat"value="<?php echo $edit['nm_pangkat']; ?>">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-4 control-label">Gaji</label>
    <div class="col-sm-5">
      <input type="number" class="form-control" required="required" name="gaji"value="<?php echo $edit['gaji']; ?>">
    </div>
  </div>
  
<div class="form-group">
    <label class="col-sm-4"></label>
    <div class="col-sm-5">
	<hr/>
<button type="submit"name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
<a href="?module=pangkat">
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
