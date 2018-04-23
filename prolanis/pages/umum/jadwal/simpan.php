<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
echo API_SMS;
$date = $_POST['tgl_awal'];
$idUnit=$_SESSION['id_branch'];
$sepparator = '-';
$parts = explode($sepparator, $date);
$toDay=date('l');
$toDate=date('d');
$dateEvent=date('Y-m-d', strtotime("+1 days"));
//$dayForDate = date("l", mktime(0, 0, 0, $parts[1], $dat, $parts[0]));
if($_POST['freq']==1){// per bulan
	$notif= $parts[2]-1;
}

switch($_GET['act'])
{

	case "baru":
		$id_literasi = $_POST[id_literasi];
		if($_POST[freq]=='1'){
			$id_literasi=0;
		} 

		$res=pg_query($dbconn,"INSERT INTO pro_jadwal (id_pro, tgl_awal, tgl_akhir, jam,ket,freq, id_unit,  id_literasi) VALUES('$_POST[id_pro]','$_POST[tgl_awal]', '$_POST[tgl_akhir]', '$_POST[jam]', '$_POST[ket]','$_POST[freq]' ,'$_SESSION[id_branch]',  '$id_literasi') RETURNING id");
		$row = pg_fetch_row($res);

		if($_POST[freq]=='1'){
			$sql =pg_query($dbconn, "INSERT INTO pro_jadwal_dtl (id_jadwal, day_notif )  values ('$row[0]', '$notif')");
			if($toDate==$notif)
			{
				$getKegiatan=pg_query("SELECT * from  pro_nama where id='$_POST[id_pro]'");
				$fetchKegiatan=pg_fetch_assoc($getKegiatan);
				$jenisKegiatan=$fetchKegiatan['nama'];
				sendNotification($_POST['jam'], $jenisKegiatan, $dateEvent,$idUnit);
			}
		}

		if (!isset($_POST['id_hari']) || empty($_POST['id_hari'])) {
		} 
		else{
			if($_POST[freq]=='2'){
				foreach ($_POST[id_hari] as $key) {
					$sql =pg_query($dbconn, "INSERT INTO pro_jadwal_dtl (id_jadwal, day_notif )  values ('$row[0]', '$key')");
					if($toDay==$key)
					{
						$getKegiatan=pg_query("SELECT * from  pro_nama where id='$_POST[id_pro]'");
						$fetchKegiatan=pg_fetch_assoc($getKegiatan);
						$jenisKegiatan=$fetchKegiatan['nama'];
						sendNotification($_POST['jam'], $jenisKegiatan, $dateEvent,$idUnit);
						
					}
				}
			}
			
		}
		
		if($res){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
				document.location.href = "media.php?umum=jadwal";
			</script>

		<?php
	    } else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			 echo mysql_error();
			?>
			<script>		
			</script>
			<?php
	    }
	break;

	case "edit":

	$id_literasi = $_POST[id_literasi];
		if($_POST[freq]=='1'){
			$id_literasi=0;
		} 

	$result=pg_query($dbconn,"UPDATE pro_jadwal SET id_pro='$_POST[id_pro]', tgl_awal='$_POST[tgl_awal]', tgl_akhir='$_POST[tgl_akhir]', jam='$_POST[jam]', ket='$_POST[ket]', freq='$_POST[freq]', id_literasi='$id_literasi' WHERE id = '$_POST[id]'");

	pg_query($dbconn,"DELETE FROM pro_jadwal_dtl WHERE id_jadwal = '".$_POST[id]."'");

	if($_POST[freq]=='1'){
		$sql =pg_query($dbconn, "INSERT INTO pro_jadwal_dtl (id_jadwal, day_notif )  values ('$row[0]', '$notif')");
	} 

	if (!isset($_POST['id_hari']) || empty($_POST['id_hari'])) {
	} 
	else{
			if($_POST[freq]=='2'){
				foreach ($_POST[id_hari] as $key) {

					$sql =pg_query($dbconn, "INSERT INTO pro_jadwal_dtl (id_jadwal, day_notif )  values ('$_POST[id]', '$key')");
				}
			}		
	}
	

	if($result)
	{
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			//document.location.href = "media.php?umum=jadwal";
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			//document.location.href = "media.php?umum=jadwal";
		</script>
		<?php
	}

	

	break;
}



function sendNotification($jam, $jenisKegiatan, $dateEvent,$idUnit)
{
  $getDataUnit=pg_query("SELECT * from master_unit where id='$idUnit'");
  $fetchDataUnit=pg_fetch_assoc($getDataUnit);
  $idOutlet=$fetchDataUnit['id_outlet'];

  $getDataPasien=pg_query("SELECT mp.* from pasien_tindak_lanjut tl
                          JOIN master_pasien mp on (mp.id=tl.id_pasien) 
                          WHERE tl.id_unit='$_SESSION[id_branch]' AND tl.id_tindak_lanjut='3' ");

  $arrNoHp=array();
  while($fetchDataPasien=pg_fetch_assoc($getDataPasien))
  {
    array_push($arrNoHp, $fetchDataPasien['no_handphone']);
  }
  $message="Yth, Bpk/Ibu Peserta Prolanis, Besok tgl ".$dateEvent." Pukul ".$jam." Kita akan mengadakan kegiatan ".$jenisKegiatan.". Terimakasih";
   $data=array(
      "phoneNo"=>$arrNoHp,
      "message"=>$message
  );
   $dataPost=json_encode($data);
     $url=API_SMS;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPost);   
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);      
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');        
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
               'Content-Type:application/json',
                'X-Auth-Token:p7riBrL1PGOKtDveaymsl2LZvWiQYDQJltan96bj',
                'X-Auth-OutletId:'.$idOutlet,
                'X-Auth-BvkUserId:1'));
            curl_setopt($ch, CURLOPT_URL, $url);    
            $return = curl_exec($ch);
}

?>