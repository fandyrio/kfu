<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../config/conn.php";
//include "config/fungsi_tanggal.php";


		$namaFile="csv/siokdokter.csv";
		//var_dump(fopen($namaFile, "w"));

$fp = fopen($namaFile, 'a+');
if ( !$fp ) {
  echo 'last error: ';
 var_dump(error_get_last());
}
else {
  //echo "ok.\n";
}


		$row = 1;
		if (($handle = fopen($namaFile, "r")) !== FALSE) {
  			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
  			{
	    		if($data[0]!="id_unit")
	    		{
	    			$query=pg_query("UPDATE master_karyawan_unit set siok='$data[2]', tanggal_berlaku='$data[3]', tanggal_berakhir='$data[4]' where id_karyawan='$data[1]' and id_unit='$data[0]'");
	    			echo "UPDATE master_karyawan_unit set siok='$data[2]', tanggal_berlaku='$data[3]', tanggal_berakhir='$data[4]' where id_karyawan='$data[1]' and id_unit='$data[0]' <br/>";
	    		}
	    			
	    			
	    	} 		
  		}
		else
		{
			echo"False";
		}

    
		

?>
<script type="text/javascript">
//window.location.replace("pendaftaran");
</script>