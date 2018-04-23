
<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include "../config/conn.php";
//CheckBpjsNumber
?>
//===================================================================================================================
	<?php
	 echo "<br />CHECK NO BPJS <br />";
	 ?>
//===================================================================================================================
<br />
<?php
$noBpjs="0001454326918";
$dateNow=date("Y-m-d");
$post_data=array(
	"no_peserta" => "$noBpjs"
);

$jsonNoBpjs = str_replace(array("\\r","\\n","\\t"), "",json_encode($post_data,JSON_PRETTY_PRINT));

$jsonBpjs = preg_replace('#(?<!\\\\)(\\$|\\\\)#', "", $jsonNoBpjs);

echo'<pre>';
print_r($jsonBpjs);
echo'</pre>';

?>
<br /><br /><br />
//===================================================================================================================
	<?php
	 echo "<br />POST PENDAFTARAN <br />";
	 ?>
//===================================================================================================================
<br />
<?php

$getDataPasien=pg_query("select * from antrian a 
left join master_karyawan mk on mk.id=a.id_dokter::integer 
join master_pasien mp on mp.id=a.id_pasien::integer
where a.id_pasien='4805' and a.id=(SELECT MAX(id) from antrian where id_pasien='4805')");

$fetchDataPasien=pg_fetch_assoc($getDataPasien);

$postData=array(
	"kdProviderPeserta"=>$fetchDataPasien['kode_faskes'],
	"tglDaftar"=>$dateNow,
	"noKartu"=>$fetchDataPasien['no_bpjs'],
	"kdPoli"=>$fetchDataPasien['poly_id'],
	"keluhan"=> null,
	"kunjSakit"=> true,
	"sistole"=> 0,
	"diastole"=> 0,
	"beratBadan"=> 0,
	"tinggiBadan"=> 0,
	"respRate"=> 0,
	"heartRate"=> 0,
	"rujukBalik"=> 0,
	"rawatInap"=> false
);

$jsonDataPasien = str_replace(array("\\r","\\n","\\t"), "",json_encode($postData,JSON_PRETTY_PRINT));

$jsonDataPasien = preg_replace('#(?<!\\\\)(\\$|\\\\)#', "", $jsonDataPasien);

echo'<pre>';
print_r($jsonDataPasien);
echo'</pre>';
?>
<br /><br /><br />
//===================================================================================================================
	<?php
	 echo "<br />GET POLY <br />";
	 ?>
//===================================================================================================================
<br />
	URL : {BASE_URL}/pcare-rest/v1/poli/fktp/{start}/{limit}<br />
		CTH : {BASE_URL}/pcare-rest/v1/poli/fktp/0/2
<br /><br /><br />
//===================================================================================================================
	<?php
	 echo "<br />GET DOKTER <br />";
	 ?>
//===================================================================================================================
<br />
	URL : {BASE_URL}/pcare-rest/v1/dokter/{start}/{limit} <br />
	CTH : {BASE_URL}/pcare-rest/v1/dokter/0/3

<br /><br /><br />
//===================================================================================================================
	<?php
	 echo "<br />POST KUNJUNGAN <br />";
	 ?>
//===================================================================================================================
<br />
<?php
	$getDataFisik=pg_query("select * from pasien_fisik_detail pfd join pasien_fisik pf on pf.id=pfd.id_pasien_fisik where pf.id_pasien='4805' and pf.id_kunjungan=(select max(id_kunjungan) from pasien_fisik where id_pasien='4805')");

	$getKeluhan=pg_query("select * from pasien_keluhan pk join pasien_keluhan_detail pkd on pkd.id_pasien_keluhan=pk.id
	join master_sympton_indo msi on msi.id=pkd.id_symptom
	where id_pasien='4805'");

	$fetchKeluhan=pg_fetch_assoc($getKeluhan);
	$keluhan=$fetchKeluhan['nama_sympton'];

	$getDiagnosa=pg_query("select * from pasien_diagnosa pd join pasien_diagnosa_detail pdd on pdd.id_pasien_diagnosa=pd.id
	join master_icd10 icd on icd.id=pdd.id_diagnosa
	where pd.id_pasien='4805' and pd.id_kunjungan=(select max(id_kunjungan) from pasien_diagnosa where id_pasien='4805')");

	$jumlah=pg_num_rows($getDiagnosa);
	
	while($fetchDataDiagnosa=pg_fetch_assoc($getDiagnosa))
	{
		$diagnosa[]=array('diagnosa'=>$fetchDataDiagnosa['nama']);
	}
	if($jumlah==1)
	{
		$diag1=$diagnosa[0];
		$diag2=null;
		$diag3=null;
	}
	else if($jumlah==2)
	{
		$diag1=$diagnosa[0];
		$diag2=$diagnosa[1];
		$diag3=null;
	}
	else
	{
		$diag1=$diagnosa[0];
		$diag2=$diagnosa[1];
		$diag3=$diagnosa[2];
	}


	while($fetchDataFisik=pg_fetch_assoc($getDataFisik))
	{
		if($fetchDataFisik['id_fisik']==1)
		{
			$suhuTubuh=$fetchDataFisik['nilai'];
		}
		else if($fetchDataFisik['id_fisik']==2)
		{
			$beratBadan=$fetchDataFisik['nilai'];
		}
		else if($fetchDataFisik['id_fisik']==3)
		{
			$tinggiBadan=$fetchDataFisik['nilai'];
		}
		else if($fetchDataFisik['id_fisik']==4)
		{
			$tekananDarah=$fetchDataFisik['nilai'];
		}
		else if($fetchDataFisik['id_fisik']==5)
		{
			$nadi=$fetchDataFisik['nilai'];
		}
		else if($fetchDataFisik['id_fisik']==6)
		{
			$pernafasan=$fetchDataFisik['nilai'];
		}
		
	}
	$explode=explode("/", $tekananDarah);
	$sistole=$explode[0];
	$diastole=$explode[1];
	$dataKunjungan=array(
		  "noKunjungan"=> null,
		  "noKartu"=> $noBpjs,
		  "tglDaftar"=> $dateNow,
		  "keluhan"=> $keluhan,
		  "kdSadar"=> "01",
		  "sistole"=> $sistole,
		  "diastole"=> $diastole,
		  "beratBadan"=> $beratBadan,
		  "tinggiBadan"=> $tinggiBadan,
		  "respRate"=> 0,
		  "heartRate"=> 0,
		  "terapi"=> null,
		  "kdProviderRujukLanjut"=> null,
		  "kdStatusPulang"=> "3",
		  "tglPulang"=> $dateNow,
		  "kdDokter"=> $fetchDataPasien['id_dokter'],
		  "kdDiag1"=> $diag1,
		  "kdDiag2"=> $diag2,
		  "kdDiag3"=> $diag3,
		  "kdPoliRujukInternal"=> "001",
		  "kdPoliRujukLanjut"=> null
		);
	

		$encodeKunjungan = str_replace(array("\\r","\\n","\\t"), "",json_encode($dataKunjungan,JSON_PRETTY_PRINT));

		$encodeKunjungan = preg_replace('#(?<!\\\\)(\\$|\\\\)#', "", $encodeKunjungan);

		echo'<pre>';
		print_r($encodeKunjungan);
		echo'</pre>';


?>

<br /><br /><br />
//===================================================================================================================
	<?php
	 echo "<br />POST TINDAKAN <br />";
	 ?>
//===================================================================================================================
<br />

<?php
$getTindakan=pg_query("select * from transaksi_invoice ti join transaksi_invoice_detail tid on tid.id_invoice=ti.id 
join tindakan t on t.id=tid.id_detail 
where ti.id_pasien='4805' and ti.id_kunjungan=(SELECT MAX(id_kunjungan) from transaksi_invoice where id_pasien='4805')");

$hargaTindakan=pg_query("SELECT SUM(total) as harga_jasa from transaksi_invoice_detail tid 
join tindakan t on t.id=tid.id_detail 
where tid.id_pasien='4805' and tid.id_kunjungan=(SELECT MAX(id_kunjungan) from transaksi_invoice where id_pasien='4805')");
$fetchHargaTindakan=pg_fetch_assoc($hargaTindakan);
$harga=$fetchHargaTindakan['harga_jasa'];

while($fetchTindakan=pg_fetch_assoc($getTindakan))
{
	$tindakan.=$fetchTindakan['nama'].', ';
	$kodeTindakan.=$fetchTindakan['id_detail'];
}

$postTindakan=array(
	  "kdTindakanSK"=> 0,
	  "noKunjungan"=> "DIDAPAT SAAT HIT KUNJUNGAN",
	  "kdTindakan"=> $kodeTindakan,
	  "biaya"=> $harga,
	  "keterangan"=> null,
	  "hasil"=> 0
);


	$encodeTindakan = str_replace(array("\\r","\\n","\\t"), "",json_encode($postTindakan,JSON_PRETTY_PRINT));

		$encodeTindakan = preg_replace('#(?<!\\\\)(\\$|\\\\)#', "", $encodeTindakan);

		echo'<pre>';
		print_r($encodeTindakan);
		echo'</pre>';

?>
<br /><br /><br />
//===================================================================================================================
	<?php
	 echo "<br />GET DIAGNOSA <br />";
	 ?>
//===================================================================================================================
<br />
URL : {BASE_URL}/pcare-rest/v1/diagnosa/{keyword}/{start}/{limit} <br />
CTH : {BASE_URL}/pcare-rest/v1/diagnosa/001/0/2

<br /><br /><br />
//===================================================================================================================
	<?php
	 echo "<br />GET REFERENSI TINDAKAN <br />";
	 ?>
//===================================================================================================================
<br />
URL : {BASE_URL}/pcare-rest/v1/tindakan/{start}/{limit}<br />
CTH : {BASE_URL}/pcare-rest/v1/tindakan/1/3