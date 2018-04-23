<style type="text/css">
	.listObat:hover
	{
		background-color: blue;
		color:white;
	}
</style>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();


include "../../../config/conn.php";
$namaObat=$_POST['obat'];
$model="dbKlinik";
//$model="APIPOC";

if(isset($_SESSION['id_units']))
{
	$idUnit=$_SESSION['id_units'];	
	$idInput=$_POST['id'];


	$getOutletId=pg_query("SELECT id_outlet from master_unit where id='$idUnit'");
	$fetchOutletId=pg_fetch_assoc($getOutletId);
	$outletId=$fetchOutletId['id_outlet'];

	if($model=="APIPOC")
	{
		$getObat=pg_query("SELECT distinct ic.catalog_name, ic.catalog_id from item_catalog ic left outer join zat_aktif_obat zao on zao.catalog_id=ic.catalog_id and zao.outlet_id=ic.outlet_id where 
		(ic.catalog_name ILIKE '%$namaObat%' and ic.outlet_id='$outletId' and aktif='Y') or (zao.zat_aktif ILIKE '%$namaObat%' and ic.outlet_id='$outletId' and aktif='Y') LIMIT 10");
		$jumlah=pg_num_rows($getObat);	
	}
	else
	{
		$getObat=pg_query("SELECT * from item_catalog_temp where catalog_name ilike '%$namaObat%' LIMIT 10");
		$jumlah=pg_num_rows($getObat);	
	}
	

	if($jumlah==0)
	{
		echo"Tidak ada data";
	}
	while($fetchObat=pg_fetch_assoc($getObat))
	{
		echo "<li class='listObat' id='$fetchObat[catalog_id]' id_nama='$fetchObat[catalog_name]' style='width:200px;'>$fetchObat[catalog_name]</li>";
	}
}
else
{
	echo "Session anda sudah habis, Silahkan Login";
}


?>
<script type="text/javascript">
	$(document).ready(function()
	{
		$(".listObat").click(function()
		{
			var id=this.id;
			var idField="<?php echo $idInput; ?>";
			$('.listObat').removeClass('active');
			if($(this).hasClass('active'))
			{
				
			}
			else
			{
				$(this).addClass('active');
			}
			var namaObat=$(this).attr('id_nama');
			/*$.ajax(
			{
				url:'content/pasien/catatresep/cek_stok.php',
				data:{id:id},
				type:'POST',
				success:function(result)
				{
					var resultObj=JSON.parse(result);
					var stock=resultObj.stock;
					var stock=10;//tidak cek stok
					if(stock>0)
					{*/
						var stock=100;
							$(".obat"+idField).val(namaObat);
							$(".idobat"+idField).val(id);
							$("#resultObat"+idField).hide();
							$("#stockObat"+idField).val(stock);

							$(".resultObatEdit").hide();
							$(".editIdobat").val(id);
							$(".editNamaObat").val(namaObat);
							
		/*			}
					else
					{
						alert("Stock Tidak Tersedia");
					}
					
				},
				error:function()
				{
					alert("ERROR");
				}
			});*/
			
			//alert(id);
		});
	});
</script>