<?php
session_start();
require('../../../../fpdf/fpdf.php');
include "../../../../config/conn.php";
include "../../../../config/library.php";
include "../../../../config/fungsi_tanggal.php";

$images="../../../../images/klinik_pratama.jpg";
$imagesCC="../../../../images/cc.png";



$idPasien=$_POST['idPasien'];
$idDokter=$_POST['id_dokter'];
$ts=$_POST['ts'];
$diBuatDi=$_POST['dibuat_di'];
$poly=$_POST['poly'];
$idRS=$_POST['id_rs'];


$idUnit=$_SESSION['id_units'];

$getPoly=pg_query("SELECT * from master_poly where id='$poly'");
$fetchPoly=pg_fetch_assoc($getPoly);

$getRSInfo=pg_query("SELECT * from master_cabang_rujukan where id='$idRS'");
$fetchRSInfo=pg_fetch_assoc($getRSInfo);

$getDiagnosa=pg_query("SELECT * from pasien_diagnosa_detail pdd join master_icd10 micd 
	on micd.id=pdd.id_diagnosa
	join kunjungan k on k.id=pdd.id_kunjungan
	where pdd.id_pasien='$idPasien' and k.status_kunjungan='Y'");

$diagnosa="";
while($diagnosaFetch=pg_fetch_assoc($getDiagnosa))
{
	$diagnosa .=$diagnosaFetch['nama'].", ";
	
}

$getKeluhan=pg_query("select * from pasien_keluhan pk join pasien_keluhan_detail pkd on pkd.id_pasien_keluhan=pk.id
	join master_sympton ms on ms.id=pkd.id_symptom
where id_kunjungan=(select max(id) from kunjungan where id_pasien='$idPasien' and status_kunjungan='Y')");

$keluhan="";
while($fetchKeluhan=pg_fetch_assoc($getKeluhan))
{
	$keluhan.=$fetchKeluhan['nama_sympton']." , ";
}

$getObat=pg_query("select pro.*, prod.nama_brand as item_resep from pasien_resep_order pro
left join pasien_resep_order_detail prod on prod.id_pasien_resep_order=pro.id
where pro.id_kunjungan=(select max(id) from kunjungan where id_pasien='$idPasien' and status_kunjungan='Y')");

if(pg_num_rows($getObat)>0)
{
	$obat="";
	while($fetchObat=pg_fetch_assoc($getObat))
	{
		if($fetchObat['status_racik']=="Y")
		{
			$obat .=$fetchObat['item_resep']." , ";
		}
		else
		{
			$obat.=$fetchObat['nama_brand']." , ";
		}
	}
}
else
{
	$obat="-";
}


$getUnitInfo=pg_fetch_assoc(pg_query("SELECT * from master_unit where id='$idUnit'"));
$kodeUnit=$getUnitInfo['kode'];

$getDataPasien=pg_query("SELECT mps.* from master_pasien mps where mps.id='$idPasien'");
$fetchDataPasien=pg_fetch_assoc($getDataPasien);

$getDataPekerjaan=pg_query("SELECT * from master_pekerjaan where id='$fetchDataPasien[id_pekerjaan]'");
$fetchDataPekerjaan=pg_fetch_assoc($getDataPekerjaan);

$getDataDoker=pg_query("SELECT * from master_karyawan where id='$idDokter'");
$fetchDokter=pg_fetch_assoc($getDataDoker);


//get data pemeriksaan fisik
//===============================================
$getDataFisik=pg_query("SELECT * from pasien_fisik_detail pfd join fisik f on f.id=pfd.id_fisik join pasien_fisik pf on pf.id=pfd.id_pasien_fisik
join kunjungan k on k.id=pf.id_kunjungan
where pf.id_pasien='$idPasien' and k.status_kunjungan='Y'");


//===============================================
//data Klinik
$tipeKlinik="KLINIK PRATAMA";
$namaKlinik=$getUnitInfo['nama'];
$alamat='Alamat : '.$getUnitInfo['alamat'].' Telp. '.$getUnitInfo['telepon'];
//================================================

//data dokter
$namaDokter=$fetchDokter['nama'];
$sip=$fetchDokter['no_izin_praktek'];
//================================================

//data pasien
if($fetchDataPasien['jenkel']==1)
{
	$jenisKelamin="Laki - Laki";
}
else
{
	$jenisKelamin="Perempuan";
}

$tanggal_lahir=date_create($fetchDataPasien['tanggal_lahir']);
$tgl_sekarang=date_create();
	
$diff=date_diff($tanggal_lahir,$tgl_sekarang);
//echo"$diff[y] tahun, $diff[m] bulan, $diff[d] hari";

$namaPasien=$fetchDataPasien['nama'];
$tempaTanggaLahir=$fetchDataPasien['tempat_lahir'];
$umurPasien=$diff->y;
$pekerjaan=$fetchDataPekerjaan['nama'];
$alamatPasien=$fetchDataPasien['alamat'];
$hasil="SEHAT JASMANI";
$tujuan=$tujuan;

$arrayFisik=array();
while($fetchDataFisik=pg_fetch_assoc($getDataFisik))
{
	array_push($arrayFisik, $fetchDataFisik['nilai']);
}
	$beratBadan=$arrayFisik[0];
	$tinggiBadan=$arrayFisik[1];
	$tekananDarah=$arrayFisik[2];	
	$denyutNadi=$arrayFisik[3];
	$butaWarna="Negatif";
	$tanggal=date('d F Y');
	$jam=date('h:i:s');
	$timeStamp=$tanggal.' '.$jam;


$uniqueName=date('d').date('m').date('Y').$idPasien.date('h').date('i').date('s');
$namaFile="surat_rujukan".$uniqueName.".pdf";



$thisYear=date('Y');
$thisMonth=date('m');
$getMaxId=pg_query("SELECT count(id) as jumlah from pasien_dokumen where id_dokumen='4' and extract(month from created_at::TIMESTAMP)='$thisMonth' and extract(year from created_at::TIMESTAMP)='$thisYear' and status_hapus='N'");
$fetchMaxId=pg_fetch_assoc($getMaxId);
$jumlahData=pg_num_rows($getMaxId);


if($jumlahData==0)
{
	$runningNumber=sprintf('%04d', 1);
}
else
{
	$jumlah=$fetchMaxId['jumlah']+=1;
	$runningNumber=sprintf('%04d', $jumlah);	
}
//FORMAT NO SURAT =KSEHAT/  Kode Unit /  / MONTH / YEAR / Running Number
$noSurat='KRUJUAKAN/'.$kodeUnit.'/'.$thisMonth.'/'.$thisYear.'/'.$runningNumber;


$insertDokumen=pg_query("INSERT into pasien_dokumen (no_surat,id_dokumen,id_dokter,created_at,tujuan,dibuat_di,id_pasien,nama_file,ts,id_poly,id_rs)
	values('$noSurat','4', '$idDokter','$timeStamp', '$tujuan', '$diBuatDi', '$idPasien','$namaFile','$ts','$poly', '$idRS');
	");


$pdf = new FPDF();
$pdf->AddPage();
$pdf->Cell(-10);
$pdf->SetFillColor(91,155,213);
$pdf->Rect(0, 0, 10, 297, 'F');
$pdf->setXY(10,0);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(110,6,$tipeKlinik,0,'C',true);
$pdf->setXY(10,5);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(256,256,256);
$pdf->MultiCell(110,10,$namaKlinik,0,'C',true);
$pdf->setXY(10,15);
$pdf->SetFont('Arial','I',10);
$pdf->MultiCell(110,4,$alamat,0,'L',true);

$pdf->Cell( 40, 40, $pdf->Image($images, 130, 0, 60), 0, 0, 'L', false );
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Text(20,40, 'Nomor Surat : ');
$pdf->Text(45,40, $noSurat);

$pdf->SetFont('Arial','',3);
$pdf->SetTextColor(0,0,256);
$pdf->Text(30,44,'___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________');
$pdf->Text(30,53,'___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________');

$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(0,0,0);
$pdf->Text(80,50,'SURAT RUJUKAN');
$pdf->SetFont('Arial','',11);

$x=60;
$pdf->Text(30,$x, 'Yang terhormas T.S');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$ts);
$pdf->Text(30,$x+=5, 'Poli Klinik');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$fetchPoly['name']);
$pdf->Text(30,$x+=5, 'Rumah Sakit');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$fetchRSInfo['nama']);
$pdf->Text(30,$x+=5, 'Alamat');
$pdf->Text(80,$x,":");
$pdf->setXY(85,$x-4);
$pdf->MultiCell(100,5,$fetchRSInfo['alamat']);

$pdf->Text(30,$x+=15,'Mohon pemeriksaan / pengobatan lebih lanjut / pemeriksaan penunjang diagnostik');
$pdf->Text(30,$x+=5,'terhadap penderita:');

$pdf->Text(40,$x+=8, 'Nama Pasien');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$namaPasien);
$pdf->Text(40,$x+=5, 'Tempat / Tanggal Lahir');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$tempaTanggaLahir);
$pdf->Text(40,$x+=5, 'Jenis Kelamin');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$jenisKelamin);
$pdf->Text(40,$x+=5, 'Umur');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$umurPasien." Tahun");
$pdf->Text(40,$x+=5, 'Pekerjaan');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$pekerjaan);
$pdf->Text(40,$x+=5, 'Alamat');
$pdf->Text(80,$x,":");
$pdf->setXY(84,$x-3);
$pdf->MultiCell(110,5,$alamatPasien,0,'L',false);

