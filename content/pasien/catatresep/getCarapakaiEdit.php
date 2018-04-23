<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../../config/conn.php";
$caraPakai=$_POST['carapakai'];
$idResep=$_POST['idResep'];

$getCaraPakai=pg_query("SELECT * from cara_pakai where code_hts ILIKE '%$caraPakai%' or arti ILIKE '%$caraPakai%' LIMIT 5");
while($fetchCaraPakai=pg_fetch_assoc($getCaraPakai))
{
	echo "<li class='list_carapakaiEdit' forCaraPakai='$fetchCaraPakai[id]' id='list_caraPakai$fetchCaraPakai[id]' style='cursor:pointer;border:1px solid black;padding:5px;'>".$fetchCaraPakai['code_hts'].'( '.$fetchCaraPakai['arti'].' ) </li>';
}

?>
<style type="text/css">
.list_carapakaiEdit:hover
{
	background-color: blue;
	color:white;
}
</style>
<script type="text/javascript">
$(document).ready(function()
{
	$(".list_carapakaiEdit").click(function()
	{
		var id=this.id;
		var idResep=<?php echo $idResep ?>;
		var caraPakai=$("#"+id).text();
		var idCaraPakai=$("#"+id).attr("forCaraPakai");
		
		$("#carapakaiEdit"+idResep).val(caraPakai);
		$("#idCaraPakaiEdit"+idResep).val(idCaraPakai);
		$(".list_carapakaiEdit").hide();
		$("#hasil_carapakaiEdit"+idResep).hide();
	});
});
</script>