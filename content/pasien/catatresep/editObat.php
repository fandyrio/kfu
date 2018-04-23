<?php
include "../../../config/conn.php";
$idKunjungan=$_GET['idKunjungan'];
$idPasien=$_GET['idPasien'];
if($_GET['edit']=="namaObat")
{
	$id=$_GET['idPRO'];
	$status=$_GET['status'];
	$getDataPRO=pg_query("SELECT * from pasien_resep_order where id='$id'");
	$fetchDataPRO=pg_fetch_assoc($getDataPRO);
	?>
		<input type="text" class="from-control first toClear editNamaObat obat0" id="0" style="width:200px;" name="namaObat0" value="<?php echo $fetchDataPRO['nama_brand'] ?>">
		<input type="hidden" class="from-control toClear first editIdobat" id="id_obat" style="width:200px;" name="idObat0" value="<?php echo $fetchDataPRO['id_inv'] ?>">
		<br />
		<b class="done" id="doneNamaObat" status="<?php echo $status; ?>">
			<img src="images/checked.jpg" width="20px" title="finish">
		</b>
		<div id="resultObat<?php echo $id ?>" class="resultObatEdit" style="position:absolute;background:white;border:1px solid black;cursor:pointer;width:200px;padding:3px;display:none;z-index:10">
		</div>

	<?php

}
else if($_GET['edit']=="dosis")
{
	$getSatuan=pg_query("SELECT * from master_me");
	$id=$_GET['idPRO'];
	$status=$_GET['status'];
	$getDataPRO=pg_query("SELECT * from pasien_resep_order where id='$id'");
	$fetchDataPRO=pg_fetch_assoc($getDataPRO);
	?>
		<input type="text" class="from-control first toClear editDosisObat dosisNew<?php echo $id; ?>" id="0" style="width:30px;" name="dosisObat" value="<?php echo $fetchDataPRO['dosis'] ?>">
		<select name="satuan" id="satuan<?php echo $id ?>">
			<?php
				while($fetchSatuan=pg_fetch_assoc($getSatuan))
				{
					echo "<option value='$fetchSatuan[id]'";
					if($fetchSatuan['id']==$fetchDataPRO['satuan'])
					{
						echo "selected";
					}

					echo ">$fetchSatuan[kode]</option>";
				}
			?>
		</select>
		<br />
		<b class="doneDosis" id="doneDosisEdit<?php echo $id; ?>" status="<?php echo $status; ?>">
			<img src="images/checked.jpg" width="20px" title="finish">
		</b>

	<?php

}
else if($_GET['edit']=="mf")
{
	$id=$_GET['idPRO'];
	$status=$_GET['status'];
	$idKunjungan=$_GET['idKunjungan'];
	$getDataPRO=pg_query("SELECT * from pasien_resep_order where id='$id'");
	$fetchDataPRO=pg_fetch_assoc($getDataPRO);
	$noResep=$fetchDataPRO['id_resep'];

	$getDataPRK=pg_query("SELECT * from pasien_resep_keterangan where id_kunjungan='$idKunjungan
		' and id_resep='$noResep'");
	$fetchDataPRK=pg_fetch_assoc($getDataPRK);
	if($fetchDataPRK['status_racikan']=="NR")
	{
		?>
		<script>
			var status="<?php echo $status ?>";
			alert("Unable to edit");
			if(status=="editOnAdd")
			{
				$("#listResep").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);
			}
			else
			{
				$("#data_pasien").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);	
			}
		</script>
		<?php
	}
	else
	{

	}
}
else if($_GET['edit']=="jumlah")
{
	$id=$_GET['idPRO'];
	$status=$_GET['status'];
	$idKunjungan=$_GET['idKunjungan'];
	$getDataPRO=pg_query("SELECT * from pasien_resep_order where id='$id'");
	$fetchDataPRO=pg_fetch_assoc($getDataPRO);
	$noResep=$fetchDataPRO['id_resep'];

	$getDataPRK=pg_query("SELECT * from pasien_resep_keterangan where id_kunjungan='$idKunjungan' and id_resep='$noResep'");
	$fetchDataPRK=pg_fetch_assoc($getDataPRK);
	
	?>
		<input type="text" class="from-control first toClear editJumlah<?php echo $id; ?>" id="0" style="width:30px;" name="dosisObat" value="<?php echo $fetchDataPRK['jml'] ?>">
		<br />
		<b class="doneJumlah" id="doneJumlah<?php echo $id; ?>" status="<?php echo $status; ?>">
			<img src="images/checked.jpg" width="20px" title="finish">
		</b>

	<?php

}
else if($_GET['edit']=="xperh")
{
	$id=$_GET['idPRK'];
	$status=$_GET['status'];
	$idKunjungan=$_GET['idKunjungan'];

	$getDataPRK=pg_query("SELECT * from pasien_resep_keterangan where id_kunjungan='$idKunjungan' and id='$id'");
	$fetchDataPRK=pg_fetch_assoc($getDataPRK);
	
	?>
		<input type="text" class="from-control first toClear editXperh<?php echo $id; ?>" id="0" style="width:30px;" name="dosisObat" value="<?php echo $fetchDataPRK['xperh'] ?>">
		<br />
		<b class="doneXperh" id="doneXperh<?php echo $id; ?>" status="<?php echo $status; ?>">
			<img src="images/checked.jpg" width="20px" title="finish">
		</b>

	<?php

}