$pdf->Text(40,$x+=7, 'Dokter Pemeriksa');
$pdf->Text(80,$x,":");
$pdf->setXY(84,$x-3);
$pdf->MultiCell(110,5,$namaDokter,0,'L',false);
$pdf->Text(40,$x+=5, 'SIP');
$pdf->Text(80,$x,":");
$pdf->setXY(84,$x-3);
$pdf->MultiCell(110,5,$sip,0,'L',false);

$pdf->setXY(30,$x+=5);
$pdf->MultiCell(150,5,'KETERANGAN','B','L',false);



//=====================================================================================
//Anamnesa
$pdf->SetFont('Arial','I',10);
$pdf->setXY(30,$x+=5);
$pdf->MultiCell(45,7,'Anamnesa','','L',false);

$pdf->SetFont('Arial','',10);
$pdf->setXY(90.5,$x+0.5);
$pdf->SetFillColor(204,204,204);
$pdf->MultiCell(90,5,"Pasien datang dengan keluhan ".$keluhan,'L', 'L',true);


//=======================================================================================


//=======================================================================================
//Pemeriksaan Fisik
$pdf->setXY(30,$x+=10);
$pdf->MultiCell(45,5,'Pemeriksaan Fisik','','L',false);

$pdf->SetFont('Arial','',10);
$pdf->setXY(90.5,$x+0.5);
$pdf->SetFillColor(204,204,204);
$pdf->MultiCell(50,5,'Tinggi Badan','L','L',false);
$pdf->setXY(120.5,$x);
$pdf->MultiCell(10,5,':','','L',false);
$pdf->setXY(130.5,$x);
$pdf->MultiCell(50,5,$tinggiBadan,'','L',false);
$pdf->setXY(140.5,$x);
$pdf->MultiCell(50,5,'Cm','','L',false);


