<?php
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}
else{
	include "../../../config/conn.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_tanggal.php";

	$module=$_GET['module'];
	$act=$_GET['act'];

	$id_pasien = $_POST['id_pasien'];
	$id_antrian=$_POST['id_antrian'];

	$getDataAntrian=pg_query("SELECT * from antrian where id='$id_antrian'");
	$fetchAntrian=pg_fetch_assoc($getDataAntrian);

	$id_kunjungan = $fetchAntrian[id_kunjungan];
	$no_rm = $_POST[no_rm];
/*
	var_dump($id_kunjungan);
	var_dump($id_pasien);
	var_dump($no_rm);*/
	/*var_dump($id_kunjungan);*/
	$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm'"));
if($d['jenkel']==1){
	$jenkel="<i class='icon-symbol-male'></i>";
}
else{
	$jenkel="<i class='icon-symbol-female'></i>";
}

if($d['foto']!=''){
	$foto="images/pasien/upload_$d[foto]";
}
else{
	$foto="images/default.png";
}

$id_pasien=$d['id'];


$a=pg_fetch_array(pg_query($dbconn,"SELECT id_kunjungan FROM antrian WHERE id_pasien='$id_pasien' AND status_aktif='Y'"));
$id_kunjungan=$a['id_kunjungan'];
	if ($module=='hasillab' AND $act=='view')
	{
		
		$anamnesa= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_anamnesa where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' and status_hapus='N'"));

		$fisik= pg_fetch_assoc(pg_query($dbconn, "SELECT * FROM pasien_fisik where id_pasien='$_POST[id_pasien]' and id_kunjungan='$_POST[id_kunjungan]' and id_unit= '$_SESSION[id_units]' and status_hapus='N'"));

	}
	?>
	<div class="card">
	<div class="card-header">
			<strong>Resume hasil</strong>
			<span class="pull-right">
			</span>
			<a href="data/phr.php?id=<?php echo $_POST['no_rm']; ?>"><button class="btn btn-sm btn-primary" style="float:right;">Sync PHR</button></a>
		</div>
	
		<div class="col-md-12 card-body">
			<table>	
				<tbody>
					<tr>
						<td width="100px">Nama</td>
						<td><b><?php echo $d['nama'];?></b></td>
					</tr>
					<tr>
						<td >Jenis Kelamin</td>
						<td><b><?php echo $jenkel;?></b></td>
					</tr>
					<tr>
						<td>Tgl Lahit</td>
						<td><?php echo "$d[tanggal_lahir]";?></td>
					</tr>
					<tr>
						<td>No RM</td>
						<td><?php echo $d['no_rm'];?></td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>
<div id="accordion" role="tablist">
  <div class="card">
    <div class="card-header" role="tab" id="headingOne">
      <h6 class="mb-0">
        <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
         Subjective
        </a>
      </h6>
    </div>
    
    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body" id="subjective">
       
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingTwo">
      <h6 class="mb-0">
        <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
         Objective
        </a>
      </h6>
    </div>
    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body" id="objective">
      <!--  -->

		
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" role="tab" id="headingThree">
      <h6 class="mb-0">
        <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
         Assesment
        </a>
      </h6>
    </div>
    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body" id="assesment">
       
      </div>
    </div>
  </div>

   <div class="card">
    <div class="card-header" role="tab" id="heading4">
      <h6 class="mb-0">
        <a class="collapsed" data-toggle="collapse" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
         Planning
        </a>
      </h6>
    </div>
    <div id="collapse4" class="collapse" role="tabpanel" aria-labelledby="heading4" data-parent="#accordion">
      <div class="card-body" id="planning">
       
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	var id_pasien = "<?php echo $id_pasien ?>";
	var id_kunjungan = "<?php echo $id_kunjungan ?>";
	var no_rm = "<?php echo $no_rm ?>";
	$("#subjective").load('content/pasien/hasilfisik/dataSubjective.php?id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&no_rm='+no_rm);
	$("#assesment").load('content/pasien/hasilfisik/dataAssesment.php?id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&no_rm='+no_rm);
	$("#planning").load('content/pasien/hasilfisik/dataPlanning.php?id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&no_rm='+no_rm);
	$("#objective").load('content/pasien/hasilfisik/dataObjective.php?id_pasien='+id_pasien+'&id_kunjungan='+id_kunjungan+'&no_rm='+no_rm);

</script>


<?php

}
?>