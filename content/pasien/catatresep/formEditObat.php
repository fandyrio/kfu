<?php
include "../../../config/conn.php";
$id=$_GET['id'];
$idResep=$_GET['idResep'];
$numberOfResep=$_GET['numberOfResep'];
$idPasien=$_GET['idPasien'];
$idKunjungan=$_GET['idKunjungan'];
?>
<form id="medicine">
					<table class="table" id="<?php echo $id;?>">
						<thead class="table-secondary">
							<tr>
								<th></th>
								<th width="200px">Nama Obat</th>
								<th width="50px" style="display:none;">Ket.</th>
								<th><center>Dosis Pasien / Satuan</center></th>
								<th></th>
								<th></th>
								<th class='not_for_racikan'><span>JML</span></th>
								<th></th>
								<th class='not_for_racikan'>Iterasi</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<?php
									$getDataObat=pg_query("SELECT * from pasien_resep_order where pro.id_kunjungan='$idKunjungan'");
									$getDataKeterangan=pg_query("SELECT * from pasien_resep_keterangan where id_kunjungan='$idKunjungan'");
									$fetchDataKeterangan=pg_fetch_assoc($getDataKeterangan);
									while($fetchDataObat=pg_fetch_array($getDataObat))
									{
										?>
											<td width="50px">Prescription</td>
											<td><?php echo $fetchDataObat['nama_brand'] ?></td>
										<?php
									}
								?>
							</td>
							<tr >
								<td width="50px">Prescription</td>
								<td>
									<input type="text" class="from-control first toClear obat obat0" id="0" style="width:200px;" name="namaObat0">
									<input type="" class="from-control" style="width:200px;" name="noUrut" value="0" id="noUrut">
									<input type="" class="from-control" style="width:200px;" name="idResep0" value="<?php echo $idResep ?>">
									<input type="" class="from-control" style="width:200px;" name="idPasien" value="<?php echo $idPasien; ?>">
									<input type="" class="from-control" style="width:200px;" name="idKunjungan" value="<?php echo $idKunjungan ?>">
									<input type="" class="from-control toClear first obat idobat0" id="id_obat" style="width:200px;" name="idObat0">
									<input type="" class="from-control toClear first" id="stockObat0" style="width:200px;" name="stockObat0">
									<div id="resultObat0" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:200px;padding:3px;display:none;z-index:10"></div>
								</td>
								<td style="display:none;"><input type="hidden" class="from-control toClear first" id="keterangan" name="keterangan0" style="width:50px;"></td>
								<td><center><input type="text" class="from-control toClear first" id="dosis" name="dosis0" style="width:50px;">
									<select name="satuan0" id='satuan0' class="first">
										<?php
											$getSatuan=pg_query("SELECT * from master_me");
											while($fetchSatuan=pg_fetch_assoc($getSatuan))
											{
												echo"<option value='$fetchSatuan[id]'>$fetchSatuan[kode]</option>";
											}
										?>
									<select>
								</center></td>
								<td>
									<!-- <input type="text" class="from-control first" id="satuan" style="width:50px;"> -->
									
								</td>
								<td>
									<!-- <input type="text" class="from-control first" id="ah" style="width:50px;"> -->
									<?php
										$getAh=pg_query("SELECT * from master_mf");
										$fetchAh=pg_fetch_assoc($getAh);
										echo "<span class='not_for_racikan'>".$fetchAh['kode']."</span>";
									?>
									

								</td>
								<td id="jmlObat"><input type="text" class="from-control first jmlObat0 jumlah" checkTo="stockObat0" id="jml0" name="jumlahObat" placeholder="Jlh" style="width:50px;"></td>
								<td>
									<button class="btn btn-primary btn-xs addObat" noUrut="0" id="addObat0"><i class="icon-plus"></i></button>
									<button class="btn btn-primary btn-xs" id="editFirst" style="display:none;"><i class="icon-note"></i></button>
									<button class="btn btn-primary btn-xs" id="updateFirst" style="display:none;">Update</button>
								</td>
								
								<td id="iterasiObat0">
									<select name="iterasi" id="iterasi">
										<?php
											$getIter=pg_query("SELECT * from master_iterasi order by id desc");
											while($fetchIterasi=pg_fetch_assoc($getIter))
											{
												echo"<option value='$fetchIterasi[id]'>$fetchIterasi[kode]</option>";	
											}
											
										?>
									</select>
								</td>
							
							</tr>

						
							<?php
							for($x=1;$x<=10;$x++)
							{
							?>
							<tr class="prescription" id="<?php echo $x; ?>">
								<td width="50px">Prescription</td>
								<td>
									<input type="text" class="from-control toClear first obat obat<?php echo $x ?>" id="<?php echo $x ?>" style="width:200px;" name="namaObat<?php echo $x ?>">
									<input type="hidden" class="from-control first obat idobat<?php echo $x; ?>" id="id_obat" style="width:200px;" name="idObat<?php echo $x ?>">
									<input type="hidden" class="from-control first" id="stockObat<?php echo $x ?>" style="width:200px;" name="stockObat<?php echo $x ?>">
									<div id="resultObat<?php echo $x; ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:200px;padding:3px;display:none;z-index:10"></div>
								</td>
								<td style="display:none;"><input type="hidden" name="keterangan<?php echo $x ?>" class="from-control keterangan keterangan<?php echo $x ?> <?php echo $x ?>" id="<?php echo $x ?>" style="width:50px;"></td>
								<td>
									<center>
										<input type="text" name="dosis<?php echo $x ?>" class="from-control dosis dosis<?php echo $x ?> <?php echo $x ?>" id="<?php echo $x ?>" style="width:50px;">
										<select name="satuan<?php echo $x; ?>" id='satuan<?php echo $x; ?>' class="from-control satuan satuan<?php echo $x ?> <?php echo $x ?>" id="<?php echo $x ?>">
											<?php
												$getSatuan=pg_query("SELECT * from master_me");
												while($fetchSatuan=pg_fetch_assoc($getSatuan))
												{
													echo"<option value='$fetchSatuan[id]'>$fetchSatuan[kode]</option>";
												}
											?>
										<select>
									</center>
								</td>
								<td>
									<!-- <input type="text" class="from-control satuan satuan<?php echo $x ?> <?php echo $x ?>" id="<?php echo $x ?>" style="width:50px;"> -->
									
								</td>
								<td>
									<!-- <input type="text" class="from-control ah ah<?php echo $x ?> <?php echo $x ?>" id="<?php echo $x ?>" style="width:50px;"> -->
									<!-- <select name="satuan" id='ah' class="from-control ah ah<?php echo $x ?> <?php echo $x ?>" id="<?php echo $x ?>">
										<?php
											$getSatuan=pg_query("SELECT * from master_mf");
											while($fetchSatuan=pg_fetch_assoc($getSatuan))
											{
												echo"<option value='$fetchSatuan[id]'>$fetchSatuan[kode]</option>";
											}
										?>
									<select> -->

								</td>
								<td><!-- <input type="text" class="from-control jml jml<?php echo $x ?> <?php echo $x ?>" id="<?php echo $x ?>" style="width:50px;" placeholder="<?php echo $x; ?>"> --></td>
								<td>
									<button class="btn btn-primary btn-xs addLoop act<?php echo $x ?> addObat" id="<?php echo $x; ?>"><i class="icon-plus"></i></button>
									<button class="btn btn-primary btn-xs edit edit<?php echo $x ?>" id="<?php echo $x ?>" style="display:none;"><i class="icon-note"></i></button>
								</td>
								<td>
									<button class='btn btn-xs btn-danger delete act<?php echo $x?>' id='<?php echo $x;?>'><i class="icon-trash"></i></button>
									<button class="btn btn-primary btn-xs update update<?php echo $x ?>" id="<?php echo $x ?>" style="display:none;">Update</button>
								</td>
								
							</tr>
							
							<?php
							}
							?>

						</tbody>
					</table>
					</form>



					<form class="formKeterangan">
					<table class="table" border="1" style="width:500px;">
										<thead class="table-secondary">
											
										
										</thead>

										<tbody>
											<tr>
												<td rowspan="2"><span style='margin-top:50px;'>Subscription</span></td>
												<td></td>
												<td style="width:20px;" colspan="4"><center>Sediaan</center></td>
												<td class="subShow">AH</td>
												<td class="subShow">JML</td>
												<td class="subShow">Iterasi</td>
												<td style="width:20px;"><center>KET +</center></td>
											</tr>
											<tr>
												
												<td>
													<input type="text" class="from-control" id='mf' style="width:30px;"  readonly>
													<input type="hidden" class="from-control" style="width:200px;" name="idKunjungan" value="<?php echo $idKunjungan ?>">
													<input type="hidden" class="form-control" style="width:200px;" name="status_racikan" id="status_racikan" value="NR">
													<input type="hidden" name="iterasiLabel" id="iterasiLabel" value="6">
													<input type="hidden" name="jumlahObat" class="jumlahObat">
													<input type="hidden" name="ah" class="ah" value="1">
													
												</td>
												<td style="width:100%;" colspan="4">
													<input type="text" style="width:100%" class="from-control ketResep sediaan" id='sediaan<?php echo $id  ?>' name="sediaan" placeholder='sediaan'>
													<input type="hidden" name="idSediaan" class="idSediaan" value="0">
													<div class="sediaanList" id="hasil_sediaan<?php echo $id ?>" style="position:absolute;background:white;border:0px solid black;cursor:pointer;width:150px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td class="forResep subShow">
													<!-- <input type="text" class="from-control ah ah<?php echo $x ?> <?php echo $x ?>" id="<?php echo $x ?>" style="width:50px;"> -->
													<select name="ahKet0" id='ah' class="from-control ah ahKet" id="ah0">
													<?php
														$getSatuan=pg_query("SELECT * from master_mf");
														while($fetchSatuan=pg_fetch_assoc($getSatuan))
														{
															echo"<option value='$fetchSatuan[id]'>$fetchSatuan[kode]</option>";
														}
													?>
												<select>

												</td>
												<td class="forResep subShow moveFromTop">
													<!-- <input type="text" name="jml_subs0" class="from-control jml jmlResep0" id="jml_10" style="width:50px;"> -->
												</td>
												<td id="iterRacikan0" style="display:none;">

												</td>
												<td><input type="text" class="from-control forResep mh K5" id='K510' style="width:40px;" name="ketSubscription" placeholder='ket +'>
													<div id="resultK510" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
											</tr>

											<tr>
												<td rowspan="2">Signatura</td>
												<td></td>
										
												<td style="width:20px;" colspan='3'><center>Aturan Pakai</center></td>
												<td style="width:30px;">Sediaan</td>
												<td colspan="3" style="width:170px;">Cara Pakai</td>
												<td style="width:30px;">KET +</td>
												
											</tr>

											<tr>
												

												<td><input type="text" class="from-control" id='' style="width:30px;" value="s"></td>
												<td><input type="text" class="from-control xh" name="xh" id='xh' style="width:30px;"></td>
												<td><input type="text" class="from-control ap" name="ap" id='ap' style="width:30px;" value='d.d.' readonly></td>
												<td><input type="text" class="from-control oh" name="oh" id='oh' style="width:30px;"></td>
												<td id="detailSediaan<?php echo $id ?>">
													<input type="text" class="from-control sediaanDetail" id='sediaanDetail<?php echo $id; ?>' name="sediaanDetail" style="width:170px;">
													<div id="hasil_sediaanDetail<?php echo $id; ?>" style="position:absolute;background:white;border:0px solid black;cursor:pointer;width:200px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td id="detailSediaan<?php echo $id ?>" style="display:none;">
													<input type="text" class="from-control forSediaan" id='idSediaanDetail' name="idSediaanDetail" style="width:170px;">
												</td>
												<td colspan="3">
													<input type="text" class="from-control carapakai" id='carapakai<?php echo $id; ?>' name="carapakai" style="width:170px;">
													<input type="hidden" name="idCaraPakai" id="idCaraPakai">
													<div id="hasil_carapakai<?php echo $id; ?>" style="margin-top:5px;position:absolute;background:white;border:0px solid black;cursor:pointer;width:250px;padding:4px;display:none;z-index:1000;"></div>
												</td>
												<td><input type="text" class="from-control ket" id='ket' name="ketSigna" style="width:40px;" placeholder="ket +"></td>
											</tr>
										</tbody>
									</table>
								</form>

