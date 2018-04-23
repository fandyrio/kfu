<?php
session_start();
$id_users =$_SESSION['login_user'];
switch($_GET['act'])
{
	case "baru":

		$id_unit= $_SESSION['id_units'];
		$id_perusahaan= $_POST['id_perusahaan'];
	    $nama = $_POST['nama'];		        
	    $harga = $_POST['harga'];	
	    
	    $harga_nett = $_POST['harga_nett'];	
	    $opsi_persen = $_POST['opsi_persen'];
	    if($opsi_persen=='Y'){
	    	$disc=$_POST['diskon'];
	    	if(!$disc){
	    		$disc=0;
	    	}	
	    	$disc_type='disc_persen';	
	    }
	    else{
	    	$disc=$_POST['diskon'];	
	    	$disc_type='disc_amount';
	    }
	    if($id_unit>1){
	    	$nasional = 'N';
	    }

	$res=pg_query($dbconn,"INSERT INTO billing_paket (nama_paket,  created_unit, $disc_type, harga_gross, harga_net, waktu_input,id_perusahaan, keterangan, id_users) 	
			VALUES(	'".$nama."', '$id_unit', '$disc',  '$harga', '$harga_nett' , '$tgl_sekarang $jam_sekarang',$id_perusahaan, '$_POST[keterangan]', '$id_users' ) RETURNING id ");
	var_dump("INSERT INTO billing_paket (nama_paket,  created_unit, $disc_type, harga_gross, harga_net, waktu_input,id_perusahaan) 	
			VALUES(	'".$nama."', '$id_unit', '$disc',  '$harga', '$harga_nett' , '$tgl_sekarang $jam_sekarang',$id_perusahaan ) RETURNING id ");
	
		$row = pg_fetch_row($res);

	pg_query($dbconn,"UPDATE billing_paket_detail set id_billing_paket='$row[0]', id_users=NULL WHERE id_users='$id_users' ");
	$log = pg_query("INSERT INTO billing_paket_penawaran_log (id_billing_paket, id_status_penawaran, waktu_input, id_users, id_perusahaan, dilihat, created_by) 
		VALUES('$row[0]', '1', '$tgl_sekarang $jam_sekarang', '$id_users', '$id_perusahaan', 'N', 'S') ");
			

	
		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			document.location.href = "mcu-penawaran";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			
			?>
			<script>
				
				
			</script>
			<?php
	    }
	break;

	case "edit":
	$id_unit= $_SESSION['id_units'];
	$id_paket = $_POST['id'];
	$nama = $_POST['nama'];
	$id_perusahaan = $_POST['perusahaan'];
	$tgl = DateToEng($_POST['tgl']);	
	$created_unit = $_POST['created_unit'];
	$harga = $_POST['harga'];		    
	$harga_nett = $_POST['harga_nett'];	

	 $opsi_persen = $_POST['opsi_persen'];
	    if($opsi_persen=='Y'){
	    	$disc=$_POST['diskon'];
	    	if(!$disc){
	    		$disc=0;
	    	}	
	    	$disc_type='disc_persen';	
	    }
	    else{
	    	$disc=$_POST['diskon'];	
	    	$disc_type='disc_amount';
	    }
	
		$result=pg_query($dbconn,"UPDATE billing_paket SET 
		nama_paket='".$nama."', harga_gross='$harga', harga_net='$harga_nett', keterangan='$_POST[keterangan]', $disc_type='$disc', id_users='$id_users' WHERE id = $id_paket");

		
		pg_query($dbconn,"UPDATE billing_paket_detail set id_billing_paket='$id_paket', id_users=NULL WHERE id_users='$id_users'");

		/*$log = pg_query("INSERT INTO billing_paket_penawaran_log (id_billing_paket, id_status_penawaran, waktu_input) 
		VALUES('$id_paket', '3', '$tgl_sekarang $jam_sekarang') ");*/
	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "mcu-penawaran";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "mcu-penawaran";
			
		</script>
		<?php
	}

	

	break;

	case "revisi":
	$id_unit= $_SESSION['id_units'];
	$id_paket = $_POST['id'];
	$nama = $_POST['nama'];
	$id_perusahaan = $_POST['perusahaan'];
	$tgl = DateToEng($_POST['tgl']);	
	$created_unit = $_POST['created_unit'];
	$harga = $_POST['harga'];		    
	$harga_nett = $_POST['harga_nett'];	

	 $opsi_persen = $_POST['opsi_persen'];
	    if($opsi_persen=='Y'){
	    	$disc=$_POST['diskon'];
	    	if(!$disc){
	    		$disc=0;
	    	}	
	    	$disc_type='disc_persen';	
	    }
	    else{
	    	$disc=$_POST['diskon'];	
	    	$disc_type='disc_amount';
	    }
	
		$result=pg_query($dbconn,"UPDATE billing_paket SET 
		nama_paket='".$nama."', harga_gross='$harga', harga_net='$harga_nett', keterangan='$_POST[keterangan]', $disc_type='$disc', id_users='$id_users' WHERE id = $id_paket");

		
		pg_query($dbconn,"UPDATE billing_paket_detail set id_billing_paket='$id_paket', id_users=NULL WHERE id_users='$id_users'");

		$log = pg_query("INSERT INTO billing_paket_penawaran_log (id_billing_paket, id_status_penawaran, waktu_input, id_users , dilihat, created_by) 
		VALUES('$id_paket', '3', '$tgl_sekarang $jam_sekarang', '$id_users', 'N', 'S') ");
	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "mcu-penawaran";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "mcu-penawaran";
			
		</script>
		<?php
	}

	break;

	case "lab":
	$id= $_POST['id'];
	$harga = $_POST['harga'];	

	$cek ="SELECT id from billing_paket_detail WHERE id_users='$id_users' AND id_detail='$id' AND jenis='L' ";
	var_dump($cek);	
	$result = pg_query($dbconn, $cek);

			$rows = pg_num_rows($result);
			if($rows < 1)
            {
            	$sql =pg_query($dbconn, "INSERT INTO billing_paket_detail (jenis, id_detail, harga, id_users ) 
                         VALUES ('L', $id, '$harga', '$id_users')");

            }
	break;

	case "group":
	$id= $_POST['id'];
	$harga = $_POST['harga'];	

	$cek ="SELECT id from billing_paket_detail WHERE id_users='$id_users' AND id_detail='$id' AND jenis='G' ";
	var_dump($cek);	
	$result = pg_query($dbconn, $cek);

			$rows = pg_num_rows($result);
			if($rows < 1)
            {
            	$sql =pg_query($dbconn, "INSERT INTO billing_paket_detail (jenis, id_detail, harga, id_users ) 
                         VALUES ('LG', $id, '$harga', '$id_users')");

            }
	break;

	case "tindakan":
	$id= $_POST['id'];
	$harga = $_POST['harga'];	

	$cek ="SELECT id from billing_paket_detail WHERE id_users='$id_users' AND id_detail='$id' AND jenis='T' ";
	var_dump($cek);	
	$result = pg_query($dbconn, $cek);

			$rows = pg_num_rows($result);
			if($rows < 1)
            {
            	$sql =pg_query($dbconn, "INSERT INTO billing_paket_detail (jenis, id_detail, harga, id_users ) 
                         VALUES ('T', $id, '$harga', '$id_users')");

            }
	break;
	case "lab_update":
	$id= $_POST['id'];
	$harga = $_POST['harga'];
	$id_paket= $_POST['id_paket'];	

	$cek ="SELECT id from billing_paket_detail WHERE id_users='$id_users' AND id_detail='$id' AND jenis='L' ";
	//var_dump($cek);	
	$result = pg_query($dbconn, $cek);

			$rows = pg_num_rows($result);
			if($rows < 1)
            {
            	$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM billing_paket WHERE id='$id_paket'"));
				if($a['disc_amount']){
					$diskon = $a['disc_amount'];
				}
				else{
					$diskon = $a['disc_persen'];

				}
				$harga_kotor = $a['harga_gross'] + $harga;
				$harga_bersih= $harga_kotor - ($harga_kotor * $diskon/100);
				$update_harga=pg_query($dbconn,"UPDATE billing_paket SET harga_gross=$harga_kotor, harga_net=$harga_bersih WHERE id = '$id_paket' ");
            	$sql =pg_query($dbconn, "INSERT INTO billing_paket_detail (id_billing_paket, jenis, id_detail, harga, id_users ) 
                         VALUES ('$id_paket','L', $id, '$harga', '$id_users')");

            }
	break;

	case "group_update":
	$id= $_POST['id'];
	$harga = $_POST['harga'];
	$id_paket= $_POST['id_paket'];		

	$cek ="SELECT id from billing_paket_detail WHERE id_users='$id_users' AND id_detail='$id' AND jenis='G' ";
	var_dump($cek);	
	$result = pg_query($dbconn, $cek);

			$rows = pg_num_rows($result);
			if($rows < 1)
            {
            	$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM billing_paket WHERE id='$id_paket'"));
				if($a['disc_amount']){
					$diskon = $a['disc_amount'];
				}
				else{
					$diskon = $a['disc_persen'];

				}
				$harga_kotor = $a['harga_gross'] + $harga;
				$harga_bersih= $harga_kotor - ($harga_kotor * $diskon/100);
				$update_harga=pg_query($dbconn,"UPDATE billing_paket SET harga_gross=$harga_kotor, harga_net=$harga_bersih WHERE id = '$id_paket' ");
            	$sql =pg_query($dbconn, "INSERT INTO billing_paket_detail (id_billing_paket, jenis, id_detail, harga, id_users ) 
                         VALUES ('$id_paket', 'LG', $id, '$harga', '$id_users')");

            }
	break;

	case "tindakan_update":
	$id= $_POST['id'];
	$harga = $_POST['harga'];	
	$id_paket= $_POST['id_paket'];	

	$cek ="SELECT id from billing_paket_detail WHERE id_users='$id_users' AND id_detail='$id' AND jenis='T' ";
	
	$result = pg_query($dbconn, $cek);

			$rows = pg_num_rows($result);
			if($rows < 1)
            {
            	$a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM billing_paket WHERE id='$id_paket'"));
				if($a['disc_amount']){
					$diskon = $a['disc_amount'];
				}
				else{
					$diskon = $a['disc_persen'];

				}
				$harga_kotor = $a['harga_gross'] + $harga;
				$harga_bersih= $harga_kotor - ($harga_kotor * $diskon/100);
				$update_harga=pg_query($dbconn,"UPDATE billing_paket SET harga_gross=$harga_kotor, harga_net=$harga_bersih WHERE id = '$id_paket' ");
            	$sql =pg_query($dbconn, "INSERT INTO billing_paket_detail (id_billing_paket, jenis, id_detail, harga, id_users ) 
                         VALUES ('$id_paket', 'T', $id, '$harga', '$id_users')");

            }
	break;
	case "kirim":
	$id= $_POST['id'];
	$catatan= $_POST['catatan'];
	$res=pg_query($dbconn,"UPDATE billing_paket SET status='2' WHERE id = '$id' ");

	$log = pg_query("INSERT INTO billing_paket_penawaran_log (id_billing_paket, id_status_penawaran, waktu_input, id_users, catatan) 
		VALUES('$id', '2', '$tgl_sekarang $jam_sekarang', '$_SESSION[login_user]', '$catatan') ");


	if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			document.location.href = "mcu-penawaran";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			
			?>
			<script>
				document.location.href = "mcu-penawaran";
				
			</script>
			<?php
	    }
	break;
}

?>