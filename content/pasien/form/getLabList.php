<?php

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
include "../../../data/constanta.php";
include "../../../config/conn.php";

if(isset($idLab))
{
	$id_lab=$idLab;
}
else
{
	$id_lab=0;
}

$id_unit=$_SESSION['id_units'];
$url=API_GET_LIST_LAB;

  $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST  ,'GET');        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
           'signature:naAMjzpnyLKt4B3QLWCW8lRA7D+aqJ/jWqhT2mI40vw='));
        curl_setopt($ch, CURLOPT_URL, $url);         

		// grab URL and pass it to the browser
		$return = curl_exec($ch);
		//var_dump($return);
		$data=json_decode($return, true);
		
		
		$size=sizeof($data['klinik']);
		
?>
<select name="lab" id="lab">
	<?php
	for($x=1;$x<=$size;$x++)
		{
			$y=$x-1;
			$data['klinik'][$y]['nama'] ;
			echo "<option value='".$data['klinik'][$y]['id']."_".$data['klinik'][$y]['nama']."_".$data['klinik'][$y]['alamat']."'";
			if($id_lab==$data['klinik'][$y]['id'])
			{
				echo "selected";
			}
			echo ">".$data['klinik'][$y]['nama']."</option>";
		}
	?>
</select>
