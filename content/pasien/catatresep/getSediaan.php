<?php
include "../../../config/conn.php";
$sediaan=$_POST['sediaan'];
$idResep=$_POST['idResep'];


$getDataSediaan=pg_query("SELECT * from master_sediaan where code_sediaan ILIKE '%$sediaan%' LIMIT 10");
$jumlah=pg_num_rows($getDataSediaan);
if($jumlah>0)
{
	while($fetchDataSediaan=pg_fetch_assoc($getDataSediaan))
	{
		echo"<li class='list_sediaan' idSediaan='$fetchDataSediaan[id]' id='$fetchDataSediaan[code_sediaan]'>$fetchDataSediaan[code_sediaan]</li>";
	}
}
else
{
	echo"<li class='list_sediaan'>Tidak ada data</li>";
}
?>
<script type="text/javascript">
$(document).ready(function()
{
	$(".list_sediaan").click(function()
	{
		var idResep=<?php echo $idResep ?>;
		var sediaan=this.id;

		$("#sediaan"+idResep).val(sediaan);
		$(".idSediaan").val($(".list_sediaan").attr('idSediaan'));
		$("#hasil_sediaan"+idResep).hide();
		$("#detailSediaan"+idResep).load("content/pasien/catatresep/setSediaanDetail.php?nama_sediaan="+sediaan).show();
	});
});

</script>
<style type="text/css">
	.list_sediaan
	{
		border:1px solid black;
		padding:5px;
	}
	.list_sediaan:hover
	{
		background-color: blue;
		color:white;
		cursor:pointer;
	}
</style>