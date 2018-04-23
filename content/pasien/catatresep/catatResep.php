<?php
session_start();

include "../../../config/conn.php";
$no_rm=$_GET['id'];
$getIdPasien=pg_query("SELECT * from master_pasien where no_rm='$no_rm'");
$fetchPasien=pg_fetch_assoc($getIdPasien);
$idPasien=$fetchPasien['id'];


$getKunjungan=pg_query("SELECT * from kunjungan where id_pasien='$idPasien' and status_kunjungan='Y'");
$fetchKunjungan=pg_fetch_assoc($getKunjungan);
$idKunjungan=$fetchKunjungan['id'];

var_dump($idKunjungan);

$getPasienNoResep=pg_query("SELECT * from pasien_no_resep where id_kunjungan='$idKunjungan'");
$jumlahPasienNoResep=pg_num_rows($getPasienNoResep);


$getDataKeterangan=pg_query("SELECT * from pasien_no_resep where id_kunjungan='$idKunjungan'");
$jumlahData=pg_num_rows($getDataKeterangan);

if($jumlahData==0)
{
	$deletePasienResep=pg_query("DELETE from pasien_resep_order where id_kunjungan='$idKunjungan' and id_pasien='$idPasien'");
	$deletePasienKet=pg_query("DELETE from pasien_resep_keterangan where id_kunjungan='$idKunjungan'");
}

$getMaxKeterangan=pg_query("SELECT MAX(id_resep) as id_resep from pasien_resep_keterangan");
$fetchMaxKeterangan=pg_fetch_assoc($getMaxKeterangan);

$getMaxOrder=pg_query("SELECT MAX(id_resep) as id_resep from pasien_resep_order");
$fetchMaxOrder=pg_fetch_assoc($getMaxOrder);


if($fetchMaxOrder['id_resep'] > $fetchMaxKeterangan['id_resep'])
{
	$deletePasienObat=pg_query("DELETE from pasien_resep_order where id_kunjungan='$idKunjungan' and id_resep='$fetchMaxOrder[id_resep]'");
}


$getDataResep=pg_query("SELECT * from pasien_resep_keterangan where id_kunjungan='$idKunjungan'");
$numDataResep=pg_num_rows($getDataResep);



if($numDataResep>0)
{
	$numberOfResep=$numDataResep;
	//index resep
	$nextStep=$numberOfResep+1;
	//buat ke puluhan
	$nextResep=$nextStep+10;

}
else
{
	$numberOfResep=0;
	$nextStep=$numberOfResep+1;
	$nextResep=$nextStep+10;

}

?>

<div id="data_catat_resep">
	<div class="card">
		<div class="card-header">
			<strong>Data Pencatatan Resep</strong>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<span class="cito" style="font-weight: bold;color:grey;float:right;font-size:20px;cursor:pointer;border:3px solid grey;padding:5px;margin-bottom:5px;" title="klik untuk CITO">C I T O !</span>
					<input type="hidden" name="cito" class="citoField" value="N">
				</div>
				<div class="col-md-12">
					<div class="col-md-12" style="border-top:1px solid black;border-bottom:1px solid black;">
						<center><h5>R E S E P</h5></center>
					</div>
				</div>
				<div class="col-md-1">
					R /<br />
					<button class="btn btn-primary btn-xs tambahFirst" id="0"><i class="icon-plus"></i></button>
					<input type="hidden" value="0" id="idUrut" name="idUrut">
					<input type="hidden" value="R0" id="idResep" name="idResep">
					<button class="btn btn-primary btn-xs" id="tambahFirstDelete" style="display:none;"><i class="icon-plus"></i></button>
				</div>
				<div class="col-md-10" id="resep">
					

				</div>
				<div class="col-md-1">
					<form class="formKeterangan">
					
					</form>
				</div>
				

				<hr />
			</div>
			<?php
				if($jumlahPasienNoResep==0)
				{
					$disabled="";
					$deleteDataResepOrder=pg_query("DELETE from pasien_resep_order where id_kunjungan='$id_kunjungan'");
					$deleteDataResepKeterangan=pg_query("DELETE from pasien_resep_keterangan where id_kunjungan='$id_kunjungan'");
				}
				else
				{
					$disabled="disabled";

				}
				echo"<button class='btn btn-sm btn-success' id='selesai' $disabled>Selesai</button>";	
			?>
			
		</div>
	</div>