else if($_GET['edit']=="operh")
{
	$id=$_GET['idPRK'];
	$status=$_GET['status'];
	$idKunjungan=$_GET['idKunjungan'];

	$getDataPRK=pg_query("SELECT * from pasien_resep_keterangan where id_kunjungan='$idKunjungan' and id='$id'");
	$fetchDataPRK=pg_fetch_assoc($getDataPRK);
	
	?>
		<input type="text" class="from-control first toClear editOperh<?php echo $id; ?>" id="0" style="width:30px;" name="dosisObat" value="<?php echo $fetchDataPRK['operh'] ?>">
		<br />
		<b class="doneOperh" id="doneOperh<?php echo $id; ?>" status="<?php echo $status; ?>">
			<img src="images/checked.jpg" width="20px" title="finish">
		</b>

	<?php

}

else if($_GET['edit']=="sediaan")
{
	$id=$_GET['idPRK'];
	$status=$_GET['status'];
	$idKunjungan=$_GET['idKunjungan'];

	$getDataPRK=pg_query("SELECT * from pasien_resep_keterangan where id_kunjungan='$idKunjungan' and id='$id'");
	$fetchDataPRK=pg_fetch_assoc($getDataPRK);
	$sediaanDetail=$fetchDataPRK['sediaan_detail'];

	$getSediaanDetail=pg_query("SELECT * from master_sediaan_detail where id='$sediaanDetail'");
	$fetchSediaanDetail=pg_fetch_assoc($getSediaanDetail);
	$sediaanCode=$fetchSediaanDetail['code_detail'];
	$sediaanId=$fetchSediaanDetail['id'];
	
	?>
		<input type="text" class="from-control sediaanDetailEdit" id='sediaanDetailEdit<?php echo $id; ?>' value="<?php echo $sediaanCode; ?>" name="sediaanDetail" style="width:40px;" autocomplete="off">
		<input type="hidden" class="from-control idSediaanDetailEdit<?php echo $id; ?>" id='idSediaanDetailEdit<?php echo $id; ?>' value="<?php echo $sediaanId ?>" name="sediaanDetail" style="width:40px;">
		<div id="hasil_sediaanDetailEdit<?php echo $id; ?>" style="position:absolute;background:white;border:0px solid black;cursor:pointer;width:200px;padding:3px;display:none;z-index:1000;"></div>
		<br />
		<b class="doneSediaan" id="doneOperh<?php echo $id; ?>" status="<?php echo $status; ?>">
			<img src="images/checked.jpg" width="20px" title="finish">
		</b>

	<?php

}
else if($_GET['edit']=="iterasi")
{
	$id=$_GET['idPRK'];
	$status=$_GET['status'];
	$idKunjungan=$_GET['idKunjungan'];

	$explodeIdPRK=explode("prk", $id);

	$getDataPRK=pg_query("SELECT * from pasien_resep_keterangan where id_kunjungan='$idKunjungan' and id='$explodeIdPRK[1]'");
	$fetchDataPRK=pg_fetch_assoc($getDataPRK);
	$iterasi=$fetchDataPRK['iterasi'];
	
	?>

	<select id="iterasi<?php echo $id; ?>">
		<?php
			$getIterasi=pg_query("SELECT * from master_iterasi");
			while($fetchIterasi=pg_fetch_assoc($getIterasi))
			{
				echo"<option value='$fetchIterasi[id]'";
					if($iterasi==$fetchIterasi['id'])
					{
						echo "selected";
					}

				echo ">$fetchIterasi[kode]</option>";
			}
		?>
	</select>
	<b class="doneIterasi" id="doneIterasi<?php echo $id; ?>" status="<?php echo $status; ?>" style="cursor:pointer;">
			<img src="images/checked.jpg" width="20px" title="finish">
		</b>

	<?php
}

