<style type="text/css">
	.item:hover
	{
		background-color: blue;
		color:white;
	}
</style>
<?php
include "../../../../config/conn.php";
$namaSpesialis=$_POST['nama_spesialis'];

$getDataSpesialis=pg_query("SELECT * from master_spesialis where deskripsi ILIKE '%$namaSpesialis%' LIMIT 10");

while($fetchSpesialis=pg_fetch_assoc($getDataSpesialis))
{
	echo "<li class='item' id='$fetchSpesialis[deskripsi]' style='cursor:pointer;'>$fetchSpesialis[deskripsi]</li>";
}

?>
<script type="text/javascript">
	$(".item").click(function()
	{
		var id=this.id;
		$("#ts").val(id);
		$("#dataSpesialis").hide();
	});
</script>