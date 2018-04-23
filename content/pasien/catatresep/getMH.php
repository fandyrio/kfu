<style type="text/css">
.listmh:hover
{
	background-color: blue;
	color:white;
}
</style>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../../config/conn.php";

$id=$_POST['id'];
$mh=$_POST['mh'];

$getMH=pg_query("SELECT * from master_mh where kode ILIKE '%$mh%' or latin ILIKE '%$mh%' or ind ILIKE '%$mh%' LIMIT 10");

while($fetchMH=pg_fetch_assoc($getMH))
{	
	echo "<li class='listmh' id='$fetchMH[id]' nama='$fetchMH[kode]'>$fetchMH[kode]</li>";
}

?>
<script type="text/javascript">
	$(document).ready(function()
	{
		$(".listmh").click(function()
		{
			var id=this.id;
			var idField="<?php echo $id ?>";
			$(".listmh").removeClass('active');
			var namaMH=$(this).attr('nama');
			$("#result"+idField).hide();
			$("#"+idField).val(namaMH);

		});
	});

</script>