</div>
<div class="daftar_resep" style="display:none;">
	<div class="card">
		<div class="card-header">
			<strong>Daftar Resep</strong>
		</div>
		<div class="card-block">
			<div class="row">
				<div class="col-md-12" id="listResep">
					
				</di>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function()
{
	$("#resep").load('content/pasien/catatresep/formCatatResep.php?id=0'+'&numberOfResep='+<?php echo $numberOfResep ?>+'&idPasien='+<?php echo $idPasien ?>+'&idKunjungan='+<?php echo $idKunjungan ?>);
	$(".tambahFirst").click(function()
	{
	/*	var id=parseInt(this.id);
		var nextResep=id+1;*/
		var noResep=parseInt($("#idUrut").val());
		var nextResep=noResep+1;
		var data=$(".formKeterangan").serialize();
		var idResep=$("#idResep").val();
		var namaObat=$(".obat0").val();
		var dosis=$("#dosis").val();
		var keterangan=$("#keterangan").val();
		var satuan=$("#satuan0").val();
		var idResep=$("#idResep").val();
		var idObat=$("#id_obat").val();
		var idPasien=<?php echo $idPasien ?>;
		var dataObat='idResep='+idResep+'&namaObat='+namaObat+'&dosis='+dosis+'&keterangan='+keterangan+'&satuan='+satuan+'&idResep='+idResep+'&idObat='+idObat+'&idKunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+idPasien;
		//$("#tambahFirst").hide();
		$.ajax(
			{
				berforeSend:function()
				{
					$("#tambahFirst").html("<img src='../images/load.gif'>");
				},
				url:'content/pasien/catatresep/checkJumlah.php',
				type:'POST',
				data:dataObat,
				success:function(result)
				{
					if(result==0)
					{
						$.ajax(
							{
								url:'content/pasien/catatresep/saveObatDirect.php',
								type:'POST',
								data:dataObat,
								success:function(result)
								{
									$.ajax(
									{
										url:'content/pasien/catatresep/savePrescription.php',
										data:data+'&idResep='+idResep+'&noResep='+noResep,
										type:'POST',
										success:function(result)
										{
											alert(result);
											$("#idUrut").val(nextResep);
											$("#idResep").val("R"+nextResep);
											$("#resep").load('content/pasien/catatresep/formCatatResep.php?id=0'+'&numberOfResep='+<?php echo $numberOfResep ?>+'&idPasien='+<?php echo $idPasien ?>+'&idKunjungan='+<?php echo $idKunjungan ?>);
											$(".daftar_resep").show();
											$("#listResep").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+true);
										},
										error:function()
										{
											alert('ERROR');
										}


									});
								}
							});
					}
					else
					{
						
						$.ajax(
						{
							url:'content/pasien/catatresep/savePrescription.php',
							data:data+'&idResep='+idResep+'&noResep='+noResep,
							type:'POST',
							success:function(result)
							{
								alert(result);
								$("#idUrut").val(nextResep);
								$("#idResep").val("R"+nextResep);
								$("#resep").load('content/pasien/catatresep/formCatatResep.php?id=0'+'&numberOfResep='+<?php echo $numberOfResep ?>+'&idPasien='+<?php echo $idPasien ?>+'&idKunjungan='+<?php echo $idKunjungan ?>);
								$(".daftar_resep").show();
								$("#listResep").load('content/pasien/catatresep/detailResep.php?id_kunjungan='+<?php echo $idKunjungan ?>+'&idPasien='+<?php echo $idPasien; ?>+'&afterAdd='+true);
							},
							error:function()
							{
								alert('ERROR');
							}


						});
					}
				}
			});

		

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

	// $(".prescription").hide();
	// $(".subShow").hide();
/*	$(".forResep").prop("readonly",true);*/
/*	
	$("#iterasi0").change(function()
	{
		var iterasi=$("#iterasi0").val();
		$("#iterasiLable0").val(iterasi);
	});

	$(".jmlObat0").keyup(function()
	{
		$(".jmlResep0").val($(".jmlObat0").val());
	});

	

	

	$(document).keydown(function(e) {
    // ESCAPE key pressed
    if (e.keyCode == 27) {
       
    }
});

	$("#addFirst").click(function(e)
	{
		e.preventDefault();
		var $nonempty = $('.first').filter(function() {
    		return this.value != ''
		 });

  		if ($nonempty.length < 6) {
    		alert('empty')
  		}
  		else
  		{
  			
  			var data=$("#medicine").serialize();
  			$.ajax(
  			{
  				url:'content/pasien/catatresep/saveObat.php',
  				data:data+'&id=0',
  				type:'POST',
  				success:function(result)
  				{

  					$(".first").prop("readonly",true);
  					$("#addFirst").hide();
  					$("#1").show();
  					$("#editFirst").show();
  					$("#idObatResep0").val(result);
  				}
  			});
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

		$(".ketResep").keyup(function()
		{
			var isi=$(".ketResep").val();
			if(isi!="")
			{
				$("#mf").val('m.f.');
				$(".subShow").show();
				$(".not_for_racikan").hide();
				$(".disabledSubscription").prop("disabled", true);
				$("#iterRacikan0").show();
				$("#iterasi0").detach().appendTo("#iterRacikan0");
			}
			else
			{
				$("#mf").val('');
				$(".not_for_racikan").show();
				$(".subShow").hide();
				$(".disabledSubscription").prop("disabled", false);
				$("#iterRacikan0").hide();
				$("#iterasi0").detach().appendTo("#iterasiObat0");
			}
			
			
		});*/


/*	$("#obat").keyup(function()
	{
		var id=0;
		var obat=$("#obat").val();
		$("#resultObat0").show();
		if(obat!=" ")
		{
			$.ajax(
		{
			url:'content/pasien/catatresep/getObat.php',
			data:{id:id,obat:obat},
			type:'POST',
			success:function(result)
			{
				
				$("#resultObat0").html(result);
			},
			error:function()
			{
				alert('ERROR');
			}
		})
		}
		
	});*/

	/*$(".hapusResep").click(function()
	{
		var id=this.id;
		if(id==11)
		{
			$("#tambahFirst").show();
		}
		$("#resep"+id).hide();

	});
	$(".tambahResep").click(function()
	{
		var id=parseInt(this.id);
		var nextId=id+1;

		$("#resep"+nextId).show();

	});

	//kolom obat
	$("#addSecond").click(function()
	{
		var $nonempty = $('.second').filter(function() {
    		return this.value != ''
		 });

  		if ($nonempty.length < 6) {
    		alert('empty')
  		}
  		else
  		{
  			$("#addSecond").hide();
  			$("#21").show();
  		}
	});*/
});
</script>