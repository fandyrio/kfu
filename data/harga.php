<?php
	include "../config/conn.php";

	session_start();
	$id=$_GET["id"];
?>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/datatable_code.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<table class="table" id="myTable">
	<thead>
		<th>Jenis Pemeriksaan</th>
		<th>Harga</th>
	</thead>
		<tbody><?php 
		$id_unit= $_SESSION['id_units'];
                 $res=pg_query($dbconn,"Select id, id_lab_analysis, harga from lab_analysis_kategori_harga_unit where  id_kategori_harga='$id'");
                                 
        while ($row=pg_fetch_assoc($res)) {
                    $view=pg_fetch_assoc(pg_query($dbconn,"Select * from lab_analysis WHERE id='$row[id_lab_analysis]'"));
			?>
				<tr>
					<td><?php echo $view["nama"] ?></td>
					<td><?php echo number_format($row["harga"],"0","",".") ?></td>
				</tr>

				<?php
			}

		$res=pg_query($dbconn,"Select id, id_tindakan, harga from tindakan_kategori_harga_unit where id_regional='$_SESSION[id_regional]' and id_kategori_harga='$id' order by id_tindakan asc");

		while ($row=pg_fetch_assoc($res)) {
			$data=pg_fetch_array(pg_query($dbconn,"Select * from tindakan where id='".$row["id_tindakan"]."' "));
						 ?>
					<tr>
						<td><?php echo $data["nama"] ?></td>
						<td><?php echo number_format($row["harga"],"0","",".") ?></td> 
					</tr>
			<?php 
			} 

		$res=pg_query($dbconn,"Select id, id_lab_analysis_group, harga_unit from lab_analysis_group_unit WHERE id_unit='$id_unit' and id_kategori_harga='$id' order by id asc");
			while ($row=pg_fetch_assoc($res)) {
				$view=pg_fetch_assoc(pg_query($dbconn,"Select * from lab_analysis_group WHERE id='$row[id_lab_analysis_group]'"));
						?>
							<tr>
								<td><?php echo $view["nama"] ?></td>
								<td><?php echo number_format($row["harga_unit"],"0","",".") ?></td> 
					
								
							</tr>
						<?php 
						} 
						?> 				
		</tbody>
</table>