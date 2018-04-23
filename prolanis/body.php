<?php
$d=pg_fetch_array(pg_query($dbconn,"SELECT a.tanggal_login, a.jam_login, b.nama FROM auth_users a, master_karyawan b WHERE a.id_karyawan=b.id AND a.id_users='$_SESSION[pro_user]'"));
?>
<div class="content-wrapper">


    <!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="alert alert-info">
					<strong>Hi, <?php echo $d['nama'];?> .</strong>
					Waktu Login Anda : 
					<?php 
						$tanggal=DateToIndo($d['tanggal_login']);
						$jam=$d['jam_login'];
						echo "$tanggal $jam";
					?>
					
				</div>
		

			</div>
		</div>
    </section>
    <!-- /.content -->
</div>
