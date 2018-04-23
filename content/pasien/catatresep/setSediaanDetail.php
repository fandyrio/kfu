<?php
include "../../../config/conn.php";
$sediaan=$_GET['nama_sediaan'];

?>
<select name="sediaanDetailSelected">
	<?php
		$getDetailSediaan=pg_query("SELECT * from master_sediaan_detail where code_sediaan='$sediaan'");
		while($fetchDetailSediaan=pg_fetch_assoc($getDetailSediaan))
		{
			echo"<option value='$fetchDetailSediaan[id]'>$fetchDetailSediaan[code_detail]</option>";
		}
	?>
</select>