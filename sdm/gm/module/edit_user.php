<?php 
if($_SESSION['level']!="gm" ){ header("location: ../logout.php"); }
if (isset($_POST['submit'])){
if ((!empty($_POST['nama']))) {
$sql = "UPDATE user SET nama= '".$_POST['nama']."', user = '".$_POST['user']."', 
		pass = '".$_POST['pass']."', no_hp= '".$_POST['no_hp']."' WHERE id_user = '".$_SESSION['id']."'";
$simpan = pg_query($sql);

if ($simpan) {
echo "<script>alert('Data Berhasil di Update');</script>";
} else { 
echo "<script>alert('Gagal Di Update');</script>";
}
}
}


$data=pg_query("select * from user where id_user='$_GET[id_user]'");
$edit=pg_fetch_array($data);
?>

<h3 class="box-title margin text-center">Edit Profil</h3>
<center> <div class="batas"> </div></center>
<br/>
<form class="form-horizontal" role="form" method="post">             
  <div class="form-group">
    <label class="col-sm-4 control-label">ID user </label>
    <div class="col-sm-5">
      <input type="text" class="form-control" readonly name="id_user" value="<?php echo $edit['id_user']; ?>" >
    </div>
  </div> 
  <div class="form-group">
    <label class="col-sm-4 control-label">Nama Lengkap</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" required="required" name="nama" value="<?php echo $edit['nama']; ?>">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-4 control-label">Nomor HP</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" required="required" name="no_hp" value="<?php echo $edit['no_hp']; ?>">
    </div>
  </div>
	<div class="form-group">
    <label class="col-sm-4 control-label">Level </label>
    <div class="col-sm-5">
     <input type="text" class="form-control" readonly value="<?php echo $edit['level']; ?>">
    </div>
  </div>
<hr/>
<div class="form-group">
    <label class="col-sm-4 control-label">Username</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" required="required" name="user" value="<?php echo $edit['user']; ?>">
    </div>
  </div>  
  <div class="form-group">
    <label class="col-sm-4 control-label">Password</label>
    <div class="col-sm-5">
      <input type="password" id="password1"class="form-control" required="required" name="pass" value="<?php echo $edit['pass']; ?>">
	  <a class="text-red">*ubah password secara berkala demi menjaga keamanan</a>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-4 control-label">Konfirmasi Password</label>
    <div class="col-sm-5">
      <input type="password" id="password2"class="form-control" required="required">	  
    </div>
  </div>
  
  <script type="text/javascript">
    window.onload = function () {
    document.getElementById("password1").onchange = validatePassword;
    document.getElementById("password2").onchange = validatePassword;
    }
    function validatePassword(){
    var pass2=document.getElementById("password2").value;
    var pass1=document.getElementById("password1").value;
    if(pass1!=pass2)
    document.getElementById("password2").setCustomValidity("Passwords Tidak Sama");
    else
    document.getElementById("password2").setCustomValidity('');}
  </script>

	<div class="form-group">
    <label class="col-sm-4 control-label">  </label>
    <div class="col-sm-5">
<button type="submit"name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
<a href="javascript:history.back()" class="btn btn-info pull-right"><i class="fa fa-backward"></i> Kembali</a>	 
    </div>
  </div>   

</form>
