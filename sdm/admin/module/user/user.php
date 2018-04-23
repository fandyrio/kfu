<?php
$aksi="module/user/user_aksi.php";


switch($_GET[aksi]){
default:
?>

	<div class="box box-solid box-info">
		<div class="box-header">
		<h3 class="btn btn disabled box-title">
		Data User </h3>
		<a class="btn btn-default pull-right"href="?module=user&aksi=tambah">
		<i class="fa  fa-plus"></i> Tambah data</a>		
		</div>		
	<div class="box-body">
	<table id="example1" class="table table-bordered table-striped">
    <thead>
    	<tr class="text-green">
    		<th>ID user</th>
    		<th>Nama</th>
    		<th>Username</th>
    		<th>Level</th> 
    		<th>No Hp</th> 
    		<th>Status</th> 
    		<th>Blokir?</th> 
    	</tr>
    </thead>

      <tbody>
      <?php 
      // Tampilkan data dari Database
      $sql = "SELECT * FROM users";
      $tampil = pg_query($dbconn, $sql);
      while ($tampilkan = pg_fetch_assoc($tampil)) { 
      $Kode = $tampilkan['id_user'];
      $blokir = $tampilkan['blokir'];?>

      	<tr>
      	<td><?php echo $tampilkan['id_user']; ?></td>
      	<td><?php echo $tampilkan['nama']; ?></td>
      	<td><?php echo $tampilkan['username']; ?></td>
      	<td><?php echo $tampilkan['level']; ?></td>
      	<td><?php echo $tampilkan['no_hp']; ?></td>
      	<td><?php if  ( $blokir== 'Y' ) {
      				echo "<a class='btn btn-xs btn-warning' disabled >NonAktif</a>";}
      				else {echo "<a class='btn btn-xs btn-success' disabled>Aktif</a>"; }   ?></td>
      	<td align="center">
      	<?php if ( $blokir== 'N' ) { ?>
      	<a class="btn btn-xs btn-warning"  data-toggle="tooltip" title="Blokir User??" href="<?php echo $aksi ?>?module=user&aksi=yes&id_user=<?php echo $tampilkan['id_user']; ?>" onclick="return confirm('Apakah anda yakin ingin blokir <?php echo $tampilkan['user']; ?> ?')"><i class="glyphicon glyphicon-ok"></i></a>
      	<?php }
      	else { ?>
      	<a class="btn btn-xs btn-success" data-toggle="tooltip" title="UnBlokir User??" href="<?php echo $aksi ?>?module=user&aksi=no&id_user=<?php echo $tampilkan['id_user']; ?>" onclick="return confirm('Apakah anda yakin UnBlokir <?php echo $tampilkan['user']; ?>?')"><i class="glyphicon glyphicon-remove"></i></a>
      	<?php } ?>
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
    $sql ="SELECT max(id_user) as terakhir from users";
      $hasil = pg_query($sql);
      $data = pg_fetch_array($hasil);
      $lastID = $data['terakhir'];
      $lastNoUrut = substr($lastID, 3, 9);
      $nextNoUrut = $lastNoUrut + 1;
      $nextID = "USR".sprintf("%03s",$nextNoUrut);
    ?>
<div class="box box-solid box-info">
  <div class="box-header">
      <h3 class="btn btn disabled box-title">
      <i class="fa  faplus"></i>
      Tambah  </h3>
    
    </div> 
    <br>     
    <div class="box-body"> 
    <form class="form-horizontal" action="<?php echo $aksi?>?module=user&aksi=tambah" role="form" method="post"> 

           <div class="box-body"> 
      <div class="form-group">
        <label class="col-sm-2">ID user </label>
        <div class="col-sm-5">
          <input type="text" class="form-control" required="required" name="id_user" value="<?php echo  $nextID; ?>" >
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2">Nama</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" required="required" name="nama" placeholder="Nama user">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2">Nomor HP</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" required="required" name="no_hp" value="+62">
        </div>
      </div>
    	<div class="form-group">
        <label class="col-sm-2">Level </label>
        <div class="col-sm-5">
            <select name="level" class="form-control">
              <option value=" "> -- Pilih Level -- </option>
              <option value="admin">Admin</option>
              <option value="hrd">HRD</option>
              <option value="gm">Pimpinan</option>
            </select>
        </div>
      </div>
    <hr/>
    <div class="form-group">
        <label class="col-sm-2">Username</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" required="required" name="user" placeholder="username">
        </div>
      </div>  
      <div class="form-group">
        <label class="col-sm-2">Password</label>
        <div class="col-sm-5">
          <input type="password" class="form-control" required="required" name="pass" minlength="5"value="12345">
        </div>
      </div>  
      <div class="form-group">
        <label class="col-sm-2">  </label>
        <div class="col-sm-5">
          <button type="submit"name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
          <button type="reset" class="btn btn-danger"><i class="glyphicon glyphicon-floppy-disk"></i><i>Reset</i></button>
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