<script type="text/javascript">
	$(document).ready(function()
	{
		$(".prescription").hide();
		$(".subShow").hide();

	$(".obat").keyup(function()
	{
		var id=this.id;
		var obat=$(".obat"+id).val();
		$("#resultObat"+id).show();
		if(obat=="")
		{
			$("#resultObat"+id).hide();
		}
			$.ajax(
			{
				url:'content/pasien/catatresep/getObat.php',
				data:{id:id,obat:obat},
				type:'POST',
				success:function(result)
				{
					
					$("#resultObat"+id).html(result);
				},
				error:function()
				{
					alert('ERROR');
				}
			});
		
	});

	$(".ketResep").keyup(function()
		{
			var isi=$(".ketResep").val();
			var id=<?php echo $id; ?>;

			if(isi!="")
			{
				$("#mf").val('m.f.');
				$(".subShow").show();
				$(".not_for_racikan").hide();
				//	$(".disabledSubscription").prop("disabled", true);
				$("#iterRacikan0").show();
				$("#iterasi").detach().appendTo("#iterRacikan0");
				$("#jml0").detach().appendTo(".moveFromTop");
				$("#status_racikan").val('R');
			}
			else
			{
				$("#mf").val('');
				$(".subShow").hide();
				$(".not_for_racikan").show();
				//$(".disabledSubscription").prop("disabled", false);
				$("#iterRacikan0").hide();
				$("#iterasi").detach().appendTo("#iterasiObat0");
				$("#jml0").detach().appendTo("#jmlObat");
				$(".sediaanList").hide();
				$("#status_racikan").val('NR');

			}
			
			
		});

		$(".addObat").click(function(e)
		{
			e.preventDefault();
			var $nonempty = $('.first').filter(function() {
	    		return this.value != ''
			 });

	  		if ($nonempty.length < 5) {
	    		alert('empty')
	  		}
	  		else
	  		{
	  			var idResep=$("#idResep").val();
	  			var noUrut=$("#noUrut").val();
	  			var data=$("#medicine").serialize();
	  			$.ajax(
	  			{
	  				url:'content/pasien/catatresep/saveObat.php',
	  				data:data+'&idResep='+idResep,
	  				type:'POST',
	  				success:function(result)
	  				{

	  					$(".obat"+noUrut).prop("readonly",true);
	  					$("#addFirst").hide();
	  					$("#editFirst").show();
	  					$("#idObatResep0").val(result);
	  					var inturut=parseInt(noUrut);
	  					var nexturut=inturut+1;
	  					$("#"+nexturut).show();
	  					$("#noUrut").val(nexturut);
	  				}
	  			});
	  		}
		});

		$(".jumlah").keyup(function()
		{
			var id=this.id;
			var idStock=$(this).attr("checkTo");
			var jumlahObat=$("#"+id).val();
			var jumlahStock=parseInt($("#"+idStock).val());
			
			if(jumlahObat > jumlahStock)
			{
				alert('Jumlah tidak cukup');
				$(this).val('');
			}
			else
			{
				$(this).val(jumlahObat);
				$(".jumlahObat").val(jumlahObat);
			}

		});

		$(".sediaan").keyup(function()
		{
			var id=this.id;
			var sediaan=$("#"+id).val();
			var idResep=<?php echo $id ?>;
			if(sediaan!="")
			{
				$.ajax(
				{
					url:'content/pasien/catatresep/getSediaan.php',
					type:'POST',
					data:{sediaan:sediaan, idResep:idResep},
					success:function(result)
					{
						$("#hasil_"+id).html(result).show();
					}
				});
			}
			else
			{
				$(".idSediaan").val(0);
				$(".sediaanList").hide();
				$("#detailSediaan<?php echo $id; ?>").load('content/pasien/catatresep/formSediaan.php?id='+<?php echo $id ?>);
			}
		});

		$(".sediaanDetail").keyup(function()
		{
			var id=this.id;
			var sediaan=$("#"+id).val();
			var idResep=<?php echo $id ?>;
			$.ajax(
			{
				url:'content/pasien/catatresep/getSediaanDetail.php',
				type:'POST',
				data:{sediaan:sediaan, idResep:idResep},
				success:function(result)
				{
					$("#hasil_"+id).html(result).show();
				}
			});
		});


		$(".carapakai").keyup(function()
		{
			var id=this.id;
			var carapakai=$("#"+id).val();
			var idResep=<?php echo $id ?>;
			$.ajax(
			{
				url:'content/pasien/catatresep/getCarapakai.php',
				type:'POST',
				data:{carapakai:carapakai, idResep:idResep},
				success:function(result)
				{
					$("#hasil_"+id).html(result).show();
				}
			});
		});



	$("#iterasi").change(function()
	{
		var iterasi=$("#iterasi").val();
		$("#iterasiLabel").val(iterasi);
	});
	$(".ahKet").change(function()
	{
		var ah=$(".ahKet").val();
		$(".ah").val(ah);
	});
/*
	$(".jmlObat0").keyup(function()
	{
		$(".jmlResep0").val($(".jmlObat0").val());
	});

	$("#selesai").click(function()
	{
		var id_pasien=<?php echo $idPasien ?>;
		var id_kunjungan=<?php echo $idKunjungan ?>;
		var statusCito=$(".citoField").val();
		var noRm="<?php echo $no_rm ?>";
		$.ajax(
		{
			url:'content/pasien/catatresep/insertPasienNoResep.php',
			type:'POST',
			data:{id_pasien:id_pasien, id_kunjungan:id_kunjungan, statusCito:statusCito},
			success:function(result)
			{
				if(result=='0')
				{
					alert("Anda belum simpan obat");
				}
				else
				{
					$("#data_pasien").load("content/pasien/catatresep/listResep.php?id="+noRm);
				}
			},
			error:function()
			{
				alert("ERROR");
			}
		});
	});

	$(".cito").click(function()
	{
		if($(this).hasClass('citoActive'))
		{
			$(".cito").css({"color":"grey", "border":"3px solid grey"});
			$(".cito").removeClass("citoActive");
			$(".citoField").val('N');
		}
		else
		{
			$(".cito").css({"color":"red", "border":"3px solid red"});
			$(".cito").addClass("citoActive");
			$(".citoField").val('Y');
		}
		
	});

	$(document).keydown(function(e) {
    // ESCAPE key pressed
    if (e.keyCode == 27) {
       
    }
});

	
	$("#editFirst").click(function(e)
	{
		e.preventDefault();
		$(".first").prop("readonly",false);
		$("#editFirst").hide();
		$("#updateFirst").show();

	});

	$(".edit").click(function(e)
	{
		e.preventDefault();
		var id=this.id;
		$("."+id).prop("readonly",false);
		$(".edit"+id).hide();
		$(".update"+id).show();
	});
	$(".update").click(function(e)
	{
		e.preventDefault();
		var id=this.id;
		var data=$("#medicine").serialize();
  			$.ajax(
  			{
  				url:'content/pasien/catatresep/updateObat.php',
  				data:data+'&id='+id,
  				type:'POST',
  				success:function(result,xhr)
  				{
  					
  					$("."+id).prop("readonly",true);
  					$("#add").hide();
  					$(".update"+id).hide();
  					$(".edit"+id).show();
  				}
  			});
	});

	$("#updateFirst").click(function(e)
	{
		e.preventDefault();
		var data=$("#medicine").serialize();
  			$.ajax(
  			{
  				url:'content/pasien/catatresep/updateObat.php',
  				data:data+'&id=0',
  				type:'POST',
  				success:function(result,xhr)
  				{
  					
  					$(".first").prop("readonly",true);
  					$("#addFirst").hide();
  					$("#updateFirst").hide();
  					$("#editFirst").show();
  				}
  			});

	});
	$(".delete").click(function(event)
	{
		event.preventDefault();
		var id=parseInt(this.id);
		var beforeId=id-1;
		if(id==1)
		{
			$("#addFirst").show();
		}
		$("#"+id).hide();
		$(".act"+beforeId).show();
	});
	$(".addLoop").click(function(e)
	{
		e.preventDefault();
		var id=parseInt(this.id);
		var nextId=id+1;
		
		var $nonempty = $('.'+id).filter(function() {
    		return this.value != ''
		 });

  		if ($nonempty.length < 3) {
    		alert('empty')
  		}
  		else
  		{
  			var data=$("#medicine").serialize();
  			$.ajax(
  			{
  				url:'content/pasien/catatresep/saveObat.php',
  				data:data+'&id='+id,
  				type:'POST',
  				success:function(result,xhr)
  				{
  					
  					$("."+id).prop("readonly",true);
  					$("#"+nextId).show();
  					$(".act"+id).hide();
  					$(".edit"+id).show();
  					$("#idObatResep"+id).val(result);
  					$(".not_for_racikan").hide();
  					$(".forResep").prop("readonly", false);
  					
  				},
  				error:function()
  				{
  					alert("ERROR");
  				}
  			});
  		}
	});


	//kolom resep
	$("#tambahFirstDelete").click(function()
	{
		var id=<?php echo $nextResep ?>;
		var data=$(".formKeterangan").serialize();
		$("#resep11").load('content/pasien/catatresep/nextResep.php?id='+id+'&idPasien='+<?php echo $idPasien ?>+'&idKunjungan='+<?php echo $idKunjungan;?>).show();		
	});
	$("#tambahFirst").click(function()
	{
		var id=<?php echo $nextResep ?>;
		var data=$(".formKeterangan").serialize();
		$("#tambahFirst").hide();
		$.ajax(
		{
			url:'content/pasien/catatresep/savePrescription.php',
			data:data,
			type:'POST',
			success:function(result)
			{
				alert(result);
				$("#resep11").load('content/pasien/catatresep/nextResep.php?id='+id+'&idPasien='+<?php echo $idPasien ?>+'&idKunjungan='+<?php echo $idKunjungan;?>).show();
			},
			error:function()
			{
				alert('ERROR');
			}


		});

	});

	$(".mh").keyup(function()
	{
		var id=this.id;
		var mh=$("#"+id).val();
		$("#result"+id).show();
		if(mh=="")
		{
			$("#result"+id).hide();
		}
		$.ajax(
			{
				url:'content/pasien/catatresep/getMH.php',
				data:{id:id,mh:mh},
				type:'POST',
				success:function(result)
				{
					$("#result"+id).html(result);
				},
				error:function()
				{
					alert('ERROR');
				}
			});

	});
	$(".xh").keyup(function()
	{
		var xh=$(".xh").val();
		if(xh>10)
		{
			alert("Tidak bisa lebih dari 10");
			$(".xh").val("");
		}
		else if(xh<=10)
		{

		}
		else
		{
			alert('Inputan tidak dikenali');
			$(".xh").val("");
		}
	});

	$(".oh").keyup(function()
	{
		var oh=$(".oh").val();
		if(oh>10)
		{
			alert("Tidak bisa lebih dari 10");
			$(".oh").val("");
		}
		else if(oh<=10)
		{

		}
		else
		{
			alert('Inputan tidak dikenali');
			$(".oh").val("");
		}
	});

		*/
	});

</script>