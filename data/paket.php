<?php
	session_start();
	include "../config/conn.php";
	?>
	<select name="id_paket" class="form-control" required>
		<?php
		$tampil=pg_query($dbconn,"SELECT u.id_billing_paket, p.nama_paket FROM billing_paket_kategori_harga_unit u inner join billing_paket p on p.id=u.id_billing_paket where u.id_unit='$_SESSION[id_units]' AND  u.id_kategori_harga='$_POST[id_penjamin]' ORDER BY u.id_billing_paket asc");

		
			?>
			<option>Pilih</option>
			<?php

		while($r=pg_fetch_array($tampil)){
			echo"<option value='$r[id_billing_paket]'>$r[nama_paket]</option>";
		}
		?>
	</select>
	<?php
	pg_close($dbconn);
?>