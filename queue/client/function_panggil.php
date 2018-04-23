<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function showRoom($idUnit, $id_karyawan)
{
	$checkPoly=pg_fetch_assoc(pg_query("SELECT poly_id, id_jabatan from master_karyawan where id='$id_karyawan'"));
	$idPoly=$checkPoly['poly_id'];
	$id_jabatan=$checkPoly['id_jabatan'];

	$getRoom=pg_query("SELECT ru.*, mp.name, mp.id as poly from ruang_unit ru
	join master_poly mp on mp.id=ru.poly
	 where ru.id_unit='$idUnit'");

	while($fetchRoom=pg_fetch_assoc($getRoom))
	{
		$jumlah=$fetchRoom['jumlah'];
		for($x=1;$x<=$jumlah;$x++)
		{
			$check=pg_query("SELECT * from ruang_dokter where nama_ruangan='$fetchRoom[name]-$x' and id_unit='$idUnit' and status='online' and id_jabatan=1");

			$jumlahCheck=pg_num_rows($check);

			if($jumlahCheck>=1)
			{
				$status="disabled";
			}
			else
			{
				$status="enabled";
			}

			?>
				<div class="card <?php echo $status ?>" style="cursor:pointer;" poly="<?php echo $fetchRoom['poly']?>" id="<?php echo $fetchRoom['name'].'-'.$x ?>">
					<div class="card-header">
						<?php echo "Ruangan ".$fetchRoom['name'].' - '.$x ?>
					</div>
				</div>
			<?php
		}
	}

	?>
	<script type="text/javascript">
	$(document).ready(function()
	{
		$(".enabled").click(function()
		{
			var id=this.id;
			var nama_ruangan=id;
			var idKaryawan="<?php echo $id_karyawan;?>";
			var id_unit="<?php echo $idUnit ?>";
			var id_poly="<?php echo $idPoly ?>";
			var list_poly=$(this).attr("poly");
			var id_jabatan="<?php echo $id_jabatan ?>";

			if((list_poly===id_poly && id_jabatan==1) || (list_poly!=id_poly && id_jabatan==3))
			{
				$.ajax(
				{
					beforeSend:function()
					{
						$("#"+id).html("<img src='images/load.gif' style='width:80px;'>");
					},
					url:'queue/client/saveDokterRoom.php',
					data:{nama_ruangan:nama_ruangan, idKaryawan:idKaryawan, id_unit:id_unit},
					type:'POST',
					success:function()
					{
						location.reload();
					},
					error:function()
					{
						alert("ERROR");
					}
				});
			}
			else
			{
				$("#notif").html("<strong>Info!</strong> Poly tidak cocok.").show("slow");
				setInterval(function(){ $("#notif").hide("slow"); }, 5000);
			}
			
		});
		$(".disabled").click(function()
		{
			$("#notif").html("<strong>Info!</strong> Ruangan ini masih digunakan oleh dokter lain.").show("slow");
			setInterval(function(){ $("#notif").hide("slow"); }, 5000);
		});
	});
	</script>
	<?php
}

function getMinNoAntrian($idDokter, $idUnit)
{
	
	date_default_timezone_set("Asia/Jakarta");

	$getIdDokter=pg_query("SELECT id_karyawan from ruang_dokter where id_unit='$idUnit' and id_jabatan=1 and status='online'");
	$fetchDokter=pg_fetch_assoc($getIdDokter);
	$idDokter=$fetchDokter['id_karyawan'];

	$today=date("Y-m-d");
	$getDataAntrian=pg_query("SELECT 
		(select min(no_cetak_antrian) as no_cetak_antrian 
		from antrian a
		join panggil_antrian pa on pa.id_antrian=a.id
		 where
		  (a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_unit='$idUnit' and pa.called='N' and a.status_aktif='Y' and a.status_antrian='Y' and pa.status='N' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and a.id_dokter='$idDokter')
		  or
		  (a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_unit='$idUnit' and pa.called='N' and a.status_aktif='Y' and a.status_antrian='Y' and pa.status='N' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and a.id_dokter='')

		  ), mp.nama, a.id_dokter from antrian a 
		join panggil_antrian pa on pa.id_antrian=a.id 
		join master_pasien mp on mp.id=a.id_pasien::integer
		where (a.status_antrian='Y' and a.status_aktif='Y' and a.id_unit='$idUnit' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and pa.called='N' and pa.status='N' and a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_dokter='$idDokter') or
			(a.status_antrian='Y' and a.status_aktif='Y' and a.id_unit='$idUnit' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and pa.called='N' and pa.status='N' and a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_dokter='')
		  order by a.id asc LIMIT 1");

	

	$jumlah=pg_num_rows($getDataAntrian);
	$fetchDataAntrian=pg_fetch_array($getDataAntrian);
	
	if($fetchDataAntrian['no_cetak_antrian']=="")
	{
		$getDataAntrian=pg_query("SELECT (select max(no_cetak_antrian) as no_cetak_antrian 
		from antrian a
		join panggil_antrian pa on pa.id_antrian=a.id
		 where (a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_unit='$idUnit' and pa.called='Y' and a.status_aktif='Y' and a.status_antrian='Y' and pa.status='Y' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and a.id_dokter='$idDokter')
		 or
		 (a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_unit='$idUnit' and pa.called='Y' and a.status_aktif='Y' and a.status_antrian='Y' and pa.status='Y' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and a.id_dokter='')

		 ), nama from antrian a 
		join panggil_antrian pa on pa.id_antrian=a.id 
		join master_pasien mp on mp.id=a.id_pasien::integer
		where a.status_antrian='Y' and a.status_aktif='Y' and a.id_unit='$idUnit' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and pa.called='Y' and pa.status='Y' and a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_dokter='$idDokter' and no_cetak_antrian=(select max(no_cetak_antrian) from antrian where id_dokter='$idDokter' and waktu_masuk >= (now()::date)::varchar || ' 00:00:00')
	/*	or
			(a.status_antrian='Y' and a.status_aktif='Y' and a.id_unit='$idUnit' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and pa.called='Y' and pa.status='Y' and a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_dokter='' )*/

		 order by a.id asc LIMIT 10");

		
		$fetchDataAntrian=pg_fetch_assoc($getDataAntrian);
		echo $fetchDataAntrian['no_cetak_antrian']."<br />";

		echo "<p style='font-size:12px;'>Nama : ".$fetchDataAntrian['nama']."D</p>";
		echo "<p style='font-size:12px;'>Sudah dipanggil</p>";
	}
	else
	{
		if($fetchDataAntrian['id_dokter']=="")
		{
			echo $fetchDataAntrian['no_cetak_antrian']."<br />";
			echo "<font size='2px'>Nama : ".$fetchDataAntrian['nama']."C</font>";	
		}
		else
		{
			if($fetchDataAntrian['id_dokter']==$idDokter)
			{
				echo $fetchDataAntrian['no_cetak_antrian']."<br />";
				echo "<font size='2px'>Nama : ".$fetchDataAntrian['nama']."B</font>";	
			}
			else
			{
				$getDataAntrian=pg_query("SELECT 
					(select min(no_cetak_antrian) as no_cetak_antrian 
					from antrian a
					join panggil_antrian pa on pa.id_antrian=a.id
					 where
					  (a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_unit='$idUnit' and pa.called='N' and a.status_aktif='Y' and a.status_antrian='Y' and pa.status='N' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and a.id_dokter='$idDokter')
					  or
					  (a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_unit='$idUnit' and pa.called='N' and a.status_aktif='Y' and a.status_antrian='Y' and pa.status='N' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and a.id_dokter='')

					  ), mp.nama, a.id_dokter from antrian a 
					join panggil_antrian pa on pa.id_antrian=a.id 
					join master_pasien mp on mp.id=a.id_pasien::integer
					where (a.status_antrian='Y' and a.status_aktif='Y' and a.id_unit='$idUnit' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and pa.called='N' and pa.status='N' and a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_dokter='$idDokter')

					or

					(a.status_antrian='Y' and a.status_aktif='Y' and a.id_unit='$idUnit' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and pa.called='N' and pa.status='N' and a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_dokter='')

					 order by a.id asc LIMIT 1");
				$fetchDataAntrian=pg_fetch_assoc($getDataAntrian);
				echo $fetchDataAntrian['no_cetak_antrian']."<br />";
				echo "<font size='2px'>Nama : ".$fetchDataAntrian['nama']."A</font>";	
			}
		}

		
	}
}

function getMinNoAntrianNext($idDokter, $idUnit)
{
	date_default_timezone_set("Asia/Jakarta");
	include "../../config/conn.php";
	$getIdDokter=pg_query("SELECT id_karyawan from ruang_dokter where id_unit='$idUnit' and id_jabatan=1 and status='online'");
	$fetchDokter=pg_fetch_assoc($getIdDokter);
	$idDokter=$fetchDokter['id_karyawan'];

	$today=date("Y-m-d");
	$getDataAntrian=pg_query("SELECT 
		(select min(no_cetak_antrian) as no_cetak_antrian 
		from antrian a
		join panggil_antrian pa on pa.id_antrian=a.id
		 where
		  (a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_unit='$idUnit' and pa.called='N' and a.status_aktif='Y' and a.status_antrian='Y' and pa.status='N' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and a.id_dokter='$idDokter')
		  or
		  (a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_unit='$idUnit' and pa.called='N' and a.status_aktif='Y' and a.status_antrian='Y' and pa.status='N' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and a.id_dokter='')

		  ), mp.nama, a.id_dokter from antrian a 
		join panggil_antrian pa on pa.id_antrian=a.id 
		join master_pasien mp on mp.id=a.id_pasien::integer
		where (a.status_antrian='Y' and a.status_aktif='Y' and a.id_unit='$idUnit' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and pa.called='N' and pa.status='N' and a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_dokter='$idDokter') or
			(a.status_antrian='Y' and a.status_aktif='Y' and a.id_unit='$idUnit' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and pa.called='N' and pa.status='N' and a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_dokter='')
		  order by a.id asc LIMIT 1");

	

	$jumlah=pg_num_rows($getDataAntrian);
	$fetchDataAntrian=pg_fetch_array($getDataAntrian);
	
	if($fetchDataAntrian['no_cetak_antrian']=="")
	{
		$getDataAntrian=pg_query("SELECT (select max(no_cetak_antrian) as no_cetak_antrian 
		from antrian a
		join panggil_antrian pa on pa.id_antrian=a.id
		 where (a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_unit='$idUnit' and pa.called='Y' and a.status_aktif='Y' and a.status_antrian='Y' and pa.status='Y' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and a.id_dokter='$idDokter')
		 or
		 (a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_unit='$idUnit' and pa.called='Y' and a.status_aktif='Y' and a.status_antrian='Y' and pa.status='Y' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and a.id_dokter='')

		 ), nama from antrian a 
		join panggil_antrian pa on pa.id_antrian=a.id 
		join master_pasien mp on mp.id=a.id_pasien::integer
		where a.status_antrian='Y' and a.status_aktif='Y' and a.id_unit='$idUnit' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and pa.called='Y' and pa.status='Y' and a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_dokter='$idDokter' and no_cetak_antrian=(select max(no_cetak_antrian) from antrian where id_dokter='$idDokter' and waktu_masuk >= (now()::date)::varchar || ' 00:00:00')
	/*	or
			(a.status_antrian='Y' and a.status_aktif='Y' and a.id_unit='$idUnit' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and pa.called='Y' and pa.status='Y' and a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_dokter='' )*/

		 order by a.id asc LIMIT 10");

		
		$fetchDataAntrian=pg_fetch_assoc($getDataAntrian);
		echo $fetchDataAntrian['no_cetak_antrian']."<br />";

		echo "<p style='font-size:12px;'>Nama : ".$fetchDataAntrian['nama']."D</p>";
		echo "<p style='font-size:12px;'>Sudah dipanggil</p>";
		echo "<p class='btn btn-danger btn-xs'>Tidak ada pasien lagi !</p>";
	}
	else
	{
		if($fetchDataAntrian['id_dokter']=="")
		{
			echo $fetchDataAntrian['no_cetak_antrian']."<br />";
			echo "<font size='2px'>Nama : ".$fetchDataAntrian['nama']."C</font>";	
		}
		else
		{
			if($fetchDataAntrian['id_dokter']==$idDokter)
			{
				echo $fetchDataAntrian['no_cetak_antrian']."<br />";
				echo "<font size='2px'>Nama : ".$fetchDataAntrian['nama']."B</font>";	
			}
			else
			{
				$getDataAntrian=pg_query("SELECT 
					(select min(no_cetak_antrian) as no_cetak_antrian 
					from antrian a
					join panggil_antrian pa on pa.id_antrian=a.id
					 where
					  (a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_unit='$idUnit' and pa.called='N' and a.status_aktif='Y' and a.status_antrian='Y' and pa.status='N' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and a.id_dokter='$idDokter')
					  or
					  (a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_unit='$idUnit' and pa.called='N' and a.status_aktif='Y' and a.status_antrian='Y' and pa.status='N' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and a.id_dokter='')

					  ), mp.nama, a.id_dokter from antrian a 
					join panggil_antrian pa on pa.id_antrian=a.id 
					join master_pasien mp on mp.id=a.id_pasien::integer
					where (a.status_antrian='Y' and a.status_aktif='Y' and a.id_unit='$idUnit' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and pa.called='N' and pa.status='N' and a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_dokter='$idDokter')

					or

					(a.status_antrian='Y' and a.status_aktif='Y' and a.id_unit='$idUnit' and a.id_poly::integer=(SELECT mp.id from master_karyawan mk join master_poly mp on mp.id=mk.poly_id where mk.id='$idDokter') and pa.called='N' and pa.status='N' and a.waktu_masuk >= (now()::date)::varchar || ' 00:00:00' and a.id_dokter='')

					 order by a.id asc LIMIT 1");
				$fetchDataAntrian=pg_fetch_assoc($getDataAntrian);
				echo $fetchDataAntrian['no_cetak_antrian']."<br />";
				echo "<font size='2px'>Nama : ".$fetchDataAntrian['nama']."A</font>";	
			}
		}

		
	}
}

function getKaryawan($idUsers)
{
	$getKaryawan=pg_query("SELECT * from auth_users where id_users=$idUsers");
	$fetchKaryawan=pg_fetch_assoc($getKaryawan);
	$idKaryawan=$fetchKaryawan['id_karyawan'];
	return $idKaryawan;
	//echo $idKaryawan;
}

if(isset($_POST['method']))
{
	$idUnit=$_POST['idUnit'];
	$idDokter=$_POST['idDokter'];
	$method=$_POST['method'];
	$method($idDokter, $idUnit);
}
?>
