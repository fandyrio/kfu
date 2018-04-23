<?php
		
		$id = $_POST['id'];
		$harga = $_POST['harga'];
		$inv = $_POST['inv'];
	
		pg_query($dbconn,"DELETE from transaksi_invoice_detail WHERE id='$id' ");
		pg_query($dbconn,"DELETE from lab_order WHERE id_transaksi_invoice_detail='$id' ");
		//pg_query($dbconn,"UPDATE transaksi_invoice SET total=total-'$harga' WHERE id='$inv'");

		//var_dump("UPDATE transaksi_invoice SET total=total-'$harga' WHERE id='$inv'");

?>