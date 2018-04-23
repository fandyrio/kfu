<?php
if (empty($_SESSION['login_users'])){
	header('location:keluar');
}
else{
	switch($_GET['act']){
		default:
		?>
		
		<!-- Page Header-->
		<header class="page-header">
			<div class="container-fluid">
				<h2 class="no-margin-bottom">Profile Admin</h2>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
					<li class="breadcrumb-item active">Profile Admin</li>
				</ul>
			</div>
		</header>
	  
		
		<section class="tables">   
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-6">
						<div class="card">
							<div class="card-close">
								<div class="dropdown">
									<button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
									<div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow">
										<!--<a href="#" class="dropdown-item" id="btnTambah"> <i class="fa fa-plus"></i>Tambah</a>-->
									</div>
								</div>
							</div>
							<div class="card-header d-flex align-items-center">
								<h3 class="h4">Data</h3>
							</div>
							<div class="card-body">
								<table class="table table-sm">
									<tr><td width="150px">Nama Lengkap</td><td width="10px">:</td><td colspan="2"><?php echo $karyawan['nama'];?></td></tr>
									<tr><td>Username</td><td>:</td><td colspan="2"><?php echo $users['username'];?></td></tr>
									<tr><td>Tempat/Tanggal Lahir</td><td>:</td><td colspan="2"><?php $tanggal_lahir=DateToIndo($karyawan['tanggal_lahir']);echo "$karyawan[tempat_lahir] / $tanggal_lahir";?></td></tr>
									<tr><td>Telepon</td><td>:</td><td colspan="2"><?php echo $karyawan['telepon'];?></td></tr>
									<tr><td>Email</td><td>:</td><td colspan="2"><?php echo $karyawan['email'];?></td></tr>
									<tr><td>Foto</td><td>:</td><td width="100px"><img src="../images/pegawai/<?php echo $karyawan['foto'];?>" class="img-fluid"></td><td></td></tr>
								</table>
							</div>
						</div>
					</div>
					
					<div class="col-lg-6" id="form">
						<form method="POST" class="form-horizontal" action="aksi-edit-profile" enctype="multipart/form-data">
							<div class="card">
								<div class="card-header d-flex align-items-center">
									<h3 class="h4">Edit</h3>
								</div>
								<div class="card-body">
									
									<div class="form-group row">
										<label class="col-sm-3 control-label">Username</label>
										<div class="col-sm-6">
											<input type="text" name="username" class="form-control" value="<?php echo $users['username'];?>" required autofocus>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 control-label">Password</label>
										<div class="col-sm-9">
											<input type="password" name="password" class="form-control" value="">
											<input type="hidden" name="password2" class="form-control" value="<?php echo $users['password'];?>">
										</div>
									</div>
									
								</div>
								<div class="card-footer">
									<button type="submit" class="btn btn-success btn-flat btn-sm">SIMPAN</button>
									<button type="reset" class="btn btn-warning btn-flat btn-sm">RESET</button>
								</div>
							</div>
						</form>
					</div>
					
				</div>
			</div>
		</section>
	
<?php
		break;
	}
}
?>