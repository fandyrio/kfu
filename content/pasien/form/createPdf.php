<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/session_start();

require('../../../fpdf/fpdf.php');
include "../../../config/conn.php";

$idUnit=$_SESSION['id_units'];
$id_kunjungan=$_GET['id_kunjungan'];
$idPasien=$_GET['id_pasien'];

$getUnitInfo=pg_fetch_assoc(pg_query("SELECT mu.*, mjk.nama as nama_jenis_klinik 
	from master_unit mu 
	join master_jenis_klinik mjk on mjk.id=mu.jenis_klinik::integer where mu.id='$idUnit'"));
$kodeUnit=$getUnitInfo['kode'];

/*if($getUnitInfo['jenis_klinik']==1)
{*/
	$images="../../../images/klinik_pratama.jpg";
//}

//===============================================
//data Klinik
//===============================================
$tipeKlinik=$getUnitInfo['nama_jenis_klinik'];
$namaKlinik=$getUnitInfo['nama'];
$alamat='Alamat : '.$getUnitInfo['alamat'].' Telp. '.$getUnitInfo['telepon'];
//================================================

//==============================================
//GET DATA RESERVASI LAB
//==============================================
$getDataReservasi=pg_query("SELECT * from data_reservasi_lab where id_kunjungan='$id_kunjungan'");
$fetchDataReservasi=pg_fetch_assoc($getDataReservasi);
$noSurat=$fetchDataReservasi['no_surat'];
$diBuatDi=$fetchDataReservasi['dibuat_di'];
//==============================================
//GET DATA PASIEN
//==============================================
$getDataPasien=pg_query("SELECT * from master_pasien where id='$idPasien'");
$fetchDataPasien=pg_fetch_assoc($getDataPasien);
if($fetchDataPasien['jenkel']==1)
{
	$jk="Laki - Laki";
}
else
{
	$jk="Perempuan";
}

$getUmurPasien=pg_query("SELECT age(tanggal_lahir::timestamp) from master_pasien where id='$idPasien'");
$fetchUmur=pg_fetch_assoc($getUmurPasien);
$explodeUmur=explode(" ", $fetchUmur['age']);
$umurPasien=$explodeUmur[0];
//==============================================
//GET DATA DOKTER
//==============================================
$getDataDokter=pg_query("SELECT * from antrian a join master_karyawan mk on mk.id=a.id_dokter where a.id_kunjungan='$id_kunjungan'");
$fetchDataDoker=pg_fetch_assoc($getDataDokter);

if($fetchDataDoker['no_izin_praktek']=="")
{
	$no_izin_praktek="-";
}
else
{
	$no_izin_praktek=$fetchDataDoker['no_izin_praktek'];
}

//==============================================
//GET ANAMNESA / KELUHAN
//=============================================
$getKeluhan=pg_query("SELECT * from pasien_keluhan pk
join pasien_keluhan_detail pkd on pkd.id_pasien_keluhan=pk.id
join master_sympton ms on ms.id=pkd.id_symptom
 where pk.id_kunjungan='$id_kunjungan'");

while($fetchKeluhan=pg_fetch_assoc($getKeluhan))
{
	$dataKeluhan.=$fetchKeluhan['nama_sympton'].', ';
}

 //=============================================
//GET DIAGNOSA
//==============================================
$getDiagnosa=pg_query("SELECT * from pasien_diagnosa_detail pd join master_icd10 icd on icd.id=pd.id_diagnosa where pd.id_kunjungan='$id_kunjungan'");
while($fetchDiagnosa=pg_fetch_array($getDiagnosa))
{
	$dataDiagnosa .=$fetchDiagnosa['nama'].', ';
}
//==============================================
//GET DATA PEMERIKSAAN
//==============================================
$getDataPemeriksaan=pg_query("SELECT * from reservasi_lab where id_kunjungan='$id_kunjungan'");
//==============================================




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

//=========================
//Deklarasi X sebagai titik awal
//=======================
$x=30;
//=======================

$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(245,16,16);
$pdf->setXY(198,3);
$pdf->MultiCell(10,5,$id_kunjungan, 1);


$pdf->SetTextColor(0,0,0);
$pdf->Text(30,$x, 'No. Surat : '.$noSurat);
$pdf->Text(40,$x+=8,'_______________________________________________________________');
$pdf->SetFont('Arial','B',10);
$pdf->Text(65,$x+=5,'SURAT RUJUKAN PENUNJANG DIAGNOSTIK');
$pdf->SetFont('Arial','',10);
$pdf->Text(40,$x+=2,'_______________________________________________________________');

$pdf->SetFont('Arial','',9);
$pdf->Text(40, $x+=5, 'Kepada Yth. ');
$pdf->Text(70, $x, ':');
$pdf->Text(80, $x, $fetchDataReservasi['lab']);

$pdf->Text(40, $x+=5, 'Alamat');
$pdf->Text(70, $x, ':');
$pdf->setXY(79,$x-3);
$pdf->MultiCell(100,4,$fetchDataReservasi['alamat_lab']);


$pdf->Text(40, $x+=12, 'Mohon pemeriksaan penunjang diagnostik terhadap penderita:');
$pdf->Text(40, $x+=5, 'Nama Pasien');
$pdf->Text(80, $x, ':');
$pdf->Text(90, $x, $fetchDataPasien['nama']);

$pdf->Text(40, $x+=5, 'Tempat, Tanggal Lahir');
$pdf->Text(80, $x, ':');
$pdf->Text(90, $x, $fetchDataPasien['tempat_lahir'].', '.date('d-F-Y', strtotime($fetchDataPasien['tanggal_lahir'])));

$pdf->Text(40, $x+=5, 'Jenis Kelamin');
$pdf->Text(80, $x, ':');
$pdf->Text(90, $x, $jk);

$pdf->Text(40, $x+=5, 'Umur');
$pdf->Text(80, $x, ':');
$pdf->Text(90, $x, $umurPasien.' Tahun');

$pdf->Text(40, $x+=5, 'Pekerjaan');
$pdf->Text(80, $x, ':');
$pdf->Text(80, $x, $fetchDataPasien['pekerjaan']);

$pdf->Text(40, $x+=5, 'Alamat');
$pdf->Text(80, $x, ':');
$pdf->setXY(90,$x-3);
$pdf->MultiCell(100,4,$fetchDataPasien['alamat']);


$pdf->Text(40, $x+=15, 'Dokter Pemeriksa');
$pdf->Text(80, $x, ':');
$pdf->Text(90, $x, $fetchDataDoker['nama']);

$pdf->Text(40, $x+=5, 'SIP');
$pdf->Text(80, $x, ':');
$pdf->Text(90, $x, $no_izin_praktek);

$pdf->SetFont('Arial','BI',10);
$pdf->Text(40,$x+=10, 'KETERANGAN');

$pdf->SetFont('Arial','',9);
$pdf->setXY(40,$x+=5);
$pdf->MultiCell(50,5,'Anamnesa', 'T');

$pdf->setXY(90,$x);
$pdf->MultiCell(100,5,$dataKeluhan, 1);

$pdf->setXY(40,$x+=5);
$pdf->MultiCell(50,5,'Diagnosa Sementara', '');

$pdf->setXY(90,$x);
$pdf->MultiCell(100,5,$dataDiagnosa, 1);


$pdf->Text(40,$x+=25, 'Mohon dilakukan pemeriksaan laboratorium meliputi:');
$no_urut=1;
while($fetchDataPemeriksaan=pg_fetch_assoc($getDataPemeriksaan))
{
	
	$pdf->Text(40,$x+=5, $no_urut.'. '.$fetchDataPemeriksaan['nama_pemeriksaan']);
	$no_urut++;
}
$pdf->Text(40,$x+=10, 'Demikian surat keterangan ini di buat untuk dipergunakan sebagaimana perlunya.');

$pdf->SetFont('Arial','I',9);
$pdf->Text(40,$x+=8, 'Terimakasih');
$pdf->Text(40,$x+=5, 'Semoga Sehat Selalu');

$pdf->SetFont('Arial','',9);
$pdf->Text(40,$x+=10, $diBuatDi.', '.date('d F Y'));
$pdf->Text(40,$x+=5, 'Dokter Pemeriksa');
$pdf->SetFont('Arial','BU',9);
$pdf->Text(40,$x+=20, $fetchDataDoker['nama']);



$pdf->Output("I");
?>
