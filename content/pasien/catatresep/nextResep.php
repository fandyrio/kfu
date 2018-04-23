<?php


include "../../../config/conn.php";
?>
<div class="col-md-1" style="border:0px solid black;float:left;">
									R /<br />
									<?php
										$id=$_GET['id'];
										$idPasien=$_GET['idPasien'];
										$idKunjungan=$_GET['idKunjungan'];
										//echo $id;

										//Konversi 11 menjadi 1, 12 menjadi 2, karena id form ini adalah 11, maka akan diubah ke 1 untuk mempermudah penamaan resep -->
										$resepNumber=$id-10;
										

									?>
									<button class="btn btn-primary btn-xs tambahResep<?php echo $id; ?>" id='<?php echo $id; ?>'><i class="icon-plus"></i></button>
									<button class="btn btn-danger btn-xs hapusResep<?php echo $id; ?>" id='<?php echo $id;?>'><i class="icon-trash"></i></button>
								</div>
								<div class="col-md-10" style="border:0px solid black;float:left;">
									<form id="medicine<?php echo $id; ?>">
									<table class="table" id="<?php echo $x;?>">
										<thead class="table-secondary">
											<tr>
												<th>#</th>
												<th width="200px">Nama Obat</th>
												<th width="50px">Ket.</th>
												<th></th>
												<th>Dosis/Satuan</th>
												<th></th>
												<th>JML</th>
												<th cospan="2">ACT</th>
											</tr>
										</thead>

										<tbody>
											<tr>
												<td width="50px">Prescription</td>
												<td>
													<input type="text" class="from-control must0 obatNextResep obatNextResep<?php echo $id ?>1" name="namaObat<?php echo $id ?>1" id="1" style="width:200px;">
													<input type="hidden" class="from-control" style="width:200px;" name="noUrut" value="<?php echo $resepNumber; ?>">
													<!-- <input type="hidden" class="from-control" style="width:200px;" name="id" value="<?php echo $id; ?>1"> -->
													<input type="hidden" class="from-control must0 id_obat<?php echo $id ?>1"  id="idobat<?php echo $id ?>1" style="width:200px;">
													<input type="hidden" class="from-control" style="width:200px;" name="idResep<?php echo $resepNumber ?>" value="R<?php echo $resepNumber ?>">
													<input type="hidden" class="from-control" style="width:200px;" name="idPasien" value="<?php echo $idPasien; ?>">
													<input type="hidden" class="from-control" style="width:200px;" name="idKunjungan" value="<?php echo $idKunjungan ?>">
													<input type="hidden" class="from-control first obat idobat<?php echo $id ?>1" id="id_obat" style="width:200px;" name="idObat<?php echo $id ?>1">
													<input type="hidden" class="from-control first" id="idObatResep<?php echo $id ?>1" style="width:200px;" name="idObatResep<?php echo $id ?>1">
													<div id="resultObat<?php echo $id; ?>1" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:200px;padding:3px;display:none;"></div>
												</td>
												<td><input type="text" class="from-control second" name="keterangan<?php echo $id.'1' ?>" id="ap" style="width:50px;"></td>
												<td></td>
												<td>
													<!-- <input type="text" class="from-control second" id="satuan" style="width:50px;"> -->
													<input type="text" class="from-control second" name="dosis<?php echo $id.'1'; ?>"id="dosis" style="width:50px;">
												<select name="satuan<?php echo $id.'1'; ?>" id='satuan' class="first">
													<?php
													$getSatuan=pg_query("SELECT * from master_me");
													while($fetchSatuan=pg_fetch_assoc($getSatuan))
													{
														echo"<option value='$fetchSatuan[id]'>$fetchSatuan[kode]</option>";
													}
													?>
												<select>
												</td>
												<td>
													<!-- <input type="text" class="from-control second" id="ah" style="width:50px;"> -->
													<?php
														$getSatuan=pg_query("SELECT * from master_mf");
														$fetchSatuan=pg_fetch_assoc($getSatuan);
														echo "<span class='not_for_racikan$resepNumber'>".$fetchSatuan['kode']."</span>";
													?>
													<input type="hidden" id='ah<?php echo $id.'1' ?>' class="not_for_racikan<?php echo $resepNumber; ?>" name='ah<?php echo $id.'1' ?>' value='<?php echo $fetchSatuan['kode'] ?>'>
												</td>
												<td><input type="text" class="from-control second jmlObat<?php echo $resepNumber ?> not_for_racikan<?php echo $resepNumber; ?>" name="jml<?php echo $id.'1'; ?>" id="jml" style="width:50px;"></td>
												<td><button class="btn btn-primary btn-xs addData addData<?php echo $id.'1' ?>" id="<?php echo $id.'1'; ?>"><i class="icon-plus"></i></button></td>
												<td></td>
												<td id="iterasiObat<?php echo $resepNumber; ?>">
													<select name="iterasi" id="iterasi<?php echo $resepNumber ?>">
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
											for($z=2;$z<=10;$z++)
											{
											?>
											<tr class="prescription" id="<?php echo $id.$z; ?>" style="display:none;">
												<td width="50px">Prescription</td>
												<td>
													<input type="text" class="from-control must0 obatNextResep obatNextResep<?php echo $id.$z ?>" name="namaObat<?php echo $id.$z ?>" id="<?php echo $z ?>" style="width:200px;">
													<input type="hidden" class="from-control" style="width:200px;" name="noUrut" value="<?php echo $resepNumber; ?>">
													<!-- <input type="hidden" class="from-control" style="width:200px;" name="id" value="<?php echo $id; ?>1"> -->
													<input type="hidden" class="from-control must0 id_obat<?php echo $id.$z ?>"  id="idobat<?php echo $id.$z ?>" style="width:200px;">
													<input type="hidden" class="from-control" style="width:200px;" name="idResep<?php echo $resepNumber ?>" value="R1">
													<input type="hidden" class="from-control" style="width:200px;" name="idPasien" value="<?php echo $idPasien; ?>">
													<input type="hidden" class="from-control" style="width:200px;" name="idKunjungan" value="<?php echo $idKunjungan ?>">
													<input type="hidden" class="from-control first obat idobat<?php echo $id.$z; ?>" id="id_obat" style="width:200px;" name="idObat<?php echo $id.$z ?>">
													<input type="hidden" class="from-control first" id="idObatResep<?php echo $id.$z ?>" style="width:200px;" name="idObatResep<?php echo $id.$z ?>">
													<div id="resultObat<?php echo $id.$z; ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:200px;padding:3px;display:none;"></div>
												</td>
												<td><input type="text" name="ap<?php echo $id.$z ?>" class="from-control <?php echo $z ?>" style="width:50px;"></td>
												<td></td>
												<td>
													<input type="text" name="dosis<?php echo $id.$z; ?>" class="from-control <?php echo $z ?>" style="width:50px;">
													<select name="satuan<?php echo $id.$z; ?>" name="satuan<?php echo $id.$z; ?>" id='satuan' class="first">
													<?php
													$getSatuan=pg_query("SELECT * from master_me");
													while($fetchSatuan=pg_fetch_assoc($getSatuan))
													{
														echo"<option value='$fetchSatuan[id]'>$fetchSatuan[kode]</option>";
													}
													?>
												<select>
												</td>
												<td></td>
												<td></td>
												<td><button class="btn btn-primary btn-xs addData addData<?php echo $id.$z ?>" id="<?php echo $id.$z; ?>"><i class="icon-plus"></i></button></td>
												<td><button class='btn btn-xs btn-danger delete<?php echo $id ?> actSecond<?php echo $z?>' id='<?php echo $z;?>'><i class="icon-trash"></i></button></td>
											</tr>
											<?php
											}
											?>
										</tbody>
									</table>
								</form>

								<form class="formKeterangan">	
									<table class="table" border="1" style="width:100px;">
										<tbody>
											<tr>
												<td rowspan="2">Subscription</td>
												<td></td>
												<td style="width:30px;" colspan="8"><center>Aturan Peracikan</center></td>
												<td class="subShow<?php echo $resepNumber ?>">AH</td>
												<td class="subShow<?php echo $resepNumber ?>">JML</td>
											</tr>
											<tr>
												
												<td>
													<input type="text" class="from-control" id='mf<?php echo $resepNumber ?>' style="width:30px;" readonly>
													<input type="hidden" class="from-control" style="width:200px;" name="idResep<?php echo $resepNumber ?>" value="R<?php echo $resepNumber; ?>">
													<input type="hidden" class="from-control" style="width:200px;" name="idKunjungan" value="<?php echo $idKunjungan ?>">
													<input type="hidden" class="from-control" style="width:200px;" name="noUrut" value="<?php echo $resepNumber; ?>">
													<input type="hidden" name="iterasi<?php echo $resepNumber ?>" id="iterasiLable<?php echo $resepNumber; ?>">
												</td>
												<td>
													<input type="text" class="from-control forResep<?php echo $resepNumber ?> mh K1" name='k1_1<?php echo $resepNumber ?>' id='K11<?php echo $resepNumber ?>' style="width:40px;">
													<div id="resultK11<?php echo $resepNumber; ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td>
													<input type="text" class="from-control forResep<?php echo $resepNumber ?> mh K2" name='k2_1<?php echo $resepNumber ?>' id='K21<?php echo $resepNumber ?>' style="width:40px;">
													<div id="resultK21<?php echo $resepNumber; ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td>
													<input type="text" class="from-control forResep<?php echo $resepNumber ?> mh K3" name='k3_1<?php echo $resepNumber ?>' id='K31<?php echo $resepNumber; ?>' style="width:30px;">
													<div id="resultK31<?php echo $resepNumber; ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td>
													<input type="text" class="from-control forResep<?php echo $resepNumber ?> mh K4" name='k4_1<?php echo $resepNumber ?>' id='K41<?php echo $resepNumber ?>' style="width:30px;">
													<div id="resultK41<?php echo $resepNumber; ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td>
													<input type="text" class="from-control forResep<?php echo $resepNumber ?> mh K5" name='k5_1<?php echo $resepNumber ?>' id='K51<?php echo $resepNumber ?>' style="width:30px;">
													<div id="resultK51<?php echo $resepNumber; ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td>
													<input type="text" class="from-control forResep<?php echo $resepNumber ?> mh k6" name='k6_1<?php echo $resepNumber ?>' id='K61<?php echo $resepNumber ?>' style="width:40px;">
													<div id="resultK61<?php echo $resepNumber; ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td>
													<input type="text" class="from-control forResep mh K7" name='k7_1<?php echo $resepNumber ?>' id='K71<?php echo $resepNumber ?>' style="width:40px;">
													<div id="resultK71<?php echo $resepNumber; ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td><input type="text" class="from-control forResep mh K5" name='k8_1<?php echo $resepNumber ?>' id='K81<?php echo $resepNumber; ?>' style="width:40px;">
													<div id="resultK81<?php echo $resepNumber; ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td class="subShow<?php echo $resepNumber ?>">
													<!-- <input type="text" class="from-control ah ah<?php echo $x ?> <?php echo $x ?>" id="<?php echo $x ?>" style="width:50px;"> -->
													<select id='ah' name="ahKet<?php echo $resepNumber; ?>" class="from-control ah ah<?php echo $id ?> <?php echo $id ?>" id="<?php echo $id ?>">
													<?php
														$getSatuan=pg_query("SELECT * from master_mf");
														while($fetchSatuan=pg_fetch_assoc($getSatuan))
														{
															echo"<option value='$fetchSatuan[id]'>$fetchSatuan[kode]</option>";
														}
													?>
												<select>

												</td>
												<td class="subShow<?php echo $resepNumber ?>"><input type="text" name="jml_subs<?php echo $resepNumber ?>" class="from-control jmlResep<?php echo $resepNumber ?> jml jml<?php echo $id ?> <?php echo $id ?>" id="<?php echo $id ?>" style="width:50px;" placeholder="<?php echo $id; ?>"></td>
												<td id="iterRacikan<?php echo $resepNumber ?>" style="display:none;">

												</td>
											</tr>

											<tr>
												<td rowspan="2">Signatura</td>
												<td></td>
												<td style="width:20px;">Ket.1</td>
												<td style="width:30px;">Ket.2</td>
												<td style="width:20px;" colspan='3'><center>Aturan Pakai</center></td>
												<td style="width:30px;">Sediaan</td>
												<td style="width:50px;">Cara Pakai</td>
												<td style="width:30px;">KET +</td>
												
											</tr>

											<tr>
												<td><input type="text" class="from-control" id='' style="width:30px;" value="s"></td>
												<td>
													<input type="text" class="from-control mh K1" name="k1_2<?php echo $resepNumber ?>" id='K12<?php echo $resepNumber ?>' style="width:40px;">
													<div id="resultK12<?php echo $resepNumber ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td>
													<input type="text" class="from-control mh K2" name="k2_2<?php echo $resepNumber ?>" id='K22<?php echo $resepNumber ?>' style="width:40px;">
													<div id="resultK22<?php echo $resepNumber ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td><input type="text" class="from-control xh<?php echo $resepNumber; ?>" name="xh<?php echo $resepNumber ?>" id='xh<?php echo $resepNumber; ?>' style="width:30px;"></td>
												<td><input type="text" class="from-control ap" id='ap' style="width:30px;" value='d.d.' readonly></td>
												<td><input type="text" class="from-control oh<?php echo $resepNumber ?>" name="oh<?php echo $resepNumber ?>" id='oh<?php echo $resepNumber; ?>' style="width:30px;"></td>
												<td>
													<input type="text" class="from-control mh k3" id='sediaan_<?php echo $resepNumber ?>' name="sediaan_<?php echo $resepNumber ?>" style="width:40px;">
													<div id="resultsediaan_<?php echo $resepNumber ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td>
													<input type="text" class="from-control mh k4" id='carapakai_<?php echo $resepNumber ?>' name="carapakai_<?php echo $resepNumber ?>" style="width:70px;">
													<div id="resultcarapakai_<?php echo $resepNumber ?>" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:80px;padding:3px;display:none;z-index:1000;"></div>
												</td>
												<td><input type="text" class="from-control ket" id='ket' name="ketTambahan2_<?php echo $resepNumber ?>" style="width:40px;"></td>
											</tr>
										</tbody>
									</table>
								</form>

								</div>
								<div class="col-md-1" style="float:left;">
									<!-- <form class="formKeterangan">
										<select name="iterasi<?php echo $resepNumber ?>" id="iterasi<?php echo $resepNumber ?>">
											<?php
												$getIter=pg_query("SELECT * from master_iterasi");
												while($fetchIterasi=pg_fetch_assoc($getIter))
												{
													echo"<option value='$fetchIterasi[id]'>$fetchIterasi[kode]</option>";	
												}
												
											?>
										</select>
										</form> -->
								</div>

