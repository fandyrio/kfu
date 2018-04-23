<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require('../../../../fpdf/fpdf.php');
include "../../../../config/conn.php";
include "../../../../config/library.php";
include "../../../../config/fungsi_tanggal.php";

$images="../../../../images/klinik_pratama.jpg";
$imagesCC="../../../../images/cc.png";



$idPasien=$_GET['idPasien'];
$idDokter=$_GET['id_dokter'];
//$tujuan=$_GET['tujuan_surat'];
$diBuatDi=$_GET['dibuat_di'];

$idUnit=$_SESSION['id_units'];
$getUnitInfo=pg_fetch_assoc(pg_query("SELECT * from master_unit where id='$idUnit'"));
$kodeUnit=$getUnitInfo['kode'];

$getDataPasien=pg_query("SELECT mps.* from master_pasien mps where mps.id='$idPasien'");
$fetchDataPasien=pg_fetch_assoc($getDataPasien);

$getDataDoker=pg_query("SELECT * from master_karyawan where id='$idDokter'");
$fetchDokter=pg_fetch_assoc($getDataDoker);

$getDataAntrian=pg_query("SELECT * from kunjungan where id_pasien='$idPasien' and status_kunjungan='Y'");
$fetchDataAntrian=pg_fetch_assoc($getDataAntrian);


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
$tanggal_lahir_format=date('d F Y', strtotime($fetchDataPasien['tanggal_lahir']));
$tgl_sekarang=date_create();
	
$diff=date_diff($tanggal_lahir,$tgl_sekarang);
//echo"$diff[y] tahun, $diff[m] bulan, $diff[d] hari";

$namaPasien=$fetchDataPasien['nama'];
$tempaTanggaLahir=$fetchDataPasien['tempat_lahir'];
$umurPasien=$diff->y;
$alamatPasien=$fetchDataPasien['alamat'];
$hasil="SEHAT JASMANI";

	$butaWarna="Negatif";
	$tanggal=date('d F Y');
	$jam=date('h:i:s');
	$timeStamp=$tanggal.' '.$jam;


$uniqueName=date('d').date('m').date('Y').$idPasien.date('h').date('i').date('s');
$namaFile="informConsent".$uniqueName.".pdf";



$thisYear=date('Y');
$thisMonth=date('m');
$getMaxId=pg_query("SELECT count(id) as jumlah from inform_consent_list where extract(month from created_at::TIMESTAMP)='$thisMonth' and extract(year from created_at::TIMESTAMP)='$thisYear'");
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
$noSurat='INFCONS/'.$kodeUnit.'/'.$thisMonth.'/'.$thisYear.'/'.$runningNumber;


$insertDokumen=pg_query("INSERT into inform_consent_list (id_kunjungan, no_surat,create_by,created_at,dibuat_di,id_pasien,nama_file)
	values('$fetchDataAntrian[id]','$noSurat', '$idDokter','$timeStamp', '$diBuatDi', '$idPasien','$namaFile');
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
$pdf->SetTextColor(256,256,256);
$pdf->SetFont('Arial','B',16);
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
$pdf->Text(50,50,'SURAT PERSETUJUAN/PENOLAKAN MEDIS KHUSUS');
$pdf->SetFont('Arial','',11);
$pdf->Text(30,60,'Saya yang bertanda tangan dibawah ini:');

$x=68;
$pdf->Text(40,68, 'Nama');
$pdf->Text(80,68,":");
$pdf->Text(85,68,$namaPasien);
$pdf->Text(40,$x+=5, 'Jenis Kelamin');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$jenisKelamin);
$pdf->Text(40,$x+=5, 'Tempat / Tanggal Lahir');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$tempaTanggaLahir.' / '.$tanggal_lahir_format);
$pdf->Text(40,$x+=5, 'Umur');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$umurPasien." Tahun");
$pdf->Text(40,$x+=5, 'Alamat');
$pdf->Text(80,$x,":");
$pdf->setXY(84,$x-3);
$pdf->MultiCell(110,5,$alamatPasien,0,'L',false);
$pdf->Text(40,$x+=8, 'Telp');
$pdf->Text(80,$x,":");
$pdf->Text(85,$x,$fetchDataPasien['no_handphone']);

$pdf->setXY(30,$x+=10);
$pdf->MultiCell(150,5,"Dengan ini menyatakan SETUJU / MENOLAK untuk dilakukan Tindakan Medis berupa _________________________________________________________
Dari penjelasan yang diberikan, telah saya mengerti segala hal yang berhubungan dengan penyakit tersebut, serta tindakan medis yang akan dilakukan dan
kemungkinan pasca tindakan yang dapat terjadi sesuai phpenjelasan yang diberikan.
",0,'L',false);






$pdf->SetFont('Arial','', 11);
$pdf->Text(150,$x+=50,$diBuatDi.', '.$tanggal);

$pdf->Text(30,$x+=10,"Dokter Pelaksana");
$pdf->Text(145,$x,"Yang membuat pernyataan");

$pdf->SetFont('Arial','UB', 11);
$pdf->Text(30,$x+=25,$namaDokter);
$pdf->Text(145,$x,$namaPasien);

$pdf->Cell( 40, 20, $pdf->Image($imagesCC, 10, $x+=3, 60), 0, 0, 'L', false );

//$pdf->Output();
$pdf->Output("../dokumen_surat/".$namaFile,"F");
?>