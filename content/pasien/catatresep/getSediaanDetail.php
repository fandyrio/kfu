<?php
include "../../../config/conn.php";
$from=$_POST['from'];


$idResep=$_POST['idResep'];

$sediaan=$_POST['sediaan'];


$getDataSediaan=pg_query("SELECT * from master_sediaan_detail where code_sediaan ILIKE '%$sediaan%' or arti ILIKE '%$sediaan%' LIMIT 5");
$jumlah=pg_num_rows($getDataSediaan);
if($jumlah>0)
{
	while($fetchDataSediaan=pg_fetch_assoc($getDataSediaan))
	{
		echo"<li class='list_sediaanDetail' forSediaan='$fetchDataSediaan[id]' id='$fetchDataSediaan[code_detail]'>$fetchDataSediaan[code_sediaan] ($fetchDataSediaan[code_detail] / $fetchDataSediaan[arti])</li>";
	}
}
else
{
	echo"<li class='list_sediaanDetail'>Tidak ada data</li>";
}
?>




<script type="text/javascript">
$(document).ready(function()
{
	$(".list_sediaanDetail").click(function()
	{
		var idResep=<?php echo $idResep ?>;
		var sediaan=this.id;
			
		$("#sediaanDetail"+idResep).val(sediaan);
		$("#hasil_sediaanDetail"+idResep).hide();
		$(".forSediaan").val($(this).attr('forSediaan'));
	});
	
	
	
});

</script>


<style type="text/css">
	.list_sediaanDetail
	{
		border:1px solid black;
		padding:5px;
	}
	.list_sediaanDetail:hover
	{
		background-color: blue;
		color:white;
		cursor:pointer;
	}
</style>