<script type="text/javascript">
$(document).ready(function()
{

	$("#iterasi<?php echo $resepNumber ?>").change(function()
	{
		var iterasi=$("#iterasi<?php echo $resepNumber ?>").val();
		$("#iterasiLable<?php echo $resepNumber ?>").val(iterasi);
	});

	$(".jmlObat<?php echo $resepNumber ?>").keyup(function()
	{
		$(".jmlResep<?php echo $resepNumber ?>").val($(".jmlObat<?php echo $resepNumber ?>").val());
	});
	/*$(".delete").click(function()
	{
		var id=parseInt(this.id);
		var beforeId=id-1;
		if(id==11)
		{
			$("#tambahFirst").show();
		}
		alert(id);
		$("#"+id).hide();
		$(".act"+beforeId).show();
	});
	$(".addLoop").click(function()
	{
		var id=parseInt(this.id);
		var nextId=id+1;

		var $nonempty = $('.'+id).filter(function() {
    		return this.value != ''
		 });

  		if ($nonempty.length < 6) {
    		alert('empty')
  		}
  		else
  		{
  			$("#"+nextId).show();
  			$(".act"+id).hide();
  		}
	});
*/

	//kolom resep
	/*$("#tambahFirst").click(function()
	{
		$("#resep11").load('content/pasien/catatresep/nextResep.php').show();
		$("#tambahFirst").hide();
	});*/
	$(".subShow<?php echo $resepNumber ?>").hide();
//	$(".forResep").prop("disabled", true);
	$(".hapusResep"+<?php echo $id; ?>).click(function()
	{
		var id=<?php echo $id ?>;
		if(id==11)
		{
			$("#tambahFirstDelete").show();
		}
		$("#resep"+id).hide();

	});
	$(".tambahResep"+<?php echo $id; ?>).click(function()
	{
		var id=<?php echo $id ?>;
		var nextId=id+1;
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
				$("#resep"+nextId).load('content/pasien/catatresep/nextResep.php?id='+nextId+'&idPasien='+<?php echo $idPasien ?>+'&idKunjungan='+<?php echo $idKunjungan;?>).show();
			},
			error:function()
			{
				alert('ERROR');
			}


		});


		
		/*$("#resep"+nextId).show();*/
	});

	$('.addData').click(function(e)
	{

		//alert(0);
		var id=parseInt(this.id);
		var nextId=id+1;
		$("#"+nextId).show();
		e.preventDefault();
		var $nonempty = $('.first').filter(function() {
    		return this.value != ''
		 });

  		if ($nonempty.length < 6) {
    		alert('empty')
  		}
  		else
  		{
  			/*alert(id);
  			alert(nextId);*/
  			var data=$("#medicine"+<?php echo $id;?>).serialize();
  			$.ajax(
  			{
  				url:'content/pasien/catatresep/saveObat.php',
  				data:data+'&id='+id,
  				type:'POST',
  				success:function(result)
  				{
  					alert(result);

  					$(".first").prop("readonly",true);
  					$(".addData"+id).hide();
  					$("#editFirst").show();
  					$("#idObatResep"+id).val(result);
  				}
  			});
  		}
	});

	$(".addLoop"+<?php echo $id.$z; ?>).click(function()
	{
		var id=parseInt(this.id);
		var nextId=id+1;
		//alert(id);
		$("#"+<?php echo $id ?>+nextId).show();
	});
	$(".delete"+<?php echo $id ?>).click(function()
	{
		var id=parseInt(this.id);

		$("#"+<?php echo $id ?>+id).hide();
	});

	//kolom obat
	$(".obatNextResep").keyup(function()
	{
		var idInput=this.id; //0
		var id=<?php echo $id; ?>; //11
		var classInput=".obatNextResep"+id+idInput;

		var obat=$(classInput).val();
		$.ajax(
			{
				url:'content/pasien/catatresep/getObat.php',
				data:{id:id,obat:obat,idInput:idInput},
				type:'POST',
				success:function(result)
				{
					$("#resultObat"+<?php echo $id ?>+idInput).html(result).show();
				},
				error:function()
				{
					alert('ERROR');
				}
			});

	});

	$("#xh"+<?php echo $id; ?>).keyup(function()
	{
		//var id=this.id;
		var xh=$("#xh"+<?php echo $id; ?>).val();
		if(xh>10)
		{
			alert("Tidak bisa lebih dari 10");
			$("#xh"+<?php echo $id; ?>).val("");
		}
		else if(xh<=10)
		{

		}
		else
		{
			alert('Inputan tidak dikenali');
			$("#xh"+<?php echo $id; ?>).val("");
		}
	});
	$("#oh"+<?php echo $id; ?>).keyup(function()
	{
		var id=this.id;
		var oh=$("#oh"+<?php echo $id; ?>).val();
		if(oh>10)
		{
			alert("Tidak bisa lebih dari 10");
			$("#oh"+<?php echo $id; ?>).val("");
		}
		else if(oh<=10)
		{

		}
		else
		{
			alert('Inputan tidak dikenali');
			$("#oh"+<?php echo $id; ?>).val("");
		}
	});

	$(".mh").keyup(function()
	{
		var id=this.id;
		var mh=$("#"+id).val();
		$("#result"+id).show();
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

	$("#K11<?php echo $resepNumber; ?>, #K21<?php echo $resepNumber; ?>, #K31<?php echo $resepNumber; ?>, #K41<?php echo $resepNumber; ?>").keyup(function()
	{
		
		var isi=$(this).val();
		if(isi!="")
		{
			$("#mf<?php echo $resepNumber; ?>").val('m.f.');
			$(".subShow<?php echo $resepNumber ?>").show();
			$(".not_for_racikan<?php echo $resepNumber ?>").hide();
			$(".disabledSubscription").prop("disabled", true);
			$("#iterRacikan<?php echo $resepNumber ?>").show();
			$("#iterasi<?php echo $resepNumber ?>").detach().appendTo("#iterRacikan<?php echo $resepNumber ?>");
		}
		else
		{
			$("#mf<?php echo $resepNumber; ?>").val('');
			$(".not_for_racikan<?php echo $resepNumber ?>").show();
			$(".subShow<?php echo $resepNumber ?>").hide();
			$(".disabledSubscription").prop("disabled", false);
			$("#iterRacikan<?php echo $resepNumber ?>").hide();
			$("#iterasi<?php echo $resepNumber ?>").detach().appendTo("#iterasiObat<?php echo $resepNumber ?>");
		}
		
	});


});
</script>