$pdf->setXY(90.5,$x+=5);
$pdf->SetFillColor(204,204,204);
$pdf->MultiCell(50,5,'Berat Badan','L','L',false);
$pdf->setXY(120.5,$x);
$pdf->MultiCell(10,5,':','','L',false);
$pdf->setXY(130.5,$x);
$pdf->MultiCell(50,5,$beratBadan,'','L',false);
$pdf->setXY(140.5,$x);
$pdf->MultiCell(50,5,'Kg','','L',false);


$pdf->setXY(90.5,$x+=5);
$pdf->SetFillColor(204,204,204);
$pdf->MultiCell(50,5,'Tekanan Darah','L','L',false);
$pdf->setXY(120.5,$x);
$pdf->MultiCell(10,5,':','','L',false);
$pdf->setXY(130.5,$x);
$pdf->MultiCell(50,5,$tekananDarah,'','L',false);
$pdf->setXY(140.5,$x);
$pdf->MultiCell(50,5,'mmHg','','L',false);


$pdf->setXY(90.5,$x+=5);
$pdf->SetFillColor(204,204,204);
$pdf->MultiCell(50,5,'Denyut Nadi','L','L',false);
$pdf->setXY(120.5,$x);
$pdf->MultiCell(10,5,':','','L',false);
$pdf->setXY(130.5,$x);
$pdf->MultiCell(50,5,$denyutNadi,'','L',false);
$pdf->setXY(140.5,$x);
$pdf->MultiCell(50,5,'kali /menit','','L',false);

//=========================================================================================
//Diagnosa
$pdf->setXY(30,$x+=5);
$pdf->MultiCell(45,5,'Diagnosa Sementara','','L',false);

$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',10);
$pdf->setXY(90.5,$x+0.5);
$pdf->SetFillColor(204,204,204);
$pdf->MultiCell(90,5,$diagnosa,'L','L',true);
//=========================================================================================
//Diagnosa
$pdf->setXY(30,$x+=5);
$pdf->MultiCell(55,5,'Terapi/ Obat yang telah diberikan','','L',false);

$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',10);
$pdf->setXY(90.5,$x+0.5);
$pdf->MultiCell(90,5,$obat,'L','L',false);
//=========================================================================================
//Diagnosa
$pdf->setXY(30,$x+=10);
$pdf->MultiCell(45,5,'Keterangan Lain','','L',false);

$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',10);
$pdf->setXY(90.5,$x+0.5);
$pdf->SetFillColor(204,204,204);
$pdf->MultiCell(90,5,'-','L','L',true);
//=========================================================================================


$pdf->Text(30,$x+=15,'Demikian surat keterangan ini di buat untuk dipergunakan sebagaimana perlunya.');
$pdf->SetFont('Arial','I', 11);
$pdf->Text(30,$x+=10,'Terimakasih');
$pdf->Text(30,$x+=5,'Semoga Sehat Selalu');

$pdf->SetFont('Arial','', 11);
$pdf->Text(30,$x+=10,$diBuatDi.', '.$tanggal);
$pdf->Text(30,$x+=5,"Dokter Pemeriksa");
$pdf->SetFont('Arial','UB', 11);
$pdf->Text(30,$x+=25,$namaDokter);

$pdf->Cell( 40, 20, $pdf->Image($imagesCC, 10, $x+=3, 60), 0, 0, 'L', false );

$pdf->Output("../dokumen_surat/".$namaFile,"F");

//$pdf->Output("I");
?>