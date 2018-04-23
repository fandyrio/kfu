<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "config/conn.php";
include "function_panggil.php";

$id_unit=$_SESSION['id_units'];
	if (!isset($_SESSION["loket_client"])) 
	{
		$_SESSION["loket_client"] = 0;
	}
	$getDataCetak=pg_query("SELECT max(id) as id from data_cetak_antrian");
	$fetchDataCetak=pg_fetch_assoc($getDataCetak);
	$existedId=$fetchDataCetak['id']; //10

	$getDataGenerate=pg_query("SELECT max(id) as id from data_antrian");
	$fetchDataGenerate=pg_fetch_assoc($getDataGenerate);
	$nextId=$fetchDataGenerate['id']; //15
	/*var_dump($nextId);
	var_dump($existedId);*/
	if($existedId!=NULL)
	{
		if($nextId >= $existedId)
		{
			$display="none";
		}
		else
		{
			$display="";
		}
	}
	else
	{
		$display="none";
	}


$id_users=$_SESSION['login_user'];
$id_karyawan=getKaryawan($id_users);

$checkKaryawanRoom=pg_query("SELECT * from ruang_dokter where id_karyawan='$id_karyawan' and tanggal='now()' and status='online'");
$jumlahKaryawanRoom=pg_num_rows($checkKaryawanRoom);


$checkDokterRoom=pg_query("SELECT * from ruang_dokter where  tanggal='now()' and status='online' and id_jabatan=1");
$fetchDokterRoom=pg_fetch_assoc($checkDokterRoom);
$jumlahDokter=pg_num_rows($checkDokterRoom);
?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item">Panggil Antrian</li>
</ol>
<?php

	if($jumlahKaryawanRoom==0)
	{
		echo "<div class='col-md-12 btn btn-danger btn-sm'>Anda belum terdaftar di ruang mana pun, klinik <button class='btn btn-primary btn-xs' data-toggle='modal' data-target='#myModal'>disini</button> untuk memilih ruangan</div>";
	}
	else
	{
		if($jumlahDokter==0)
		{
			echo "<div class='col-md-12 btn btn-danger btn-sm'>Belum ada dokter yang login diruangan ini</div>";
		}		
	}
?>

<div class="modal fade" id="myModal" style="z-index:9999;">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Pilih Ruangan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" >
      	<div class="alert alert-info" id="notif" style="display:none;">
  			
		</div>
        <?php
        	showRoom($id_unit, $id_karyawan);
        ?>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
 </div>

<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card ">
        <div class="card-header">
            <i class="icon-user"></i> Antrian
          </div>

<div class="row justify-content-center">
	<div class="col-sm-3">
		<div class="card">
			<div class="card-header ruangan">
				<?php
				
				if($jumlahDokter==0)
				{
					echo "-";
					$status="disabled";
				}
				else
				{
					$status="enabled";
					$fetchDataRoom=pg_fetch_assoc($checkKaryawanRoom);
					echo $fetchDataRoom['nama_ruangan'];
				}
				?>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<h2 class="text-center no_antrian">
							<?php
								if($jumlahKaryawanRoom==0)
								{
									echo "0";
								}
								else
								{

									getMinNoAntrian($id_karyawan,$id_unit);
								}

							?>
						</h2>
					</div>
				</div>
				<hr />
				<center>
					<button class="btn btn-sm btn-primary" id="call" <?php echo $status ?>>Call <i class="fa fa-volume-up"></i></button>
					<button class="btn btn-sm btn-success" id="next" <?php echo $status ?>>Next <i class="fa fa-angle-double-right"></i></button>
				</center>
				
			</div>
		</div>
	</div>	
     </div>
    </div>
   </div>
  </div>   
 </div>
</div>

  	
  	<script type="text/javascript">
	$("document").ready(function()
	{
		$("#call").click(function()
		{
			var no_antrian=parseInt($(".no_antrian").text());
			var idUnit=parseInt("<?php echo $id_unit ?>");
			var ruangan="<?php echo $fetchDataRoom['nama_ruangan']; ?>";
			var idDokter="<?php echo $id_karyawan ?>";
			$("#call").prop("readonly", true);
			$.ajax(
			{
				url:'monitor/sound.php',
				data:{no_antrian:no_antrian,idUnit:idUnit, ruangan:ruangan, idDokter:idDokter},
				type:'POST',
				success:function(result)
				{
					alert(result);
				},
				error:function()
				{
					alert("E");
				}
			});

		});

		$("#next").click(function()
		{
			var idUnit=parseInt("<?php echo $id_unit ?>");
			var ruangan="<?php echo $fetchDataRoom['nama_ruangan']; ?>";
			var idDokter="<?php echo $id_karyawan ?>";
			var method="getMinNoAntrianNext";
			$.ajax(
			{
				url:'queue/client/function_panggil.php',
				data:{idDokter:idDokter, idUnit:idUnit, method:method},
				type:'POST',
				success:function(result)
				{
					$(".no_antrian").html(result);
				},
				error:function()
				{
					alert("Error Next");
				}
			});
		});
	});
	</script>

