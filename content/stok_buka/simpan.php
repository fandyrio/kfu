<?php
switch($_GET['act'])
{
	case "baru":
		//head.php
	    $kode = $_POST['kode'];
	    $id_generik = $_POST['id_generik'];
	    $id_brand = $_POST['id_brand'];
	    $status = $_POST['status'];
	    $id_form = $_POST['id_form'];
	    $strength = $_POST['strength'];
	    $id_atccode = $_POST['id_atccode'];
	    $id_kelas_mims = $_POST['id_mims'];
	    $id_opsi_billing = $_POST['id_opsi_billing'];
	    $expire_control = (isset($_POST['edc'])?1:0);
	    $id_satuan = $_POST['id_satuan'];


		$harga_ditentukan =  (isset($_POST['ditentukan_pengguna'])?'Y':'N');
		$tentukan_pengguna =  (isset($_POST['tentukan_pengguna'])?'Y':'N');
	    $register = $_POST['register'];   
	    $alasan = $_POST['alasan'];

	    $standar_cost = $_POST['standar_cost'];

	    //details.pp
	    $id_kategori = $_POST['id_kategori'];
	    $id_pengobatan = $_POST['id_pengobatan'];
	   // $route = $_POST['route'];
	    $id_narkotika = $_POST['id_narkotika'];
	    $id_kategori_kehamilan = $_POST['id_kategori_kehamilan'];
	    //$obat_pengganti = $_POST['obat_pengganti'];
	   
	    $id_mims = $_POST['id_mims'];
	    
	    $print_label = (isset($_POST['print_label'])?1:0);
	    
	    $otc = (isset($_POST['otc'])?1:0);

	    //pricing.php--harga
	    $metode_harga = $_POST['metode_harga'];
	    $harga = 'ARRAY['. implode(',', $_POST['harga']). ']';
	    $id_layanan = 'ARRAY['. implode(',', $_POST['id_layanan']). ']';
	    
	    //gambar
	    $temp = explode(".", $_FILES["foto"]["name"]);
		$newfilename = round(microtime(true)) . '.' . end($temp);
		move_uploaded_file($_FILES["foto"]["tmp_name"], "images/gambar_obat/" . $newfilename);

		

		//opsi resep -- tabel opsi_resep
		$resepkode = $_POST['resepkode'];
		$dosage = $_POST['dosage'];
		$ambil = $_POST['ambil'];
		$perhari = $_POST['perhari'];
		$indikasi = $_POST['indikasi'];
		$perhari = $_POST['intruksi'];
		//opsi_billing
		
		$res=pg_query($dbconn,"INSERT INTO inv_inventori (
		code, 
		id_generik, 
		id_brand, 
		status,
		id_form, 
		strength,
		id_atccode,
		id_kelas_mims, 
		id_opsi_billing,
		expire_control,
		id_satuan,
		id_kategori_kehamilan,
		id_narkotika, 
		otc,
		label_printing,
		harga_ditentukan,
		tentukan_pengguna,
		id_kategori_obat,
		id_kelas_pengobatan,
		metode_harga,
		standar_cost,
		path_image,
		register,
		alasan_distop
		) 
		VALUES('".$kode."', '".$id_generik."', 
		'".$id_brand."', 
		'".$status."', 
		'".$id_form."', 
		'".$strength."', 
		'".$id_atccode."', 
		'".$id_kelas_mims."', 
		'".$id_opsi_billing."', 
		'".$expire_control."', 
		'".$id_satuan."',  
		'".$id_kategori_kehamilan."',  
		'".$id_narkotika."', '".$otc."', 
		'".$print_label."', '".$harga_ditentukan."', 
		'".$tentukan_pengguna."','".$id_kategori."', 
		'".$id_pengobatan."', '".$metode_harga."', '".$standar_cost."', 
		'".$newfilename."',
		'".$register."',
		'".$alasan."'
		)");

		

		 $sql =pg_query($dbconn, "INSERT INTO inv_kategori_harga(id_generik, id_brand,metode_harga, harga, id_layanan ) 
                         select $id_generik, $id_brand ,'".$metode_harga."' ,*
					from unnest($harga, $id_layanan)");


		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?inventori=inven";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo pg_last_error();

			var_dump("INSERT INTO inventori (
		code, 
		id_generik, 
		id_brand, 
		status,
		id_form, 
		strength,
		id_atccode,
		id_kelas_mims, 
		id_opsi_billing,
		expire_control,
		id_satuan,
		id_kategori_kehamilan,
		id_narkotika, 
		otc,
		label_printing,
		harga_ditentukan,
		tentukan_pengguna,
		id_kategori_obat,
		id_kelas_pengobatan,
		metode_harga,
		standar_cost,
		path_image,
		) 
		VALUES('".$kode."', '".$id_generik."', 
		'".$id_brand."', 
		'".$status."', 
		'".$id_form."', 
		'".$strength."', 
		'".$id_atccode."', 
		'".$id_kelas_mims."', 
		'".$id_opsi_billing."', 
		'".$expire_control."', 
		'".$id_satuan."',  
		'".$id_kategori_kehamilan."',  
		'".$id_narkotika."', '".$otc."', 
		'".$print_label."', '".$harga_ditentukan."', 
		'".$tentukan_pengguna."', '".$id_kategori."', 
		'".$id_pengobatan."', '".$metode_harga."', '".$standar_cost."', 
		'".$newfilename."')");
			?>
			<?php
	    }
	break;

	case "edit":
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$kategori = $_POST['kategori'];
	$result=pg_query($dbconn,"UPDATE inv_obat SET
	nama='".$nama."',
	id_kategori='".$kategori."',
	WHERE id = $id");
	

	if($result)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?inventori=obat";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "media.php?inventori=obat";
			
		</script>
		<?php
	}

	

	break;
}

?>