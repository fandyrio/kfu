<?php
include_once "../config/conn.php";
$id_regional=$_POST['id_regional'];




?>
<select id="klinik" class="form-control">
	<option value="0">PILIH KLINIK</option>
	<?php
		$getKlinik=pg_query("SELECT * from master_unit where id_regional='$id_regional' order by nama");
		while($fetchKlinik=pg_fetch_assoc($getKlinik))
		{
			echo"<option value='$fetchKlinik[id]'>$fetchKlinik[nama]</option>";
		}
	?>
</select>	