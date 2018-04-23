<style>
.col-sm-1
{

}

</style>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../../../config/conn.php";

$idKunjungan=$_REQUEST['id_kunjungan'];
$idPasien=$_REQUEST['idPasien'];
if(isset($_REQUEST['status']))
{
	$status=$_REQUEST['status'];
}
else
{
	$status="editOnAdd";
}


var_dump($idKunjungan);
$getResepKeterangan=pg_query("SELECT prk.*, mf.kode as kode_mf, mi.kode as kode_iterasi, k.id_pasien as id_pasien, ms.code_sediaan as codes, msd.code_detail as coded, cp.code_hts from pasien_resep_keterangan prk 
	join master_mf mf on mf.id=prk.ah 
	join master_iterasi mi on mi.id=prk.iterasi
	join cara_pakai cp on cp.id=prk.cara_pakai::integer
	join kunjungan k on k.id=prk.id_kunjungan
	left join master_sediaan ms on ms.id=prk.sediaan::integer
	left join master_sediaan_detail msd on msd.id=prk.sediaan_detail::integer
	where id_kunjungan='$idKunjungan' order by id_resep");

$getNoResep=pg_query("SELECT * from pasien_no_resep where id_kunjungan='$idKunjungan'");
$fetchNoResep=pg_fetch_assoc($getNoResep);

$getPasien=pg_query("SELECT * from master_pasien where id='$idPasien'");
$fetchPasien=pg_fetch_assoc($getPasien);


?>
<div class="card">
	<div class="card-header">
		<strong>Detail Resep</strong>
		<?php
		if(isset($_GET['afterAdd']))
		{
	
		}
		else
		{
			?>
			<a href="content/pasien/catatresep/cetakDataResep.php?idKunjungan=<?php echo $idKunjungan; ?>" target="_blank"><button class="btn btn-xs btn-primary" style="float:right">cetak resep</button></a>
			<?php
		}
		?>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12">
					<?php
					if($fetchNoResep['cito']=="Y")
					{
						?>
							<p style="float:right;border:0.5px solid red;padding:5px;color:red;">C I T O !</p>
						<?php
					}
					?>
				</div>
				<div class="col-md-12" style="border-top:2px solid black;border-bottom:2px solid black;font-size:15px;float:left">
					<center>R E S E P</center>
				</div>
			
				<?php
				
				while($fetchResepKeterangan=pg_fetch_assoc($getResepKeterangan))
				{

					$getResepOrder=pg_query("SELECT pro.*, pro.id as id_pro, me.kode as kode_satuan from pasien_resep_order pro 
						join master_me me on me.id=pro.satuan 
						where pro.id_kunjungan='$idKunjungan' and pro.id_resep='$fetchResepKeterangan[id_resep]'");
					?>
							
							<?php
							$flagStat=1;
							while($fetchResepOrder=pg_fetch_assoc($getResepOrder))
							{

								?>
								<div class="col-md-12" style="padding-top:10px;float:left;">
								<?php
								if($flagStat!=1)
								{
									?>
										<div class="col-md-1" style="float:left;border:0px solid black;">
											 
										</div>
									<?php
								}
								else
								{
									?>
										<div class="col-md-1" style="float:left;border:0px solid black;">
											R /	 
										</div>
									<?php	
								}
								?>
									<div class="col-md-3 form_nama_obat<?php echo $fetchResepOrder['id_pro']?>" style="float:left;border:0px solid black;cursor:pointer;">
										<b class="nama_obat" id='<?php echo $fetchResepOrder['id_pro'] ?>'><?php echo $fetchResepOrder['nama_brand'] ?></b>
									</div>
									<div class="col-md-1" style="float:left;border:0px solid black;">
										<b class=""><?php echo $fetchResepOrder['ket'] ?></b>
									</div>
									<div class="col-md-2 form_dosis_obat<?php echo $fetchResepOrder['id_pro']?>" style="float:left;text-align:center;cursor:pointer;">
										<b class="dosis" id='<?php echo $fetchResepOrder['id_pro'] ?>'><?php echo $fetchResepOrder['dosis'].' '.$fetchResepOrder['kode_satuan'] ?></b>
									</div>
									<div class="col-md-1 form_status_mf<?php echo $fetchResepOrder['id_pro']?>" style="float:left;cursor:pointer;">
										<?php
										if($fetchResepKeterangan['status_racikan']=="NR")
										{
											echo "<b class='status_mf' id='$fetchResepOrder[id_pro]'>$fetchResepKeterangan[kode_mf]</b>";
										}
										?>

										
									</div>
									<div class="col-md-1 form_jumlah<?php echo $fetchResepOrder['id_pro']?>" style="float:left;cursor:pointer;">
										<?php
										if($fetchResepKeterangan['status_racikan']=="NR")
										{
											echo "<b class='jumlahObat' id='$fetchResepOrder[id_pro]'>$fetchResepKeterangan[jml]</b>";
										}
										?>
									</div>
									<div class="col-md-3 form_iterasi_prk<?php echo $fetchResepKeterangan['id'] ?>" style="float:left;cursor:pointer;">
										<?php
										if($fetchResepKeterangan['status_racikan']=="NR")
										{
											echo "<b class='iterasi' id='prk$fetchResepKeterangan[id]'>$fetchResepKeterangan[kode_iterasi]</b>";
										}
										?>
									</div>
								</div>
								<?php
								$flagStat++;
							}		
							?>
				<!-- 			<button id="<?php echo $fetchResepKeterangan['id_resep'] ?>" class="btn btn-xs btn-primary edit" style="float:right;">Edit</button>
						<button id="hapus" class="btn btn-xs btn-danger" style="float:right;">Hapus</button> -->
				<div class="col-sm-12" style="margin-top:15px;float:left;">
					<div class="col-sm-1" style="float:left;">
						
					</div>
					<?php
					if($fetchResepKeterangan['status_racikan']=='R')
					{
						?>
							<div class="col-sm-1" style="float:left;width:40px;">
								m.f
							</div>
							<div class="col-sm-1" style="float:left;width:40px;">
								<?php
									echo$fetchResepKeterangan['codes'];
								?>
							</div>
							<div class="col-sm-1" style="float:left;">
								<b>
									<?php
										echo $fetchResepKeterangan['kode_mf'];
									?>
								</b>
							</div>
							<div class="col-sm-1" style="float:left;">
								<b>
									<?php
										echo $fetchResepKeterangan['jml'];
									?>
								</b>
							</div>
							<div class="col-sm-1 form_iterasi_prk<?php echo $fetchResepKeterangan['id'] ?>" style="float:left;cursor:pointer;">
									<?php
										echo "<b class='iterasi' id='prk$fetchResepKeterangan[id]'>$fetchResepKeterangan[kode_iterasi]</b>";
									?>
							</div>
								<div class="col-sm-1" style="float:left;">
								<b>
									<?php
										echo $fetchResepKeterangan['ket_subscription'];
									?>
								</b>
							</div>
							<div class="col-sm-12" style="margin-top:-20px;margin-bottom:-10px;float:left;">
								<hr />
							</div>
						<?php
					}
					?>
					
				</div>

				<div class="col-sm-12" style="margin-top:0px;float:left;">
					<div class="col-sm-1" style="float:left;">
						
					</div>
					<div class="col-sm-1" style="float:left;width:40px;">
						s
					</div>
					<div class="col-sm-1 form_xperh<?php echo $fetchResepKeterangan['id']; ?>" style="float:left;width:40px;cursor:pointer;">
						<?php
							echo "<span class='xperh' id='$fetchResepKeterangan[id]'>".$fetchResepKeterangan['xperh']."</span>";
						?>
					</div>
					<div class="col-sm-1" style="float:left;width:40px;">
						d.d
					</div>
					<div class="col-sm-1 form_operh<?php echo $fetchResepKeterangan['id'] ?>" style="float:left;width:40px;cursor:pointer;">
						<?php
							echo "<span class='operh' id='$fetchResepKeterangan[id]'>".$fetchResepKeterangan['operh']."</span>";
						?>
					</div>
					<div class="col-sm-1 form_sediaan<?php echo $fetchResepKeterangan['id'] ?>" style="float:left;width:50px;cursor:pointer;">
						<?php
							echo "<span class='sediaan' id='$fetchResepKeterangan[id]'>".$fetchResepKeterangan['coded']."</span>";
						?>
					</div>
					<div class="col-sm-1 form_carapakai<?php echo $fetchResepKeterangan['id'] ?>" style="float:left;cursor:pointer;">
						<?php
							echo "<span class='carapakai' id='$fetchResepKeterangan[id]'>".$fetchResepKeterangan['code_hts']."</span>";
						?>
					</div>
					<div class="col-sm-1 form_keterangan<?php echo $fetchResepKeterangan['id'] ?>" style="float:left;cursor:pointer;">
						<?php
							echo "<span class='keterangan' id='$fetchResepKeterangan[id]'>".$fetchResepKeterangan['ket_signa']."</span>";
						?>
					</div>
				</div>

				<hr width="100%" style="float:left;border:1px solid black;">
			<?php
		}
				?>
				


				
			</div>
		<button class="btn btn-danger btn-sm" id="back">Back</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function()
	{
		var idKunjungan="<?php echo $idKunjungan ?>";
		var idPasien="<?php echo $idPasien ?>";
		$("#back").click(function()
		{
			$("#data_pasien").load("content/pasien/catatresep/listResep.php?id=<?php echo $fetchPasien['no_rm'] ?>");
		});

		$(".nama_obat").click(function()
		{
			var idPRO=this.id;
			$(".form_nama_obat"+idPRO).html("<img src='images/load.gif' style='width:60px;'>");
			$(".form_nama_obat"+idPRO).load("content/pasien/catatresep/editObat.php?edit=namaObat&idPRO="+idPRO+'&idKunjungan='+idKunjungan+'&idPasien='+idPasien+'&status=<?php echo $status ?>');
		});

		$(".dosis").click(function()
		{

			var idPRO=this.id;
			$(".form_dosis_obat"+idPRO).html("<img src='images/load.gif' style='width:60px;'>");
			$(".form_dosis_obat"+idPRO).load("content/pasien/catatresep/editObat.php?edit=dosis&idPRO="+idPRO+'&idKunjungan='+idKunjungan+'&idPasien='+idPasien+'&status=<?php echo $status ?>');
		});
		$(".status_mf").click(function()
		{

			var idPRO=this.id;
			$(".form_status_mf"+idPRO).html("<img src='images/load.gif' style='width:60px;'>");
			$(".form_status_mf"+idPRO).load("content/pasien/catatresep/editObat.php?edit=mf&idPRO="+idPRO+'&idKunjungan='+idKunjungan+'&idPasien='+idPasien+'&status=<?php echo $status ?>');
		});
		$(".jumlahObat").click(function()
		{

			var idPRO=this.id;
			$(".form_jumlah"+idPRO).html("<img src='images/load.gif' style='width:60px;'>");
			$(".form_jumlah"+idPRO).load("content/pasien/catatresep/editObat.php?edit=jumlah&idPRO="+idPRO+'&idKunjungan='+idKunjungan+'&idPasien='+idPasien+'&status=<?php echo $status ?>');
		});
		$(".xperh").click(function()
		{

			var idPRK=this.id;
			$(".form_xperh"+idPRK).html("<img src='images/load.gif' style='width:60px;'>");
			$(".form_xperh"+idPRK).load("content/pasien/catatresep/editObat.php?edit=xperh&idPRK="+idPRK+'&idKunjungan='+idKunjungan+'&idPasien='+idPasien+'&status=<?php echo $status ?>');
		});
		$(".operh").click(function()
		{

			var idPRK=this.id;
			$(".form_operh"+idPRK).html("<img src='images/load.gif' style='width:60px;'>");
			$(".form_operh"+idPRK).load("content/pasien/catatresep/editObat.php?edit=operh&idPRK="+idPRK+'&idKunjungan='+idKunjungan+'&idPasien='+idPasien+'&status=<?php echo $status ?>');
		});
		$(".sediaan").click(function()
		{

			var idPRK=this.id;
			$(".form_sediaan"+idPRK).html("<img src='images/load.gif' style='width:60px;'>");
			$(".form_sediaan"+idPRK).load("content/pasien/catatresep/editObat.php?edit=sediaan&idPRK="+idPRK+'&idKunjungan='+idKunjungan+'&idPasien='+idPasien+'&status=<?php echo $status ?>');
		});
		$(".iterasi").click(function()
		{

			var idPRK=this.id;
			$(".form_iterasi_"+idPRK).html("<img src='images/load.gif' style='width:60px;'>");
			$(".form_iterasi_"+idPRK).load("content/pasien/catatresep/editObat.php?edit=iterasi&idPRK="+idPRK+'&idKunjungan='+idKunjungan+'&idPasien='+idPasien+'&status=<?php echo $status ?>');
		});
		$(".carapakai").click(function()
		{

			var idPRK=this.id;
			$(".form_keterangan"+idPRK).hide();
			$(".form_carapakai"+idPRK).html("<img src='images/load.gif' style='width:60px;'>");
			$(".form_carapakai"+idPRK).load("content/pasien/catatresep/editObat.php?edit=carapakai&idPRK="+idPRK+'&idKunjungan='+idKunjungan+'&idPasien='+idPasien+'&status=<?php echo $status ?>');
		});
		$(".keterangan").click(function()
		{

			var idPRK=this.id;
			$(".form_keterangan"+idPRK).html("<img src='images/load.gif' style='width:60px;'>");
			$(".form_keterangan"+idPRK).load("content/pasien/catatresep/editObat.php?edit=keterangan&idPRK="+idPRK+'&idKunjungan='+idKunjungan+'&idPasien='+idPasien+'&status=<?php echo $status ?>');
		});

	});

	$(".edit").click(function()
	{
		var idKunjungan="<?php echo $idKunjungan ?>";
		var idResep=this.id;
		$("#data_catat_resep").load("content/pasien/catatesep/editObat.php?idKunjungan="+idKunjungan+'&idResep='+idResep);
	});

</script>