else if($_GET['edit']=="carapakai")
{
	$id=$_GET['idPRK'];
	$status=$_GET['status'];
	$idKunjungan=$_GET['idKunjungan'];



	$getDataPRK=pg_query("SELECT * from pasien_resep_keterangan where id_kunjungan='$idKunjungan' and id='$id'");
	$fetchDataPRK=pg_fetch_assoc($getDataPRK);
	$cara_pakai=$fetchDataPRK['cara_pakai'];

	$getCarapakai=pg_query("SELECT * from cara_pakai where id='$cara_pakai'");
	$fetchCarapakai=pg_fetch_assoc($getCarapakai);
	
	?>

	<input type="text" class="from-control carapakaiEdit" id='carapakaiEdit<?php echo $id; ?>' value="<?php echo $fetchCarapakai['code_hts']?>" name="carapakai" style="width:170px;" autocomplete="off">
	<input type="hidden" name="idCaraPakai" id="idCaraPakaiEdit<?php echo $id; ?>" value="<?php echo $fetchCarapakai['id'] ?>" autocomplete="off">
	<div id="hasil_carapakaiEdit<?php echo $id; ?>" style="margin-top:5px;position:absolute;background:white;border:0px solid black;cursor:pointer;width:250px;padding:4px;display:none;z-index:1000;"></div>
	<b class="doneCarapakai" id="doneCarapakai<?php echo $id; ?>" status="<?php echo $status; ?>" style="cursor:pointer;">
			<img src="images/checked.jpg" width="20px" title="finish">
		</b>

	<?php
}

else if($_GET['edit']=="keterangan")
{
	$id=$_GET['idPRK'];
	$status=$_GET['status'];
	$idKunjungan=$_GET['idKunjungan'];



	$getDataPRK=pg_query("SELECT * from pasien_resep_keterangan where id_kunjungan='$idKunjungan' and id='$id'");
	$fetchDataPRK=pg_fetch_assoc($getDataPRK);
	$keterangan=$fetchDataPRK['ket_signa'];

	
	?>

	<input type="text" class="from-control keteranganSigna" id='keteranganSigna<?php echo $id; ?>' value="<?php echo $keterangan?>" name="keterangan" style="width:170px;" autocomplete="off">
	<b class="doneKeteranganSigna" id="doneKeteranganSigna<?php echo $id; ?>" status="<?php echo $status; ?>" style="cursor:pointer;">
			<img src="images/checked.jpg" width="20px" title="finish">
		</b>

	<?php
}

?>

