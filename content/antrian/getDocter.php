<style type="text/css">
	.data:hover
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
include "../../config/conn.php";

$nama_dokter=$_POST['nama_dokter'];
$id_poly=$_POST['id_poly'];

$getDokter=pg_query("SELECT * from master_karyawan_unit mku join master_karyawan mk on mk.id=mku.id_karyawan where mku.id_unit='$_SESSION[id_units]' and mk.nama ILIKE '%$nama_dokter%' and poly_id='$id_poly'");
$jumlahDokter=pg_num_rows($getDokter);
if($jumlahDokter==0)
{
	echo "<center>Data dokter tidak tersedia</center>";
}
else
{
	while($fetchDokter=pg_fetch_assoc($getDokter))
	{
		echo "<li class='data' id='$fetchDokter[id]' style='cursor:pointer;'>$fetchDokter[nama]</li>";
	}

}

?>
<script type="text/javascript">
	$(document).ready(function()
	{
		$(".data").click(function()
		{
			var id=this.id;
			$(this).removeClass('activeDokter');
			if($(this).hasClass('activeDokter'))
			{

			}
			else
			{
				$(this).addClass('activeDokter');
			}
			$("#id_dokter").val(id);
			$("#nama_dokter").val($('.activeDokter').text());
			$("#listDokter").hide();
			$('.save').prop("disabled", false);
		});
	});
</script>