<script type="text/javascript">
	$(document).ready(function()
	{
		$(".editNamaObat").keyup(function()
		{
			var id=this.id;
			var idPRO="<?php echo $id; ?>";
			var obat=$(".editNamaObat").val();
			$("#resultObat"+idPRO).show();
			if(obat=="")
			{
				$("#resultObat"+idPRO).hide();
			}
				$.ajax(
				{
					url:'content/pasien/catatresep/getObat.php',
					data:{id:id,obat:obat},
					type:'POST',
					success:function(result)
					{
						
						$("#resultObat"+idPRO).html(result);
					},
					error:function()
					{
						alert('ERROR');
					}
				});
			
		});
		$(".done").click(function()
		{
			//common
			var id=this.id;
			var idPRO="<?php echo $id; ?>";
			var status=$(this).attr("status");
			//=========================================
			//Nama Obat
			var nama_obat=$(".editNamaObat").val();
			var id_obat=$(".editIdobat").val();
			//=========================================
			$.ajax(
				{
					beforeSend:function()
					{
						$("#doneNamaObat").html("<img src='images/load.gif' style='width:60px;'>");
					},

					url:'content/pasien/catatresep/updateObat.php',
					data:{id:id,nama_obat:nama_obat,id_obat:id_obat, idPRO:idPRO},
					type:'POST',
					success:function(result)
					{
						$(".daftar_resep").show();
						if(status=="editOnAdd")
						{
							$("#listResep").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);
						}
						else
						{
							$("#data_pasien").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);	
						}
						
					},
					error:function()
					{
						alert('ERROR');
					}
				});
		});


		$(".doneDosis").click(function()
		{
			//common
			var id="doneDosisEdit";//doneDosisEdit
			var idPRO="<?php echo $id; ?>";
			var status=$(this).attr("status");
			//=========================================
			//Dosis
			var dosis=$(".dosisNew"+idPRO).val();
			var satuan=$("#satuan"+idPRO).val();
			//=========================================
			$.ajax(
				{
					beforeSend:function()
					{
						$("#doneDosisEdit"+idPRO).html("<img src='images/load.gif' style='width:60px;'>");
					},
					url:'content/pasien/catatresep/updateObat.php',
					data:{id:id,dosis:dosis, idPRO:idPRO, satuan:satuan},
					type:'POST',
					success:function(result)
					{
						$(".daftar_resep").show();
						if(status=="editOnAdd")
						{
							$("#listResep").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);
						}
						else
						{
							$("#data_pasien").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);	
						}
						
					},
					error:function()
					{
						alert('ERROR');
					}
				});
		});
		
		$(".doneJumlah").click(function()
		{
			//common
			var id="editJumlah";//doeDosisEdit
			var idPRO="<?php echo $id; ?>";
			var status=$(this).attr("status");
			//=========================================
			//Dosis
			var jumlah=$(".editJumlah"+idPRO).val();
			var noResep="<?php echo $noResep ?>";
			var idKunjungan="<?php echo $idKunjungan ?>";
			//=========================================
			$.ajax(
				{
					beforeSend:function()
					{
						$("#doneJumlah"+idPRO).html("<img src='images/load.gif' style='width:60px;'>");
					},
					url:'content/pasien/catatresep/updateObat.php',
					data:{id:id,jumlah:jumlah, idPRO:idPRO, idKunjungan:idKunjungan, noResep:noResep},
					type:'POST',
					success:function(result)
					{
						$(".daftar_resep").show();
						if(status=="editOnAdd")
						{
							$("#listResep").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);
						}
						else
						{
							$("#data_pasien").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);	
						}
						
					},
					error:function()
					{
						alert('ERROR');
					}
				});
		});

		$(".doneXperh").click(function()
		{
			//common
			var id="editXperh";//doeDosisEdit
			var idPRK="<?php echo $id; ?>";
			var status=$(this).attr("status");

			//=========================================
			//Dosis
			var xperh=$(".editXperh"+idPRK).val();
			var idKunjungan="<?php echo $idKunjungan ?>";
			//=========================================
			$.ajax(
				{
					beforeSend:function()
					{
						$("#doneXperh"+idPRK).html("<img src='images/load.gif' style='width:60px;'>");
					},
					url:'content/pasien/catatresep/updateObat.php',
					data:{id:id,xperh:xperh, idPRK:idPRK, idKunjungan:idKunjungan},
					type:'POST',
					success:function(result)
					{
						$(".daftar_resep").show();
						if(status=="editOnAdd")
						{
							$("#listResep").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);
						}
						else
						{
							$("#data_pasien").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);	
						}
						
					},
					error:function()
					{
						alert('ERROR');
					}
				});
		});

		$(".doneOperh").click(function()
		{
			//common
			var id="editOperh";//doeDosisEdit
			var idPRK="<?php echo $id; ?>";
			var status=$(this).attr("status");

			//=========================================
			//Dosis
			var operh=$(".editOperh"+idPRK).val();
			var idKunjungan="<?php echo $idKunjungan ?>";
			//=========================================
			$.ajax(
				{
					beforeSend:function()
					{
						$("#doneOperh"+idPRK).html("<img src='images/load.gif' style='width:60px;'>");
					},
					url:'content/pasien/catatresep/updateObat.php',
					data:{id:id,operh:operh, idPRK:idPRK, idKunjungan:idKunjungan},
					type:'POST',
					success:function(result)
					{
						$(".daftar_resep").show();
						if(status=="editOnAdd")
						{
							$("#listResep").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);
						}
						else
						{
							$("#data_pasien").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);	
						}
						
					},
					error:function()
					{
						alert('ERROR');
					}
				});
		});

		$(".sediaanDetailEdit").keyup(function()
		{
			var id=this.id;
			var sediaan=$("#"+id).val();
			var idPRK="<?php echo $id; ?>";
			
			$.ajax(
			{
				url:'content/pasien/catatresep/getSediaanDetailEdit.php',
				type:'POST',
				data:{sediaan:sediaan, idPRK:idPRK},
				success:function(result)
				{
					$("#hasil_"+id).html(result).show();
				}
			});
		});


		$(".doneSediaan").click(function()
		{
			//common
			var id="editSediaan";//doeDosisEdit
			var idPRK="<?php echo $id; ?>";
			var status=$(this).attr("status");

			//=========================================
			//Dosis
			var sediaan=$(".idSediaanDetailEdit"+idPRK).val();
			var idKunjungan="<?php echo $idKunjungan ?>";
			//=========================================
			$.ajax(
				{
					beforeSend:function()
					{
						$("#doneSediaan"+idPRK).html("<img src='images/load.gif' style='width:60px;'>");
					},
					url:'content/pasien/catatresep/updateObat.php',
					data:{id:id,sediaan:sediaan, idPRK:idPRK, idKunjungan:idKunjungan},
					type:'POST',
					success:function(result)
					{
						$(".daftar_resep").show();
						if(status=="editOnAdd")
						{
							$("#listResep").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);
						}
						else
						{
							$("#data_pasien").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);	
						}
						
					},
					error:function()
					{
						alert('ERROR');
					}
			});
		});

		$(".doneIterasi").click(function()
		{
			//common
			var id="editIterasi";//doeDosisEdit
			var idPRK="<?php echo $id; ?>";
			var status=$(this).attr("status");

			//=========================================
			//Iterasi
			var iterasi=$("#iterasi"+idPRK).val();
			var idKunjungan="<?php echo $idKunjungan ?>";
			//=========================================
			$.ajax(
				{
					beforeSend:function()
					{
						$("#doneSediaan"+idPRK).html("<img src='images/load.gif' style='width:60px;'>");
					},
					url:'content/pasien/catatresep/updateObat.php',
					data:{id:id,iterasi:iterasi, idPRK:idPRK, idKunjungan:idKunjungan},
					type:'POST',
					success:function(result)
					{
						$(".daftar_resep").show();
						if(status=="editOnAdd")
						{
							$("#listResep").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);
						}
						else
						{
							$("#data_pasien").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);	
						}
						
					},
					error:function()
					{
						alert('ERROR');
					}
			});
		});

		$(".carapakaiEdit").keyup(function()
		{
			var id=this.id;
			var carapakai=$("#"+id).val();
			var idResep="<?php echo $id ?>";
			var from="edit";
			$.ajax(
			{
				url:'content/pasien/catatresep/getCarapakaiEdit.php',
				type:'POST',
				data:{carapakai:carapakai, idResep:idResep,from:from},
				success:function(result)
				{
					$("#hasil_"+id).html(result).show();
				}
			});
		});

		$(".doneCarapakai").click(function()
		{
			//common
			var id="editCarapakai";//doeDosisEdit
			var idPRK="<?php echo $id; ?>";
			var status=$(this).attr("status");

			//=========================================
			//Iterasi
			var carapakai=$("#idCaraPakaiEdit"+idPRK).val();
			var idKunjungan="<?php echo $idKunjungan ?>";
			//=========================================
			$.ajax(
				{
					beforeSend:function()
					{
						$("#doneCarapakai"+idPRK).html("<img src='images/load.gif' style='width:60px;'>");
					},
					url:'content/pasien/catatresep/updateObat.php',
					data:{id:id,carapakai:carapakai, idPRK:idPRK, idKunjungan:idKunjungan},
					type:'POST',
					success:function(result)
					{
						$(".daftar_resep").show();
						if(status=="editOnAdd")
						{
							$("#listResep").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);
						}
						else
						{
							$("#data_pasien").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);	
						}
						
					},
					error:function()
					{
						alert('ERROR');
					}
			});
		});



		$(".doneKeteranganSigna").click(function()
		{
			//common
			var id="editKeteranganSigna";//doeDosisEdit
			var idPRK="<?php echo $id; ?>";
			var status=$(this).attr("status");

			//=========================================
			//Iterasi
			var keteranganSigna=$("#keteranganSigna"+idPRK).val();
			var idKunjungan="<?php echo $idKunjungan ?>";
			//=========================================
			$.ajax(
				{
					beforeSend:function()
					{
						$("#doneKeteranganSigna"+idPRK).html("<img src='images/load.gif' style='width:60px;'>");
					},
					url:'content/pasien/catatresep/updateObat.php',
					data:{id:id,keteranganSigna:keteranganSigna, idPRK:idPRK, idKunjungan:idKunjungan},
					type:'POST',
					success:function(result)
					{
						$(".daftar_resep").show();
						if(status=="editOnAdd")
						{
							$("#listResep").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);
						}
						else
						{
							$("#data_pasien").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+false);	
						}
						
					},
					error:function()
					{
						alert('ERROR');
					}
			});
		});

	});
</script>